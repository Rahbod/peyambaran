<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use  app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $roles array */
/* @var $actions array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = CustomActiveForm::begin([
        'id' => 'category-form',
        //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'hidden']])->hiddenInput()->label(false) ?>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            </div>
            <!--            <div class="col-sm-3">-->
            <!--                --><? //= $form->field($model, 'parent')->dropDownList($roles, ['value' => $model->parent ?: 'guest', 'prompt' => Yii::t('words', 'base.noParent')]) ?>
            <!--            </div>-->
        </div>

<!--        <div class="container-fluid mt-5">-->
<!--            <div class="col-sm-12 mt-3">-->
<!--                <h5>--><?//= Yii::t('words', 'role.statuses_permission') ?><!--</h5>-->
<!--            </div>-->
<!--            --><?php //foreach ($statuses as $modelName => $statusList): ?>
<!--                <div class="col-sm-12 mt-4">-->
<!--                    <div class="form-group m-form__group">-->
<!--                        <h6><b>--><?php //echo Yii::t('words', "role.{$modelName}_statuses") ?><!--</b></h6>-->
<!--                        --><?php //foreach ($statusList as $status => $label): ?>
<!--                            <div class="col-sm-12">-->
<!--                                <label class="m-checkbox m-checkbox--solid m-checkbox--brand mr-5">-->
<!--                                    --><?//= Html::checkbox(Html::getInputName($model, 'statuses_permission') . "[$modelName][$status]", isset($model->statuses_permission[$modelName][$status])?$model->statuses_permission[$modelName][$status]:false, [
//                                        'value' => true,
//                                        'class' => 'm-group-checkable'
//                                    ]) ?>
<!--                                    --><?//= Yii::t('words', "$modelName.$label") ?>
<!--                                    <span></span>-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        --><?php //endforeach; ?>
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endforeach; ?>
<!--        </div>-->

        <div class="container-fluid mt-5">
            <div class="col-sm-12 mt-3">
                <h5><?= Yii::t('words', 'Permissions') ?></h5>
            </div>
            <?php foreach ($actions as $key => $controller): ?>
                <div class="col-sm-4 mt-4">
                    <div class="form-group m-form__group">
                        <a href="#" data-toggle="collapse" data-target="#group-<?= $key ?>">
                            <h6 class="text-dark"><i class="fa fa-plus text-info"></i> <b><?php echo $controller['alias'] ?></b></h6>
                        </a>
                        <div class="collapse mt-3" id="group-<?= $key ?>">
                        <?php foreach ($controller['actions'] as $action): ?>
                            <div class="col-sm-12">
                                <label class="m-checkbox m-checkbox--solid m-checkbox--brand mr-5"
                                       for="<?php echo $action['name'] ?>">
                                    <?php echo Html::checkbox('actions[]', $action['selected'], ['value' => $action['name'], 'id' => $action['name'], 'class' => 'm-group-checkable']) ?>
                                    <?php echo $action['alias'] ?>
                                    <span></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel'); ?></button>
        </div>
    </div>

    <?php CustomActiveForm::end(); ?>

</div>