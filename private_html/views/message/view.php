<?php

use app\models\Message;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

switch ($model->type) {
    case \app\models\Message::TYPE_CONTACT_US:
        $label =Yii::t('words', 'Contactus');
        $url = ['contactus'];
        $attributes = [
            [
                'attribute' => 'type',
                'value' => \app\models\Message::getStatusLabels($model->type),
                'format' => 'raw'
            ],
            [
                'attribute' => 'created',
                'value' => jDateTime::date('Y/m/d', $model->created)
            ],
            [
                'attribute' => 'department_id',
                'value' => $model->department->name,
            ],
            'name',
            'email',
            'tel',
            [
                'attribute' => 'subject',
                'value' => function ($model) {
                    return $model->subject ? "<b>{$model->subject}</b>" : null;
                },
                'format' => 'raw'
            ],
            'body:ntext',
        ];
        break;
    case \app\models\Message::TYPE_COMPLAINTS:
        $label =Yii::t('words', 'Complaints');
        $url = ['complaints'];
        $attributes = [
            [
                'attribute' => 'type',
                'value' => \app\models\Message::getStatusLabels($model->type),
                'format' => 'raw'
            ],
            [
                'attribute' => 'created',
                'value' => jDateTime::date('Y/m/d', $model->created)
            ],
            'name',
            'email',
            [
                'attribute' => 'degree',
                'value' => Message::getDegrees($model->degree)
            ],
            'tel',
            'country',
            'city',
            'address',
            'body:ntext',
        ];
        break;
    case \app\models\Message::TYPE_SUGGESTIONS:
        $label =Yii::t('words', 'Suggestions');
        $url = ['suggestions'];
        $attributes = [
            [
                'attribute' => 'type',
                'value' => \app\models\Message::getStatusLabels($model->type),
                'format' => 'raw'
            ],
            [
                'attribute' => 'created',
                'value' => jDateTime::date('Y/m/d', $model->created)
            ],
            [
                'attribute' => 'subject',
                'value' => function ($model) {
                    $subject = Message::getSubjects($model->subject);
                    return "<b>{$subject}</b>";
                },
                'format' => 'raw'
            ],
            'name',
            'email',
            [
                'attribute' => 'degree',
                'value' => Message::getDegrees($model->degree)
            ],
            'tel',
            'country',
            'city',
            'address',
            'body:ntext',
        ];
        break;
}

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $label, 'url' => $url];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                <!--                <li class="m-portlet__nav-item hidden">-->
                <!--                    --><? //= Html::a('<span><i class="far fa-edit"></i><span>' . Yii::t('words', 'Update') . '</span></span>', ['update', 'id' => $model->id], [
                //                        'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-success',
                //                        'encode' => false,
                //                    ]) ?>
                <!--                </li>-->
                <li class="m-portlet__nav-item">
                    <?= Html::a('<span><i class="far fa-trash-alt"></i><span>' . Yii::t('words', 'Delete') . '</span></span>', ['delete', 'id' => $model->id], [
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
                'attributes' => $attributes,
            ]) ?>
        </div>
    </div>
</div>
