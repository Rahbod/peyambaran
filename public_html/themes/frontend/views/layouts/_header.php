<?php

use \app\models\Menu;
use yii\helpers\Url;
use \yii\helpers\Html;

/* @var $this \yii\web\View */

// echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png')
?>
<header class="<?= Yii::$app->controller->headerClass?:'' ?>">
    <div class="container">
        <div class="top row">
            <div class="col-lg-8 col-md-8 col-sm-8 hidden-xs">
                <div class="dropdown language-select">
                    <label>Language</label>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="icon icon-chevron-down"></span>
                        <?= Yii::t('words', Yii::$app->language); ?>
                        <span class="language-icon"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach (\app\components\MultiLangActiveRecord::$langArray as $key => $item): ?>
                            <li><a href="<?= Url::to(["/{$key}"]) ?>"><?= Yii::t('words', $key) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="<?= Url::to('/user/register') ?>" class="btn btn-green btn-sm" data-toggle="modal" target="#signup">
                    <i class="user-icon"></i>
                    <?= Yii::t('words', 'Register') ?>
                </a>
                <a href="<?= Url::to('/user/login') ?>" class="btn btn-purple btn-sm" data-toggle="modal" target="#login">
                    <i class="user-icon"></i>
                    <?= Yii::t('words', 'Login') ?>
                </a>
                <?= Html::beginForm(['/site/search', 'get', ['class' => 'search-form']])?>
                    <div class="input-group search-container">
                        <input class="form-control" placeholder="متن جستجو">
                        <span class="input-group-addon">
                            <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs logo pull-left">
                <img src="<?= $this->theme->baseUrl.(Yii::$app->controller->bodyClass == 'blueHeader'?"logo-white.png":"/images/logo.png")?>">
                <div class="logo-right">
                    <h1>بیمارســتان پیامبران</h1>
                    <h2>Payambaran</h2>
                    <h3 class="font-light">Tamilnadu Government<br>Multi Super Speciality Hospital</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-container">
        <div class="container">
            <ul class="nav navbar nav-pills">
                <?php foreach (Menu::find()->roots()->valid()->orderBySort()->all() as $item):?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-target='#deps' href="#">
                            <i class="icon icon-chevron-down"></i>
                            <?= $item->name ?>
                        </a>
                        <div class="dropdown-menu" id="deps">
                            <div class="container">
                                <ul class="menu-part">
                                    <?php foreach ($item->children(1)->all() as $sub_item): ?>
                                        <li<?= $sub_item->children(1)->count()>0?" class='has-child'":"" ?>><a href="<?= $sub_item->url ?>" ><?= $sub_item->name ?></a></li>
                                        <?php foreach ($sub_item->children(1)->all() as $sub_item_child): ?>
                                            <li><a href="<?= $sub_item_child->url ?>" ><?= $sub_item_child->name ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target='#deps' href="#">
                        <i class="icon icon-chevron-down"></i>
                        بخش های بیمارستان
                    </a>
                    <div class="dropdown-menu" id="deps">
                        <div class="container">
                            <ul class="menu-part">
                                <li><a href="#" >بستری</a></li>
                                <li><a href="#" >لاله</a></li>
                                <li><a href="#" >ارکیده</a></li>
                                <li><a href="#" >یاس</a></li>
                                <li><a href="#" >شبنم</a></li>
                                <li><a href="#" >شکوفه</a></li>
                                <li><a href="#" >نیلوفر</a></li>
                                <li><a href="#" >شقایق</a></li>
                                <li><a href="#" >غزال</a></li>
                                <li><a href="#" >سپیده</a></li>
                                <li><a href="#" >سوئیت</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >جراحی</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >مراقبت های ویژه</a></li>
                                <li><a href="#" >ICU</a></li>
                                <li><a href="#" >ICU.OH</a></li>
                                <li><a href="#" >CCU</a></li>
                                <li><a href="#" >NICU</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >سرپایی</a></li>
                                <li><a href="#" >آندوسکوپی</a></li>
                                <li><a href="#" >کلینیک پوست لیزر و جراحی</a></li>
                                <li><a href="#" >کلینیک زخم</a></li>
                                <li><a href="#" >اورژانس</a></li>
                                <li><a href="#" >کلینیک</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >جراحی</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="#">پاراکلینیک ها</a></li>
                <li><a href="#">پزشکان</a></li>
                <li><a href="#">تعرفه ها</a></li>
                <li><a href="#">برنامه کلینیک ها</a></li>
                <li><a href="#">گردشگری سلامت</a></li>
                <li><a href="#">اعتباربخشی</a></li>
            </ul>
        </div>
    </div>
</header>
