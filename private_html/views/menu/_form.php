<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
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

        <?= $form->errorSummary($model) ?>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'lang')->dropDownList(Menu::$langArray, ['class' => 'form-control m-input m-input--solid']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'parentID')->dropDownList(Menu::parentsList(), [
                    'prompt' => 'بدون والد'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'show_in_footer', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
        </div>

        <?php echo $form->field($model, 'content', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox(['id' => 'content-trigger'], false) ?>

        <div class="content-box" style="display: none">

            <?= $form->field($model, 'menu_type')->radioList(Menu::$menuTypeLabels, ['class' => 'menu-type', 'separator' => '<br>']) ?>

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
                <?= Menu::renderMenuActionsSelect($this->context, $model, 'action_name', ['class' => 'form-control m-input m-input--solid'], $form) ?>
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
    if($("#content-trigger").is(":checked"))
        $(".content-box").show();

    var val = $(".menu-type input:checked").val();
    $(".menu-type-container").not(".type-"+val).hide();
    $(".menu-type-container.type-"+val).show();
    
    $("body").on("change", "#content-trigger", function(){
        if($(this).is(":checked"))
            $(".content-box").show();
        else
            $(".content-box").hide();
    }).on("change", ".menu-type input", function(){
        var val = $(this).val();
        $(".menu-type-container").not(".type-"+val).hide();
        $(".menu-type-container.type-"+val).show();
    });
', \yii\web\View::POS_READY, 'content-trigger');