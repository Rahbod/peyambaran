<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Person;

/* @var $this yii\web\View */
/* @var $model app\models\ClinicProgram */
/* @var $form app\components\customWidgets\CustomActiveForm */

$searchModel = new \app\models\PersonSearch();
$searchModel->type = Person::TYPE_DOCTOR;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$dayID = $model->isNewRecord ? false : $model->id;
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'clinic-program-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]);
?>
    <div class="m-portlet__body">
        <div class="m-form__content">
            <?= $this->render('//layouts/_flash_message') ?>
        </div>

        <?= $form->errorSummary($model) ?>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group m-form__group">
                    <?= Html::label($model->getAttributeLabel('date'), '', ['class' => 'col-form-label control-label']) ?>
                    <?= Html::textInput('', jDateTime::date('l d F Y', $model->date), ['readonly' => true, 'class' => 'form-control m-input m-input--solid disabled']) ?>
                </div>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'is_holiday', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox(['id' => 'content-trigger'], false) ?>
            </div>
        </div>

        <div class="content-box mt-5" style="display: none">
            <div class="container-fluid">
                <div class="container-fluid">
                    <h5><?= Yii::t('words', 'Doctors') ?></h5>
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => \app\components\customWidgets\CustomCheckboxColumn::className(),
                                'header' => Yii::t('words', 'Presence Status'),
                                'checkboxOptions' => function ($model, $key, $index, $column) use ($dayID) {
                                    $checked = false;
                                    if ($dayID) {
                                        $rel = $model->getProgramRel($dayID);
                                        $checked = !is_null($rel);
                                    }
                                    return [
                                        'name' => "ClinicProgram[doctors][{$model->id}][personID]",
                                        'value' => $model->personID,
                                        'checked' => $checked
                                    ];
                                },
                                'options' => ['width' => '5%']
                            ],
                            [
                                'attribute' => 'name',
                                'header' => Yii::t('words', 'Doctor Name'),
                                'value' => function ($model) {
                                    return $model->name;
                                }
                            ],
                            [
                                'header' => Yii::t('words', 'Start Time'),
                                'value' => function ($model) use ($dayID) {
                                    $value = '';
                                    if ($dayID) {
                                        $rel = $model->getProgramRel($dayID);
                                        $value = $rel ? $rel->start_time : '';
                                    }
                                    return Html::textInput("ClinicProgram[doctors][{$model->id}][start_time]", $value, ['class' => 'form-control m-input m-input--air']);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'header' => Yii::t('words', 'End Time'),
                                'value' => function ($model) use ($dayID) {
                                    $value = '';
                                    if ($dayID) {
                                        $rel = $model->getProgramRel($dayID);
                                        $value = $rel ? $rel->end_time : '';
                                    }
                                    return Html::textInput("ClinicProgram[doctors][{$model->id}][end_time]", $value, ['class' => 'form-control m-input m-input--air']);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'header' => Yii::t('words', 'Description'),
                                'value' => function ($model) use ($dayID) {
                                    $value = '';
                                    if ($dayID) {
                                        $rel = $model->getProgramRel($dayID);
                                        $value = $rel ? $rel->description: '';
                                    }
                                    return Html::textInput("ClinicProgram[doctors][{$model->id}][description]", $value, ['class' => 'form-control m-input m-input--air']);
                                },
                                'format' => 'raw'
                            ]
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel') ?></button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>


<?php
$this->registerJs('
    if(!$("#content-trigger").is(":checked"))
        $(".content-box").show();
 
    $("body").on("change", "#content-trigger", function(){
        if(!$(this).is(":checked"))
            $(".content-box").show();
        else
            $(".content-box").hide();
    });
', \yii\web\View::POS_READY, 'content-trigger');