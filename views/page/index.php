<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

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
                        <a href="<?= \yii\helpers\Url::to(['create'])?>" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= Yii::t('words', 'Create Page') ?></span>
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
                       'id',
                       'userID',
                       'modelID',
                       'type',
                       'name',
                        //'dyna',
                        //'extra:ntext',
                        //'created',
                        //'status',
                        ['class' => 'app\components\customWidgets\CustomActionColumn']
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
