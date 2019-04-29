<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

/** @var $this \yii\web\View */
?>
<section class="dashboard">
    <div class="container">
        <div class="row news-container">
            <div class="col-md-4">
                <div class="sidebar-user-menu">
                    <div class="top-section">
                        <div class="user-side-pic">
                            <?php
                            $src = $this->theme->baseUrl . '/images/user.jpg';
                            if (Yii::$app->user->identity->avatar &&
                                is_file(Yii::getAlias('@webroot/uploads/user/avatars/') . Yii::$app->user->identity->avatar))
                                $src = Yii::getAlias('@web/uploads/user/avatars/') . Yii::$app->user->identity->avatar;
                            ?>
                            <img src="<?= $src ?>" alt="<?= Yii::$app->user->identity->name ?>">
                        </div>
                        <div class="user-side-details">
                            <h3><?= Yii::$app->user->identity->name ?></h3>
                            <p><?= Yii::$app->user->identity->email ?></p>
                            <p><?= Yii::$app->user->identity->phone ?></p>
                        </div>
                        <a href="#" class="user-side-setting"><span class="icon-gear"></span></a>
                    </div>
                    <div class="content-section">
                        <?= $this->render('//user/_user_menu') ?>
                    </div>
                    <div class="footer-border"></div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
                         class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Hospitalization Request') ?></h1>
                        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
                    </div>
                </div>
                <div class="content-body">
                    <div class="table-responsive">
                        <?= \yii\grid\GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'custom-table'],
                            'columns' => [
                                'name',
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
