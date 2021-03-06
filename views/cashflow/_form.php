<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\money\MaskMoney;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use app\models\form\CashflowDetailCreate;

/* @var $this yii\web\View */
/* @var $model app\models\form\CashflowCreate|app\models\form\CashflowUpdate */
/* @var $form ActiveForm */

$minDetailCount = 5;
$formname = $model->formName();
?>

<style>
    tr.danger * {
        text-decoration: line-through;
    }
</style>

<div class="cashflow-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'CashflowForm',
            //'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);

    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    echo Html::hiddenInput('next-action', 'done', ['id' => 'next-action']);
    ?>

    <div class="">

        <div class="form-master">

            <!-- attribute cashflowType_id -->
            <?=
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
            $form->field($model, 'cashflowType_id')->dropDownList(
                \app\models\CashflowType::options(),
                [
                'prompt' => 'Select',
                'disabled' => (isset($relAttributes) && isset($relAttributes['cashflowType_id'])),
                ]
            );
            ?>

            <!-- attribute number -->
            <?=
            $form->field($model, 'number')->textInput(['maxlength' => true])
            ?>

            <!-- attribute date -->
            <?=
            // generated by fredyns\suite\giiant\crud\providers\extensions\DateProvider::activeField
                $form
                ->field($model, 'date')
                // TODO: must configured properly together with model
                ->widget(\yii\jui\DatePicker::classname(),
                    [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control',
                    ],
                ])
            ?>

            <!-- attribute account_id -->
            <?=
                $form
                ->field($model, 'account_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => ArrayHelper::getValue($model, 'account.label', '-'),
                    'options' => ['placeholder' => 'mencari rekening ...'],
                    'pluginOptions' => [
                        'minimumInputLength' => 2,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['/api/account/list']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(item) { return item.text; }'),
                        'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                    ],
            ]);
            ?>

            <!-- attribute notes -->
            <?=
            $form->field($model, 'notes')->textarea(['rows' => 6])
            ?>

            <?= $form->errorSummary($model); ?>

        </div>
        <hr/>

        <div class="form-detail">

            <?php
            $newDetailCount = Yii::$app->request->get('detailCount');

            if (empty($newDetailCount) OR $newDetailCount < $minDetailCount) {
                $newDetailCount = $minDetailCount;
            }

            for ($i = 1; $i <= $newDetailCount; $i++) {
                $model->allDetails[] = new CashflowDetailCreate([
                    'recordStatus' => CashflowDetailCreate::RECORDSTATUS_DELETED,
                    'nominal' => 0,
                ]);
            }

            echo TabularForm::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $model->allDetails,
                    'pagination' => FALSE,
                    ]),
                'form' => $form,
                'actionColumn' => FALSE,
                'checkboxColumn' => [
                    'class' => '\kartik\grid\CheckboxColumn',
                    'contentOptions' => ['class' => 'kv-row-select'],
                    'headerOptions' => ['class' => 'kv-all-select'],
                    'header' => '<i class="glyphicon glyphicon-trash"></i>',
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        $classSlug = $model->isNewRecord ? 'cashflowdetailcreate' : 'cashflowdetailupdate';

                        return [
                            'value' => $classSlug."-{$key}-recordstatus",
                        ];
                    }
                ],
                'attributes' => [
                    // primary key column
                    'id' => [// primary key attribute
                        'type' => TabularForm::INPUT_HIDDEN,
                        'columnOptions' => ['hidden' => true],
                    ],
                    'recordStatus' => [
                        'type' => TabularForm::INPUT_HIDDEN,
                        'columnOptions' => ['hidden' => true],
                        'options' => ['class' => 'detail-recordStatus'],
                    ],
                    'flow' => [
                        'type' => TabularForm::INPUT_DROPDOWN_LIST,
                        'items' => CashflowDetailCreate::optsFlow(),
                        'columnOptions' => ['width' => '100px']
                    ],
                    'nominal' => [
                        'type' => TabularForm::INPUT_WIDGET,
                        'widgetClass' => MaskMoney::classname(),
                        'columnOptions' => ['width' => '160px'],
                        'options' => [
                            'options' => [
                                'style' => 'text-align: right;',
                            ],
                        ],
                    ],
                    'budgetItem_id' => [
                        'type' => TabularForm::INPUT_WIDGET,
                        'widgetClass' => Select2::classname(),
                        'options' => function($detailModel, $key, $index, $widget) {
                            return [
                                'initValueText' => ArrayHelper::getValue($detailModel, 'budgetItem.label', '-'),
                                'options' => ['placeholder' => 'mencari mata anggaran ...'],
                                'pluginOptions' => [
                                    'minimumInputLength' => 2,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to(['/api/budget-item/list']),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                                ],
                            ];
                        },
                    //'columnOptions' => ['width' => '170px']
                    ],
                    'notes' => [
                        'type' => TabularForm::INPUT_TEXT,
                    ],
                ],
                'gridSettings' => [
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        return [
                            'class' => $model->isNewRecord ? 'CashflowDetailCreate' : 'CashflowUpdate',
                        ];
                    },
                    'panel' => [
                        'heading' => '<h3 class="panel-title">Cashflow Details</h3>',
                        'type' => GridView::TYPE_PRIMARY,
                        'footer' => ''
                        .Html::button(
                            '<i class="glyphicon glyphicon-plus"></i> Add New Detail'
                            , ['id' => 'add-new-detail', 'class' => 'btn btn-info pull-right']
                        ),
                    ]
                ],
            ]);
            ?>

        </div>

        <hr/>

        <?php
        echo Html::button(
            '<span class="glyphicon glyphicon-check"></span> Save &amp; Done',
            [
            'id' => 'save-'.$formname,
            'class' => 'btn btn-success form-submit'
            ]
        )
        .' &nbsp; &nbsp; ';

        if ($model->isNewRecord) {
            echo Html::button(
                '<span class="glyphicon glyphicon-check"></span> Save &amp; Create More',
                [
                'id' => 'more-'.$formname,
                'class' => 'btn btn-primary form-submit'
                ]
            );
        }
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS

	$(function () {
        $(".CashflowDetailCreate:first .detail-recordStatus").val("active");
        $(".CashflowDetailCreate:gt(0)").hide();

        $("#add-new-detail").click(function(){
            $(".CashflowDetailCreate:hidden:first .detail-recordStatus").val("active");
            $(".CashflowDetailCreate:hidden:first").show();
        });

        $(".form-submit").click(function(){
            $("#CashflowForm").submit();
        });

        $("#more-{$formname}").click(function(){
            $("#next-action").val("more");
        });

        $(".kv-row-checkbox:checkbox").click(function(){
            statusId = $(this).val();

            if($(this).prop('checked') == true){
                $("#"+statusId).val("deleted");
            } else {
                $("#"+statusId).val("active");
            }
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

