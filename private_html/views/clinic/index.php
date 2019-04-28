<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClinicProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Manage Days');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clinic-index">

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
							<span><?= Yii::t('words', 'Create New Day') ?></span>
						</span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="<?= \yii\helpers\Url::to(['import-excel-program']) ?>"
                           class="btn btn-dark m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-file-text"></i>
							<span><?= Yii::t('words', 'Import excel') ?></span>
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
//                    'filterModel' => false,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'date',
                            'value' => function ($model) {
                                return "<span dir='ltr'>" . jDateTime::date('Y l d F', $model->date) . "</span>";
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'is_holiday',
                            'value' => function ($model) {
                                return $model->is_holiday ? '<i class="text-success fa fa-check-circle"></i>' : '';
                            },
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'userID',
                            'value' => function ($model) {
                                return $model->user->username;
                            }
                        ],
                        ['class' => 'app\components\customWidgets\CustomActionColumn',]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
