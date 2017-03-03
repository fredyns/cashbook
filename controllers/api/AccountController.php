<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "AccountController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\AccountActControl;

class AccountController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Account';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        AccountActControl::checkAccess($action, $model, $params);
    }
}
