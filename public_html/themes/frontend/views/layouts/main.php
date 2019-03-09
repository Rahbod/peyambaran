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
    <title><?= (($this->title) ? $this->title . ' - ': ''). Yii::$app->name; ?></title>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-rtl.min.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-rtl');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/fontiran-fa-num.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'fontiran-fa-num');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/font-awesome.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'font-awesome');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/owl.carousel.min.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'owl-carousel');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/owl.theme.default.min.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'owl-theme');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-theme.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-theme');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/responsive-theme.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'responsive-theme');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/bootstrap.min.js', ['depends' => [JqueryAsset::className()]], 'bootstrap');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.nicescroll.min.js', ['depends' => [JqueryAsset::className()]], 'nicescroll');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/owl.carousel.min.js', ['depends' => [JqueryAsset::className()]], 'owl-script');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.script.js', ['depends' => [JqueryAsset::className()]], 'script');?>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<?php echo $this->render('_header');?>
<div class="content">
    <?= $content ?>
</div>
<?php echo $this->render('_footer');?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
