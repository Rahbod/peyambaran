<?php
/** @var $model \app\models\Menu */
?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
    <div class="card">
        <div class="card-body text-nowrap" style="overflow: hidden;text-overflow: ellipsis">
            <a href="<?= $model->getUrl() ?>">
                <h4><?= $model->name ?></h4>
            </a>
        </div>
    </div>
</div>