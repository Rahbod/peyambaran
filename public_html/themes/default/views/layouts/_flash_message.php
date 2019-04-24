<?php

/* @var $this yii\web\View */
/* @var $prefix string */

$flashName = 'alert';
if(isset($prefix))
    $flashName = $prefix . '-' . $flashName;

if(Yii::$app->session->hasFlash($flashName)):
    $alert = Yii::$app->session->getFlash($flashName, null, true);
    $type = $alert['type'];
    $message = $alert['message'];
?>
    <div class="m-alert m-alert--icon alert alert-<?= $type ?> m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
        <div class="m-alert__icon">
            <i class="la la-warning"></i>
        </div>
        <div class="m-alert__text">
            <?= nl2br($message) ?>
        </div>
        <div class="m-alert__close">
            <button type="button" class="close" data-close="alert" aria-label="Close">
            </button>
        </div>
    </div>
<?php endif;?>