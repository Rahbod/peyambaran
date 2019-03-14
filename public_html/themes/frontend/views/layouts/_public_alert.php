<?php

/* @var $this yii\web\View */
/* @var $prefix string */

$flashName = 'public-alert';
if (isset($prefix))
    $flashName = $prefix . '-' . $flashName;

$delay = isset($delay) ? $delay : 5000;

if (Yii::$app->session->hasFlash($flashName)):
    $alert = Yii::$app->session->getFlash($flashName, null, true);
    $type = $alert['type'];
    $message = $alert['message'];
    ?>
    <div class="alert-message public-alert">
        <div class="alert alert-<?= $type ?> alert-dismissible fade" role="alert" data-delay="<?= $delay ?>">
            <?= $message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
<?php endif;

$this->registerJs("
    $('.public-alert').each(function(){
        var delay = $(this).find('.alert').data('delay'); 
        var alert = $(this).find('.alert');
        alert.addClass('in');
        setTimeout(function(){
             alert.removeClass('in');
        }, delay);
    });
", \yii\web\View::POS_READY, 'public-alert-hide');
