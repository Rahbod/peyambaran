<?php

use app\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */

// echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png')
?>
<header class="navbar-default <?= Yii::$app->controller->headerClass ?: '' ?>">
    <div class="container">
        <div class="top row">
            <div class="col-lg-8 col-md-8 col-sm-8 hidden-xs">
                <div class="dropdown language-select">
                    <label class="text-right iran-sans"><?= Yii::t('words', 'Language') ?></label>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="icon icon-chevron-down"></span>
                        <?= Yii::t('words', Yii::$app->language); ?>
                        <span class="language-icon"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::to(["/fa"]) ?>">FA</a></li>
                        <li><a href="<?= Url::to(["/en"]) ?>">EN</a></li>
                        <!--                        --><?php //foreach (\app\components\MultiLangActiveRecord::$langArray as $key => $item): ?>
                        <!--                            <li><a href="--><? //= Url::to(["/{$key}"]) ?><!--">-->
                        <? //= Yii::t('words', $key) ?><!--</a></li>-->
                        <!--                        --><?php //endforeach; ?>
                    </ul>
                </div>

                <?php if (Yii::$app->user->isGuest): ?>
                    <a href="<?= Url::to(['/user/register']) ?>" class="btn btn-green btn-sm">
                        <i class="user-icon"></i>
                        <?= Yii::t('words', 'Register') ?>
                    </a>
                    <a href="<?= Url::to(['/user/login']) ?>" class="btn btn-purple btn-sm">
                        <i class="user-icon"></i>
                        <?= Yii::t('words', 'Login') ?>
                    </a>
                <?php else: ?>
                    <div class="user-header-box">
                        <a href="<?= Url::to(['/user/dashboard']) ?>">
                            <div class="user-header-pic">
                                <?php
                                $src = $this->theme->baseUrl . '/images/user.jpg';
                                if (Yii::$app->user->identity->avatar &&
                                    is_file(Yii::getAlias('@webroot/uploads/user/avatars/') . Yii::$app->user->identity->avatar))
                                    $src = Yii::getAlias('@web/uploads/user/avatars/') . Yii::$app->user->identity->avatar;
                                ?>
                                <img src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                            </div>
                        </a>
                        <div class="user-header-details">
                            <? if (Yii::$app->user->identity->roleID != 'user'): ?>
                                <a href="<?= Url::to(['/admin']) ?>"><span
                                            class="user-header-name"><?= Yii::$app->user->identity->username ?></span></a>
                            <? else: ?>
                                <a href="<?= Url::to(['/user/dashboard']) ?>"><span
                                            class="user-header-name"><?= Yii::$app->user->identity->name ?></span></a>
                            <? endif; ?>
                            <!--                            <a href="#"><span class="user-header-setting icon-gear"></span></a>-->
                        </div>
                    </div>
                <?php endif; ?>
                <?= Html::beginForm(['/site/search'], 'get', ['class' => 'search-form']) ?>
                <div class="input-group search-container">
                    <?= Html::textInput('q', Yii::$app->request->getQueryParam('q'), ['class' => 'form-control', 'placeholder' => Yii::t('words', 'Search...')]) ?>
                    <span class="input-group-addon">
                            <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                        </span>
                </div>
                <?= Html::endForm() ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs logo pull-left">
                <img src="<?= $this->theme->baseUrl . (Yii::$app->controller->bodyClass == 'innerPages' ? "/images/logo-white2.png" : "/images/logo2.png") ?>">
                <div class="logo-right">
                    <a href="<?= Url::to(['/']) ?>">
                        <h1><?= Yii::t('words', 'logo_title') ?></h1>
                        <h2>Payambaran</h2>
                        <h3 class="font-light">Speciality Hospital</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-container">
        <div class="container">
            <ul class="nav navbar nav-pills">
                <?php foreach (Menu::find()->roots()->valid()->orderBySort()->all() as $item): ?>
                    <?php
                    $ic = $item->children(1)->count();
                    $sic = $item->children(2)->count();
                    if ($ic > 0): ?>
                        <li class="dropdown<?php if (($sic - $ic) === 0) echo ' relative'; // one level ?>">
                            <a class="dropdown-toggle" href="#">
                                <i class="icon icon-chevron-down"></i>
                                <?= $item->name ?>
                            </a>
                            <div class="dropdown-menu<?php if (($sic - $ic) !== 0) echo ' wide'; // multi level ?>">
                                <div class="<?= ($sic - $ic) !== 0 ? 'container' : 'container-fluid'; ?>">
                                    <?php if (($sic - $ic) === 0): // one level ?>
                                        <ul class="menu-part d-inline-block">
                                            <?php foreach ($item->children(1)->valid()->orderBySort()->all() as $sub_item): ?>
                                                <li<?= $sub_item->children(1)->count() > 0 ? " class='has-child'" : "" ?>>
                                                    <a href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: // two level ?>
                                        <?php foreach ($item->children(1)->valid()->orderBySort()->all() as $sub_item): ?>
                                            <ul class="menu-part d-inline-block">
                                                <li<?= $sub_item->children(1)->count() > 0 ? " class='has-child'" : "" ?>>
                                                    <a
                                                            href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a></li>
                                                <?php foreach ($sub_item->children(1)->all() as $sub_item_child): ?>
                                                    <li>
                                                        <a href="<?= $sub_item_child->url ?>"><?= $sub_item_child->name ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= $item->url ?>"><?= $item->name ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <nav class="navbar">
            <a class="navbar-brand" href="<?= Url::to(['/']) ?>">
                <!--                <img  class="siteLogo__image img-fluid" src="-->
                <? //= $this->theme->baseUrl . (Yii::$app->controller->bodyClass == 'innerPages' ? "/images/logo-white.png" : "/images/logo.png") ?><!--">-->
                <h1><?= Yii::t('words', 'logo_title')?></h1>
            </a>


            <button id="sidebarCollapse" class="navbar-toggler" type="button">
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
                <span class="navbar-toggler-lines"></span>
            </button>

            <div class="dropdown language-select mobile-language">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
