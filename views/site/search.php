<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\JobContainerSearch $searchModel
 */
$this->title = Yii::t('app', 'Search');
$this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['search', 'number' => $searchTerm]];
?>

<div class="giiant-crud site-search">

    <h1>
        <?= Yii::t('app', 'Search') ?>
    </h1>

    <div class="site-search">

        <?php
        $form = ActiveForm::begin([
                'action' => ['search'],
                'method' => 'get',
        ]);
        ?>

        <div class="form-group field-number required">
            <label class="col-lg-3 control-label" for="number">Keyword</label>
            <div class="col-lg-9">
                <input type="text" id="sitesearch" class="form-control" name="sitesearch" value="<?= $sitesearch ?>">
            </div>
        </div>

        <br/>
        <br/>

        <div class="form-group col-sm-offset-3 col-lg-9">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="clearfix"></div>

</div>
