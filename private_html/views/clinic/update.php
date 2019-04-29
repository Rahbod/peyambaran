<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClinicProgram */

$this->title = Yii::t('words', 'Update Day: {name}', [
    'name' => jDateTime::date('l d F Y', $model->date),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'Clinic Program'), 'url' => ['index']];
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
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="<?= \yii\helpers\Url::to(['create']) ?>"
                       class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= Yii::t('words', 'Create New Day') ?></span>
						</span>
                    </a>
                </li>
                <li class="m-portlet__nav-item">
                    <a href="<?= \yii\helpers\Url::to(['import-excel-program']) ?>"
                       class="btn btn-dark m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-file-text"></i>
							<span><?= Yii::t('words', 'Import excel') ?></span>
						</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!--begin::Form-->
    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>
    <!--end::Form-->
</div>