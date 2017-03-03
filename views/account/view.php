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
/* @var $model app\models\Account */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud account-view">

    <h1>
        <?= Yii::t('app', 'Account') ?>
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

    <?php $this->beginBlock('app\models\Account'); ?>    
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'owner_uid',
            'number',
            'name',
            'currency',
            // generated by fredyns\suite\giiant\crud\providers\core\OptsProvider::attributeFormat
            [
                'attribute' => 'accountStatus',
                'value' => \app\models\Account::getAccountStatusValueLabel($model->accountStatus),
            ],
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
    
    $addCashflow = $CashflowActControl->button('create', [
        'label' => 'New Cashflow',
        'urlOptions' => [
            'CashflowForm' => ['account_id' => $model->id],
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
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::columnFormat
            [
                'attribute' => 'cashflowType_id',
                'options' => [],
                'format' => 'raw',
                'value' => function ($model) {
                    return \fredyns\suite\widgets\LinkedDetail::widget([
                        'model' => $model,
                        'attribute' => 'cashflowType',
                        'actionControl' => 'app\actioncontrols\CashflowTypeActControl',
                    ]);
                },
            ],
            'number',
            'date',
            'approval',
            'notes:ntext',
            'approved_at',
            'approved_by',
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
                'filename' => $this->title . ' - Cashflow',
            ],
            GridView::PDF => [
                'label' => 'Save as PDF',
                'filename' => $this->title . ' - Cashflow',
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
            [
                'label' => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\Account'],
                'active' => true,
            ],
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
