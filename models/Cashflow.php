<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\Cashflow as BaseCashflow;
use fredyns\suite\models\Profile;

/**
 * This is the model class for table "cashflow".
 *
 * @property Profile $approvedBy
 */
class Cashflow extends BaseCashflow
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    const ALIAS_APPROVEDBY = 'approvedBy';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(), [
                # custom behaviors
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
                parent::rules(), [
                # custom validation rules
                ]
        );
    }

    /**
     * Getting blamable Profile model for approval
     *
     * @return Profile
     */
    public function getApprovedBy()
    {
        return $this->getBlamedProfile('approved_by', static::ALIAS_APPROVEDBY);
    }

    /**
     * @inheritdoc
     */
    public function getCashflowDetails()
    {
        return parent::getCashflowDetails()->andWhere(['recordStatus' => 'active']);
    }

    public function approve()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            MonthlyBudgetItemRecap::parseMultiple($this->cashflowDetails);

            $this->approval = static::APPROVAL_APPROVED;
            $this->approvedBy = Yii::$app->user->id;
            $this->approved_at = time();

            $this->save(FALSE);
            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }
    }
}