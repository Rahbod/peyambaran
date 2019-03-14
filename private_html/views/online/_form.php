<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\OnlineService;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\OnlineService */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'menu-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <?php echo $form->errorSummary($model) ?>
        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->field($model, 'icon')->widget(\devgroup\dropzone\DropZone::className(), [
                    'url' => Url::to(['upload-icon']),
                    'removeUrl' => Url::to(['delete-icon']),
                    'storedFiles' => isset($icon) ? $icon : [],
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'icon')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg, svg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.1,
                    ],
                ])->hint('100x100 pixel')?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'hover_icon')->widget(\devgroup\dropzone\DropZone::className(), [
                    'url' => Url::to(['upload-icon-hover']),
                    'removeUrl' => Url::to(['delete-icon-hover']),
                    'storedFiles' => isset($hoverIcon) ? $hoverIcon : [],
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'hover_icon')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg, svg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.1,
                    ],
                ])->hint('100x100 pixel')?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'lang')->dropDownList(OnlineService::$langArray, ['class' => 'form-control m-input m-input--solid']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'short_description')->textarea(['rows' => 1, 'style' => 'min-height:0']) ?>

        <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>

        <div class="content-box">

            <?= $form->field($model, 'menu_type')->radioList(OnlineService::$menuTypeLabels, ['class' => 'menu-type', 'separator' => '<br>'])->label(Yii::t('words', 'Content')) ?>

            <div class="menu-type-container type-1" style="display: none">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'page_id')->dropDownList(\app\models\Page::getList(), ['class' => 'form-control m-input m-input--solid select2', 'data-live-search' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group m-form__group mt-5">
                            <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('words', 'Create Page'), ['/page/create', 'return' => Yii::$app->request->url], ['encode' => false, 'class' => 'btn btn-info']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-type-container type-2" style="display: none">
                <?= OnlineService::renderMenuActionsSelect($this->context, $model, 'action_name', ['class' => 'form-control m-input m-input--solid'], $form) ?>
            </div>
            <div class="menu-type-container type-3" style="display: none">
                <?= $form->field($model, 'external_link')->textInput() ?>
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


<?php
$this->registerJs('
    var val = $(".menu-type input:checked").val();
    $(".menu-type-container").not(".type-"+val).hide();
    $(".menu-type-container.type-"+val).show();
    
    $("body").on("change", ".menu-type input", function(){
        var val = $(this).val();
        $(".menu-type-container").not(".type-"+val).hide();
        $(".menu-type-container.type-"+val).show();
    });
', \yii\web\View::POS_READY, 'content-trigger');