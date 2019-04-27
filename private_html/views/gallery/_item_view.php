<?php
/* @var $this yii\web\View */
/* @var $model app\models\PictureGallery */
?>
<div class="gallery__imageContainer">
    <a href="<?= Yii::getAlias('@web/uploads/gallery/') . $model->full_image ?>"
       data-transition="crossfade"
       class="html5lightbox"
       data-group="mygroup" >
        <img class="gallery__images" src="<?= Yii::getAlias('@web/uploads/gallery/thumbs/280x380/') . $model->full_image ?>" alt="<?= $model->name ?>">
    </a>
    <div class="-hoverBox">
        <a href="<?= Yii::getAlias('@web/uploads/gallery/') . $model->full_image ?>"
           data-transition="crossfade"
           data-thumbnail="<?= Yii::getAlias('@web/uploads/gallery/') . $model->thumbnail_image ?>"
           class="html5lightbox"
           data-group="mygroup"
           title="<?= $model->name ?>">
            <h4><?= $model->name ?></h4>
            <img src="<?= $this->theme->baseUrl ?>/images/gallery/frame.png">
        </a>
    </div>
</div>