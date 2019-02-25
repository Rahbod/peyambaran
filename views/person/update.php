<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Person */
/* @var $avatar \devgroup\dropzone\UploadedFiles */

$this->title = Yii::t('words', 'Update Person: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('words', 'Update');
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
    <?= $this->render('_form', [
        'model' => $model,
        'avatar' => $avatar,
    ]) ?>
    <!--end::Form-->
</div>