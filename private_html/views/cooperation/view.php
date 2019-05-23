<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\CooperationController;
use app\models\Cooperation;

/* @var $this yii\web\View */
/* @var $model app\models\Cooperation */
$this->title = "درخواست همکاری \"{$model->getFullName()}\"";
$this->params['breadcrumbs'][] = ['label' => Yii::t('words', 'Cooperation request'), 'url' => ['index']];
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
                        <?= Html::a('<span><i class="far fa-trash-alt"></i><span>' . Yii::t('words', 'Delete') . '</span></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-danger',
                            'encode' => false,
                            'data-confirm' => Yii::t('words', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]) ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
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

                <?php if ($model->avatar && is_file(Yii::getAlias('@webroot/' . CooperationController::$avatarPath . '/' . $model->avatar))): ?>
                    <div class="row mt-5 mb-5">
                        <div class="col-sm-4">
                            <a href="<?= Yii::getAlias('@web/' . CooperationController::$avatarPath . '/' . $model->avatar) ?>"
                               target="_blank" data-pjax="0">
                                <?= Html::img(Yii::getAlias('@web/' . CooperationController::$avatarPath . '/' . $model->avatar), ['class' => 'rounded-circle', 'style' => 'width:150px;height:150px;']) ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-bordered detail-view">
                    <tbody>
                    <tr>
                        <th><?= Yii::t('words', 'Name and Family') ?></th>
                        <td><?= $model->getFullName() ?></td>
                    </tr>
                    <tr>
                        <th><?= Yii::t('words', 'Tell') ?></th>
                        <td><b style="font-size: 16px"><?= $model->tell ?></b></td>
                    </tr>
                    <tr>
                        <th><?= $model->getAttributeLabel('created') ?></th>
                        <td><?= jDateTime::date('Y/m/d', $model->created) ?></td>
                    </tr>
                    <?php foreach ($model->dynaDefaults as $field => $setting):
                        if ($field == 'lang' || $field == 'tell' || $field == 'avatar' || $field == 'family'
                            || $field == 'edu_history' || $field == 'job_history' || $field == 'job_history')
                            continue;

                        if ($model->cooperation_type == Cooperation::COOPERATION_TYPE_MEDICAL && (
                                $field == 'military_status' || $field == 'military_reason' || $field == 'military_date'
                                || $field == 'skills' || $field == 'activity_requested'
                            ))
                            continue;

                        if (($model->cooperation_type == Cooperation::COOPERATION_TYPE_OFFICIAL ||
                                $model->cooperation_type == Cooperation::COOPERATION_TYPE_ASSISTANCE) && (
                                $field == 'medical_number' || $field == 'work_permits_status' || $field == 'work_permits_expire'
                                || $field == 'resume' || $field == 'activity_date'
                            ))
                            continue;

                        if ($model->cooperation_type == Cooperation::COOPERATION_TYPE_ASSISTANCE && (
                                $field == 'medical_number' || $field == 'work_permits_status' || $field == 'work_permits_expire'
                                || $field == 'resume' || $field == 'activity_date'
                            ))
                            continue;

                        switch ($field) {
                            case 'gender':
                                $value = $model->getGenderLabel();
                                break;
                            case 'marital_status':
                                $value = $model->getMaritalLabel();
                                break;
                            case 'cooperation_type':
                                $value = $model->getCooperationTypeLabel();
                                break;
                            case 'language_level':
                                $levels = [1 => 'متوسط', 2 => 'خوب', 3 => 'عالی'];
                                $value = $levels[$model->language_level];
                                break;
                            case 'military_status':
                                $levels = [1 => 'انجام دادم', 0 => 'معافیت'];
                                $value = $levels[$model->military_status];
                                break;
                            case 'work_permits_status':
                                $levels = [1 => 'پروانه موقت', 2 => 'پروانه مطب', 3 => 'پروانه دائم'];
                                $value = $levels[$model->work_permits_status];
                                break;
                            default:
                                $value = $model->$field;
                        }
                        ?>
                        <tr>
                            <th><?= $model->getAttributeLabel($field) ?></th>
                            <td><?= $value ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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
            <div class="row mt-5 mb-5">
                <div class="col-sm-4">
                    <?= Html::img(Yii::getAlias('@web/' . CooperationController::$avatarPath . '/' . $model->avatar), ['class' => 'rounded-circle', 'style' => 'width:150px;height:150px;']) ?>
                </div>
            </div>
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
                    if ($field == 'lang' || $field == 'avatar' || $field == 'family'
                        || $field == 'edu_history' || $field == 'job_history' || $field == 'job_history')
                        continue;

                    if ($model->cooperation_type == Cooperation::COOPERATION_TYPE_MEDICAL && (
                            $field == 'military_status' || $field == 'military_reason' || $field == 'military_date'
                            || $field == 'skills' || $field == 'activity_requested'
                        ))
                        continue;

                    if (($model->cooperation_type == Cooperation::COOPERATION_TYPE_OFFICIAL ||
                            $model->cooperation_type == Cooperation::COOPERATION_TYPE_ASSISTANCE) && (
                            $field == 'medical_number' || $field == 'work_permits_status' || $field == 'work_permits_expire'
                            || $field == 'resume' || $field == 'activity_date'
                        ))
                        continue;

                    if ($model->cooperation_type == Cooperation::COOPERATION_TYPE_ASSISTANCE && (
                            $field == 'medical_number' || $field == 'work_permits_status' || $field == 'work_permits_expire'
                            || $field == 'resume' || $field == 'activity_date'
                        ))
                        continue;

                    switch ($field) {
                        case 'gender':
                            $value = $model->getGenderLabel();
                            break;
                        case 'marital_status':
                            $value = $model->getMaritalLabel();
                            break;
                        case 'cooperation_type':
                            $value = $model->getCooperationTypeLabel();
                            break;
                        case 'language_level':
                            $levels = [1 => 'متوسط', 2 => 'خوب', 3 => 'عالی'];
                            $value = $levels[$model->language_level];
                            break;
                        case 'military_status':
                            $levels = [1 => 'انجام دادم', 0 => 'معافیت'];
                            $value = $levels[$model->military_status];
                            break;
                        case 'work_permits_status':
                            $levels = [1 => 'پروانه موقت', 2 => 'پروانه مطب', 3 => 'پروانه دائم'];
                            $value = $levels[$model->work_permits_status];
                            break;
                        default:
                            $value = $model->$field;
                    }
                    ?>
                    <tr>
                        <th><?= $model->getAttributeLabel($field) ?></th>
                        <td><?= $value ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif;