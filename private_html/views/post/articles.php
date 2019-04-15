<?php
/** @var $this \yii\web\View */
/** @var $searchModel \app\models\Post */
/** @var $dataProvider \yii\data\ActiveDataProvider */
?>

<section class="news">
    <div class="container">
        <div class="row news-container">
            <div class="col-xs-12">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/images/news/news-header-image.png" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Articles') ?></h1>
                        <h3 class="content-header__subTitle "><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
                    </div>
                    <div class="newsSearchBox">
                        <form class="search-form" action="<?= \yii\helpers\Url::to(['/post/articles']) ?>" method="get"
                              style="min-width: 400px;">
                            <p class="search-form-label"><?= Yii::t('words', 'Search in articles...') ?></p>
                            <div class="input-group search-container">
                                <input class="form-control" placeholder="<?= Yii::t('words', 'Search...') ?>" name="term" value="<?= Yii::$app->request->getQueryParam('term') ?>">
                                <span class="input-group-addon"><button type="submit" class="search-btn"><i
                                                class="search-icon"></i></button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="container-fluid px-0">
                    <div class="row">
                        <?php echo \yii\widgets\ListView::widget([
                            'id' => 'news-list',
                            'dataProvider' => $dataProvider,
                            'itemView' => '_news_item',
                            'layout' => '{items} {pager}'
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="content-footer galleryFooter text-center mb-5">
                    <a href="void:;" class="btn text-purple -more">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        بارگزاری بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
