<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\themes\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\BootstrapAsset;
use yii\web\JqueryAsset;
use \yii\helpers\Url;

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
        <section class="dashboard">
            <div class="container">
                <div class="row news-container">
                    <div class="col-md-4">
                        <div class="sidebar-user-menu">
                            <div class="top-section">
                                <div class="user-side-pic">
                                    <?php
                                    $src = $this->theme->baseUrl . '/images/user.jpg';
                                    if (Yii::$app->user->identity->avatar &&
                                        is_file(Yii::getAlias('@webroot/uploads/user/avatars/') . Yii::$app->user->identity->avatar))
                                        $src = Yii::getAlias('@web/uploads/user/avatars/') . Yii::$app->user->identity->avatar;
                                    ?>
                                    <img src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                                </div>
                                <div class="user-side-details">
                                    <h3><?= Yii::$app->user->identity->name ?></h3>
                                    <p><?= Yii::$app->user->identity->email ?></p>
                                    <p><?= Yii::$app->user->identity->phone ?></p>
                                </div>
                                <a href="#" class="user-side-setting"><span class="icon-gear"></span></a>
                            </div>
                            <div class="content-section">
                                <ul class="list-unstyled">
                                    <li class="<?= Yii::$app->request->getUrl() === '/user/dashboard'?'active':'' ?>">
                                        <a href="<?= Url::to(['/user/dashboard']) ?>"><i
                                                    class=""></i><span><?= Yii::t('words', 'Dashboard') ?></span></a>
                                    </li>
                                    <li class="<?= Yii::$app->request->getUrl() === '/reception/list'?'active':'' ?>">
                                        <a href="<?= Url::to(['/reception/list']) ?>"><i
                                                    class=""></i><span><?= Yii::t('words', 'Reception request') ?></span></a>
                                    </li>
                                    <li class="<?= Yii::$app->request->getUrl() === '/cooperation/list'?'active':'' ?>">
                                        <a href="<?= Url::to(['/cooperation/list']) ?>"><i class=""></i><span><?= Yii::t('words', 'Cooperation request') ?></span></a>
                                    </li>
                                    <li class="<?= Yii::$app->request->getUrl() === '/advice/list'?'active':'' ?>">
                                        <a href="<?= Url::to(['/advice/list']) ?>"><i class=""></i><span><?= Yii::t('words', 'Medical advice request') ?></span></a>
                                    </li>
                                    <li class="<?= Yii::$app->request->getUrl() === ''?'active':'' ?>">
                                        <a class="disabled" href="<?= Url::to(['']) ?>"><i class=""></i><span><?= Yii::t('words', 'Visit request') ?></span></a>
                                    </li>
<!--                                    <li>-->
<!--                                        <a class="disabled" href="#user-tab-5"><i class=""></i><span>جوابدهی آزمایشگاه</span></a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a class="disabled" href="#user-tab-6"><i class=""></i><span>جوابدهی تصویربرداری</span></a>-->
<!--                                    </li>-->
                                    <li><a href="<?= \yii\helpers\Url::to(['/user/logout']) ?>"><i
                                                    class=""></i><span class="text-danger" ><?= Yii::t('words', 'Logout') ?></span></a></li>
                                </ul>
                            </div>
                            <div class="footer-border"></div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<div class="screen-overlay"></div>

<?php echo $this->render('_footer'); ?>
<?php echo $this->render('_public_alert'); ?>
<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>
