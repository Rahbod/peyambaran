<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'menu-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <?= \app\components\MultiLangActiveRecord::renderSelectLangInput($form, $model) ?>

        <?= $form->field($model, 'parentID')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Menu::find()->roots(), 'id', 'name')) ?>

        <?= $form->field($model, 'type')->dropDownList([ 'cat' => 'Cat', 'tag' => 'Tag', 'lst' => 'Lst', 'mnu' => 'Mnu', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'dyna')->textInput() ?>

        <?= $form->field($model, 'extra')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'created')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'left')->textInput() ?>

        <?= $form->field($model, 'right')->textInput() ?>

        <?= $form->field($model, 'depth')->textInput() ?>

        <?= $form->field($model, 'tree')->textInput() ?>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>
