<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use \yii\helpers\Url;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'gallery-form',
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
                'dictDefaultMessage' => 'جهت آپلود تصویر پوستر کلیک کنید',
                'acceptedFiles' => 'png, jpeg, jpg',
                'maxFiles' => 1,
                'maxFileSize' => 0.2,
            ],
        ])->hint('270x190 pixel') ?>

        <?php echo $form->field($model, 'video')->widget(\devgroup\dropzone\DropZone::className(), [
            'url' => Url::to(['upload-video']),
            'removeUrl' => Url::to(['delete-video']),
            'storedFiles' => isset($image) ? $image : [],
            'sortable' => false, // sortable flag
            'sortableOptions' => [], // sortable options
            'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'video')],
            'options' => [
                'createImageThumbnails' => true,
                'addRemoveLinks' => true,
                'dictRemoveFile' => 'حذف',
                'addViewLinks' => true,
                'dictViewFile' => '',
                'dictDefaultMessage' => 'جهت آپلود ویدئو کلیک کنید',
                'acceptedFiles' => 'mp4',
                'maxFiles' => 1,
                'maxFileSize' => 10,
            ],
        ]) ?>

        <?= \app\components\MultiLangActiveRecord::renderSelectLangInput($form, $model) ?>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'short_description')->textInput() ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'formCategories')->dropDownList(Category::getWithType(Category::CATEGORY_TYPE_PICTURE_GALLERY), ['prompt' => Yii::t('words', 'Select Category')]) ?>
            </div>
        </div>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel')?></button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>
