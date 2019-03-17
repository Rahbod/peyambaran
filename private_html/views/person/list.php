<?php

/** @var $this \yii\web\View */
/** @var $model \app\models\Person */

$expertiseMenu = \app\models\Category::find()
    ->andWhere([
        'type' => \app\models\Category::TYPE_CATEGORY,
        'category_type' => \app\models\Category::CATEGORY_TYPE_EXPERTISE,
    ])
    ->all();

$expertiseID = Yii::$app->request->getQueryParam('expertise')?:0;
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <nav id="sidebar">
                    <div class="sidebar-header mt-3">
                        <h4 class="text-purple"><?= Yii::t('words', 'Payambaran Medical team') ?></h4>
                    </div>
                    <ul class="list-unstyled mt-5">
                        <?php foreach ($expertiseMenu as $item):$sc = $item->children(1)->count(); ?>
                            <li class="mb-3">
                                <?php if ($sc > 0): ?>
                                    <a href="void:;" class="text-purple"><?= $item->name ?></a>
                                    <ul class="list-unstyled submenu">
                                        <?php foreach ($item->children(1)->all() as $item_child): ?>
                                            <li>
                                                <a class="-hoverBlue text-dark-2<?= $expertiseID == $item_child->id ? " active" : "" ?>"
                                                   href="<?= $item_child->url ?>"><?= $item_child->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <a class="-hoverBlue text-dark-2<?= $expertiseID == $item->id ? " active" : "" ?>"
                                       href="<?= $item->url ?>"><?= $item->name ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9">
                <div class="content-header bg-purple">
                    <div class="content-header__gradient-overlay"></div>
                    <img src="<?= $this->theme->baseUrl ?>/images/doctors/avatar.png" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Doctors') ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                    </div>
                    <img src="<?= $this->theme->baseUrl ?>/images/doctors/avatar-24.png" class="content-header__fade-bg">

                </div>
                <div class="content-body">
                    <div class="panel-group" id="accordion">
                        <?php echo \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemView' => '_item_view'
                        ]); ?>
                    </div>
                </div>
                <div class="content-footer text-center">
                    <a href="void:;" class="btn text-purple -more purple">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        بارگزاری بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
