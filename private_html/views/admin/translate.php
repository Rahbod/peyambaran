<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Setting;
use yii\widgets\ActiveForm;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $basePhrases [] */
/* @var $destPhrases [] */

$this->title = Yii::t('words', 'Translate Management');
$this->params['breadcrumbs'][] = $this->title;
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
        'id' => 'translate-form',
        //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
        'options' => ['class' => 'm-form m-form--label-align-left']
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <?php foreach ($basePhrases as $key => $phrase): ?>
            <div class="form-group m-form__group row">
                <?php echo Html::label($phrase, '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList("new_phrases[$key]", '', Setting::$_timeZones, [
                        'class' => 'form-control m-input m-input__solid'
                    ]); ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel') ?></button>
        </div>
    </div>
    <?php CustomActiveForm::end(); ?>
</div>
