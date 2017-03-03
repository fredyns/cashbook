<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\CashflowDetailSearch */
/* @var $form ActiveForm */
?>

<div class="cashflow-detail-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'cashflow_id') ?>

    <?= $form->field($model, 'flow') ?>

    <?= $form->field($model, 'nominal') ?>

    <?= $form->field($model, 'budgetItem_id') ?>

    <?= $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'monthlyBudgetItem_id')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
