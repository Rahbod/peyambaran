<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reception */

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
        <?= Html::a(Yii::t('words', 'Back'),Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-primary pull-left']) ?>
        <?= Html::a(Yii::t('words', 'Delete request'), ['delete', 'id' => $model->id], [
            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-sm btn-danger pull-left ml-3',
        ]) ?>
    </div>
    <div class="row mb-5 contactUs__container dashboard__form-container">

<!--        <div class="row">-->
<!--        --><?//= Html::beginForm(['update', 'id' => $model->id])?>
<!--        <div class="form-group">-->
<!--            --><?//= Html::textInput('Reception[visit_date]',$model->visit_date) ?>
<!--        </div>-->
<!--        --><?//= Html::endForm()?>
<!--        </div>-->

        <table class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <th>نام بیمار</th>
                <td><?= $model->getPatientName() ?></td>
            </tr>
            <tr>
                <th><?= $model->getAttributeLabel('created') ?></th>
                <td><?= jDateTime::date('Y/m/d', $model->created) ?></td>
            </tr>
            <?php foreach ($model->dynaDefaults as $field => $setting):
                if ($field == 'lang' || $field == 'family' || $field == 'files')
                    continue;
                $value = $model->$field;
                ?>
                <tr>
                    <th><?= $model->getAttributeLabel($field) ?></th>
                    <td><?= $value ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <h4><?= $model->getAttributeLabel('files') ?></h4>
        <ol>
            <?php
            $i=0;
            foreach ($model->attachments as $attachment): $i++?>
                <li><?= Html::a(Yii::t('words', 'Download attachment').' '.$i, $attachment->getAbsoluteUrl()) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>