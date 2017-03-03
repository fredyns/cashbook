<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\MonthlyBudgetItem;

/**
 * This is the form model class for table "monthly_budgetItem".
 */
class MonthlyBudgetItemForm extends MonthlyBudgetItem
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          /* filter */
          /* default value */
          /* required */
          /* safe */
          /* field type */
          /* value limitation */
          /* value references */
          [['year', 'month', 'budgetItem_id'], 'required'],
          [['year'], 'safe'],
          [['month', 'budgetItem_id', 'deleted_at', 'deleted_by'], 'integer'],
          [['openBalance', 'debit', 'credit', 'closingBalance'], 'number'],
          [['recordStatus'], 'string'],
          [['budgetItem_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\BudgetItem::className(), 'targetAttribute' => ['budgetItem_id' => 'id']],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
