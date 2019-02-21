<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $action mixed */
/* @var $modalID string */
/* @var $pjaxContainer string */
?>

<?php Pjax::begin([
    'id' => (isset($modalID) ? $modalID . '-pjax' : 'delete-pjax'),
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
    'clientOptions' => [
        'container' => '#' . (isset($pjaxContainer) ? $pjaxContainer : 'grid-pjax')
    ]
]);?>
<div class="custom-modal delete-modal hidden" id="<?= isset($modalID) ? $modalID : 'delete-modal' ?>">
    <div class="top">
        <i class="delete-icon"></i>
        <span id="title">آیا از حذف این گزینه اطمینان دارید؟</span>
    </div>
    <div class="context">
        <div class="record-info">
            <i class="icon book"></i>
            <span class="action-name"></span>
            <span class="record-name nicescroll" data-cursorcolor="#a6c426" data-cursorborder="none" data-railpadding='js:{"top":0,"right":-10,"bottom":0,"left":0}' data-autohidemode="false"></span>
        </div>
        <div class="overflow-fix">
            <div class="pull-left">
                <?= Html::beginForm($action, 'post', [
                    'id' => 'delete-form',
                    'data-pjax' => true
                ]) ?>
                    <?= Html::hiddenInput('Delete[id]', null, ['id' => 'id']) ?>
                    <?= Html::hiddenInput('Delete[type]', null, ['id' => 'type']) ?>
                    <?= Html::input('button', null, 'انصراف', ['class' => 'btn btn-dark btn-shadow close-modal']) ?>
                    <?= Html::input('submit', 'Delete[submit]', 'حذف', ['class' => 'btn btn-danger btn-shadow', 'id' => 'delete-form-submit']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end();?>