<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


if (empty($model->post_body) && !empty($model->body))
    $model->post_body = $model->body;

?>
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
                    <?= Html::a('<span><i class="far fa-edit"></i><span>'.Yii::t('words', 'Update').'</span></span>', ['update', 'id' => $model->id], [
                        'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-success',
                        'encode' => false,
                    ]) ?>
                </li>
                <li class="m-portlet__nav-item">
                    <?= Html::a('<span><i class="far fa-trash-alt"></i><span>'.Yii::t('words', 'Delete').'</span></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-danger',
                        'encode' => false,
                        'data' => [
                            'confirm' => Yii::t('words', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'userID',
                        'value' => $model->user->username
                    ],
                    [
                        'attribute' => 'lang',
                        'value' => '<b>'.\app\components\MultiLangActiveRecord::$langArray[$model->lang].'</b>',
                        'format' => 'raw',
                    ],
                    'name',
//                    [
//                        'attribute' => 'publish_date',
//                        'value' => $model->publish_date
//                    ],
                    [
                        'attribute' => 'created',
                        'value' => jDateTime::date('Y/m/d', $model->created)
                    ],
                    [
                        'attribute' => 'publish_date',
                        'value' => $model->publish_date?jDateTime::date('Y/m/d', $model->publish_date):null
                    ],
                    [
                        'attribute' => 'status',
                        'value' => \app\models\Page::getStatusLabels($model->status)
                    ],
                    [
                        'attribute' => 'summary',
                        'value' => $model->summary,
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'post_body',
                        'value' => $model->post_body,
                        'format' => 'raw'
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
