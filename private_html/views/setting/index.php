<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Setting;
use yii\widgets\ActiveForm;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $settings [] */

$this->title = Yii::t('words', 'General Setting');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
    $("[data-toggle=\'box\']").each(function(){
        var val = $(this).is(":checked"),
            target = $($(this).data("target"));
        target.find(":input").attr("disabled", !val);
    });
    
    $("body").on("change", "[data-toggle=\'box\']", function (e) {
        var val = $(this).is(":checked"),
            target = $($(this).data("target"));
        target.find(":input").attr("disabled", !val);
    });
', \yii\web\View::POS_READY, 'box-toggle');
?>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = CustomActiveForm::begin([
        'id' => 'setting-form',
        //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
        'options' => ['class' => 'm-form m-form--label-align-left']
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= Yii::t('words', 'General') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Time Zone'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[timeZone]', $settings['timeZone'], Setting::$_timeZones, [
                        'class' => 'form-control m-input m-input__solid'
                    ]); ?>
                </div>
            </div>


            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Tell') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[tell]', $settings['tell'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Fax') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[fax]', $settings['fax'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Email') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[email]', $settings['email'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Address') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textarea('Setting[address]', $settings['address'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'rows' => 3
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'En Address') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textarea('Setting[en_address]', $settings['en_address'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'rows' => 3
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Ar Address') ?></label>

                <div class="col-lg-6">
                    <?php echo Html::textarea('Setting[ar_address]', $settings['ar_address'], [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'rows' => 3
                    ]); ?>
                </div>
            </div>

        </div>

        <div class="m-form__section m-form__section--last">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= Yii::t('words', 'Map') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Status') ?></label>

                <div class="col-lg-6">
                    <label class="switch">
                        <?php echo Html::checkbox('Setting[map][enabled]', $settings['map']['enabled'], [
                            'data' => [
                                'toggle' => 'box',
                                'target' => '.map-setting',
                            ]
                        ]) ?>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="map-setting">
                <div class="m-form__group form-group row">
                    <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Latitude') ?></label>
                    <div class="col-lg-6">
                        <?php echo Html::textInput('Setting[map][lat]', $settings['map']['lat'], [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                        ]); ?>
                    </div>
                </div>
                <div class="m-form__group form-group row">
                    <label class="col-lg-2 col-form-label"><?= Yii::t('words', 'Longitude') ?></label>
                    <div class="col-lg-6">
                        <?php echo Html::textInput('Setting[map][lng]', $settings['map']['lng'], [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-form__section m-form__section--last">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= Yii::t('words', 'Social Networks') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Twitter'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][twitter]', $settings['socialNetworks']['twitter'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Facebook'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][facebook]', $settings['socialNetworks']['facebook'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Google Plus'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][googleplus]', $settings['socialNetworks']['googleplus'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Linked-in'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][linkedin]', $settings['socialNetworks']['linkedin'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
            
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Instagram'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][instagram]', $settings['socialNetworks']['instagram'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(Yii::t('words', 'Telegram'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[socialNetworks][telegram]', $settings['socialNetworks']['telegram'], [
                        'class' => 'form-control m-input m-input__solid text-right',
                        'dir' => 'ltr',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel') ?></button>
        </div>
    </div>
    <?php CustomActiveForm::end(); ?>

    <!--end::Form-->
</div>