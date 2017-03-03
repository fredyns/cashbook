<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form ActiveForm */
?>

<div class="account-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Account',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);
    
    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <!-- attribute owner_uid -->
            <?=
            $form->field($model, 'owner_uid')->textInput()
            ?>

            <!-- attribute number -->
            <?=
            $form->field($model, 'number')->textInput(['maxlength' => true])
            ?>

            <!-- attribute name -->
            <?=
            $form->field($model, 'name')->textInput(['maxlength' => true])
            ?>

            <!-- attribute currency -->
            <?=
            $form->field($model, 'currency')->textInput(['maxlength' => true])
            ?>

            <!-- attribute accountStatus -->
            <?=
            // generated by fredyns\suite\giiant\crud\providers\core\OptsProvider::activeField
            $form
                ->field($model, 'accountStatus')
                ->dropDownList(
                    \app\models\Account::optsaccountStatus()
                );
            ?>
        </p>

        <?php $this->endBlock(); ?>
        
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label'   => Yii::t('app', 'Account'),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ],
        ]);
        ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?=
        Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
        );
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

