<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "MonthlyBudgetItemController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\MonthlyBudgetItemActControl;

class MonthlyBudgetItemController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\MonthlyBudgetItem';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        MonthlyBudgetItemActControl::checkAccess($action, $model, $params);
    }
}
