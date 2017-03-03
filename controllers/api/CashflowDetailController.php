<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "CashflowDetailController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\CashflowDetailActControl;

class CashflowDetailController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\CashflowDetail';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        CashflowDetailActControl::checkAccess($action, $model, $params);
    }
}
