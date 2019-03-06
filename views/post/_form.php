<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use yii\helpers\Url;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'post-form',
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
        ]) ?>

        <?= \app\components\MultiLangActiveRecord::renderSelectLangInput($form, $model) ?>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'type')->dropDownList(\app\models\Post::getTypeLabels()) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'formCategories')->dropDownList(Category::getWithType(Category::CATEGORY_TYPE_NEWS), ['prompt' => Yii::t('words', 'Select Category')]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'publish_date')->widget(\yii\jui\DatePicker::className(), ['dateFormat' => 'php:Y/m/d','options' => ['class' => 'form-control m-input m-input--solid']]) ?>
            </div>
        </div>

        <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'body')->widget(\dosamigos\tinymce\TinyMce::className(), [
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
