<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\Account as BaseAccount;

/**
 * This is the model class for table "account".
 *
 * @property string $label model label
 */
class Account extends BaseAccount
{

    use ModelTool,
        ModelBlame,
        ModelSoftDelete;

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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                parent::attributeLabels(),
                [
                # custom validation rules
                'cif' => 'CIF',
                'number' => 'Acc.Number',
                'name' => 'Name',
                'currency' => 'Currency',
                ]
        );
    }

    /**
     * get model label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->number.' - '.$this->name;
    }

    /**
     * @inheritdoc
     */
    public function getCashflows()
    {
        return parent::getCashflows()->andWhere(['recordStatus' => 'active']);
    }
}