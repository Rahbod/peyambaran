<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Cooperation request');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-request-index">

    <?php Pjax::begin(); ?>

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <?= Html::encode($this->title) ?>
                    </h3>
                </div>
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
                        [
                            'attribute' => 'name',
                            'value' => function ($model) {
                                return $model->getFullName();
                            }
                        ],
                        [
                            'attribute' => 'gender',
                            'value' => function ($model) {
                                return $model->getGenderLabel();
                            },
                            'filter' => \app\models\Cooperation::getGenderLabels()
                        ],
                        [
                            'attribute' => 'cooperation_type',
                            'value' => function ($model) {
                                return $model->getCooperationTypeLabel();
                            },
                            'filter' => \app\models\Cooperation::getCooperationTypeLabels()
                        ],
                        [
                            'attribute' => 'military_status',
                            'value' => function ($model) {
                                if ($model->military_status === null)
                                    return $model->military_status;
                                return $model->military_status == 1 ? 'پایان خدمت' : 'معافیت';
                            },
                            'filter' => [
                                    0 => 'معافیت',
                                    1 => 'پایان خدمت',
                            ]
                        ],
                        'city',
                        'activity_requested',
                        [
                            'attribute' => 'created',
                            'value' => function ($model) {
                                return jDateTime::date('y/m/d', $model->created);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                $css = $model->getStatusCssClass();
                                return "<span class='m-badge m-badge--inline m-badge--pill m-badge--$css'>{$model->getStatusLabel()}</span>";
                            },
                            'filter' => \app\models\UserRequest::getStatusLabels(),
                            'format' => 'raw'
                        ],
                        [
                            'class' => 'app\components\customWidgets\CustomActionColumn',
                            'template' => '{view} {delete}'
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
