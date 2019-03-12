<?php

use app\models\Menu;

/** @var $this \yii\web\View */
/** @var $model \app\models\Page */
/** @var $relatedMenu Menu */

$relatedMenu = Menu::find()->andWhere([Menu::columnGetString('page_id') => $model->id])->one();
if ($relatedMenu)
    $root = $relatedMenu->parents()->andWhere('parentID IS NULL')->one();
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <?php if ($root): ?>
                <div class="col-md-3">
                    <nav id="sidebar">
                        <div class="sidebar-header mt-5">
                            <h4><?= $root->name ?></h4>
                        </div>
                        <ul class="list-unstyled mt-5">
                            <?php foreach ($root->children(1)->all() as $sub_item):$sc = $sub_item->children(1)->count(); ?>
                                <li class="mb-3">
                                    <?php if ($sc > 0): ?>
                                        <a href="void:;" class="text-purple"><?= $sub_item->name ?></a>
                                        <ul class="list-unstyled submenu">
                                            <?php foreach ($sub_item->children(1)->all() as $sub_item_child): ?>
                                                <li>
                                                    <a class="-hoverBlue text-dark-2<?= $relatedMenu->id === $sub_item_child->id ? " active" : "" ?>"
                                                       href="<?= $sub_item_child->url ?>"><?= $sub_item_child->name ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else:?>
                                        <a class="-hoverBlue text-dark-2<?= $relatedMenu->id === $sub_item->id ? " active" : "" ?>"
                                           href="<?= $sub_item->url ?>"><?= $sub_item->name ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
            <div class="<?= $root ? 'col-sm-9' : 'col-sm-10 col-sm-offset-1' ?>">
                <div class="content-header bg-cyan">
                    <div class="content-header__gradient-overlay"></div>
                    <img class="content-header__fade-bg"
                         src="<?= Yii::getAlias('@web/uploads/pages/') . $model->image ?>">
                    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
                         class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= $model->name ?></h1>
                    </div>
                </div>
                <div class="content-body">
                    <div class="mb-5 text-justify"><?= $model->body ?></div>
                    <?php if ($model->gallery): ?>
                        <div class="mt-5 page-gallery row">
                            <? foreach ($model->gallery as $item):
                                if ($item->file && is_file(Yii::getAlias("@webroot/" . \app\models\Attachment::$attachmentPath . "/$item->path/$item->file"))):?>
                                    <div class="col-lg-3 col-sm-4 col-xs-6 mb-5">
                                        <div class="page-gallery__item">
                                            <a href="<?= Yii::getAlias("@web/" . \app\models\Attachment::$attachmentPath . "/$item->path/$item->file") ?>"
                                               target="_blank">
                                                <img src="<?= Yii::getAlias("@web/" . \app\models\Attachment::$attachmentPath . "/$item->path/$item->file") ?>"
                                                     alt="<?= \yii\helpers\Html::encode($model->name) ?>">
                                            </a>
                                        </div>
                                    </div>
                                <? endif; ?>
                            <? endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
