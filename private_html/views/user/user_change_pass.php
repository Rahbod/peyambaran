<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

?>

<section class="register">
    <div class="container">
        <div class="row register-container">
            <div class="col-xs-12 px-0">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/svg/user.svg" class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Forget password') ?></h1>
                        <h3 class="content-header__subTitle galleryHeader__subTitle"><?= Yii::t('words', 'Login to account') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 px-0 bg-white -bbrr -bblr">
                <div class="register-form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 col-sm-offset-3">
                                <div class="register-form-container">
                                    <?= $this->render('//layouts/_flash_message') ?>
                                    <h4 class="register-form-container__title"><?= Yii::t('words', 'Change password') ?></h4>
                                    <p class="register-form-container__description"><?= Yii::t('words', 'change_password_text') ?></p>
                                    <?php $form = CustomActiveForm::begin([
                                        'id' => 'change-password-form',
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        'validateOnSubmit' => true,
                                    ]); ?>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'oldPassword')->passwordInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 1, 'placeholder' => Yii::t('words', 'Old password')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'newPassword')->passwordInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 2, 'placeholder' => Yii::t('words', 'New password')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'repeatPassword')->passwordInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 3, 'placeholder' => Yii::t('words', 'Repeat password')])->label(false) ?>
                                        </div>

                                        <div class="form-group col-12">
                                            <div class="clearfix">
                                                <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn submitBtn', 'tabindex' => 5]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php CustomActiveForm::end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>