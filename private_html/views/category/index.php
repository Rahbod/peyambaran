<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
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
							<span><?= Yii::t('words', 'Create Category') ?></span>
						</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <?= \richardfan\sortable\SortableGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'sortUrl' => \yii\helpers\Url::to(['sort-item']),
                    'columns' => [
                        [
                            'header' => '',
                            'value' => function(){
                                return '<i class="handle"></i>';
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'handle-container'],
                            'headerOptions' => ['class' => 'handle-container'],
                        ],
                        'name',
                        [
                            'attribute' => 'category_type',
                            'value' => function($model){
                                return $model->getCategoryTypeLabel($model->category_type);
                            },
                            'filter' => \app\models\Category::getCategoryTypeLabels()
                        ],
                        [
                            'attribute' => 'parentID',
                            'value' => function($model){
                                return $model->parent?"<b>{$model->parent->name}</b>":'-';
                            },
                            'filter' => \app\models\Category::parentsList(),
                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \app\models\Page::getStatusLabels($model->status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Page::getStatusFilter()
                        ],
                        [
                            'attribute' => 'en_status',
                            'value' => function ($model) {
                                $model->en_status = $model->en_status ?: 0;
                                return \app\models\Page::getStatusLabels($model->en_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Page::getStatusFilter()
                        ],
                        [
                            'attribute' => 'ar_status',
                            'value' => function ($model) {
                                $model->ar_status = $model->ar_status ?: 0;
                                return \app\models\Page::getStatusLabels($model->ar_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Page::getStatusFilter()
                        ],
                        ['class' => 'app\components\customWidgets\CustomActionColumn']
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php
//    var_dump(\yii\helpers\ArrayHelper::map(\app\models\Category::find()->roots()->all(), 'url', 'name'));exit;
    ?>
    <?php Pjax::end(); ?>
</div>
