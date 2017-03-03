<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "CashflowController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\CashflowActControl;

class CashflowController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Cashflow';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        CashflowActControl::checkAccess($action, $model, $params);
    }
}
