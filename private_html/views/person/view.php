<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Person */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'People'), 'url' => ['index']];
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
            <?php if($model->avatar && is_file(Yii::getAlias("@webroot/{$this->context->avatarDir}/$model->avatar"))): ?>
            <div class="text-center mb-4" style="display: block;overflow: hidden">
                <img class="rounded-circle" style="display: inline-block;overflow: hidden" width="160" height="160" src="<?= Yii::getAlias("@web/{$this->context->avatarDir}/$model->avatar") ?>">
            </div>
            <?php endif; ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'medical_number',
                    [
                        'attribute' => 'userID',
                        'value' => $model->user->username
                    ],
                    [
                        'attribute' => 'name',
                        'value' => '<b>'.$model->name.'</b>',
                        'format' => 'raw',
                    ],
                    'firstname',
                    'surename',
                    [
                        'attribute' => 'expertise',
                        'value' => $model->getExpertiseLabel()?$model->getExpertiseLabel()->name:null,
                    ],
                    [
                        'attribute' => 'experience',
                        'value' => $model->experience.'  سال',
                    ],
                    [
                        'attribute' => 'resume',
                        'value' => $model->resume,
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'created',
                        'value' => jDateTime::date('Y/m/d', $model->created)
                    ],
                    [
                        'attribute' => 'status',
                        'value' => \app\models\Page::getStatusLabels($model->status)
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
