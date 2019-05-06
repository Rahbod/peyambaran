<?php

use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\LoginForm */
?>
<section class="register forgotPassword">
    <div class="container">
        <div class="row register-container">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12 px-md-0">
                <div class="content-header -orangeBg">
                    <img src="<?= $this->theme->baseUrl ?>/svg/user.svg" class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Forget password') ?></h1>
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
                                        <div class="form-group col-xs-12 col-sm-6 col-md-12 px-0 mb-4">
                                            <?= Html::textInput('username', Yii::$app->request->getBodyParam('username'), [
                                                'class' => 'form-control',
                                                'spellcheck' => false,
                                                'tabindex' => 1,
                                                'placeholder' => Yii::t('words', 'Phone')
                                            ]) ?>
                                        </div>
                                        <div class="form-group col-xs-12 col-sm-6 col-md-12 px-0">
                                            <div class="clearfix text-left">
                                                <?= Html::submitButton(Yii::t('words', 'Send'), ['class' => 'btn submitBtn', 'tabindex' => 5]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 bg-white bg-md-transparent hidden">
                                <div class="social-accounts-container">
                                    <div class="social-accounts login-with-google">
                                        <a href="void:;">
                                            <?= Yii::t('words', 'Login with google') ?>
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/google.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-facebook">
                                        <a href="void:;">
                                            <?= Yii::t('words', 'Login with facebook') ?>
                                            <img src="<?= $this->theme->baseUrl ?>/images/register/facebook.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-twitter">
                                        <a href="void:;">
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