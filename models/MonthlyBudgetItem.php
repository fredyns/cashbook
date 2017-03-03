<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\traits\ModelTool;
use fredyns\suite\traits\ModelBlame;
use fredyns\suite\traits\ModelSoftDelete;
use app\models\base\MonthlyBudgetItem as BaseMonthlyBudgetItem;

/**
 * This is the model class for table "monthly_budgetItem".
 */
class MonthlyBudgetItem extends BaseMonthlyBudgetItem
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
     * get column month enum value label
     * @param string $value
     * @return string
     */
    public static function getMonthValueLabel($value, $nickname = false)
    {
        $labels = $nickname ? self::optsMonthNick() : self::optsMonth();

        if (isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column month ENUM value labels
     * @return array
     */
    public static function optsMonth()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    /**
     * column month ENUM value labels
     * @return array
     */
    public static function optsMonthNick()
    {
        return [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agt',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];
    }
}