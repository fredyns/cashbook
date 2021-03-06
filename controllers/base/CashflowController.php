<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;
use app\models\Cashflow;
use app\models\search\CashflowSearch;
use app\models\form\CashflowForm;
use app\actioncontrols\CashflowActControl;

/**
 * CashflowController implements the CRUD actions for Cashflow model.
 */
class CashflowController extends Controller
{


    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    
    /**
     * Lists all active Cashflow models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashflowSearch;
        $dataProvider = $searchModel->searchIndex($_GET);
        $actionControl = CashflowActControl::checkAccess('index', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'actionControl' => $actionControl,
            'searchModel' => $searchModel,
        ]);
    }

    
    /**
     * Lists deleted active Cashflow models.
     * @return mixed
     */
    public function actionDeleted()
    {
        $searchModel = new CashflowSearch;
        $dataProvider = $searchModel->searchDeleted($_GET);
        $actionControl = CashflowActControl::checkAccess('deleted', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('deleted', [
            'dataProvider' => $dataProvider,
            'actionControl' => $actionControl,
            'searchModel' => $searchModel,
        ]);
    }

    
    /**
     * Displays a single Cashflow model.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $actionControl = CashflowActControl::checkAccess('view', $model);

        Url::remember();
        Tabs::rememberActiveState();

        return $this->render('view', [
            'model' => $model,
            'actionControl' => $actionControl,
        ]);
    }

    /**
     * Creates a new Cashflow model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CashflowForm;
        $actionControl = CashflowActControl::checkAccess('create', $model);

        try {
            if ($model->load($_POST) && $model->save()) {
                Yii::$app->getSession()->addFlash('success', "Data successfully saved!");

                return $this->redirect(ReturnUrl::getUrl(Url::previous()));
            } elseif (!Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create', [
            'model' => $model,
            'actionControl' => $actionControl,
        ]);
    }

    /**
     * Updates an existing Cashflow model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findForm($id);
        $actionControl = CashflowActControl::checkAccess('update', $model);

        if ($model->load($_POST) && $model->save()) {
            Yii::$app->getSession()->addFlash('success', "Data successfully updated!");

            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }

        return $this->render('update',
                [
                'model' => $model,
                'actionControl' => $actionControl,
        ]);
    }

    /**
     * Deletes an existing Cashflow model.
     * If deletion is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);

            CashflowActControl::checkAccess('delete', $model);

            if ($model->delete() !== false) {
                Yii::$app->getSession()->addFlash('info', "Data successfully deleted!");
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);
        } finally {
            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }
    }

    
    /**
     * Restores an deleted Cashflow model.
     * If restoration is successful, the browser will be redirected to the previous page.
     * @param integer $id
     * @return mixed
     */
    public function actionRestore($id)
    {
        try {
            $model = $this->findModel($id);

            CashflowActControl::checkAccess('restore', $model);

            if ($model->restore() !== false) {
                Yii::$app->getSession()->addFlash('success', "Data successfully restored!");
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);
        } finally {
            return $this->redirect(ReturnUrl::getUrl(Url::previous()));
        }
    }

    
    /**
     * Finds the Cashflow model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cashflow the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cashflow::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * Finds the Cashflow form model for modification.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CashflowForm the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findForm($id)
    {
        if (($model = CashflowForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
