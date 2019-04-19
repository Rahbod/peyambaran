<?php

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\Person */

$categories = \app\models\Category::find()
    ->andWhere([
        'type' => \app\models\Category::TYPE_CATEGORY,
        'category_type' => \app\models\Category::CATEGORY_TYPE_PICTURE_GALLERY,
    ])
    ->all();

$categoryID = Yii::$app->request->getQueryParam('category') ?: 0;
$baseUrl = $this->theme->baseUrl;
$this->registerJsFile($baseUrl.'/js/vendors/html5lightbox/froogaloop2.min.js',[], 'froogaloop2');
$this->registerJsFile($baseUrl.'/js/vendors/html5lightbox/html5lightbox.js',[], 'html5lightbox');
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <nav class="gallery-sidebar-menu">
                    <div class="sidebar-header mt-3">
                        <h4 class="text-purple"><?= Yii::t('words', 'Payambaran Hospital Gallery') ?></h4>
                    </div>
                    <ul class="list-unstyled mt-5">
                        <?php foreach ($categories as $item):$sc = $item->children(1)->count(); ?>
                            <li class="mb-3">
                                <?php if ($sc > 0): ?>
                                    <a href="void:;" class="text-purple"><?= $item->name ?></a>
                                    <ul class="list-unstyled submenu">
                                        <?php foreach ($item->children(1)->all() as $item_child):
                                            if($categoryID == $item_child->id) $category = $item_child;
                                            $url = Url::to(['/gallery/show', 'category' => $item_child->id]); ?>
                                            <li>
                                                <a class="-hoverBlue text-dark-2<?= $categoryID == $item_child->id ? " active" : "" ?>"
                                                   href="<?= $url ?>"><?= $item_child->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else:
                                    if($categoryID == $item->id) $category = $item;
                                    $url = Url::to(['/gallery/show', 'category' => $item->id]); ?>
                                    <a class="-hoverBlue text-dark-2<?= $categoryID == $item->id ? " active" : "" ?>"
                                       href="<?= $url ?>"><?= $item->fullName ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </nav>
            </div>

            <div class="col-xs-12 col-md-9">
                <div class="content-header">
                    <div class="content-header__gradient-overlay"></div>
                    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Gallery') ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                    </div>
                    <a class="sideMenuIcon"></a>

<!--                    <img src="--><?//= $this->theme->baseUrl ?><!--/images/doctors/avatar-24.png"-->
<!--                         class="content-header__fade-bg">-->

                </div>
                <div class="content-body">
                    <?php if($categoryID && $category):?><h4 class="text-purple my-40"><?= $category->name ?></h4><?php endif;?>
                    <div class="mt-3 mb-5">
                        <?php echo \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '{items}',
                            'itemView' => '_item_view'
                        ]); ?>
                    </div>
                </div>
                <div class="content-footer text-center mb-5">
                    <a href="void:;" class="btn text-purple -more purple" disabled="">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        <?= Yii::t('words', 'Load more') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
