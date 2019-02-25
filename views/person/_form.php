<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use \yii\helpers\Url;

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
                'maxFileSize' => 0.5,
            ],
        ]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surename')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList(\app\models\Person::$typeLabels) ?>

        <?= $form->field($model, 'expertise')->dropDownList(\app\models\Person::$typeLabels) ?>

        <?= $form->field($model, 'experience')->dropDownList(\app\models\Person::$typeLabels) ?>

        <?= $form->field($model, 'resume')->widget(\app\components\customWidgets\CustomTinyMce::className(), [
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
