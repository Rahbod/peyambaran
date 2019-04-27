<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

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
                        <a href="<?= \yii\helpers\Url::to(['create-department']) ?>"
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= Yii::t('words', 'Create Department') ?></span>
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
                <?= CustomGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \app\models\Department::getStatusLabels($model->status, true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Department::getStatusFilter()
                        ],
                        [
                            'attribute' => 'en_status',
                            'value' => function ($model) {
                                $model->en_status = $model->en_status ?: 0;
                                return \app\models\Department::getStatusLabels($model->en_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Department::getStatusFilter()
                        ],
                        [
                            'attribute' => 'ar_status',
                            'value' => function ($model) {
                                $model->ar_status = $model->ar_status ?: 0;
                                return \app\models\Department::getStatusLabels($model->ar_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Department::getStatusFilter()
                        ],
                        [
                            'class' => 'app\components\customWidgets\CustomActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="far fa-trash-alt text-danger"></span>', ['delete-department', 'id' => $model->id], [
                                        'data-pjax' => '0',
                                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                    ]);
                                },
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="far fa-edit text-success"></span>', ['update-department', 'id' => $model->id], [
                                        'data-pjax' => '0',
                                    ]);
                                }
                            ]
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
