<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form app\components\customWidgets\CustomActiveForm */

$this->registerJs('
    $("[data-toggle=\'box\']").each(function(){
        var val = $(this).val(),
            target = $(".box-target.box-"+val);
        target.removeClass("hide").find(":input").attr("disabled", false);
    });
    
    $("body").on("change", "[data-toggle=\'box\']", function (e) {
        var val = $(this).val(),
            target = $(".box-target.box-"+val);
        $(".box-target").not(target).addClass("hide").find(":input").attr("disabled", true);
        target.removeClass("hide").find(":input").attr("disabled", false);
    });
', \yii\web\View::POS_READY, 'box-toggle');

$form = CustomActiveForm::begin([
    'id' => 'category-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($model, 'ar_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'parentID')->dropDownList(Category::parentsList(), [
                    'prompt' => 'بدون والد'
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'category_type')->dropDownList(Category::getCategoryTypeLabels(),[
                        'data-toggle' => 'box'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'en_status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'ar_status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
        </div>
        <div class="row box-target box-image_gallery hide">
            <div class="col-sm-4">
                <?php echo $form->field($model, 'show_in_home', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'show_always', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
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

<style>
    .box-target.hide{
        display:none
    }
</style>
