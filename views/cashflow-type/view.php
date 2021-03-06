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
/* @var $model app\models\CashflowType */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud cashflow-type-view">

    <h1>
        <?= Yii::t('app', 'Cashflow Type') ?>
        <small>
            <?= $model->name ?>
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

    <?php $this->beginBlock('app\models\CashflowType'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]);
    ?>

    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('Cashflows'); ?>

    <?php
    Pjax::begin([
        'id' => 'pjax-Cashflows',
        'enableReplaceState' => false,
        'linkSelector' => '#pjax-Cashflows ul.pagination a, th a',
        'clientOptions' => [
            'pjax:success' => 'function(){alert(\"yo\")}',
        ],
    ]);

    // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
    $CashflowActControl = new \app\actioncontrols\CashflowActControl;

    $addCashflow = $CashflowActControl->button('create',
        [
        'label' => 'New Cashflow',
        'urlOptions' => [
            'CashflowForm' => ['cashflowType_id' => $model->id],
        ],
    ]);

    echo '<div class=\"table-responsive\">';
    echo GridView::widget([
        //'layout' => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getCashflows(),
            'pagination' => [
                'pageSize' => 50,
                'pageParam' => 'page-cashflows',
            ]
            ]),
        'pager' => [
            'class' => yii\widgets\LinkPager::className(),
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last'
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class' => 'x'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'number',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::columnFormat
            [
                'attribute' => 'account_id',
                'options' => [],
                'format' => 'raw',
                'value' => function ($model) {
                    return \fredyns\suite\widgets\LinkedDetail::widget([
                            'model' => $model,
                            'attribute' => 'account',
                            'actionControl' => 'app\actioncontrols\AccountActControl',
                    ]);
                },
            ],
            'date',
            'approval',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
            [
                'class' => 'fredyns\suite\grid\KartikActionColumn',
                'actionControl' => 'app\actioncontrols\CashflowActControl',
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => false, // pjax is set to always true for this demo
        'toolbar' => [
            $addCashflow.' {export}',
        ],
        'export' => [
            'icon' => 'export',
            'label' => 'Export',
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => true,
        'pageSummaryRowOptions' => [
            'class' => 'kv-page-summary',
            'style' => 'height: 100px;'
        ],
        'persistResize' => false,
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Save as EXCEL',
                'filename' => $this->title.' - Cashflow',
            ],
            GridView::PDF => [
                'label' => 'Save as PDF',
                'filename' => $this->title.' - Cashflow',
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => false,
        ],
        'panelBeforeTemplate' => '
            <div class="clearfix">{summary}</div>
            <div class="pull-right">
                <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
                    {toolbar}
                </div>
            </div>
            <div class="pull-left">
                <div class="kv-panel-pager">
                    {pager}
                </div>
            </div>
            {before}
            <div class="clearfix"></div>
        ',
    ]);
    echo '</div>';

    Pjax::end();
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
            /* /
              [
              'label' => '<b class=""># '.$model->id.'</b>',
              'content' => $this->blocks['app\models\CashflowType'],
              'active' => true,
              ],
              // */
            [
                'content' => $this->blocks['Cashflows'],
                'label' => '<small>Cashflows <span class="badge badge-default">'
                .$model->getCashflows()->count()
                .'</span></small>',
                'active' => false,
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
