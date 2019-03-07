<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\themes\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\BootstrapAsset;
use yii\web\JqueryAsset;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= (($this->title) ? $this->title . ' - ': ''). Yii::$app->name; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/fontiran.css', [], 'fontiran'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/vendors.bundle.rtl.css', [], 'vendors'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/demo/default/base/style.bundle.rtl.css', [], 'style'); ?>

    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/base/vendors.bundle.js', [], 'vendors'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/demo/default/base/scripts.bundle.js', [], 'scripts'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/demo/default/base/login-script.js', [], 'login-script'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/snippets/custom/pages/user/login.js', [], 'login'); ?>
    <?php $this->head(); ?>
</head>

<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default" style="overflow-x: hidden">
<?php $this->beginBody(); ?>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url(<?= $this->theme->baseUrl ?>/assets/app/media/img/bg/bg-2.jpg);">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper" style="z-index: 3;">
            <div class="m-login__container">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->

<!-- end::Body -->
<?php $this->endBody(); ?>
<!--end::Page Snippets -->
</body>
</html>
<?php $this->endPage(); ?>
