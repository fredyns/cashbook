<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Description of CashflowCreate
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class CashflowCreate extends CashflowForm
{
    /**
     * all form cashflow-detail entries
     *
     * @var CashflowDetailForm[]
     */
    public $allDetails = [];

    /**
     * new form cashflow-detail entries
     *
     * @var CashflowDetailCreate[]
     */
    public $newDetails = [];

    /**
     * load new inputed cashflow-detail entries
     */
    public function loadNewDetails()
    {
        $formname = 'CashflowDetailCreate';
        $isPost = Yii::$app->request->isPost;
        $detailEntries = $isPost ? Yii::$app->request->post($formname, []) : Yii::$app->request->get($formname, []);

        foreach ($detailEntries as $newDetail) {
            $detail = new CashflowDetailCreate;
            $detail->setScenario($this->scenario);

            if ($detail->load([$formname => $newDetail]) && $detail->recordStatus == CashflowDetailCreate::RECORDSTATUS_ACTIVE) {
                $this->newDetails[] = $detail;
            }
        }
    }

    /**
     * validate cashflow & details
     *
     * @return boolean
     */
    public function validateWithDetail()
    {
        $formValid = $this->validate();

        if (empty($this->allDetails)) {
            $this->addError('cashflowDetails', "Detail bukti harus diisi.");

            return false;
        } else {
            return $formValid && Model::validateMultiple($this->allDetails);
        }
    }

    /**
     * creating new model plus details
     *
     * @return boolean true when operation success
     * @throws \Exception
     */
    public function createWithDetail()
    {
        $this->setScenario('cashflow-create');
        $this->loadNewDetails();

        // details content

        $this->allDetails = $this->newDetails;

        // load entries from post/get

        $isPost = Yii::$app->request->isPost;
        $entries = $isPost ? Yii::$app->request->post() : Yii::$app->request->get();

        if (!$isPost OR ! $this->load($entries)) {
            return false;
        }

        // validation

        if (!$this->validateWithDetail()) {
            return false;
        }

        // data storing

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->save(FALSE);

            foreach ($this->allDetails as $detail) {
                $detail->cashflow_id = $this->id;
                $detail->save(FALSE);
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }
    }
}