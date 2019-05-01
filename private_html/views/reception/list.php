<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;
use yii\widgets\Pjax;

/** @var $this \yii\web\View */
?>

<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Reception request') ?></h1>
        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
    </div>
</div>
<div class="content-body mt-5">
    <?php if ($dataProvider->totalCount || Yii::$app->request->isPjax): ?>
        <div class="row mt-2 mb-4">
            <div class="col-sm-12">
                <?= Html::a(Yii::t('words', 'New Request'), ['request'], ['class' => 'btn btn-sm btn-primary pull-left']) ?>
            </div>
        </div>
        <div class="table-responsive">
            <?php Pjax::begin(['enablePushState' => false]); ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'custom-table'],
                'layout' => '{items}',
                'columns' => [
                    ['class' => '\yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'header' => Yii::t('words', 'Patient name'),
                        'value' => function ($model) {
                            return $model->getPatientName();
                        }
                    ],
                    [
                        'attribute' => 'reception_type',
                        'value' => function ($model) {
                            return $model->getReceptionTypeLabel();
                        },
                        'filter' => \app\models\Reception::getReceptionTypeLabels()
                    ],
                    [
                        'attribute' => 'created',
                        'value' => function ($model) {
                            return jDateTime::date('Y/m/d', $model->created);
                        }
                    ],
                    [
                        'attribute' => 'visit_date',
                        'value' => function ($model) {
                            return $model->visit_date?jDateTime::date('Y/m/d', $model->visit_date):null;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            $css = $model->getStatusCssClass();
                            return "<span class='label label-$css'>{$model->getStatusLabel()}</span>";
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => '\yii\grid\ActionColumn',
                        'template' => '{view} {delete}'
                    ],
                ]
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    <? else: ?>
        <div class="d-flex new-req"
             style="height: 200px;text-align: center;justify-content: center;align-items: center">
            <div style="display: inline-block">
                <?= Html::a(Yii::t('words', 'New Request'), ['request'], ['class' => 'btn btn-lg btn-primary']) ?>
            </div>
        </div>
    <? endif; ?>
</div>