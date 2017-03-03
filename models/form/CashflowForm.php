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
          [['cashflowType_id', 'number', 'date', 'account_id'], 'required'],
          [['cashflowType_id', 'account_id', 'approved_at', 'approved_by'], 'integer'],
          [['date'], 'safe'],
          [['approval', 'notes'], 'string'],
          [['number'], 'string', 'max' => 32],
          [['cashflowType_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\CashflowType::className(), 'targetAttribute' => ['cashflowType_id' => 'id']],
          [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Account::className(), 'targetAttribute' => ['account_id' => 'id']],
          ['approval', 'in', 'range' => [
                    self::APPROVAL_PENDING,
                    self::APPROVAL_APPROVED,
                ]
            ],
        ];
    }

}
