<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "BudgetItemController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\BudgetItemActControl;

class BudgetItemController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\BudgetItem';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        BudgetItemActControl::checkAccess($action, $model, $params);
    }
}
