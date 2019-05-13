<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $clinicSearchModel app\models\ClinicProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<section class="clinic-program">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="content-header">
                    <img src="<?= Yii::getAlias('@web/themes/frontend/svg/gallery-white.svg') ?>"
                         class="img-fluid content-header__image mirror" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Clinic Program') ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="table-responsive">
                    <?php Pjax::begin(['enablePushState' => false]); ?>
                    <?= CustomGridView::widget([
                        'id' => 'clinic-table',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $clinicSearchModel,
                        'tableOptions' => ['class' => 'table table-hover table-condensed'],
                        'layout' => "<div class='items'>{items}</div>\n{pager}",
//                        'pager' => [
//                            'class' => \nirvana\infinitescroll\InfiniteScrollPager::className(),
//                            'widgetId' => 'clinic-table',
//                            'itemsCssClass' => 'items',
////                            'contentLoadedCallback' => 'afterAjaxListViewUpdate',
//                            'nextPageLabel' => 'Load more items',
//                            'linkOptions' => [
//                                'class' => 'btn btn-lg btn-block',
//                            ],
//                            'pluginOptions' => [
//                                'loading' => [
//                                    'msgText' => "<em>Loading next set of items...</em>",
//                                    'finishedMsg' => "<em>No more items to load</em>",
//                                ],
//                                'behavior' => \nirvana\infinitescroll\InfiniteScrollPager::BEHAVIOR_TWITTER,
//                            ],
//                        ],
                        'columns' => [
                            [
                                'attribute' => 'name',
                                'value' => function ($model) {
                                    return $model->person->getName();
                                }
                            ],
                            [
                                'attribute' => 'exp',
                                'value' => function ($model) {
                                    return $model->expertise->getName();
                                },
                                'filter' => Html::activeDropDownList($clinicSearchModel, 'exp', Category::getWithType(Category::CATEGORY_TYPE_EXPERTISE,'array', true), [
                                    'class' => 'form-control',
                                    'prompt' => Yii::t('words', 'All')
                                ]),
                                'options' => ['width' => '150px']
                            ],
                            [
                                'attribute' => 'date',
                                'header' => Yii::t('words', 'Week Days'),
                                'value' => function ($model) {
                                    return "<span dir='ltr'>" . jDateTime::date('l', $model->date) . "</span>";
                                },
                                'filter' => Html::activeDropDownList($clinicSearchModel, 'week', \app\models\ClinicProgramView::getDayNames(), [
                                    'class' => 'form-control',
                                    'prompt' => Yii::t('words', 'All')
                                ]),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date',
                                'value' => function ($model) {
                                    return "<span dir='ltr'>" . jDateTime::date('Y/m/d', $model->date) . "</span>";
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'date',
                                'header' => Yii::t('words', 'Time'),
                                'value' => function ($model) {
                                    return "<div class='text-center'>{$model->time}</div>";
                                },
                                'filter' => Html::activeTextInput($clinicSearchModel, 'fromtime', [
                                        'class' => 'form-control time-filter',
                                    ]) . ' - ' . Html::activeTextInput($clinicSearchModel, 'totime', [
                                        'class' => 'form-control time-filter',
                                    ]),
                                'format' => 'raw',
                                'options' => ['width' => '162px']
                            ],
                            [
                                'attribute' => 'description',
                                'options' => ['dir' => 'auto']
                            ],
//                            ['class' => 'app\components\customWidgets\CustomActionColumn',]
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