<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use fredyns\suite\helpers\ActiveUser;
use fredyns\suite\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\CashflowDetail */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud cashflow-detail-view">

    <h1>
        <?= Yii::t('app', 'Cashflow Detail') ?>
        <small>
            <?= $model->id ?>
            <?php if ($model->recordStatus == 'deleted'): ?>
                <span class="badge">deleted</span>
            <?php endif; ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= $actionControl->buttons(['index', 'create']); ?>
        </div>

        <div class="pull-right">
            <?= $actionControl->buttons(['update', 'delete', 'restore']); ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\CashflowDetail'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\CashflowActControl',
                'attribute' => 'cashflow.number',
            ],
            // generated by fredyns\suite\giiant\crud\providers\core\OptsProvider::attributeFormat
            [
                'attribute' => 'flow',
                'value' => \app\models\CashflowDetail::getFlowValueLabel($model->flow),
            ],
            'nominal',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\BudgetItemActControl',
                'attribute' => 'budgetItem',
            ],
            'notes:ntext',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\MonthlyBudgetItemActControl',
                'attribute' => 'monthlyBudgetItem',
            ],
        ],
    ]);
    ?>

    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('info'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'profileActControl' => 'app\actioncontrols\ProfileActControl',
        'attributes' => [
            [
                'attribute' => 'recordStatus',
                'format' => 'html',
                'value' => '<span class="badge">'.$model->recordStatus.'</span>',
            ],
            [
                'label' => 'Created',
                'blamed' => 'createdBy',
                'timestamp' => 'created_at',
            ],
            [
                'label' => 'Updated',
                'blamed' => 'updatedBy',
                'timestamp' => 'updated_at',
            ],
            [
                'label' => 'Deleted',
                'blamed' => 'deletedBy',
                'timestamp' => 'deleted_at',
            ],
        ],
    ]);
    ?>
    <?php $this->endBlock(); ?>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\CashflowDetail'],
                'active' => true,
            ],
            [
                'content' => $this->blocks['info'],
                'label' => '<small>info</small>',
                'active' => false,
                'visible' => ActiveUser::isAdmin(),
            ],
        ],
    ]);
    ?>

</div>
