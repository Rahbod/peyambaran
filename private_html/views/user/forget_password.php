<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\LoginForm */
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
                            <div class="col-sm-6 col-xs-12 vertical-separator-line">
                                <div class="register-form-container">
                                    <?= $this->render('//layouts/_flash_message') ?>
                                    <h4 class="register-form-container__title"><?= Yii::t('words', 'Forget password') ?></h4>
                                    <p class="register-form-container__description"><?= Yii::t('words', 'forget_password_text') ?></p>
                                    <?= Html::beginForm(['/user/forget-password'], 'post', [
                                        'options' => ['class' => 'forms'],
                                        'fieldConfig' => [
                                            'options' => ['class' => '']
                                        ]
                                    ]);
                                    ?>

                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <?= Html::textInput('username', Yii::$app->request->getBodyParam('username'), [
                                                'class' => 'form-control',
                                                'spellcheck' => false,
                                                'tabindex' => 1,
                                                'placeholder' => Yii::t('words', 'user.phone')
                                            ]) ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="clearfix">
                                                <?= Html::submitButton(Yii::t('words', 'Send'), ['class' => 'btn submitBtn', 'tabindex' => 5]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="social-accounts-container">
                                    <div class="social-accounts login-with-google">
                                        <a href="void:;">
                                            ورود با حساب گوگل
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/google.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-facebook">
                                        <a href="void:;">
                                            ورود با حساب فیسبوک
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/facebook.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-twitter">
                                        <a href="void:;">
                                            ورود با حساب تویتتر
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