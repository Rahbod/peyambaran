<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\CooperationController;
use app\models\Cooperation;

/* @var $this yii\web\View */
/* @var $model app\models\Cooperation */

$this->title = $model->name;
?>

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
        <?= Html::a(Yii::t('words', 'Back'), ['list'], ['class' => 'btn btn-sm btn-primary pull-left']) ?>
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
                <th>نام و نام خانوادگی</th>
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