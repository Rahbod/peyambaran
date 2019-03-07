<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClinicProgram */

$searchModel = new \app\models\PersonSearch();
$searchModel->type = \app\models\Person::TYPE_DOCTOR;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$dayID = $model->id;

$this->title = jDateTime::date('l d F Y', $model->date);
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'Clinic Program'), 'url' => ['index']];
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
                        'attribute' => 'date',
                        'value' => $this->title
                    ],
                    [
                        'attribute' => 'is_holiday',
                        'value' => $model->is_holiday?
                                        "<b class='text-success'><i class='fa fa-check'></i></b>":
                                        "<b class='text-danger'><i class='fa fa-times-circle'></i></b>",
                        'format' => 'raw'
                    ]
                ],
            ]) ?>

            <h5 class="mt-5"><?= Yii::t('words', 'Doctors') ?></h5>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}',
                'columns' => [
                    [
                        'class' => \app\components\customWidgets\CustomCheckboxColumn::className(),
                        'header' => Yii::t('words', 'Presence Status'),
                        'disabled' => true,
                        'checkboxOptions' => function ($model, $key, $index, $column) use ($dayID) {
                            $checked = false;
                            if ($dayID) {
                                $rel = $model->getProgramRel($dayID);
                                $checked = !is_null($rel);
                            }
                            return [
                                'name' => "ClinicProgram[doctors][{$model->id}][personID]",
                                'value' => $model->personID,
                                'checked' => $checked,
                                'disabled' => true,
                            ];
                        },
                        'options' => ['width' => '5%']
                    ],
                    [
                        'attribute' => 'name',
                        'header' => Yii::t('words', 'Doctor Name'),
                        'value' => function ($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'header' => Yii::t('words', 'Start Time'),
                        'value' => function ($model) use ($dayID) {
                            $value = '';
                            if ($dayID) {
                                $rel = $model->getProgramRel($dayID);
                                $value = $rel ? $rel->start_time : '';
                            }
                            return Html::textInput("ClinicProgram[doctors][{$model->id}][start_time]", $value, ['class' => 'form-control m-input m-input--air disabled','readonly' => true]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'header' => Yii::t('words', 'End Time'),
                        'value' => function ($model) use ($dayID) {
                            $value = '';
                            if ($dayID) {
                                $rel = $model->getProgramRel($dayID);
                                $value = $rel ? $rel->end_time : '';
                            }
                            return Html::textInput("ClinicProgram[doctors][{$model->id}][end_time]", $value, ['class' => 'form-control m-input m-input--air disabled','readonly' => true]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'header' => Yii::t('words', 'Description'),
                        'value' => function ($model) use ($dayID) {
                            $value = '';
                            if ($dayID) {
                                $rel = $model->getProgramRel($dayID);
                                $value = $rel ? $rel->description: '';
                            }
                            return Html::textInput("ClinicProgram[doctors][{$model->id}][description]", $value, ['class' => 'form-control m-input m-input--air disabled','readonly' => true]);
                        },
                        'format' => 'raw'
                    ]
                ],
            ]); ?>
        </div>
    </div>
</div>
