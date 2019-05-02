<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Reception */
?>

<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Reception request') ?></h1>
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

        <p><?= Yii::t('words', 'reception_text') ?></p>
        <?=  $form->errorSummary($model) ?>
        <div class="row">
            <?= $model->formRenderer($form, '{field}', 'col-sm-6') ?>
        </div>

        <?= Html::submitButton(Yii::t('words', 'Submit'), ['class' => 'btn dashboard__form--btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>