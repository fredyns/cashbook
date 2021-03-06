<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\CashflowType as BaseCashflowType;

/**
 * This is the model class for table "cashflowType".
 */
class CashflowType extends BaseCashflowType
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
     * provide data options from model
     *
     * @return array
     */
    public static function options()
    {
        return ArrayHelper::map(static::findAll(['recordStatus' => 'active']), 'id', 'name');
    }

    /**
     * @inheritdoc
     */
    public function getCashflows()
    {
        return parent::getCashflows()->andWhere(['recordStatus' => 'active']);
    }
}