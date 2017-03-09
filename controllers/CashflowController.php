<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;
use fredyns\suite\filters\AdminLTELayout;
use app\actioncontrols\CashflowActControl;
use app\models\Cashflow;
use app\models\search\CashflowSearch;
use app\models\form\CashflowForm;
use app\models\form\CashflowCreate;
use app\models\form\CashflowUpdate;
use app\models\form\CashflowDetailForm;

/**
 * This is the class for controller "CashflowController".
 */
class CashflowController extends \app\controllers\base\CashflowController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'layout' => [
                'class' => AdminLTELayout::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'approve' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new CashflowCreate();
        $actionControl = CashflowActControl::checkAccess('create', $model);
        $nextAction = Yii::$app->request->post('next-action', 'done');

        try {
            if ($model->createWithDetail()) {
                Yii::$app->getSession()->addFlash('success', "Data successfully saved!");

                if ($nextAction === 'more') {
                    return $this->redirect(['create']);
                } else {
                    return $this->redirect(ReturnUrl::getUrl(Url::previous()));
                }
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        if (($model = CashflowUpdate::findOne($id)) === null) {
            throw new HttpException(404, 'The requested page does not exist.');
        }

        $actionControl = CashflowActControl::checkAccess('update', $model);

        if ($model->updateWithDetail()) {
            Yii::$app->getSession()->addFlash('success', "Data successfully updated!");

            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }

        return $this->render('update',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }

    public function actionApprove($id)
    {
        try {
            $model = $this->findModel($id);

            CashflowActControl::checkAccess('approve', $model);

            if ($model->approve()) {
                Yii::$app->getSession()->addFlash('info', "Data successfully approved!");
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);
        } finally {
            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }
    }
}