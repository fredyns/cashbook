<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\CashflowDetail;

/**
 * Description of CashflowDetailCreate
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 */
class CashflowDetailCreate extends CashflowDetailForm
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* filter */
            [
                ['notes'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            [['recordStatus'], 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [
                ['cashflow_id', 'flow', 'nominal', 'budgetItem_id'],
                'required',
                'when' => function ($model, $attribute) {
                    /* @var $model CashflowDetailForm */
                    return ($model->recordStatus == static::RECORDSTATUS_ACTIVE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        attr = ["cashflow_id", "flow", "nominal", "budgetItem_id"];
                        element_id = $(attribute).attr("id");
                        attr.forEach(function(item, index){element_id = element_id.replace(item, "recordstatus")});

                        return ($("#"+element_id).val() == "active");
                    }',
            ],
            /* safe */
            /* field type */
            [['cashflow_id', 'budgetItem_id', 'monthlyBudgetItem_id'], 'integer'],
            [['flow', 'notes', 'recordStatus'], 'string'],
            [['nominal'], 'number'],
            /* value limitation */
            ['flow', 'in', 'range' => [
                    self::FLOW_DEBIT,
                    self::FLOW_CREDIT,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
            [
                ['cashflow_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Cashflow::className(),
                'targetAttribute' => ['cashflow_id' => 'id'],
            ],
            [
                ['budgetItem_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\BudgetItem::className(),
                'targetAttribute' => ['budgetItem_id' => 'id'],
            ],
            [
                ['monthlyBudgetItem_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\MonthlyBudgetItem::className(),
                'targetAttribute' => ['monthlyBudgetItem_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
                parent::scenarios(),
                [
                'cashflow-create' => ['flow', 'nominal', 'budgetItem_id', 'notes', 'recordStatus'],
                'cashflow-update' => ['flow', 'nominal', 'budgetItem_id', 'notes', 'recordStatus'],
                ]
        );
    }
}