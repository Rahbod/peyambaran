<?php
/* @var $this yii\web\View */
/* @var $model app\models\Person */
?>
<div class="panel panel-default mb-3">
    <div class="panel-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 col-lg-6">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $model->id ?>">
                            <div class="panel-title__doctorAvatar">
                                <?php if ($model->avatar && is_file(Yii::getAlias("@webroot/uploads/person/$model->avatar"))): ?>
                                    <img src="<?= Yii::getAlias('@web/uploads/person/') . $model->avatar ?>"
                                         alt="<?= $model->getName() ?>">
                                <?php else: ?>
                                    <img class="panel-title__doctorAvatar-default"
                                         src="<?= $this->theme->baseUrl ?>/images/doctors/avatar-gray.png"
                                         alt="<?= $model->getName() ?>">
                                <?php endif; ?>
                            </div>
                            <h4 class="panel-title__doctorName"><?= $model->getName() ?></h4>
                            <p class="panel-title__doctorExpertise">
                                <?= $model->getExpertiseLabel() ? $model->getExpertiseLabel()->getName() : '-' ?>
                            </p>
                            <div class="panel-title__more">
                                <img src="<?= $this->theme->baseUrl . '/images/doctors/more-info.png' ?>" alt="">
                                <?= Yii::t('words', 'more information') ?>
                            </div>
                        </a>
                    </h4>
                </div>
                <div class="col-sm-3 col-lg-2 text-center">
                    <a class="btn panel-title__takeTurn" href="void:;"><?= Yii::t('words', 'get_visit') ?></a>
                </div>
                <div class="col-sm-5 col-lg-4">
                    <?php foreach ($model->getVisitDays() as $day):
                        $rels = $day->getPersonsRel()->andWhere(['personID' => $model->id])->all();
                        foreach ($rels as $rel):
                            ?>
                            <div class="panel-title__doctorTimes">
                                <span><i class="icomoon-success ml-2"
                                         style="margin-bottom: -5px;"></i><?= jDateTime::date('l', $day->date) ?></span>
                                <span><?= Yii::t('words', 'show_time', [
                                        'start_time' => substr($rel->start_time,0,5),
                                        'end_time' => substr($rel->end_time,0,5),
                                    ]) ?></span>
                            </div>
                        <?php endforeach;endforeach; ?>
                </div>
            </div>
        </div>

    </div>
    <div id="collapse-<?= $model->id ?>" class="panel-collapse collapse">
        <div class="panel-body"><?= $model->resume ?></div>
    </div>
</div>