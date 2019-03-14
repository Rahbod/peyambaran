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
                    <img src="./images/call.png" class="img-fluid content-header__image"
                         alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Html::encode($this->title) ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                    </div>
                    <div class="socialAccounts">
                        <?php $val = Setting::get('socialNetworks.linkedin');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="'.$this->theme->baseUrl.'/svg/instagram.png" alt="Linked-in"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.facebook');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="'.$this->theme->baseUrl.'/svg/facebook.png" alt="Facebook"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.googleplus');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="'.$this->theme->baseUrl.'/svg/google.png" alt="Google plus"></a>' : ''; ?>
                        <?php $val = Setting::get('socialNetworks.twitter');
                        echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '"><img src="'.$this->theme->baseUrl.'/svg/twitter.png" alt="Twitter"></a>' : ''; ?>
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
                        'options'=>['class' => 'contactUs__form'],
                        'fieldConfig' => [
                            'options' => ['class' => 'form-group col-lg-3'],
                            'inputOptions' => ['class' => 'form-control'],
                            'labelOptions' => ['class' => ''],
                        ],
                    ]) ?>
                    <div class="form-row">
                        <?= $form->field($model, 'department_id', ['template' => '{label} <span class="-required">(الزامی)</span> {input} {error}'])->dropDownList(ArrayHelper::map(Department::find()->valid()->all(), 'id', 'name'),['tabindex' => 1]) ?>

                        <?= $form->field($model, 'name', ['template' => '{label} <span class="-required">(الزامی)</span> {input} {error}'])->textInput(['tabindex' => 2])?>

                        <?= $form->field($model, 'email', ['template' => '{label} <span class="-required">(الزامی)</span> {input} {error}'])->textInput(['placeholder' => 'user@example.com']) ?>

                        <?= $form->field($model, 'degree', ['template' => '{label} <span class="-required">(الزامی)</span> {input} {error}'])->dropDownList(Message::getDegree(),['tabindex' => 1]) ?>

                        <div class="form-group col-lg-3">
                            <label for="grade">میزان تحصیلات</label>
                            <select name="grade" tabindex="4" class="form-control" id="grade">
                                <option selected>مدیریت</option>
                                <option>پذیرش</option>
                                <option>صندوق</option>
                                <option>آزمایشگاه</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="country">کشور</label>
                            <select name="country" tabindex="5" class="form-control" id="country">
                                <option selected>ایران</option>
                                <option>عراق</option>
                                <option>افغانستان</option>
                                <option>کویت</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="city">منطقه / شهر</label>
                            <select name="city" tabindex="6" class="form-control" id="city">
                                <option selected>منطقه / شهر</option>
                                <option>تهران</option>
                                <option>قم</option>
                                <option>مشهد</option>
                                <option>اصفهان</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="phone">شماره تماس</label>
                            <span class="-required">(الزامی)</span>
                            <input placeholder="شماره تماس" type="text"
                                   class=" form-control" spellcheck="false" tabindex="7"
                                   name="phone" id="phone">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="address">ادرس</label>
                            <input placeholder="آدرس" type="text"
                                   class=" form-control" spellcheck="false" tabindex="8"
                                   name="address" id="address">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">متن پیام</label>
                            <span class="-required">(الزامی)</span>
                            <textarea placeholder="متن پیام" name="description" class="form-control"
                                      tabindex="9" id="description" cols="30" rows="8"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="clearfix">
                                <button tabindex="11" type="button" class="btn submitBtn">ارسال به بخش مربوطه</button>

                                <input tabindex="10" class="floatToLeft securityCode__input form-control"
                                       placeholder="تصویر امنیتی"
                                       type="text">
                                <a class="floatToLeft form-control securityCode__image">
                                    <!--<img src="" alt="">-->
                                    RCii7485
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="form-row last">
                        <?= $form->field($model, 'verifyCode', ['options' => ['class' => 'col-lg-7 col-md-7 col-sm-7 col-xs-12 captcha']])->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                            'captchaAction' => ['site/captcha'],
                            'template' => "{image}\n{url}\n{input}",
                            'linkOptions' => [
                                'label' => Yii::t('words', 'New Code')
                            ],
                            'options' => [
                                'placeholder' => Yii::t('words', 'Verify Code'),
                                'autocomplete' => 'off'
                            ],
                        ])->label(false) ?>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <?php echo Html::input('submit', '', Yii::t('words', 'Send Message')); ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="site-contact">

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
