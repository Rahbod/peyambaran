<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */

$this->title = Yii::t('words', 'Create Picture');
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">'.Yii::t('words', 'Picture Gallery').'</span>', 'url' => ['index'], 'class' =>'m-nav__link'];
$this->params['breadcrumbs'][] = $this->title;
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
        'thumb' => $thumb?:[],
        'fullImage' => $fullImage?:[],
    ]) ?>
    <!--end::Form-->
</div>