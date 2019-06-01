<?php

use app\components\Setting;
use app\models\Department;
use app\models\Menu;
use voime\GoogleMaps\Map;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */

$contactModel = new \app\models\ContactForm();
?>
<footer>
    <?php if (Setting::get('map.enabled')): ?>
        <section class="map-bg">
            <div class="map"><?= Map::widget([
                    'apiKey' => 'AIzaSyAosC6bTYYziiqWxM5lhIHkwLECdkv26vY',
                    'zoom' => 15,
                    'center' => [Setting::get('map.lat'), Setting::get('map.lng')],
                    'markers' => [
                        ['position' => [Setting::get('map.lat'), Setting::get('map.lng')]],
                    ],
                    'width' => '100%',
                    'height' => '350px',
                    'mapType' => Map::MAP_TYPE_TERRAIN,
                ]); ?>
            </div>
        </section>
    <?php endif; ?>
    <div class="bottom-section">
        <div class="container">
            <div class="overflow-fix">
                <div class="form-container">
                    <div class="row">
                        <h3><?= Yii::t('words', 'Contact us') ?></h3>
                        <div class="text"><?= Yii::t('words', 'contact_footer_text') ?></div>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'action' => ['/site/contact'],
                        'enableClientValidation' => true,
                        'validateOnSubmit' => true,
                        'fieldConfig' => [
                            'options' => ['class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-12 '],
                            'labelOptions' => ['class' => ''],
                            'inputOptions' => ['class' => ''],
                        ],
                    ]);
                    echo Html::hiddenInput('return', Yii::$app->request->url);
                    ?>
                    <div class="row">
                        <div class="row">
                            <?= $form->field($contactModel, 'department_id')->dropDownList(ArrayHelper::map(Department::find()->valid()->all(), 'id', function ($model) {
                                return $model->getName();
                            })) ?>

                            <?= $form->field($contactModel, 'name')->textInput() ?>

                            <?= $form->field($contactModel, 'email')->textInput(['placeholder' => 'exampel@email.com']) ?>

                            <?= $form->field($contactModel, 'tel')->textInput(['placeholder' => '09xxxxxxxx']) ?>

                            <?= $form->field($contactModel, 'body', ['options' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12']])->textInput() ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-7 col-md-12 col-sm-7 col-xs-12">
                                <?= $form->field($contactModel, 'verifyCode', ['options' => ['class' => 'captcha']])->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                                    'captchaAction' => ['site/captcha'],
                                    'template' => "{image}\n{url}\n{input}",
                                    'linkOptions' => [
                                        'label' => ''
                                    ],
                                    'options' => [
                                        'placeholder' => Yii::t('words', 'Verify Code'),
                                        'autocomplete' => 'off'
                                    ],
                                ])->label(false) ?>
                            </div>

                            <div class="col-lg-5 col-md-12 col-sm-5 col-xs-12">
                                <?php echo Html::input('submit', '', Yii::t('words', 'Send Message')); ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
                <div class="info-container">
                    <ul>
                        <li>
                            <div class="addressContainer">
                                <i class="icon point-icon"></i>
                                <div><?= Setting::get(Yii::$app->language == 'fa' ? 'address' : Yii::$app->language . '_address') ?></div>
                            </div>
                        </li>
                        <li>
                            <i class="icon phone-icon"></i>
                            <div><?= Yii::t('words', 'Tell & Fax') ?><br> <?= Setting::get('tell') ?>
                                - <?= Setting::get('fax') ?></div>
                        </li>
                        <li class="email">
                            <i class="icon email-icon"></i>
                            <div><?= Setting::get('email') ?></div>
                        </li>
                        <li>
                            <i class="icon share-icon"></i>
                            <div>
                                <?php $val = Setting::get('socialNetworks.linkedin');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon instagram-icon"></a>' : ''; ?>
                                <?php $val = Setting::get('socialNetworks.facebook');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon facebook-icon"></a>' : ''; ?>
                                <?php $val = Setting::get('socialNetworks.googleplus');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon google-icon"></a>' : ''; ?>
                                <?php $val = Setting::get('socialNetworks.twitter');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon twitter-icon"></a>' : ''; ?>
                                <?php $val = Setting::get('socialNetworks.instagram');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon instagram-icon"></a>' : ''; ?>
                                <?php $val = Setting::get('socialNetworks.telegram');
                                echo $val && !empty($val) ? '<a rel="nofollow" target="_blank" href="' . $val . '" class="icon telegram-icon"></a>' : ''; ?>
                            </div>
                        </li>
                    </ul>
                    <hr>
                    <div class="certificate-block">
                        <h3><?= Yii::t('words', 'Valid certificates') ?></h3>
                        <div class="certs">
                            <div class="cert-item">
                                <div class="cert-item-inner">
                                    <h4 class="bolder open-sans">ISO 9001:2008</h4>
                                    <p>Professional of medical therapeutic & diginic service</p>
                                </div>
                            </div>
                            <div class="cert-item">
                                <div class="cert-item-inner">
                                    <h4 class="bolder open-sans">IPD</h4>
                                    <p>International Patient Department</p>
                                </div>
                            </div>
                            <div class="cert-item">
                                <div class="cert-item-inner">
                                    <h4 class="bolder open-sans">ISO 14001:2004</h4>
                                    <p>Professional of medical therapeutic & diginic service</p>
                                </div>
                            </div>
                            <div class="cert-item">
                                <div class="cert-item-inner">
                                    <h4 class="bolder open-sans">OHSAS 18001:207</h4>
                                    <p>Professional of medical therapeutic & diginic service</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-section">
        <div class="container">
            <div class="row">
                <?php $i = 0;
                foreach (Menu::find()->roots()->valid()->andWhere([Menu::columnGetString('show_in_footer') => 1])->orderBySort()->all() as $item): ?>
                    <?php
                    $ic = $item->children(1)->count();
                    $sic = $item->children(2)->count();
                    if ($ic > 0):$i++; ?>
                        <div class="footer-block col-xs-12 <?= $i == 1 ? 'col-sm-12' : 'col-sm-6 col-md-4' ?>">
                            <h4><?= $item->name ?></h4>
                            <div class="footer-sub-block">
                                <?php if (($sic - $ic) === 0): // one level ?>
                                    <ul class="menu-part">
                                        <?php foreach ($item->children(1)->valid()->all() as $sub_item): ?>
                                            <li><a href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: // two level ?>
                                    <?php foreach ($item->children(1)->valid()->all() as $sub_item): ?>
                                        <ul class="menu-part d-inline-block">
                                            <li<?= $sub_item->children(1)->valid()->count() > 0 ? " class='has-child'" : "" ?>>
                                                <a
                                                        href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a></li>
                                            <?php foreach ($sub_item->children(1)->valid()->all() as $sub_item_child): ?>
                                                <li>
                                                    <a href="<?= $sub_item_child->url ?>"><?= $sub_item_child->name ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <li><a href="<?= $item->url ?>"><?= $item->name ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="copyright">
                <div class="pull-right">
                    <a href="http://tarsiminc.com" target="_blank">by tarsim.inc</a>
                </div>
                <div class="pull-left text hidden-xs"><b>PAYAMBARAN HOSPITAL</b> . ALL RIGHTS RESERVED
                    © <?= date('Y') ?></div>
            </div>
        </div>
    </div>
</footer>