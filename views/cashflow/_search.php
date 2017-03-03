<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\CashflowSearch */
/* @var $form ActiveForm */
?>

<div class="cashflow-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'cashflowType_id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'approval') ?>

    <?= $form->field($model, 'account_id') ?>

    <?php // echo $form->field($model, 'notes')?>

    <?php // echo $form->field($model, 'approved_at')?>

    <?php // echo $form->field($model, 'approved_by')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
