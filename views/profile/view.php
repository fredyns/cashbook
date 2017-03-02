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
/* @var $model app\models\Profile */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud profile-view">

    <h1>
        <?= Yii::t('app', 'Profile') ?>
        <small>
            <?= $model->name ?>
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

    <?php $this->beginBlock('app\models\Profile'); ?>    
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'bio:ntext',
            'timezone',
            'public_email:email',
            'gravatar_email:email',
            'website',
            'name',
            'location',
            'phone',
            'address:ntext',
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
                'content' => $this->blocks['app\models\Profile'],
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
