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
        return [
            /* filter */
            /* default value */
            [['openBalance', 'debit', 'credit'], 'default', 'value' => 0],
            [['recordStatus'], 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            [['year'], 'default', 'value' => date('Y')],
            /* required */
            [['year', 'month', 'budgetItem_id'], 'required'],
            /* safe */
            /* field type */
            [['budgetItem_id'], 'integer'],
            [['month'], 'integer', 'min' => 1, 'max' => 12],
            [['openBalance', 'debit', 'credit', 'closingBalance'], 'number'],
            [['recordStatus'], 'string'],
            [['year'], 'date', 'format' => 'php:Y'],
            /* value limitation */
            [
                ['year', 'month', 'budgetItem_id'],
                'unique',
                'targetAttribute' => ['year', 'month', 'budgetItem_id'],
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
            [
                ['budgetItem_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\BudgetItem::className(),
                'targetAttribute' => ['budgetItem_id' => 'id'],
            ],
        ];
    }
}