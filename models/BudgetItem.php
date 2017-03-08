<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\BudgetItem as BaseBudgetItem;

/**
 * This is the model class for table "budgetItem".
 *
 * @property string $label model label
 */
class BudgetItem extends BaseBudgetItem
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;
    const ALIAS_PARENT = 'parent';

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
     * model label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->code.' - '.$this->description;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return parent::getParent()->alias(static::ALIAS_PARENT);
    }

    /**
     * @inheritdoc
     */
    public function getBudgetItems()
    {
        return parent::getBudgetItems()->andWhere(['recordStatus' => 'active']);
    }

    /**
     * @inheritdoc
     */
    public function getCashflowDetails()
    {
        return parent::getCashflowDetails()->andWhere(['recordStatus' => 'active']);
    }

    /**
     * @inheritdoc
     */
    public function getMonthlyBudgetItems()
    {
        return parent::getMonthlyBudgetItems()->andWhere(['recordStatus' => 'active']);
    }
}