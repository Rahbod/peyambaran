<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this \yii\web\View */

Pjax::begin([
    'id' => 'header-pjax',
    'options' => [
        'class' => 'header',
    ],
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
    'formSelector' => false,
    'linkSelector' => false,
]);?>
<div class="container-fluid overflow-fix">
<!--    <div class="pull-right visible-xs menu-btn-box">-->
<!--        <span class="version">Version 2.0</span>-->
<!--        <a href="#" class="menu-trigger"></a>-->
<!--    </div>-->
    <div class="pull-right hidden-xs">
        سامانه مدیریت اسناد و مدارک دیجیتال
    </div>
    <div class="pull-left logo-en">
        Soha Library
        <small>make.Knowledge</small>
    </div>

    <div class="menu">
        <div class="head">
            <div class="container-fluid">
                <a href="#" class="menu-trigger"></a>
                <h3>سها<small>سامانه مدیریت اسناد و مدارک دیجیتال</small></h3>
            </div>
        </div>
        <div class="items nicescroll" data-cursorcolor="#a6c426" data-cursorborder="none" data-railpadding='js:{"top":0,"right":0,"bottom":0,"left":5}' data-autohidemode="leave">
            <div class="user-block">
                <ul>
                    <li class="list-link-item"><a href="#">شرایط و ضوابط</a></li>
                    <li class="list-link-item"><a href="#">راهنما</a></li>
                    <li class="list-link-item"><a href="#">نقشه سایت</a></li>
                    <li class="list-link-item"><a href="#">گزارش خطا</a></li>
                    <li class="list-link-item"><a href="#">درباره ما</a></li>
                    <li class="list-link-item"><a href="#">تماس با ما</a></li>
                </ul>
            </div>
            <img src="<?php echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png') ?>" class="logo">
        </div>
    </div>
</div>
<?php Pjax::end();?>
