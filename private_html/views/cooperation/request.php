<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Cooperation */

$this->registerJs('
    $(".fields-type-"+$("#cooperation-type-trigger").val()).addClass("show");
    $("body").on("change", "#cooperation-type-trigger", function(){
        var val = $(this).val();
        $(".fields-container").not(".fields-type-"+val).removeClass("show");
        $(".fields-container").not(".fields-type-"+val).find("input").prop("disabled", true);
        $(".fields-type-"+val).addClass("show").find("input").prop("disabled", false);
    });');

$this->registerJs('
    $("body").on("click", ".table-add-row-trigger", function (e) {
        e.preventDefault();
        var table = $(this).parents("table");
        var i = table.find("tbody tr").length;
        var namePrefix = "Cooperation[job_history][" + i + "]";
        var html = "<tr>" +
            "<td><input name=\"" + namePrefix + "[place]\" class=\'form-control\'></td>" +
            "<td><input name=\"" + namePrefix + "[type]\" class=\'form-control\'></td>" +
            "<td><input name=\"" + namePrefix + "[end_date]\" class=\'form-control\' placeholder=\'__/__/____\'></td>" +
            "<td><input name=\"" + namePrefix + "[cause]\" class=\'form-control\'></td>" +
            "<td><input name=\"" + namePrefix + "[contact]\" class=\'form-control\'></td>" +
            "</tr>";
        table.find("tbody").append(html);
    });
');
?>

<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Cooperation request') ?></h1>
        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
    </div>
</div>
<div class="col-sm-12">
    <div class="row mt-5 mb-4">
        <?= Html::a(Yii::t('words', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-primary pull-left']) ?>
    </div>
    <div class="row mb-5 contactUs__container dashboard__form-container">
        <?php $form = ActiveForm::begin([
            'id' => 'user-request-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
            'options' => ['class' => 'contactUs__form']
        ]); ?>

        <p><?= Yii::t('words', 'cooperation_text') ?></p>
        <?= $form->errorSummary($model) ?>
        <div class="row">
            <?= $model->formRenderer($form, '{field}', 'col-sm-4') ?>

            <!--Official and assistance edu history-->
            <div class="col-sm-12 mt-4 fields-container fields-type-1 fields-type-2">
                <?= Html::label($model->getAttributeLabel('edu_history')) ?>
                <table class="table bg-white table-bordered">
                    <thead>
                    <tr>
                        <th><?= Yii::t('words', 'Field') ?></th>
                        <th><?= Yii::t('words', 'Course') ?></th>
                        <th><?= Yii::t('words', 'Graduation date') ?></th>
                        <th width="40%"><?= Yii::t('words', 'Name and address') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (\app\models\Cooperation::getGradeLabels() as $grade => $label):
                        $field = !$model->isNewRecord && isset($model->edu_history[$grade]['field']) ? $model->edu_history[$grade]['field'] : null;
                        $graduation_date = !$model->isNewRecord && isset($model->edu_history[$grade]['graduation_date']) ? $model->edu_history[$grade]['graduation_date'] : null;
                        $detail = !$model->isNewRecord && isset($model->edu_history[$grade]['detail']) ? $model->edu_history[$grade]['detail'] : null;
                        ?>
                        <tr>
                            <td><?= $label ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][field]", $field, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][graduation_date]", $graduation_date, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++,'placeholder' => '__/__/____']) ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][detail]", $detail, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!--Medical edu history-->
            <div class="col-sm-12 mt-4 fields-container fields-type-3">
                <?= Html::label($model->getAttributeLabel('edu_history')) ?>
                <table class="table bg-white table-bordered">
                    <thead>
                    <tr>
                        <th><?= Yii::t('words', 'Field') ?></th>
                        <th><?= Yii::t('words', 'Course') ?></th>
                        <th><?= Yii::t('words', 'Graduation date') ?></th>
                        <th width="40%"><?= Yii::t('words', 'Name and address') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (\app\models\Cooperation::getGradeLabels(true) as $grade => $label):
                        $field = !$model->isNewRecord && isset($model->edu_history[$grade]['field']) ? $model->edu_history[$grade]['field'] : null;
                        $graduation_date = !$model->isNewRecord && isset($model->edu_history[$grade]['graduation_date']) ? $model->edu_history[$grade]['graduation_date'] : null;
                        $detail = !$model->isNewRecord && isset($model->edu_history[$grade]['detail']) ? $model->edu_history[$grade]['detail'] : null;
                        ?>
                        <tr>
                            <td><?= $label ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][field]", $field, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][graduation_date]", $graduation_date, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++,'placeholder' => '__/__/____']) ?></td>
                            <td><?= Html::textInput("Cooperation[edu_history][{$grade}][detail]", $detail, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!--Job history-->
            <div class="col-sm-12">
                <?= Html::label($model->getAttributeLabel('job_history')) ?>
                <table class="table bg-white table-bordered">
                    <thead>
                    <tr>
                        <th><?= Yii::t('words', 'Employment place') ?></th>
                        <th><?= Yii::t('words', 'Cooperation type') ?></th>
                        <th><?= Yii::t('words', 'Completion date') ?></th>
                        <th><?= Yii::t('words', 'Cause of quitting activity') ?></th>
                        <th width="40%"><?= Yii::t('words', 'Address and contact number') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;
                    foreach ($model->job_history as $key => $item):
                        $place = !$model->isNewRecord && isset($item['place']) ? $item['place'] : null;
                        $type = !$model->isNewRecord && isset($item['type']) ? $item['type'] : null;
                        $end_date = !$model->isNewRecord && isset($item['end_date']) ? $item['end_date'] : null;
                        $cause = !$model->isNewRecord && isset($item['cause']) ? $item['cause'] : null;
                        $contact = !$model->isNewRecord && isset($item['contact']) ? $item['contact'] : null;
                        ?>
                        <tr>
                            <td><?= Html::textInput("Cooperation[job_history][{$key}][place]", $place, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                            <td><?= Html::textInput("Cooperation[job_history][{$key}][type]", $type, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                            <td><?= Html::textInput("Cooperation[job_history][{$key}][end_date]", $end_date, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++,'placeholder' => '__/__/____']) ?></td>
                            <td><?= Html::textInput("Cooperation[job_history][{$key}][cause]", $cause, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                            <td><?= Html::textInput("Cooperation[job_history][{$key}][contact]", $contact, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        </tr>
                        <?php $i++;endforeach; ?>
                    <tr>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][place]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][type]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][end_date]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++,'placeholder' => '__/__/____']) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][cause]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][contact]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                    </tr>
                    <?= $i++; ?>
                    <tr>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][place]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][type]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][end_date]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++,'placeholder' => '__/__/____']) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][cause]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                        <td><?= Html::textInput("Cooperation[job_history][{$i}][contact]", null, ['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" class="text-center"><a href="#" class="table-add-row-trigger" type="button"
                                                               style="width: 100%;height: 100%;display: inline-block"><i
                                        class="icon icon-plus"></i></a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4><?= $model->getAttributeLabel('language_level') ?></h4>
                <div class="form-group">
                    <fieldset>
                        <label>زبان انگلیسی:</label>
                        <label>
                            <input type="radio" name="Cooperation[language_level]" value="1" tabindex="<?= \app\models\Cooperation::$tabindex++ ?>">
                            متوسط
                        </label>
                        <label>
                            <input type="radio" name="Cooperation[language_level]" value="2" tabindex="<?= \app\models\Cooperation::$tabindex++ ?>">
                            خوب
                        </label>
                        <label>
                            <input type="radio" name="Cooperation[language_level]" value="3" tabindex="<?= \app\models\Cooperation::$tabindex++ ?>">
                            عالی
                        </label>
                    </fieldset>
                </div>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'language_cert')->textInput(['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'other_language_cert')->textInput(['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 mt-4 fields-container fields-type-1">
                <h4><?= $model->getAttributeLabel('military_status') ?></h4>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <fieldset>
                                <label>
                                    <input type="radio" name="Cooperation[military_status]" value="1" tabindex="<?= \app\models\Cooperation::$tabindex++ ?>">
                                    انجام دادم
                                </label>
                                <label>
                                    <input type="radio" name="Cooperation[military_status]" value="0" tabindex="<?= \app\models\Cooperation::$tabindex++ ?>">
                                    معافیت
                                </label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'military_reason')->textInput(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('military_reason'), 'tabindex' => \app\models\Cooperation::$tabindex++])->label(false) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'military_date')->textInput(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('military_date'), 'tabindex' => \app\models\Cooperation::$tabindex++])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-4 fields-container fields-type-1 fields-type-2">
                <h4><?= $model->getAttributeLabel('skills') ?></h4>
                <?= $form->field($model, 'skills')->textarea(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('skills'), 'rows' => 3, 'tabindex' => \app\models\Cooperation::$tabindex++])->label(false) ?>
            </div>
            <div class="col-sm-12 mt-4 fields-container fields-type-1 fields-type-2">
                <h4><?= $model->getAttributeLabel('activity_requested') ?></h4>
                <?= $form->field($model, 'activity_requested')->textarea(['class' => 'form-control', 'rows' => 3, 'tabindex' => \app\models\Cooperation::$tabindex++])->label(false) ?>
            </div>
            <!--End Official and Assistance fields-->

            <!--Begin Medical fields-->
            <div class="row fields-container fields-type-3">
                <div class="col-sm-12 mt-4">
                    <h4><?= Yii::t('words', 'Work permits') ?></h4>
                    <?= $form->field($model, 'work_permits_status')->radioList([
                        1 => 'پروانه موقت',
                        2 => 'پروانه مطب',
                        3 => 'پروانه دائم',
                    ],['tabindex' => \app\models\Cooperation::$tabindex++])?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'work_permits_expire')->textInput(['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'medical_number')->textInput(['class' => 'form-control', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?>
                </div>

                <div class="col-sm-4">
                    <?= $form->field($model, 'activity_date')->textInput(['class' => 'form-control','placeholder' => '__/__/____', 'tabindex' => \app\models\Cooperation::$tabindex++]) ?>
                </div>

                <div class="col-sm-12">
                    <h4><?= $model->getAttributeLabel('resume') ?></h4>
                    <?= $form->field($model, 'resume')->textarea(['class' => 'form-control', 'rows' => 3, 'tabindex' => \app\models\Cooperation::$tabindex++])->label(false) ?>
                </div>
            </div>
            <!--Begin Medical fields-->
        </div>

        <?= Html::submitButton(Yii::t('words', 'Submit'), ['class' => 'btn dashboard__form--btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<style>
    .fields-container {
        display: none;
    }

    .fields-container.show {
        display: block;
    }
</style>