<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReceptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "درخواست های پذیرش";
if(Yii::$app->user->identity->reception_type)
    $this->title = "درخواست های پذیرش - ".$searchModel->getReceptionTypeLabel(Yii::$app->user->identity->reception_type);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-request-index">

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
                            'header' => Yii::t('words', 'Name and Family'),
                            'value' => function ($model) {
                                return $model->getPatientName();
                            }
                        ],
                        [
                            'attribute' => 'reception_type',
                            'value' => function ($model) {
                                return $model->getReceptionTypeLabel();
                            },
                            'visible' => !Yii::$app->user->identity->reception_type,
                            'filter' => \app\models\Reception::getReceptionTypeLabels()
                        ],
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
