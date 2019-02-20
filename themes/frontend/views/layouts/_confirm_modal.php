<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php Pjax::begin([
    'id' => 'confirm-modal',
    'options' => [
        'class' => 'custom-modal confirm-modal hidden',
    ],
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
    'clientOptions' => [
        'container' => '#grid-pjax'
    ]
]);?>
    <div class="top">
        <i class="confirm-icon"></i>
        <span id="title"><?= Yii::t('words', 'base.sureYou') ?></span>
    </div>
    <div class="context">
        <div class="record-info">
            <i class="icon book"></i>
            <span class="action-name"></span>
            <span class="record-name"></span>
        </div>
        <div class="overflow-fix">
            <div class="pull-left">
                <?= Html::beginForm(['confirm'], 'post', [
                    'id' => 'confirm-form',
                    'data-pjax' => true
                ]) ?>
                    <?= Html::hiddenInput('Confirm[id]', null, ['id' => 'id']) ?>
                    <?= Html::hiddenInput('Confirm[type]', null, ['id' => 'type']) ?>
                    <?= Html::input('button', null, Yii::t('words', 'base.cancel'), ['class' => 'btn btn-dark btn-shadow close-modal']) ?>
                    <?= Html::input('submit', 'Confirm[submit]', Yii::t('words', 'base.move'), ['class' => 'btn btn-success btn-shadow', 'id' => 'confirm-form-submit']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
<?php Pjax::end();?>