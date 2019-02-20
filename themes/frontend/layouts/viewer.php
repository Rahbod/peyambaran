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
    <title><?= Yii::$app->name.(($this->title)?' - '.$this->title:''); ?></title>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-rtl.min.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-rtl');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/fontiran.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'fontiran');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-theme.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-theme');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/responsive-theme.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'responsive-theme');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/vars.js', ['depends' => [JqueryAsset::className()]], 'vars');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.script.js', ['depends' => [JqueryAsset::className()]], 'script');?>
    <?php $this->head(); ?>
</head>
<body class="overflow-fix">
<?php $this->beginBody(); ?>
    <?= $content ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
