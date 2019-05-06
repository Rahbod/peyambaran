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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= (($this->title) ? $this->title . ' - ' : '') . Yii::$app->name; ?></title>
    <?php if (Yii::$app->language != 'en')
        $this->registerCssFile($this->theme->baseUrl . '/css/bootstrap-rtl.min.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'bootstrap-rtl'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/css/bootstrap-4-classes.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'bootstrap-4-classes'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/css/font-awesome.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'font-awesome'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/css/owl.carousel.min.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'owl-carousel'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/css/owl.theme.default.min.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'owl-theme'); ?>
    <?php $this->registerCssFile($this->theme->baseUrl . '/js/vendors/icomoon/style.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'icomoon'); ?>
    <?php
    $this->registerCssFile($this->theme->baseUrl . '/css/sidebar.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'sidebar');
    $this->registerCssFile($this->theme->baseUrl . '/css/bootstrap-theme.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'bootstrap-theme');
    if (Yii::$app->language == 'en') {
        $this->registerCssFile($this->theme->baseUrl . '/css/bootstrap-theme-ltr.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'bootstrap-theme-en');
        $this->registerCssFile($this->theme->baseUrl . '/css/responsive-theme-ltr.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'responsive-theme-ltr');
        $this->registerCssFile($this->theme->baseUrl . '/css/sidebar-ltr.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'sidebar-ltr');
        $this->registerCssFile($this->theme->baseUrl . '/css/fontiran.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'fontiran-fa-num');
    } else {
        $this->registerCssFile($this->theme->baseUrl . '/css/fontiran-fa-num.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'fontiran-fa-num');
        $this->registerCssFile($this->theme->baseUrl . '/css/responsive-theme.css', ['depends' => [BootstrapAsset::className()], 'media' => 'all'], 'responsive-theme');
    }
    ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/js/bootstrap.min.js', ['depends' => [JqueryAsset::className()]], 'bootstrap'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/js/jquery.nicescroll.min.js', ['depends' => [JqueryAsset::className()]], 'nicescroll'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/js/owl.carousel.min.js', ['depends' => [JqueryAsset::className()]], 'owl-script'); ?>
    <?php $this->registerJsFile($this->theme->baseUrl . '/js/jquery.script.js', ['depends' => [JqueryAsset::className()]], 'script'); ?>
    <?php $this->registerJs('
        $(".captcha a").trigger("click");
    ', \yii\web\View::POS_LOAD, 'captcha-refresh'); ?>
    <?php $this->head(); ?>
</head>
<body class="<?= Yii::$app->controller->bodyClass ?: '' ?>">
<?php $this->beginBody(); ?>
<?php echo $this->render('_header'); ?>
<main>
    <div class="content">
        <?= $content ?>
    </div>
</main>
<div class="screen-overlay"></div>

<?php echo $this->render('_footer'); ?>
<?php echo $this->render('_public_alert'); ?>
<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
