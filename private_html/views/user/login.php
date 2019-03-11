<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

/** @var $this \yii\web\View */
?>
<section class="register login">
    <div class="container">
        <div class="row register-container">
            <div class="col-xs-12 px-0">
                <div class="content-header -blueBg">
                    <img src="./svg/user.svg" class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Login') ?></h1>
                        <h3 class="content-header__subTitle galleryHeader__subTitle"><?= Yii::t('words', 'Login to account') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 px-0 bg-white -bbrr -bblr">
                <div class="register-form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6 vertical-separator-line">
                                <div class="register-form-container">
                                    <h4 class="register-form-container__title"><?= Yii::t('words', 'Login to account') ?></h4>
                                    <p class="register-form-container__description"><?= Yii::t('words', 'login_text') ?></p>
                                    <?php $form = ActiveForm::begin([
                                        'options' => ['class' => 'forms'],
                                        'fieldConfig' => [
                                            'options' => ['class' => '']
                                        ]
                                    ]); ?>
                                    <?= $form->errorSummary($model) ?>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'username')->textInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 1, 'placeholder' => Yii::t('words', 'Phone')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <?= $form->field($model, 'password')->passwordInput(['class' => 'toggleLabel form-control', 'spellcheck' => false, 'tabindex' => 2, 'placeholder' => Yii::t('words', 'Password')])->label(false) ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="text-left">
                                                <a class="forgotBtn" href="<?= Url::to(['/user/forget-password']) ?>"><?= Yii::t('words', 'Forget password?') ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="clearfix">
                                                <a class="floatToRight form-control securityCode__image">
                                                    <!--<img src="" alt="">-->
                                                    RCii7485
                                                </a>
                                                <input class="floatToRight securityCode__input form-control"
                                                       placeholder="تصویر امنیتی"
                                                       type="text">
                                                <?= Html::submitButton(Yii::t('words', 'Login'), ['class' => 'btn submitBtn -blueBg', 'tabindex' => 4]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="social-accounts-container">
                                    <div class="social-accounts login-with-google">
                                        <a href="void:;">
                                            ورود با حساب گوگل
                                            <img src="./images/register/google.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-facebook">
                                        <a href="void:;">
                                            ورود با حساب فیسبوک
                                            <img src="./images/register/facebook.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-twitter">
                                        <a href="void:;">
                                            ورود با حساب تویتتر
                                            <img src="./images/register/twitter.png" alt="">
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