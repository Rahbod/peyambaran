<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use \yii\helpers\Url;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'person-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
<div class="m-portlet__body">
    <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
    <?php
    echo $form->errorSummary($model)
    ?>
    <?php echo $form->field($model, 'avatar')->widget(\devgroup\dropzone\DropZone::className(), [
        'url' => Url::to(['upload-avatar']),
        'removeUrl' => Url::to(['delete-avatar']),
        'storedFiles' => isset($avatar) ? $avatar : [],
        'sortable' => false, // sortable flag
        'sortableOptions' => [], // sortable options
        'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'avatar')],
        'options' => [
            'createImageThumbnails' => true,
            'addRemoveLinks' => true,
            'dictRemoveFile' => 'حذف',
            'addViewLinks' => true,
            'dictViewFile' => '',
            'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
            'acceptedFiles' => 'png, jpeg, jpg',
            'maxFiles' => 1,
            'maxFileSize' => 0.2,
        ],
    ])->hint('100x100 pixel') ?>

<!--            --><?//= $form->field($model, 'type')->dropDownList(\app\models\Person::getTypeLabels()) ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'medical_number')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'fellowship', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'priority', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'surename')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'type')->dropDownList(\app\models\Person::getTypeLabels(), ['prompt' => Yii::t('words', 'Select Type')]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'expertise')->dropDownList(Category::getWithType(Category::CATEGORY_TYPE_EXPERTISE), ['prompt' => Yii::t('words', 'Select Expertise')]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'experience', ['template' => "{label}\n<div class='input-group'>{input}<div class='input-group-append'><span class='input-group-text'>سال</span></div></div>\n{hint}\n{error}"])->textInput() ?>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'ar_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'resume')->textarea(['rows' => 6]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'en_resume')->textarea(['rows' => 6]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'ar_resume')->textarea(['rows' => 6]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'en_status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'ar_status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel')?></button>
    </div>
</div>
<?php CustomActiveForm::end(); ?>