<!--                    <span class="icon icon-chevron-down"></span>-->
                    <span class="text-uppercase"><?= Yii::$app->language ?></span>
<!--                    <span class="language-icon"></span>-->
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?= Url::to(["/fa"]) ?>">FA</a></li>
                    <li><a href="<?= Url::to(["/en"]) ?>">EN</a></li>
                    <!--                        --><?php //foreach (\app\components\MultiLangActiveRecord::$langArray as $key => $item): ?>
                    <!--                            <li><a href="--><? //= Url::to(["/{$key}"]) ?><!--">-->
                    <? //= Yii::t('words', $key) ?><!--</a></li>-->
                    <!--                        --><?php //endforeach; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>

<nav id="sidebar">
    <div class="sidebar-header">
        <img src="<?= $this->theme->baseUrl . "/images/logo-white.png" ?>">
        <h4 class=""><?= Yii::t('words', 'logo_title')?></h4>
    </div>
    <ul class="list-unstyled components">
        <?php if (Yii::$app->user->isGuest): ?>
            <li>
                <a href="<?= Url::to(['/user/register']) ?>" class="menu-item">
                    <?= Yii::t('words', 'Register') ?>
                </a>
            </li>

            <li>
                <a href="<?= Url::to(['/user/login']) ?>" class="menu-item">
                    <?= Yii::t('words', 'Login') ?>
                </a>
            </li>

            <li>
                <hr>
            </li>
        <?php else: ?>
            <li>
                <? if (Yii::$app->user->identity->roleID != 'user'): ?>
                    <a href="#user_subitem" class="submenu menu-item username-padding" data-toggle="collapse"
                       aria-expanded="false">
                        <?php
                        $src = $this->theme->baseUrl . '/images/user.jpg';
                        if (Yii::$app->user->identity->avatar &&
                            is_file(Yii::getAlias('@webroot/uploads/user/avatars/') . Yii::$app->user->identity->avatar))
                            $src = Yii::getAlias('@web/uploads/user/avatars/') . Yii::$app->user->identity->avatar;
                        ?>
                        <img class="user-avatar" src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                        <?= Yii::$app->user->identity->username ?>
                    </a>
                <? else: ?>
                    <a href="#user_subitem" class="submenu menu-item username-padding" data-toggle="collapse"
                       aria-expanded="false">
                        <?php
                        $src = $this->theme->baseUrl . '/images/user.jpg';
                        if (Yii::$app->user->identity->avatar &&
                            is_file(Yii::getAlias('@webroot/uploads/user/avatars/') . Yii::$app->user->identity->avatar))
                            $src = Yii::getAlias('@web/uploads/user/avatars/') . Yii::$app->user->identity->avatar;
                        ?>
                        <img class="user-avatar" src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                        <?= Yii::$app->user->identity->name ?>
                    </a>
                <? endif; ?>
                <ul class="collapse list-unstyled" id="user_subitem">
                    <li>
                        <? if (Yii::$app->user->identity->roleID != 'user'): ?>
                            <a class="menu-item" href="<?= Url::to(['/admin']) ?>">پروفایل کاربری</a>
                        <? else: ?>
                            <a class="menu-item" href="<?= Url::to(['/user/dashboard']) ?>">پروفایل کاربری</a>
                        <? endif; ?>
                    </li>
                </ul>
            </li>
            <li>
                <hr>
            </li>
        <?php endif; ?>

        <?php foreach (Menu::find()->roots()->valid()->orderBySort()->all() as $item): ?>
            <?php
            $ic = $item->children(1)->count();
            $sic = $item->children(2)->count();
            if ($ic > 0): ?>
                <li>
                    <a class="submenu menu-item" href="#<?= $item->id ?>" data-toggle="collapse"
                       aria-expanded="false"><?= $item->name ?></a>
                    <ul class="collapse list-unstyled" id="<?= $item->id ?>">
                        <?php foreach ($item->children(1)->all() as $sub_item): ?>
                            <?php
                            $sic = $sub_item->children(1)->count();
                            $ssic = $sub_item->children(2)->count();
                            if ($sic > 0): ?>
                                <li>
                                    <a class="submenu menu-item" href="#<?= $sub_item->id ?>" data-toggle="collapse"
                                       aria-expanded="false"><?= $sub_item->name ?></a>
                                    <ul class="collapse list-unstyled" id="<?= $sub_item->id ?>">
                                        <?php foreach ($sub_item->children(1)->all() as $sub_sub_item): ?>
                                            <li>
                                                <a class="menu-item"
                                                   href="<?= $sub_sub_item->url ?>"><?= $sub_sub_item->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>

                            <?php else: ?>
                                <li>
                                    <a class="menu-item" href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>

            <?php else: ?>
                <li>
                    <a class="menu-item" href="<?= $item->url ?>"><?= $item->name ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
