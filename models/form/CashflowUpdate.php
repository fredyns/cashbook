<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Description of CashflowUpdate
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class CashflowUpdate extends CashflowCreate
{
    /**
     * stored/old cashflow-detail entries
     *
     * @var CashflowDetailUpdate[]
     */
    public $oldDetails = [];

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashflowDetails()
    {
        return $this
                ->hasMany(CashflowDetailUpdate::className(), ['cashflow_id' => 'id'])
                ->andWhere(['recordStatus' => 'active'])
                ->indexBy('id');
    }

    /**
     * load stored cashflow details
     */
    public function loadOldDetails()
    {
        $isPost = Yii::$app->request->isPost;
        $entries = $isPost ? Yii::$app->request->post() : Yii::$app->request->get();
        $this->oldDetails = $this->getCashflowDetails()->all();

        if ($this->oldDetails) {
            foreach ($this->oldDetails as $detail) {
                $detail->setScenario($this->scenario);
            }

            Model::loadMultiple($this->oldDetails, $entries);
        }
    }

    /**
     * @inheritdoc
     */
    public function updateWithDetail()
    {
        $this->setScenario('cashflow-update');
        $this->loadOldDetails();
        $this->loadNewDetails();

        // details content

        $this->allDetails = ArrayHelper::merge($this->oldDetails, $this->newDetails);

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
                if ($detail->isNewRecord) {
                    $detail->cashflow_id = $this->id;
                    $detail->save(FALSE);
                } elseif ($detail->recordStatus == CashflowDetailForm::RECORDSTATUS_DELETED) {
                    $detail->delete();
                } else {
                    $detail->save(FALSE);
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }
    }
}