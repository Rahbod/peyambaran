<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
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
                <?= $form->field($model, 'parentID')->dropDownList(Category::parentsList(), [
                    'prompt' => 'بدون والد'
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'category_type')->dropDownList(Category::getCategoryTypeLabels()) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
        </div>
    </div>

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel')?></button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>


<?php
$this->registerJs('
    if($("#content-trigger").is(":checked"))
        $(".content-box").show();

    var val = $(".category-type input:checked").val();
    $(".category-type-container").not(".type-"+val).hide();
    $(".category-type-container.type-"+val).show();
    
    $("body").on("change", "#content-trigger", function(){
        if($(this).is(":checked"))
            $(".content-box").show();
        else
            $(".content-box").hide();
    }).on("change", ".category-type input", function(){
        var val = $(this).val();
        $(".category-type-container").not(".type-"+val).hide();
        $(".category-type-container.type-"+val).show();
    });
', \yii\web\View::POS_READY, 'content-trigger');