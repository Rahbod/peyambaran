<?php
/** @var $this \yii\web\View */

use app\models\Attachment;

/** @var $model \app\models\Post */
/** @var $relatedPosts \app\models\Post[] */
$baseUrl = $this->theme->baseUrl;
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');
?>
<section class="news-show gallery">
    <div class="container">
        <div class="row news-show-container">
            <div class="col-xs-12">
                <div class="content-header ">
                    <div class="content-header--titlesContainer">
                        <img src="<?= $this->theme->baseUrl ?>/images/news/news-header-image.png"
                             class="img-fluid content-header__image" alt="">
                        <div class="content-header__titles">
                            <h1 class="media-heading content-header__title"><?= Yii::t('words', 'News & Articles') ?></h1>
                            <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                        </div>
                    </div>
                    <div class="newsSearchBox mt-4 mt-lg-0">
                        <form class="search-form" action="<?= \yii\helpers\Url::to(['/post/news']) ?>" method="get">
                            <p style="color: #fff;margin-right: 10px;"
                               class="search-form-label"><?= Yii::t('words', $model->type == \app\models\Post::TYPE_NEWS ? 'Search in news...' : 'Search in articles...') ?></p>
                            <div class="input-group search-container">
                                <input class="form-control" placeholder="<?= Yii::t('words', 'Search...') ?>"
                                       name="term" value="<?= Yii::$app->request->getQueryParam('term') ?>">
                                <span class="input-group-addon"><button type="submit" class="search-btn"><i
                                                class="search-icon"></i></button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-md-4 px-0 pr-lg-0">
                                <div class="card mb-3 m-lg-0">
                                    <div class="card-header">
                                        <div class="statics-row">
                                            <span class="comments-count text-right"><?= number_format($model->comments_count) ?>
                                                <i
                                                        class="comment-icon"></i></span>
                                            <span class="view-count text-center"><?= number_format($model->seen) ?><i
                                                        class="eye-icon"></i></span>
                                            <span class="news-date text-left"><?= jDateTime::date('Y/m/d', $model->publish_date) ?>
                                                <i
                                                        class="calendar-icon"></i></span>
                                        </div>
                                        <!--                                        <p>-->
                                        <!--                                            <i class="icomoon-comment-alt-regular"></i> --><? //= number_format($model->comments_count) ?>
                                        <!--                                        </p>-->
                                        <!---->
                                        <!--                                        <p>-->
                                        <!--                                            <i class="icomoon-eye-regular"></i> --><? //= number_format($model->seen) ?>
                                        <!--                                        </p>-->
                                        <!--                                        <p>-->
                                        <!--                                            <i class="icomoon-calendar-alt-regular"></i> --><? //= $model->publish_date ?>
                                        <!--                                        </p>-->
                                    </div>
                                    <div class="card-body text-center">
                                        <a title="" href="#" class="card-link">
                                            <img class="card-img-top"
                                                 src="<?= Yii::getAlias('@web/uploads/post/') . $model->image ?>"
                                                 alt="">
                                            <h4 class="card-title"><?= $model->name ?></h4>
                                        </a>
                                    </div>
                                    <?php if ($model->gallery): ?>
                                        <hr>
                                        <div class="clearfix">
                                            <p style="color: #7a7a7a;"><?= Yii::t('words', 'News pictures') ?></p>
                                            <?php foreach ($model->gallery as $item):
                                                if (!$item->file OR !is_file(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . Attachment::getAttachmentPath($item->created) . DIRECTORY_SEPARATOR . $item->file)) continue; ?>
                                                <div class="gallery__imageContainer">
                                                    <a class="simpleGallery__link html5lightbox"
                                                       data-transition="crossfade" data-group="mygroup"
                                                       href="<?= Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Attachment::getAttachmentPath($item->created) .DIRECTORY_SEPARATOR. $item->file ?>">
                                                        <img class="gallery__images"
                                                                src="<?= Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Attachment::getAttachmentPath($item->created) .'/thumbs/100x100/'. $item->file ?>">
                                                    </a>
                                                    <div class="-hoverBox">
                                                        <a href="<?= Yii::getAlias('@web') . DIRECTORY_SEPARATOR . Attachment::getAttachmentPath($item->created) .DIRECTORY_SEPARATOR. $item->file ?>"
                                                           data-transition="crossfade"
                                                           class="html5lightbox"
                                                           data-group="mygroup"
                                                           title="<?= $item->name ?>">
                                                            <h4><?= $item->name ?></h4>
                                                            <img src="<?= $this->theme->baseUrl ?>/images/gallery/frame.png">
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-8 px-0">
                                <div class="newsShow">
                                    <div class="newsShow__content">
                                        <h4 class="newsShow__title"><?= $model->name ?></h4>
                                        <div class="mb-5 mt-5 text-justify page-text"><?= $model->body ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($relatedPosts): ?>
    <section class="related-news" style="overflow-x: hidden;">
        <div class="container">
            <div class="row insurance-container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="inline-title">
                        <h3 class="section-title"><?= Yii::t('words', 'Related News & Articles') ?></h3>
                    </div>
                </div>
            </div>
            <div class="news-carousel owl-carousel owl-theme"
                 data-stagePadding="50"
                 data-rtl="true"
                 data-autoWidth="true"
                 data-nav="true"
                 data-items="1"
                 data-margin="15"
                 data-autoplayspeed="9000"
                 data-autoHeight="true"
                 data-responsive='{"786" :{ "items": 2 }, "992" :{ "items": 3 }}'>
                <?php foreach ($relatedPosts as $item): ?>
                    <div class="news-item">
                        <div class="news-item-inner">
                            <a href="<?= $item->url ?>">
                                <div class="statics-row">
                                <span class="comments-count text-right"><?= number_format($item->comments_count) ?><i
                                            class="comment-icon"></i></span>
                                    <span class="view-count text-center"><?= number_format($item->seen) ?><i
                                                class="eye-icon"></i></span>
                                    <span class="news-date text-left"><?= jDateTime::date('Y/m/d', $item->publish_date) ?>
                                        <i class="calendar-icon"></i></span>
                                </div>
                                <div class="news-image">
                                    <div class="news-image-inner">
                                        <img src="<?= Yii::getAlias('@web/uploads/post/') . $item->image ?>">
                                    </div>
                                </div>
                                <div class="news-details">
                                    <h3><?= $item->name ?></h3>
                                    <div class="news-description"><?= !empty($item->summary) ? $item->summary : mb_substr(strip_tags(nl2br($item->body)), 0, 200) ?>
                                        <div class="overlay"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</section>
