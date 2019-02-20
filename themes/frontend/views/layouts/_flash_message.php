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
    <div class="alert-message">
        <div class="alert alert-<?= $type ?>"><?= $message ?></div>
    </div>
<?php endif;?>