<?php

namespace app\models\form;

use Yii;
use yii\base\Model;

/**
 * Description of CashflowUpdate
 *
 * @property CashflowDetailForm[] $details cashflow detail indexed by id
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class CashflowUpdate extends CashflowForm
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this
                ->hasMany(CashflowDetailUpdate::className(), ['cashflow_id' => 'id'])
                ->indexBy('id');
    }

    /**
     * @inheritdoc
     */
    public function update($attributeNames = null)
    {
        $this->setScenario('cashflow-update');

        foreach ($this->details as $detail) {
            $detail->setScenario($this->scenario);
        }

        // load entries from post/get

        $isPost = Yii::$app->request->isPost;
        $entries = $isPost ? Yii::$app->request->post() : Yii::$app->request->get();

        if (!$isPost OR ! $this->load($entries) OR ! Model::loadMultiple($this->details, $entries)) {
            return false;
        }

        // validation

        if (!$this->validate() OR ! Model::validateMultiple($this->details)) {
            return false;
        }

        // data storing

        $transaction = Yii::$app->db->beginTransaction();

        try {
            parent::update(FALSE, $attributeNames);

            foreach ($this->details as $detail) {
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