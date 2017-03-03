<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\YiiSession;

/**
 * This is the form model class for table "yii_session".
 */
class YiiSessionForm extends YiiSession
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
          [['id'], 'required'],
          [['expire'], 'integer'],
          [['data'], 'string'],
          [['id'], 'string', 'max' => 64],
        ];
    }

}
