<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\MonthlyBudgetItemSearch */
/* @var $form ActiveForm */
?>

<div class="monthly-budget-item-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'month') ?>

    <?= $form->field($model, 'budgetItem_id') ?>

    <?= $form->field($model, 'openBalance') ?>

    <?= $form->field($model, 'debit') ?>

    <?php // echo $form->field($model, 'credit')?>

    <?php // echo $form->field($model, 'closingBalance')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
