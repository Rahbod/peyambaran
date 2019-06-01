<?php

use app\models\Category;
use app\models\Insurance;
use app\models\OnlineService;
use app\models\Post;
use app\models\Slide;
use yii\helpers\Html;
use app\components\Setting;

/* @var $this yii\web\View */
/** @var $newsProvider \yii\data\ActiveDataProvider */
/** @var $articleProvider \yii\data\ActiveDataProvider */
/** @var $pageProvider \yii\data\ActiveDataProvider */
/** @var $menuProvider \yii\data\ActiveDataProvider */


if ($pageProvider->count)
    $active = 'page';
else if ($menuProvider->count)
    $active = 'menu';
else if ($newsProvider->count)
    $active = 'news';
else if ($articleProvider->count)
    $active = 'article';
else
    $active = 'page';

?>


<section class="news news-show">
    <div class="container">
        <div class="row news-container">
            <div class="col-xs-12">
                <ul class="nav nav-tabs search-nav justify-content-center" id="tabs-tab" role="tablist">
                    <li class="nav-item<?= $active == 'page' ? ' active' : '' ?>">
                        <a class="nav-link" id="tabs-pages-tab" data-toggle="tab" href="#tab-pages" role="tab"
                           aria-controls="tabs-pages" aria-selected="false">
                            <?= Yii::t('words', 'Pages') ?>
                            <span class="badge badge-danger"><?= number_format($pageProvider->count) ?></span></a>
                    </li>
                    <li class="nav-item<?= $active == 'menu' ? ' active' : '' ?>">
                        <a class="nav-link" id="tabs-menu-tab" data-toggle="tab" href="#tab-menu" role="tab"
                           aria-controls="tabs-menu" aria-selected="false">
                            <?= Yii::t('words', 'Menu') ?>
                            <span class="badge badge-danger"><?= number_format($menuProvider->count) ?></span></a>
                    </li>
                    <li class="nav-item<?= $active == 'news' ? ' active' : '' ?>">
                        <a class="nav-link" id="tabs-news-tab" data-toggle="tab" href="#tab-news" role="tab"
                           aria-controls="tabs-news" aria-selected="true">
                            <?= Yii::t('words', 'News & Events') ?>
                            <span class="badge badge-danger"><?= number_format($newsProvider->count) ?></span> </a>
                    </li>
                    <li class="nav-item<?= $active == 'article' ? ' active' : '' ?>">
                        <a class="nav-link" id="tabs-article-tab" data-toggle="tab" href="#tab-article" role="tab"
                           aria-controls="tabs-article" aria-selected="false">
                            <?= Yii::t('words', 'Articles') ?>
                            <span class="badge badge-danger"><?= number_format($articleProvider->count) ?></span></a>
                    </li>
                    <!--                    <li class="nav-item">-->
                    <!--                        <a class="nav-link " id="tabs-translation-tab" data-toggle="tab" href="#tab-translation" role="tab" aria-controls="tabs-translation" aria-selected="false">Translations</a>-->
                    <!--                    </li>-->
                </ul>
            </div>
            <div class="col-xs-12 mt-5">
                <div class="tab-content">
                    <div class="tab-pane fade<?= $active == 'page' ? ' in active' : '' ?>" id="tab-pages">
                        <? if ($pageProvider->count): ?>
                            <?php echo \yii\widgets\ListView::widget([
                                'id' => 'pages-list',
                                'dataProvider' => $pageProvider,
                                'itemView' => '//page/_page_item',
                                'layout' => '{items}'
                            ]) ?>
                        <? else: ?>
                            <div class="empty-box d-flex">
                                <h3 class="d-flex__title"><?= Yii::t('words', 'No Result!') ?></h3>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="tab-pane fade<?= $active == 'menu' ? ' in active' : '' ?>" id="tab-menu">
                        <? if ($menuProvider->count): ?>
                            <?php echo \yii\widgets\ListView::widget([
                                'id' => 'menu-list',
                                'dataProvider' => $menuProvider,
                                'itemView' => '//menu/_menu_item',
                                'layout' => '{items}'
                            ]) ?>
                        <? else: ?>
                            <div class="empty-box d-flex">
                                <h3 class="d-flex__title"><?= Yii::t('words', 'No Result!') ?></h3>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="tab-pane fade<?= $active == 'news' ? ' in active' : '' ?>" id="tab-news">
                        <? if ($newsProvider->count): ?>
                            <?php echo \yii\widgets\ListView::widget([
                                'id' => 'news-list',
                                'dataProvider' => $newsProvider,
                                'itemView' => '//post/_news_item',
                                'layout' => '{items}'
                            ]) ?>
                        <? else: ?>
                            <div class="empty-box d-flex">
                                <h3 class="d-flex__title"><?= Yii::t('words', 'No Result!') ?></h3>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="tab-pane fade<?= $active == 'article' ? ' in active' : '' ?>" id="tab-article">
                        <? if ($articleProvider->count): ?>
                            <?php echo \yii\widgets\ListView::widget([
                                'id' => 'article-list',
                                'dataProvider' => $articleProvider,
                                'itemView' => '//post/_news_item',
                                'layout' => '{items}'
                            ]) ?>
                        <? else: ?>
                            <div class="empty-box d-flex">
                                <h3 class="d-flex__title"><?= Yii::t('words', 'No Result!') ?></h3>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

