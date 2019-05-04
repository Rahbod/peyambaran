<?php

use yii\helpers\Html;
use app\components\Setting;

/* @var $this yii\web\View */
/* @var $model app\models\Slide */

$this->title = Yii::t('words', 'Slider setting');
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">' . Yii::t('words', 'Slides') . '</span>', 'url' => ['index'], 'class' => 'm-nav__link'];
$this->params['breadcrumbs'][] = $this->title;

$settings = Setting::get('slider');
?>

<div class="m-portlet m-portlet--tab">
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
    <?= Html::beginForm(); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label">نمایش دکمه های چپ و راست</label>

            <div class="col-lg-6">
                <label class="switch">
                    <?php echo Html::checkbox('Setting[nav]', $settings['nav'], ['value' => "true"]) ?>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label">نمایش تعداد اسلاید(دایره ها)</label>

            <div class="col-lg-6">
                <label class="switch">
                    <?php echo Html::checkbox('Setting[dots]', $settings['dots'], ['value' => "true"]) ?>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label">چرخش نامحدود تصاویر</label>

            <div class="col-lg-6">
                <label class="switch">
                    <?php echo Html::checkbox('Setting[loop]', $settings['loop'], ['value' => "true"]) ?>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label">چرخش خودکار تصاویر</label>

            <div class="col-lg-6">
                <label class="switch">
                    <?php echo Html::checkbox('Setting[autoplay]', $settings['autoplay'], ['value' => "true"]) ?>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <?php echo Html::label('سرعت تغییر تصویر', '', ['class' => 'col-lg-2 col-form-label']) ?>
            <div class="col-lg-6">
                <?php echo Html::textInput('Setting[autoPlaySpeed]', $settings['autoPlaySpeed'], [
                    'class' => 'form-control m-input m-input__solid',
                    'size' => 4
                ]); ?>
                <small>بر حسب میلی ثانیه</small>
            </div>
        </div>

    </div>
    <div class="m-portlet__foot m-portet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?= Html::endForm(); ?>
    <!--end::Form-->
</div>