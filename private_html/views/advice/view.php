<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Advice */

$this->title = $model->name;
?>

<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Request details') ?></h1>
        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
    </div>
</div>
<div class="col-sm-12">
    <div class="row mt-5 mb-4">
        <?= Html::a(Yii::t('words', 'Back'), ['list'], ['class' => 'btn btn-sm btn-primary pull-left']) ?>
        <?= Html::a(Yii::t('words', 'Delete request'), ['delete', 'id' => $model->id], [
            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-sm btn-danger pull-left ml-3',
        ]) ?>
    </div>
    <div class="row mb-5 contactUs__container dashboard__form-container">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'userID',
                'type',
                'name',
                'created',
                'status',
            ],
        ]) ?>
    </div>
</div>
