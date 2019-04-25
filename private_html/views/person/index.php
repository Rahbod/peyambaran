<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\models\Person */

$this->title = Yii::t('words', 'People');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

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
							<span><?= Yii::t('words', 'Create Person') ?></span>
						</span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item">
                        <a href="<?= \yii\helpers\Url::to(['export-csv']) ?>"
                           class="btn btn-dark m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-file-text"></i>
							<span><?= Yii::t('words', 'Export doctors list') ?></span>
						</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php Pjax::begin(); ?>
        <div class="m-portlet__body">
            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <?= CustomGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'medical_number',
                        'name',
//                        [
//                            'attribute' => 'type',
//                            'value' => function ($model) {
//                                return $model->getTypeLabel();
//                            }
//                        ],
                        [
                            'attribute' => 'expertise',
                            'value' => function ($model) {
                                return $model->getExpertiseLabel() ? $model->getExpertiseLabel()->name : null;
                            },
                            'filter' => Category::getWithType(Category::CATEGORY_TYPE_EXPERTISE)
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
        <?php Pjax::end(); ?>
    </div>
</div>
