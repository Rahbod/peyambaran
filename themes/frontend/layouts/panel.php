<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\themes\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\BootstrapAsset;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

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
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/fontiran-fa-num.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'fontiran');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/persian-datepicker.css', null, 'persian-date-picker-css');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/selectize.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'selectize-css');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-select.min.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-select');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/selectize.bootstrap3.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'selectize-bootstrap2-css');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/bootstrap-theme.css', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'bootstrap-theme');?>
    <?php $this->registerCssFile($this->theme->baseUrl.'/css/responsive-theme.css?v=1.0.3', ['depends' => [BootstrapAsset::className()],'media' => 'all'], 'responsive-theme');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.nicescroll.min.js', ['depends' => [JqueryAsset::className()]], 'nicescroll');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/moment.min.js', ['depends' => [JqueryAsset::className()]], 'moment-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/moment-jalaali.js', ['depends' => [JqueryAsset::className()]], 'moment-jalali-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/persian-date.min.js', ['depends' => [JqueryAsset::className()]], 'persian-date-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/persian-datepicker-0.4.5.js', ['depends' => [JqueryAsset::className()]], 'persian-datepicker-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/selectize.min.js', ['depends' => [JqueryAsset::className()]], 'selectize-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/bootstrap-select.min.js', ['depends' => [JqueryAsset::className()]], 'bootstrap-select-js');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/defaults-fa_IR.js', ['depends' => [JqueryAsset::className()]], 'defaults-fa_IR');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.hotkeys.js', ['depends' => [JqueryAsset::className()]], 'hotkeys');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.highlight.js', ['depends' => [JqueryAsset::className()]], 'highlight');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/vars.js', ['depends' => [JqueryAsset::className()]], 'vars');?>
    <?php $this->registerJsFile($this->theme->baseUrl.'/js/jquery.script.js', ['depends' => [JqueryAsset::className()]], 'script');?>
    <?php $this->registerJsFile(\yii\helpers\Url::to(['/site/dynamic-js']), ['depends' => [JqueryAsset::className()]], 'dynamicJs');?>
    <?php $this->head(); ?>
</head>
<body class="forms-page">
<?php $this->beginBody(); ?>
<?php if(Yii::$app->session->get('db_lock')):?>
<div class="lock-error">
    <span><?= Yii::t('words','base.dbLockMessage') ?></span>
</div>
<?php endif;?>
<?php echo $this->render('_panel_header');?>
<?php echo $content;?>
<div class="modals">
    <div class="custom-modal blue-modal hidden" id="statistics-modal"></div>
    <div class="custom-modal notification-modal hidden" id="notification-modal"></div>
    <div class="custom-modal setting-modal hidden" id="setting-modal"></div>
    <div class="custom-modal blue-modal hidden" id="add-language-modal"></div>
</div>
<div class="loading"></div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
