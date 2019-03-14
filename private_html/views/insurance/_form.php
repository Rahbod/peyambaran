<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Insurance */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'insurance-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <?php echo $form->field($model, 'image')->widget(\devgroup\dropzone\DropZone::className(), [
            'url' => Url::to(['upload-image']),
            'removeUrl' => Url::to(['delete-image']),
            'storedFiles' => isset($image) ? $image : [],
            'sortable' => false, // sortable flag
            'sortableOptions' => [], // sortable options
            'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'image')],
            'options' => [
                'createImageThumbnails' => true,
                'addRemoveLinks' => true,
                'dictRemoveFile' => 'حذف',
                'addViewLinks' => true,
                'dictViewFile' => '',
                'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                'acceptedFiles' => 'png, jpeg, jpg',
                'maxFiles' => 1,
                'maxFileSize' => 0.5,
            ],
        ])->hint('34x34 pixel') ?>
        
        <?= \app\components\MultiLangActiveRecord::renderSelectLangInput($form, $model) ?>

        <?= $form->field($model, 'type')->dropDownList(\app\models\Insurance::getTypeLabels()) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel')?></button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>
