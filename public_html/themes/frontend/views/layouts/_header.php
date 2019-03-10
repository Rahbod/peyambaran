<?php

use \app\models\Menu;
use yii\helpers\Url;
use \yii\helpers\Html;

/* @var $this \yii\web\View */

// echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png')
?>
<header class="<?= Yii::$app->controller->headerClass ?: '' ?>">
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

                <?php if(Yii::$app->user->isGuest || Yii::$app->user->identity->roleID != 'user'): ?>
                <a href="<?= Url::to(['/user/register']) ?>" class="btn btn-green btn-sm">
                    <i class="user-icon"></i>
                    <?= Yii::t('words', 'Register') ?>
                </a>
                <a href="<?= Url::to(['/user/login']) ?>" class="btn btn-purple btn-sm">
                    <i class="user-icon"></i>
                    <?= Yii::t('words', 'Login') ?>
                </a>
                <?php else:?>
                    <div class="user-header-box">
                        <a href="<?= Url::to(['/user/dashboard']) ?>">
                            <div class="user-header-pic">
                                <?php
                                $src = $this->theme->baseUrl.'/images/user.jpg';
                                if(Yii::$app->user->identity->avatar &&
                                    is_file(Yii::getAlias('@webroot/uploads/user/avatars/').Yii::$app->user->identity->avatar))
                                    $src = Yii::getAlias('@web/uploads/user/avatars/').Yii::$app->user->identity->avatar;
                                ?>
                                <img src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                            </div>
                        </a>
                        <div class="user-header-details">
                            <a href="<?= Url::to(['/user/dashboard']) ?>"><span class="user-header-name"><?= Yii::$app->user->identity->name ?></span></a>
<!--                            <a href="#"><span class="user-header-setting icon-gear"></span></a>-->
                        </div>
                    </div>
                <?php endif; ?>
                <?= Html::beginForm(['/site/search'], 'get', ['class' => 'search-form']) ?>
                <div class="input-group search-container">
                    <?= Html::textInput('term', Yii::$app->request->getQueryParam('term'), ['class' => 'form-control', 'placeholder' => Yii::t('words', 'Search...')]) ?>
                    <span class="input-group-addon">
                            <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                        </span>
                </div>
                <?= Html::endForm() ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs logo pull-left">
                <img src="<?= $this->theme->baseUrl . (Yii::$app->controller->bodyClass == 'innerPages' ? "/images/logo-white.png" : "/images/logo.png") ?>">
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
                <?php foreach (Menu::find()->roots()->valid()->orderBySort()->all() as $item): ?>
                    <?php if ($item->children(1)->count() > 0): ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-target='#deps' href="#">
                                <i class="icon icon-chevron-down"></i>
                                <?= $item->name ?>
                            </a>
                            <div class="dropdown-menu" id="deps">
                                <div class="container">
                                    <ul class="menu-part">
                                        <?php foreach ($item->children(1)->all() as $sub_item): ?>
                                            <li<?= $sub_item->children(1)->count() > 0 ? " class='has-child'" : "" ?>><a
                                                        href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a></li>
                                            <?php foreach ($sub_item->children(1)->all() as $sub_item_child): ?>
                                                <li>
                                                    <a href="<?= $sub_item_child->url ?>"><?= $sub_item_child->name ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </ul>
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
</header>
