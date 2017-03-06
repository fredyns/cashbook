<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\AccountSearch */
/* @var $form ActiveForm */
?>

<div class="account-search">

    <?php
    $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'cif') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'currency') ?>

    <?= $form->field($model, 'accountStatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
