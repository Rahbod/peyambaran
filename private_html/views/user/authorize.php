<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
?>

<section class="register">
    <div class="container">
        <div class="row register-container">
            <div class="col-xs-12 px-0">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/svg/user.svg" class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Authorize mobile') ?></h1>
                        <h3 class="content-header__subTitle galleryHeader__subTitle"><?= Yii::t('words', 'Create user account') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 px-0 bg-white -bbrr -bblr">
                <div class="register-form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 col-sm-offset-3 mt-5 mb-5">
                                <div class="register-form-container">
                                    <?= $this->render('//layouts/_flash_message') ?>
                                    <p class="register-form-container__description"><?= Yii::t('words', 'register_authorize_text') ?></p>
                                    <?= Html::beginForm(['/user/authorize'],'post',[
                                        'options' => ['class' => 'forms'],
                                        'fieldConfig' => [
                                            'options' => ['class' => '']
                                        ]
                                    ]);

                                    echo Html::hiddenInput('hash', $hash);
                                    echo Html::hiddenInput('forget', $forgetMode);
                                    ?>

                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <?= Html::textInput('code',Yii::$app->request->getBodyParam('code'),[
                                                'class' => 'form-control',
                                                'spellcheck' => false,
                                                'tabindex' => 1,
                                                'placeholder' => Yii::t('words', 'Authorize code')
                                            ])?>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="clearfix">
                                                <?= Html::submitButton(Yii::t('words', 'confirm'), ['class' => 'btn submitBtn', 'tabindex' => 5]) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
