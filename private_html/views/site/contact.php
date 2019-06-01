<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\components\Setting;
use yii\helpers\ArrayHelper;
use app\models\ContactForm;
use app\models\Department;
use app\models\Message;

$this->title = Yii::t('words', 'Contact us');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="contactUsPage">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/images/call.png" class="img-fluid content-header__image"
                         alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Html::encode($this->title) ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                    </div>
                    <div class="socialAccounts">
                        <?php $val = Setting::get('socialNetworks.linkedin');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/instagram.png" alt="Linked-in"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.facebook');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/facebook.png" alt="Facebook"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.googleplus');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/google.png" alt="Google plus"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.twitter');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/twitter.png" alt="Twitter"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.instagram');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/instagram.png" alt="Instagram"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.telegram');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="' . $this->theme->baseUrl . '/svg/telegram.svg" alt="Telegram" width="34px"></a>' : ''; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="texts">
                    <h4 class="-blue"><?= Yii::t('words', 'contact_page_text') ?></h4>
                    <p class="-grey"><?= Yii::t('words', 'contact_page_description') ?></p>
                </div>
                <div class="contactUs__container">
                    <?php $form = ActiveForm::begin([
                        'action' => ['/site/contact'],
                        'enableClientValidation' => true,
                        'validateOnSubmit' => true,
                        'options' => ['class' => 'contactUs__form'],
                        'fieldConfig' => [
                            'options' => ['class' => 'form-group col-sm-3'],
                            'inputOptions' => ['class' => 'form-control'],
                            'labelOptions' => ['class' => ''],
                        ],
                    ]) ?>

                    <div class="form-row">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'department_id', ['template' => '{label} <span class="-required"></span> {input} {error}'])->dropDownList(ArrayHelper::map(Department::find()->valid()->all(), 'id', function ($model){return$model->getName();}), ['tabindex' => 1]) ?>

                                <?= $form->field($model, 'name', ['template' => '{label} <span class="-required"></span> {input} {error}'])->textInput(['tabindex' => 2]) ?>

                                <?= $form->field($model, 'email', ['template' => '{label} <span class="-required"></span> {input} {error}'])->textInput(['placeholder' => 'user@example.com', 'tabindex' => 3]) ?>

                                <?= $form->field($model, 'degree')->dropDownList(Message::getDegrees(), ['tabindex' => 4]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->field($model, 'country')->textInput(['tabindex' => 5]) ?>

                                <?= $form->field($model, 'city')->textInput(['tabindex' => 6]) ?>

                                <?= $form->field($model, 'tel', ['template' => '{label} <span class="-required"></span> {input} {error}'])->textInput(['tabindex' => 7]) ?>

                                <?= $form->field($model, 'address', ['options' => ['class' => 'form-group col-sm-3']])->textInput(['tabindex' => 8]) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'body', ['options' => ['class' => 'form-group col-sm-12'], 'template' => '{label} <span class="-required"></span> {input} {error}'])->textarea(['tabindex' => 9, 'rows' => 8]) ?>

                        <div class="form-group col-sm-12">

                            <div class="clearfix captcha-container row">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'pull-right']])->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                                        'captchaAction' => ['/site/captcha'],
                                        'template' => '{input} {image}',
                                        'linkOptions' => ['label' => Yii::t('words', 'Refresh')],
                                        'imageOptions' => ['class' => 'floatToLeft form-control securityCode__image'],
                                        'options' => [
                                            'class' => 'floatToLeft securityCode__input form-control',
                                            'placeholder' => Yii::t('words', 'Verify Code'),
                                            'tabindex' => 10,
                                            'autocomplete' => 'off'
                                        ],
                                    ])->label(false) ?>
                                </div>
                                <div class="col-sm-6"><button tabindex="11" type="submit" class="btn submitBtn"><?= Yii::t('words', 'Send to department') ?></button></div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>