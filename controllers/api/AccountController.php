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
use yii\db\Query;
use app\models\Account;

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

    /**
     * profiding model list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionList($q = null, $id = null)
    {
        $minimumInputLength = 2;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => '',
            ],
        ];

        if (!is_null($q) && strlen($q) >= $minimumInputLength) {
            $query = new Query;

            $query
                ->select('id, name AS text')
                ->from('account')
                ->where(['like', 'name', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = Account::findOne($id);

            if ($model) {
                $out['results'] = [
                    'id' => $id,
                    'text' => $model->name,
                ];
            }
        }
        return $out;
    }
}