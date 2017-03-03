<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\SocialAccount;

/**
 * This is the form model class for table "social_account".
 */
class SocialAccountForm extends SocialAccount
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
          [['user_id'], 'integer'],
          [['provider', 'client_id'], 'required'],
          [['data'], 'string'],
          [['provider', 'client_id', 'email', 'username'], 'string', 'max' => 255],
          [['code'], 'string', 'max' => 32],
          [['provider', 'client_id'], 'unique', 'targetAttribute' => ['provider', 'client_id'], 'message' => 'The combination of Provider and Client ID has already been taken.'],
          [['code'], 'unique'],
          [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

}
