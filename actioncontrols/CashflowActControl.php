<?php

namespace app\actioncontrols;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use kartik\icons\Icon;
use app\models\Cashflow;

/**
 * Cashflow model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property Cashflow $model data model
 * @property string $allowApprove is allowing to Approve model
 * @property array $urlApprove url config for Approve model
 */
class CashflowActControl extends \fredyns\suite\libraries\ActionControl
{
    const ACTION_APPROVE = 'approve';

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/cashflow';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'Cashflow',
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function modelLabel()
    {
        return parent::modelLabel();
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [
            'forbidden' => "%s is not allowed.",
            'notconfigured' => "%s is not configured properly.",
            'model-unknown' => "Unknown Data.",
            'model-unsaved' => "Can't %s unsaved data.",
            'model-deleted' => "Data already (soft) deleted.",
            'model-active' => "Data is not deleted.",
            'softdelete-unsupported' => "Data doesn't support soft-delete.",
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionPersistentModel()
    {
        return ArrayHelper::merge(
                parent::actionPersistentModel(),
                [
                #  additional action name
                static::ACTION_APPROVE,
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actionUnspecifiedModel()
    {
        return ArrayHelper::merge(
                parent::actionUnspecifiedModel(), [
                # additional action name
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(
                parent::actions(),
                [
                static::ACTION_APPROVE => [
                    'label' => 'Approve',
                    'url' => $this->urlApprove,
                    'icon' => Icon::show('check-square-o'),
                    'linkOptions' => [
                        'title' => 'click approve this cashflow',
                        'aria-label' => 'Approve',
                        'data-pjax' => '0',
                        'data-confirm' => 'Are you sure to approve this item?',
                        'data-method' => 'post',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-primary',
                    ],
                ],
                /* / action sample / */

                # 'action_name' => [
                #     'label'         => 'Action_Label',
                #     'url'           => $this->urlAction,
                #     'icon'          => Icon::show('star'),
                #     'linkOptions'   => [
                #         'title'      => 'click to do action',
                #         'aria-label' => 'Action_Label',
                #         'data-pjax'  => '0',
                #     ],
                #     'buttonOptions' => [
                #         'class' => 'btn btn-default',
                #     ],
                # ],
                ]
        );
    }

    /**
     * check permission to access Deleted page
     *
     * @return boolean
     */
    public function getAllowDeleted($params = [])
    {
        return true;
    }

    /**
     * get URL param to approve model
     *
     * @return array
     */
    public function getUrlApprove()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute(static::ACTION_APPROVE);
            $param['ru'] = ReturnUrl::getToken();

            return $param;
        }

        return [];
    }

    /**
     * check permission to approve model
     *
     * @return boolean
     */
    public function getAllowApprove($params = [])
    {
        return ($this->model->approval == Cashflow::APPROVAL_PENDING);
    }
    ################################ sample : additional action ################################

    /**
     * get URL param to do action
     *
     * @return array
     */
    public function getUrlAction()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('action_slug');
            $param['ru'] = ReturnUrl::getToken();

            return $param;
        }

        return [];
    }

    /**
     * check permission to do action
     *
     * @return boolean
     */
    public function getAllowAction($params = [])
    {
        return true;
    }
}