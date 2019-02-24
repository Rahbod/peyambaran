<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'page-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
<div class="m-portlet__body">
    <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

    <?= $form->errorSummary($model) ?>

    <?= \app\components\MultiLangActiveRecord::renderSelectLangInput($form, $model) ?>

    <?php echo $form->field($model, 'image')->widget(\devgroup\dropzone\DropZone::className(), [
        'url' => Url::to(['uploadImage']),
        'removeUrl' => Url::to(['deleteImage']),
        'storedFiles' => isset($serverAttachments) ? $serverAttachments : [],
        'sortable' => false, // sortable flag
        'sortableOptions' => [], // sortable options
        'htmlOptions' => ['class' => '', 'id' => Html::getInputId($model, 'image')],
        'options' => [
            'createImageThumbnails' => false,
            'addRemoveLinks' => true,
            'dictRemoveFile' => 'حذف',
            'addViewLinks' => true,
            'dictViewFile' => 'مشاهده فایل',
            'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
            'acceptedFiles' => 'png, jpeg, jpg',
            'maxFiles' => 1,
            'maxFileSize' => 0.5,
        ],
    ])?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->widget(\app\components\customWidgets\CustomTinyMce::className(), [
        'options' => ['rows' => 6],
    ]); ?>

    <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="reset" class="btn btn-secondary">Cancel</button>
    </div>
</div>
<?php CustomActiveForm::end(); ?>
