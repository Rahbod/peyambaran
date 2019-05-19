<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Advice */

$this->title = "درخواست مشاوره پزشکی \"{$model->getFullName()}\"";
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'Medical advice request'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($admin): ?>
    <?php \yii\widgets\Pjax::begin() ?>
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
                        <?= Html::a('<span><i class="far fa-edit"></i><span>ثبت پاسخ</span></span>', "#", [
                            'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-success',
                            'encode' => false,
                            'data' => [
                                'toggle' => 'collapse',
                                'target' => '#visit-collapse',
                            ],
                        ]) ?>
                    </li>
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
            <div class="m-portlet--collapse collapse" id="visit-collapse">
                <div class="well">
                    <?php $form = \app\components\customWidgets\CustomActiveForm::begin([
                        'id' => 'visit-date-form',
                        'action' => ['update', 'id' => $model->id],
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'validateOnSubmit' => true,
                    ]); ?>
                    <h5 class="text-center">ثبت پاسخ</h5>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <?= Html::label('متن پاسخ', 'answer', ['class' => 'control-label pull-left']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'answer')->textarea(['class' => 'form-control m-form-control m-input', 'rows' => 6])->label(false) ?>
                        </div>
                        <div class="col-sm-3">
                            <?= Html::submitButton('ثبت پاسخ', ['class' => 'btn btn-success', 'data' => ['method' => 'post']]) ?>
                        </div>
                    </div>
                    <?php \app\components\customWidgets\CustomActiveForm::end() ?>
                </div>
            </div>

            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
            <div class="row">
                <?php $form = \app\components\customWidgets\CustomActiveForm::begin([
                    'id' => 'change-status-form',
                    'options' => ['class' => 'form-inline col-sm-12','data-pjax' => false],
                    'action' => ['update', 'id' => $model->id],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'validateOnSubmit' => true,
                ]); ?>
                <div class="mb-4 col-sm-12">
                    <div class="row">
                        <?= $form->field($model, 'status')->dropDownList(\app\models\UserRequest::getStatusLabels())->label('تغییر وضعیت درخواست') ?>
                        <div class="pull-left mt-2 ml-5">
                            <?= Html::submitButton('تغییر وضعیت', ['class' => 'btn btn-success btn-sm']) ?>
                        </div>
                    </div>
                </div>
                <?php \app\components\customWidgets\CustomActiveForm::end() ?>
            </div>

            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
                <table class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr>
                        <th><?= Yii::t('words', 'Name and Family') ?></th>
                        <td><?= $model->getFullName() ?></td>
                    </tr>
                    <tr>
                        <th><?= $model->getAttributeLabel('created') ?></th>
                        <td><?= jDateTime::date('Y/m/d', $model->created) ?></td>
                    </tr>
                    <?php foreach ($model->dynaDefaults as $field => $setting):
                        if ($field == 'lang' || $field == 'family' || $field == 'files')
                            continue;
                        $value = $model->$field;
                        ?>
                        <tr>
                            <th><?= $model->getAttributeLabel($field) ?></th>
                            <td><?= $value ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <h4><?= $model->getAttributeLabel('files') ?></h4>
                <ol>
                    <?php
                    $i = 0;
                    foreach ($model->attachments as $attachment): $i++ ?>
                        <li><?= Html::a(Yii::t('words', 'Download attachment') . ' ' . $i, $attachment->getAbsoluteUrl()) ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
    <?php \yii\widgets\Pjax::end() ?>
<?php else: ?>

    <div class="content-header">
        <img src="<?= $this->theme->baseUrl ?>/svg/"
             class="img-fluid content-header__image" alt="">
        <div class="content-header__titles">
            <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Request details') ?></h1>
            <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row mt-5 mb-4">
            <?= Html::a(Yii::t('words', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-sm btn-primary pull-left']) ?>
            <?= Html::a(Yii::t('words', 'Delete request'), ['delete', 'id' => $model->id], [
                'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'class' => 'btn btn-sm btn-danger pull-left ml-3',
            ]) ?>
        </div>
        <div class="row mb-5 contactUs__container dashboard__form-container">
            <table class="table table-striped table-bordered detail-view">
                <tbody>
                <tr>
                    <th><?= Yii::t('words', 'Name and Family') ?></th>
                    <td><?= $model->getFullName() ?></td>
                </tr>
                <tr>
                    <th><?= $model->getAttributeLabel('created') ?></th>
                    <td><?= jDateTime::date('Y/m/d', $model->created) ?></td>
                </tr>
                <?php foreach ($model->dynaDefaults as $field => $setting):
                    if ($field == 'lang' || $field == 'family' || $field == 'files')
                        continue;
                    $value = $model->$field;
                    ?>
                    <tr>
                        <th><?= $model->getAttributeLabel($field) ?></th>
                        <td><?= $value ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h4><?= $model->getAttributeLabel('files') ?></h4>
            <ol>
                <?php
                $i = 0;
                foreach ($model->attachments as $attachment): $i++ ?>
                    <li><?= Html::a(Yii::t('words', 'Download attachment') . ' ' . $i, $attachment->getAbsoluteUrl()) ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
<?php endif;