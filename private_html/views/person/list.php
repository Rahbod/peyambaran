<?php

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\Person */

$expertiseMenu = \app\models\Category::find()
    ->andWhere([
        'type' => \app\models\Category::TYPE_CATEGORY,
        'category_type' => \app\models\Category::CATEGORY_TYPE_EXPERTISE,
    ])
    ->valid()
    ->all();
$expertiseID = Yii::$app->request->getQueryParam('expertise') ?: 0;
?>

<section class="doctors gallery">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <nav class="gallery-sidebar-menu">
                    <div class="sidebar-header mt-3">
                        <h4 class="text-purple"><?= Yii::t('words', 'Payambaran Medical team') ?></h4>
                    </div>
                    <ul class="list-unstyled mt-4">
                        <?php foreach ($expertiseMenu as $item):$sc = $item->children(1)->count(); ?>
                            <li class="mb-3">
                                <?php if ($sc > 0): ?>
                                    <a href="void:;" class="text-purple"><?= $item->getName() ?></a>
                                    <ul class="list-unstyled submenu">
                                        <?php foreach ($item->children(1)->all() as $item_child): $url = Url::to(['/person/list', 'expertise' => $item_child->id]); ?>
                                            <li>
                                                <a class="-hoverBlue text-dark-2<?= $expertiseID == $item_child->id ? " active" : "" ?>"
                                                   href="<?= $url ?>"><?= $item_child->getName() ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: $url = Url::to(['/person/list', 'expertise' => $item->id]); ?>
                                    <a class="-hoverBlue text-dark-2<?= $expertiseID == $item->id ? " active" : "" ?>"
                                       href="<?= $url ?>"><?= $item->getName() ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9">
                <div class="content-header bg-purple">
                    <div class="content-header__gradient-overlay"></div>
                    <img  src="<?= $this->theme->baseUrl ?>/images/doctors/avatar.png"
                         class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Doctors') ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran hospital') ?></h3>
                    </div>
                    <img src="<?= $this->theme->baseUrl ?>/images/doctors/avatar-24.png"
                         class="content-header__fade-bg">
                    <button type="button" class="btn sideMenuIcon" data-toggle="modal" data-target="#myModal"></button>

                </div>
                <div class="content-body p-0">
                    <div class="panel-group mt-5" id="accordion">
                        <?php echo \yii\widgets\ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '{items}',
                            'itemView' => '_item_view'
                        ]); ?>
                    </div>
                </div>
                <div class="content-footer text-center">
                    <a href="void:;" class="btn text-purple -more purple" disabled="">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        <?= Yii::t('words', 'Load more') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><?= Yii::t('words', 'Payambaran Medical team') ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <nav class="">
                    <ul class="list-unstyled">
                        <?php foreach ($expertiseMenu as $item):$sc = $item->children(1)->count(); ?>
                            <li class="mb-3">
                                <?php if ($sc > 0): ?>
                                    <a href="void:;" class="text-purple"><?= $item->name ?></a>
                                    <ul class="list-unstyled submenu">
                                        <?php foreach ($item->children(1)->all() as $item_child): $url = Url::to(['/person/list', 'expertise' => $item_child->id]); ?>
                                            <li>
                                                <a class="-hoverBlue text-dark-2<?= $expertiseID == $item_child->id ? " active" : "" ?>"
                                                   href="<?= $url ?>"><?= $item_child->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: $url = Url::to(['/person/list', 'expertise' => $item->id]); ?>
                                    <a class="-hoverBlue text-dark-2<?= $expertiseID == $item->id ? " active" : "" ?>"
                                       href="<?= $url ?>"><?= $item->name ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
            </div>
        </div>

    </div>
</div>
