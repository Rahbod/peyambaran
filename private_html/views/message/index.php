<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('words', 'Messages');
$this->params['breadcrumbs'][] = $this->title;


switch ($this->context->action->id){
    case 'contactus':
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
//                        [
//                            'attribute' => 'type',
//                            'value' => function ($model) {
//                                return \app\models\Message::getStatusLabels($model->type);
//                            },
//                            'filter' => \app\models\Message::getStatusLabels()
//                        ],
            [
                'attribute' => 'department_id',
                'value' => function ($model) {
                    return $model->department->name;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Department::find()->all(), 'id', 'name'),
                'visible' =>
                    !Yii::$app->request->getQueryParam('id') &&
                    !Yii::$app->user->identity->contactus_type,
            ],
            'tel',
            [
                'class' => 'app\components\customWidgets\CustomActionColumn',
                'template' => '{view} {delete}'
            ]
        ];
        break;
    case    'suggestions':
    case 'complaints':
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'tel',
            [
                'class' => 'app\components\customWidgets\CustomActionColumn',
                'template' => '{view} {delete}'
            ]
        ];
        break;
}


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
            <div class="m-portlet__head-tools fade">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="<?= \yii\helpers\Url::to(['create']) ?>"
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= Yii::t('words', 'Create Message') ?></span>
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
                    'columns' => $gridColumns,
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
