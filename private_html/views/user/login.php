<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
/** @var $model \app\models\LoginForm */
?>
<section class="register login">
    <div class="container">
        <div class="row register-container">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12 px-md-0">
                <div class="content-header -blueBg">
                    <img src="<?= $this->theme->baseUrl ?>/svg/user.svg"
                         class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Login') ?></h1>
                        <h3 class="content-header__subTitle galleryHeader__subTitle"><?= Yii::t('words', 'Login to account') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-sm-offset-3 col-xs-12 px-md-0 -bbrr -bblr">
                <div class="register-form bg-md-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-12 bg-white bg-md-transparent">
                                <div class="register-form-container">
                                    <?= $this->render('//layouts/_flash_message') ?>
                                    <h4 class="register-form-container__title"><?= Yii::t('words', 'Login to account') ?></h4>
                                    <p class="register-form-container__description"><?= Yii::t('words', 'login_text') ?></p>
                                    <?php $form = ActiveForm::begin([
                                        'options' => ['class' => 'forms'],
                                        'enableClientValidation' => true,
                                        'validateOnSubmit' => true,
                                        'fieldConfig' => [
                                            'options' => ['class' => '']
                                        ],

                                    ]); ?>
                                    <div class="form-row">
                                        <div class="form-group col-sm-12 px-0">
                                            <?= $form->field($model, 'username')->textInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 1, 'placeholder' => Yii::t('words', 'Phone')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-sm-12 px-0">
                                            <?= $form->field($model, 'password')->passwordInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 2, 'placeholder' => Yii::t('words', 'Password')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-sm-12 px-0 d-none d-md-block">
                                            <div class="text-right text-lg-left my-5">
                                                <a class="forgotBtn"
                                                   href="<?= Url::to(['/user/forget-password']) ?>"><?= Yii::t('words', 'Forget password?') ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 px-0">
                                            <div class="clearfix captcha-container">
                                                <?= $form->field($model, 'verifyCode')->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                                                    'captchaAction' => ['/user/captcha'],
                                                    'template' => '<span class="floatToRight form-control securityCode__image" style="padding: 0 !important;">{image}{url}</span> {input}',
                                                    'linkOptions' => ['label' => ''],
                                                    'options' => [
                                                        'class' => 'floatToRight securityCode__input form-control',
                                                        'placeholder' => Yii::t('words', 'Verify Code'),
                                                        'tabindex' => 4,
                                                        'autocomplete' => 'off'
                                                    ],
                                                ])->label(false)->hint(false) ?>
                                                <?= Html::submitButton(Yii::t('words', 'Login'), ['class' => 'btn submitBtn -blueBg', 'tabindex' => 5]) ?>

                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12 px-0">
                                            <div class="text-center mt-5">
                                                <a class="forgotBtn"
                                                   href="<?= Url::to(['/user/forget-password']) ?>"><?= Yii::t('words', 'Forget password?') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 bg-white bg-md-transparent hidden">
                                <div class="social-accounts-container">
                                    <div class="social-accounts login-with-google">
                                        <a>
                                            <?= Yii::t('words', 'Login with google') ?>
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/google.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-facebook">
                                        <a>
                                            <?= Yii::t('words', 'Login with facebook') ?>
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/facebook.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-twitter">
                                        <a>
                                            <?= Yii::t('words', 'Login with twitter') ?>
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/twitter.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>