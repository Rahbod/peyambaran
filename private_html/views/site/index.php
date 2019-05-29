<?php

use app\models\Category;
use app\models\Insurance;
use app\models\OnlineService;
use app\models\Post;
use app\models\Slide;
use yii\helpers\Html;
use app\components\Setting;

/* @var $this yii\web\View */
/** @var $slides Slide[] */
/** @var $inpatientInsurances Insurance[] */
/** @var $outpatientInsurances Insurance[] */
/** @var $posts Post[] */
/** @var $galleryCategories Category[] */
/** @var $onlineServices OnlineService[] */

$baseUrl = $this->theme->baseUrl;
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/froogaloop2.min.js', [], 'froogaloop2');
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');
?>


<section class="slider-container">
    <div class="slider header-slider owl-carousel owl-theme"
        <?= Yii::$app->language == 'en' ? 'data-rtl="false"' : 'data-rtl="true"' ?>
         data-owlcarousel='js:<?= \yii\helpers\Json::encode(Setting::get('slider')); ?>'
         data-items="1"
         data-autoHeight="true">
        <?php foreach ($slides as $slide):
            if ($slide->image && is_file(Yii::getAlias('@webroot/uploads/slide/') . $slide->image)):?>
                <div class="slide-item relative">
                    <div class="image-container">
                        <img src="<?= Yii::getAlias('@web/uploads/slide/') . $slide->image ?>"
                             alt="<?= Html::encode($slide->name) ?>">
                    </div>
                </div>
            <?php endif;endforeach; ?>
    </div>
</section>

<!--Online Services-->
<?php if ($onlineServices): ?>
    <section class="texture-bg circle-texture online-services">
        <div class="container">
            <div class="row online-services-container">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
                    <div class="online-services-icon"></div>
                    <h3 class="section-title"><?= Yii::t('words', 'Online Services') ?></h3>
                    <p class="title-description"><?= Yii::t('words', 'Payambaran hospital') ?></p>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 text-right">
                    <?php foreach ($onlineServices as $onlineService): ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                            <div class="online-item-inner">
                                <a href="<?= $onlineService->url ?>">
                                    <div class="item-image">
                                        <div class="item-image-circle">
<!--                                            <div class="clock-icon online-services-icons"></div>-->
<!--                                            <div class="clock-icon-white -hover-show"></div>-->
                                        </div>
                                    </div>
                                    <div class="item-details">
                                        <h4 class="item-title"><?= $onlineService->name ?></h4>
                                        <p class="item-description"><?= nl2br($onlineService->short_description) ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!--End  Online Services-->

<!--Insurance-->
<?php if ($inpatientInsurances || $outpatientInsurances): ?>
    <section class="texture-bg umbrella-texture insurance">
        <div class="container">
            <div class="row insurance-container">
                <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 text-right">
                    <div class="insurance--header--desktop">
                        <div class="umbrella-icon"></div>
                        <?= Yii::t('words', 'insurance_title') ?>
                    </div>
                    <div class="insurance--header--mobile">
                        <div class="umbrella-icon"></div>
                        <div class="flex-fill">
                            <h3 class="section-title">بیمه های<span class="hidden">طرف قرارداد پیامبران</span></h3>
                            <p class="title-description">طرف قرارداد پیامبران</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="insurance-btn-box">
                            <ul>
                                <li class="active"><a href="#" data-toggle="tab" data-target="#insurance-box-1">
                                        <?= Yii::t('words', 'hospitalization insurances') ?>
                                        <i class="icon icon-chevron-left"></i>
                                    </a></li>
                                <li><a href="#" data-toggle="tab" data-target="#insurance-box-2">
                                        <?= Yii::t('words', 'Outpatient insurances') ?>
                                        <i class="icon icon-chevron-left"></i>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12 text-right">
                    <div class="tab-content insurance-box">
                        <div class="tab-pane fade active in" id="insurance-box-1">
                            <div class="">
                                <?php foreach ($inpatientInsurances as $item): ?>
                                    <div class="insurance-item">
                                        <div class="insurance-item-inner">
                                            <a>
                                                <?php if ($item->image && is_file(Yii::getAlias('@webroot/uploads/insurance/') . $item->image)): ?>
                                                    <div class="item-image">
                                                        <img class="grayscale"
                                                             src="<?= Yii::getAlias('@web/uploads/insurance/') . $item->image ?>">
                                                    </div>
                                                    <h5 class="with-image"
                                                        title="<?= Html::encode($item->name) ?>"><?= $item->name ?></h5>
                                                <?php else: ?>
                                                    <h5 title="<?= Html::encode($item->name) ?>"><?= $item->name ?></h5>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="insurance-box-2">
                            <?php foreach ($outpatientInsurances as $item): ?>
                                <div class="insurance-item">
                                    <div class="insurance-item-inner">
                                        <a href="#">
                                            <?php if ($item->image && is_file(Yii::getAlias('@webroot/uploads/insurance/') . $item->image)): ?>
                                                <div class="item-image">
                                                    <img class="grayscale"
                                                         src="<?= Yii::getAlias('@web/uploads/insurance/') . $item->image ?>">
                                                </div>
                                                <h5 class="with-image"
                                                    title="<?= Html::encode($item->name) ?>"><?= $item->name ?></h5>
                                            <?php else: ?>
                                                <h5 title="<?= Html::encode($item->name) ?>"><?= $item->name ?></h5>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
