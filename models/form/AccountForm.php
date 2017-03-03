<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\Account;

/**
 * This is the form model class for table "account".
 */
class AccountForm extends Account
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
          [['owner_uid', 'number', 'name', 'currency'], 'required'],
          [['owner_uid'], 'integer'],
          [['accountStatus'], 'string'],
          [['number'], 'string', 'max' => 32],
          [['name'], 'string', 'max' => 255],
          [['currency'], 'string', 'max' => 8],
          ['accountStatus', 'in', 'range' => [
                    self::ACCOUNTSTATUS_ACTIVE,
                    self::ACCOUNTSTATUS_SUSPENDED,
                ]
            ],
        ];
    }

}
