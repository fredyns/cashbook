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
                ['number', 'name', 'currency'],
                'filter',
                'filter' => function($value) {
                    return StringHelper::plaintextFilter($value);
                },
            ],
            [
                ['currency'],
                'filter',
                'filter' => function($value) {
                    return strtoupper($value);
                },
            ],
            /* default value */
            [['currency'], 'default', 'value' => 'IDR'],
            [['accountStatus'], 'default', 'value' => static::ACCOUNTSTATUS_ACTIVE],
            [['recordStatus'], 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['owner_uid', 'number', 'name', 'currency'], 'required'],
            /* safe */
            /* field type */
            [['owner_uid'], 'integer'],
            [['accountStatus', 'recordStatus'], 'string'],
            [['number'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 8],
            /* value limitation */
            ['accountStatus', 'in', 'range' => [
                    self::ACCOUNTSTATUS_ACTIVE,
                    self::ACCOUNTSTATUS_SUSPENDED,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            /* value references */
        ];
    }
}