<!--End Insurance-->

<!--News and Articles-->
<?php if ($posts): ?>
    <section class="texture-bg health-texture new-articles">
        <div class="container">
            <div class="row insurance-container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                    <div class="news-icon"></div>
                    <div class="inline-title">
                        <h3 class="section-title"><?= Yii::t('words', 'News & Articles') ?></h3>
                        <p class="title-description"><?= Yii::t('words', 'Payambaran hospital') ?></p>
                    </div>
                </div>
            </div>
            <div class="news-carousel owl-carousel owl-theme"
                 data-stagePadding="50"
                <?= Yii::$app->language == 'fa' ? 'data-rtl="true"' : 'data-rtl="false"' ?>
                 data-autoWidth="true"
                 data-nav="true"
                 data-loop="true"
                 data-items="1"
                 data-margin="15"
                 data-autoplay="true"
                 data-autoplayspeed="9000"
                 data-autoHeight="true"
                 data-responsive='{"786" :{ "items": 2 }, "992" :{ "items": 3 }}'>
                <?php foreach ($posts as $item): ?>
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
<!--End News and Articles-->

<!--Gallery-->
<?php if (\app\models\PictureGallery::find()->valid()->count() > 0): ?>
    <section class="gallery-bg">
        <div class="container">
            <div class="row gallery-tabs">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                    <div class="gallery-icon"></div>
                    <h3 class="section-title"><?= Yii::t('words', 'Picture Gallery') ?></h3>
                </div>
                <ul class="pull-left nav nav-tabs">
                    <?php $i = 0;
                    foreach ($galleryCategories as $item): ?>
                        <?php if (count($item->catitems) > 0): $i++; ?>
                            <li<?= $i == 1 ? ' class="active"' : '' ?>><a href="#" data-toggle="tab"
                                                                          data-target="#gallery-category-<?= $item->id ?>"><?= $item->name ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="row gallery-container">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 gallery-left-box">
                    <div class="tab-content row">
                        <?php $i = 0;
                        foreach ($galleryCategories as $category): ?>
                            <?php if (count($category->catitems) > 0): $i++; ?>
                                <div class="tab-pane fade<?= $i == 1 ? ' active in' : '' ?>"
                                     id="gallery-category-<?= $category->id ?>">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right gallery-list-box nicescroll"
                                         data-cursorcolor="#4d82f2" data-cursorborder="none"
                                         data-railpadding='js:{"top":0,"right":-5,"bottom":0,"left":0}'
                                         data-autohidemode="false">
                                        <?php $k = 0;
                                        foreach ($category->items as $item):$k++; ?>
                                            <div class="gallery-list relative">
                                                <div class="gallery-item<?= $k === 1 ? " active" : "" ?>">
                                                    <a href="#" data-toggle="tab"
                                                       data-target="#gallery-details-<?= $item->id ?>">
                                                        <div class="item-image">
                                                            <img src="<?= Yii::getAlias('@web/uploads/gallery/') . $item->thumbnail_image ?>"
                                                                 alt="<?= $item->name ?>">
                                                        </div>
                                                        <div class="item-details">
                                                            <h4 class="with-small"><?= $item->name ?></h4>
                                                            <p><?= $item->short_description ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right">
                                        <div class="tab-content">
                                            <?php $k = 0;
                                            foreach ($category->items as $item):$k++; ?>
                                                <div class="tab-pane fade<?= $k === 1 ? " in active" : "" ?>"
                                                     id="gallery-details-<?= $item->id ?>">
                                                    <div class="gallery-item-details">
                                                        <div class="item-image-big">
                                                            <a href="<?= Yii::getAlias('@web/uploads/gallery/') . $item->full_image ?>"
                                                               data-transition="crossfade"
                                                               class="html5lightbox"
                                                               data-group="gallery-group-<?= $category->id ?>">
                                                                <img src="<?= Yii::getAlias('@web/uploads/gallery/thumbs/280x380/') . $item->full_image ?>"
                                                                     alt="<?= $item->name ?>">
                                                            </a>
                                                            <div class="-hoverBox">
                                                                <a href="<?= Yii::getAlias('@web/uploads/gallery/') . $item->full_image ?>"
                                                                   data-transition="crossfade"
                                                                   class="html5lightbox"
                                                                   data-group="gallery-group-<?= $category->id ?>"
                                                                   title="<?= $item->name ?>">
                                                                    <img src="<?= $this->theme->baseUrl ?>/images/gallery/frame.png">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="gallery-details">
                                                            <h3><?= $item->name ?></h3>
                                                            <p><?= $item->short_description ?></p>
                                                            <div class="font-light"><?= strip_tags(nl2br($item->body)) ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!--End Galley-->