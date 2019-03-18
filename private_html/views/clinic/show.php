<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClinicProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<section class="clinic-program">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="content-header">
                    <img src="./svg/gallery-white.svg" class="img-fluid content-header__image mirror" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title">برنامه کلینیک ها</h1>

                        <h3 class="content-header__subTitle">بیمارستان پیامبران</h3>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="table-responsive">
                    <?php Pjax::begin(); ?>
                    <?= CustomGridView::widget([
                        'id' => 'clinic-table',
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-hover table-condensed'],
                        'layout' => "<div class='items'>{items}</div>\n{pager}",
                        'pager' => [
                            'class' => \nirvana\infinitescroll\InfiniteScrollPager::className(),
                            'widgetId' => 'clinic-table',
                            'itemsCssClass' => 'items',
//                            'contentLoadedCallback' => 'afterAjaxListViewUpdate',
                            'nextPageLabel' => 'Load more items',
                            'linkOptions' => [
                                'class' => 'btn btn-lg btn-block',
                            ],
                            'pluginOptions' => [
                                'loading' => [
                                    'msgText' => "<em>Loading next set of items...</em>",
                                    'finishedMsg' => "<em>No more items to load</em>",
                                ],
                                'behavior' => \nirvana\infinitescroll\InfiniteScrollPager::BEHAVIOR_TWITTER,
                            ],
                        ],
                        'columns' => [
                            'exp',
                            'name',
                            [
                                'attribute' => 'date',
                                'header' => Yii::t('words', 'Week Days'),
                                'value' => function ($model) {
                                    return "<span dir='ltr'>" . jDateTime::date('l', $model->date) . "</span>";
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date',
                                'value' => function ($model) {
                                    return "<span dir='ltr'>" . jDateTime::date('y/m/d', $model->date) . "</span>";
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date',
                                'header' => Yii::t('words', 'Time'),
                                'value' => function ($model) {
                                    return "<span>{$model->time}</span>";
                                },
                                'format' => 'raw',
                            ],
                            'description:ntext',
                            ['class' => 'app\components\customWidgets\CustomActionColumn',]
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="content-footer text-center mb-5">
                    <a href="void:;" class="btn -more gray" disabled="">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        <?= Yii::t('words', 'Load more') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>