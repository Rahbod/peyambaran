<?php

/** @var $this \yii\web\View */
/** @var $model \app\models\Page */
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="content-header">
                    <img src="./svg/gallery-white.svg" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= $model->name ?></h1>
                    </div>
                </div>
                <div class="content-body">
                    <div class="mt-4 mb-4 text-center" style="display: block;overflow: hidden;width: 100%;">
                        <img class="rounded" style="max-width: 100%;overflow: hidden;border: 1px solid #999" src="<?= Yii::getAlias('@web/uploads/pages/').$model->image ?>">
                    </div>
                    <div class="mb-5 text-justify"><?= $model->body ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
