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
use yii\db\Query;
use app\models\BudgetItem;

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
                ->select("id, CONCAT(code, ' - ', description) AS text")
                ->from('budgetItem')
                ->where([
                    'or',
                    ['like', 'code', $q],
                    ['like', 'description', $q]
                ])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = BudgetItem::findOne($id);

            if ($model) {
                $out['results'] = [
                    'id' => $id,
                    'text' => $model->label,
                ];
            }
        }
        return $out;
    }
}