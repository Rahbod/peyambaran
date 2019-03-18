<?php
/* @var $this yii\web\View */
/* @var $model app\models\Person */
?>
<div class="panel panel-default mb-3">
    <div class="panel-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-<?= $model->id ?>">
                            <img class="panel-title__doctorAvatar"
                                 src="<?= Yii::getAlias('@web/uploads/person/').$model->avatar ?>" alt="">
                            <h4 class="panel-title__doctorName"><?= $model->name ?></h4>
                            <p class="panel-title__doctorExpertise">
                                <?= $model->getExpertiseLabel()->name ?>
                            </p>
                            <div class="panel-title__more">
                                <img src="<?= $this->theme->baseUrl.'/images/doctors/more-info.png' ?>" alt="">
                                <?= Yii::t('words', 'more information') ?>
                            </div>
                        </a>
                    </h4>
                </div>
                <div class="col-lg-2">
                    <a class="btn panel-title__takeTurn" href="void:;"><?= Yii::t('words', 'get_visit') ?></a>
                </div>
                <div class="col-lg-4">
                    <?php foreach ($model->getVisitDays() as $day):
                        $rel = $day->getPersonsRel()->andWhere(['personID' => $model->id])->one();
                        ?>
                        <div class="panel-title__doctorTimes">
                            <span class="icomoon-success"><?= jDateTime::date('l', $day->date) ?></span>
                            <span><?= Yii::t('words', 'show_time', [
                                    'start_time' => $rel->start_time,
                                    'end_time' => $rel->end_time,
                                ]) ?></span>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>

    </div>
    <div id="collapse-<?= $model->id ?>" class="panel-collapse collapse">
        <div class="panel-body"><?= $model->resume ?></div>
    </div>
</div>