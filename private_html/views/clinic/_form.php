<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Person;

/* @var $this yii\web\View */
/* @var $model app\models\ClinicProgram */
/* @var $form app\components\customWidgets\CustomActiveForm */

$dayID = $model->isNewRecord ? (Yii::$app->request->getQueryParam('copy') ?: false) : $model->id;
$cmodel = \app\models\ClinicProgram::findOne($dayID);
$ids = \yii\helpers\ArrayHelper::getColumn($cmodel->personsRel, 'personID');

$searchModel = new \app\models\PersonSearch();
$searchModel->type = Person::TYPE_DOCTOR;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams, $ids);

$this->registerJs('
    $("body").on("change", "#copy-day", function(){
        var url = $(this).data("url");
        var val = $(this).val();
        window.location = url+"?copy="+val;
    });
');
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'clinic-form',
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
                <div class="form-group m-form__group has-danger">
                    <?= Html::label($model->getAttributeLabel('date'), '', ['class' => 'col-form-label control-label']) ?>
                    <?= Html::textInput('', jDateTime::date('l d F Y', $model->date), ['readonly' => true, 'class' => 'form-control m-input m-input--solid disabled text-danger', 'style' => 'font-weight: bold']) ?>
                </div>
            </div>
            <?php if ($model->isNewRecord): ?>
                <div class="col-sm-4 well">
                    <div class="form-group m-form__group">
                        <?= Html::label(Yii::t('words', 'Copy from'), '', ['class' => 'col-form-label control-label']) ?>
                        <?= Html::dropDownList('copy', Yii::$app->request->getQueryParam('copy'), \yii\helpers\ArrayHelper::map(\app\models\ClinicProgram::find()->all(), 'id', function ($model) {
                            return jDateTime::date('l d F Y', $model->date);
                        }), [
                            'data-url' => \yii\helpers\Url::to(['create']),
                            'class' => 'form-control m-input m-input--solid',
                            'id' => 'copy-day',
                            'prompt' => Yii::t('words', 'Select Day...'),
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-sm-4">
                <?php echo $form->field($model, 'is_holiday', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox(['id' => 'content-trigger'], false) ?>
            </div>
        </div>

        <div class="content-box mt-5" style="display: none">
            <div class="container-fluid">
                <div class="container-fluid">
                    <h5><?= Yii::t('words', 'Doctors') ?>
                        <button type="button" data-toggle="modal" data-target="#add-doctor"
                                class="btn btn-sm btn-primary"><?= Yii::t('words', 'Add Doctor') ?></button>
                    </h5>
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => '{items}',
                        'columns' => [
//                            [
//                                'class' => \app\components\customWidgets\CustomCheckboxColumn::className(),
//                                'header' => Yii::t('words', 'Presence Status'),
//                                'checkboxOptions' => function ($model, $key, $index, $column) use ($dayID) {
//                                    $checked = false;
//                                    if ($dayID) {
//                                        $rel = $model->getProgramRel($dayID);
//                                        $checked = !is_null($rel);
//                                    }
//                                    return [
//                                        'name' => "ClinicProgram[doctors][{$model->id}][personID]",
//                                        'value' => $model->personID,
//                                        'checked' => $checked
//                                    ];
//                                },
//                                'options' => ['width' => '5%']
//                            ],
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
                                        $value = $rel ? $rel->description : '';
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


    <div class="modal fade" id="add-doctor" rel="dialog">
        <div class="modal-dialog">
            <?php
            $relModel = new \app\models\PersonProgramRel();
            $doctorForm = CustomActiveForm::begin([
                'id' => 'add-doctor-form',
                'action' => ['add-doctor'],
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validateOnSubmit' => true,
            ]);
            echo $doctorForm->field($relModel, 'dayID', ['value' => $model->isNewRecord?null:$dayID]);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?= Yii::t('words', 'Add Doctor') ?></h3>
                </div>
                <div class="modal-body">
                    <?= $doctorForm->field($relModel, 'personID')->dropDownList(\yii\helpers\ArrayHelper::map(Person::find()->valid()->all(), 'id', 'name'))->label(Yii::t('words', 'Doctor Name')) ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $doctorForm->field($relModel, 'start_time')->textInput() ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $doctorForm->field($relModel, 'end_time')->textInput() ?>
                        </div>
                    </div>

                    <?= $doctorForm->field($relModel, 'description')->textarea(['rows' => 3]) ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal"><?= Yii::t('words', 'Cancel') ?></button>
                </div>
            </div>
            <?php CustomActiveForm::end(); ?>
        </div>
    </div>

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