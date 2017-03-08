<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\Cashflow;

/**
 * This is the form model class for table "cashflow".
 */
class CashflowForm extends Cashflow
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
            [
                ['number', 'notes'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            [['approval'], 'default', 'value' => static::APPROVAL_PENDING],
            [['recordStatus'], 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['cashflowType_id', 'number', 'date', 'account_id'], 'required'],
            /* safe */
            /* field type */
            [['cashflowType_id', 'account_id'], 'integer'],
            [['approval', 'notes', 'recordStatus'], 'string'],
            [['number'], 'string', 'max' => 32],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            /* value limitation */
            ['approval', 'in', 'range' => [
                    self::APPROVAL_PENDING,
                    self::APPROVAL_APPROVED,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
            [
                ['cashflowType_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CashflowType::className(),
                'targetAttribute' => ['cashflowType_id' => 'id'],
            ],
            [
                ['account_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Account::className(),
                'targetAttribute' => ['account_id' => 'id'],
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
                'cashflow-create' => ['cashflowType_id', 'number', 'date', 'account_id', 'notes'],
                'cashflow-update' => ['cashflowType_id', 'number', 'date', 'account_id', 'notes'],
                ]
        );
    }
}