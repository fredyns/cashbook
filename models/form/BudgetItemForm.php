<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\helpers\StringHelper;
use app\models\BudgetItem;

/**
 * This is the form model class for table "budgetItem".
 */
class BudgetItemForm extends BudgetItem
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
          [['code'], 'required'],
          [['recordStatus'], 'string'],
          [['deleted_at', 'deleted_by'], 'integer'],
          [['code'], 'string', 'max' => 64],
          [['description'], 'string', 'max' => 255],
          ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
        ];
    }

}
