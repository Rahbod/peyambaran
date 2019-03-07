<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('words', 'Change Password: {name}', ['name' => Yii::$app->user->identity->username]);
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">'.Yii::t('words', 'Slides').'</span>', 'url' => ['index'], 'class' =>'m-nav__link'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = CustomActiveForm::begin([
        'id' => 'change-password-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <?= $form->field($model, 'oldPassword')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true]) ?>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel')?></button>
        </div>
    </div>
    <?php CustomActiveForm::end(); ?>
    <!--end::Form-->
</div>