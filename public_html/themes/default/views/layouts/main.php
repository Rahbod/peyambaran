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
<html lang="<?= Yii::$app->language; ?>" direction="rtl"
      class="wf-poppins-n3-active wf-poppins-n4-active wf-poppins-n5-active wf-poppins-n6-active wf-poppins-n7-active wf-roboto-n3-active wf-roboto-n4-active wf-roboto-n5-active wf-roboto-n6-active wf-roboto-n7-active wf-active">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <?php $this->registerAssetBundle(yii\web\JqueryAsset::className(), \yii\web\View::POS_HEAD); ?>

    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css', [], 'fullcalendar'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/fontiran.css', [], 'fontiran'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/flag-icon.css', [], 'flag-icon'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/vendors.bundle.rtl.css', [], 'vendors'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/custom/datatables/datatables.bundle.rtl.css', [], 'datatables'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css', [], 'full-calendar'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/demo/default/base/style.bundle.rtl.css', [], 'style'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/assets/vendors/base/selectize.bootstrap3.css', [], 'selectize-css'); ?>

    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/base/vendors.bundle.js', [], 'vendors'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/demo/default/base/scripts.bundle.js', [], 'scripts'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js', [], 'full-calendar'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/app/js/dashboard.js', [], 'dashboard'); ?>

    <?php $this->registerJsFile($this->theme->baseUrl . '/assets/vendors/base/selectize.js', [], 'selectize'); ?>
    <?php $this->head();?>
</head>

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<?php $this->beginBody(); ?>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <?php echo $this->render('_header');?>
    <!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            <!-- BEGIN: Aside Menu -->
            <?php echo $this->render('_side_menu');?>
            <!-- END: Aside Menu -->
        </div>

        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            <?php echo $this->render('_breadcrumbs') ?>
            <!-- END: Subheader -->
            <div class="m-content">
                <!--Begin::Section-->
                <?php echo $content; ?>
                <!--End::Section-->
            </div>
        </div>
    </div>
    <!-- end:: Body -->

    <!-- begin::Footer -->
    <?php echo $this->render('_footer');?>

    <!-- end::Footer -->
</div>

<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->

<!-- end::Body -->
<?php $this->endBody(); ?>
<!--end::Page Snippets -->
</body>
</html>
<?php $this->endPage(); ?>
