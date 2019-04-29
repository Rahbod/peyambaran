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

    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <div class="m-form__section m-form__section--first">
            <form method="get">
                <div class="form-group m-form-group row">
                    <div class="col-sm-4">
                        <?= Html::dropDownList('lang', Yii::$app->request->getQueryParam('lang'), [
                            'en' => 'انگلیسی',
                            'ar' => 'عربی',
                        ], ['class' => 'form-control', 'prompt' => 'زبان موردنظر را انتخاب کنید']) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= Html::submitButton('انتخاب زبان', ['class' => 'btn btn-success btn-sm mt-1']) ?>
                    </div>
                </div>
            </form>
        </div>

        <?php if ($basePhrases && $destPhrases): ?>
            <hr>
            <div class="m-form__section m-form__section--last">
                <div class="m-form__heading">
                    <h5>عبارات</h5>
                    <p class="text-danger">
                        ** توجه:
                        - متغیرهایی که به صورت {...} داخل براکت هستند یا عباراتی که تگ های html دارند را به همان صورت بازنویسی کنید.
                    </p>
                </div>

                <?php $form = CustomActiveForm::begin([
                    'id' => 'translate-form',
                    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'validateOnSubmit' => true,
                    'options' => ['class' => 'm-form m-form--label-align-left']
                ]); ?>
                <?php foreach ($basePhrases as $key => $phrase):
                    $value = '';
                    if (isset($destPhrases[$key]))
                        $value = $destPhrases[$key];
                    elseif (Yii::$app->request->getQueryParam('lang') == 'en') {
                        if(strpos($key,'base.') === false && strpos($key,'user.') === false)
                            $value = $key;
                    }
                    ?>
                    <div class="form-group m-form__group row">
                        <?php echo Html::label($phrase, '', ['class' => 'col-lg-2 col-form-label']) ?>
                        <div class="col-lg-6">
                            <?php echo Html::textarea("new_phrases[$key]", $value, [
                                'class' => 'form-control m-input m-input__solid',
                                'rows' => 1,
                                'dir' => 'auto'
                            ]); ?>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
                <div class="m-form__actions">
                    <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
                    <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel') ?></button>
                </div>
                <?php CustomActiveForm::end(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<style>
    textarea.form-control {
        min-height: 50px;
    }
</style>
