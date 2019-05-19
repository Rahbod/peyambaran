<?php
/** @var $model \app\models\Post */
?>

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-4">
    <div class="news-item">
        <div class="news-item-inner">
            <a href="<?= $model->url ?>">
                <div class="statics-row">
                    <span class="comments-count text-right"><?= number_format($model->comments_count) ?><i
                                class="comment-icon"></i></span>
                    <span class="view-count text-center"><?= number_format($model->seen) ?><i
                                class="eye-icon"></i></span>
                    <span class="news-date text-left"><?= jDateTime::date('Y/m/d', $model->publish_date) ?>
                        <i class="calendar-icon"></i></span>
                </div>
                <div class="news-image">
                    <div class="news-image-inner">
                        <img src="<?= Yii::getAlias('@web/uploads/post/') . $model->image ?>">
                    </div>
                </div>
                <div class="news-details">
                    <h3><?= $model->name ?></h3>
                    <div class="news-description"><?= !empty($model->summary) ? $model->summary : mb_substr(strip_tags(nl2br($model->body)), 0, 200) ?>
                        <div class="overlay"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!--<div class="col-lg-4">
    <a href="<? /*= $model->url */ ?>">
        <div class="card m-0 mb-5">
            <div class="card-header">
                <p>
                    <i class="icomoon-comment-alt-regular"> <? /*= number_format($model->comments_count) */ ?> </i>
                </p>

                <p>
                    <i class="icomoon-eye-regular"> <? /*= number_format($model->seen) */ ?> </i>
                </p>
                <p>
                    <i class="icomoon-calendar-alt-regular"> <? /*= jDateTime::date('Y/m/d', strtotime($model->publish_date)) */ ?> </i>
                </p>
            </div>
            <div class="card-body">
                <a title="" href="#" class="card-link">
                    <img src="<? /*= Yii::getAlias('@web/uploads/post/') . $model->image */ ?>" class="card-img-top"
                         alt="<? /*= $model->name */ ?>">
                    <h4 class="card-title"><? /*= $model->name */ ?></h4>
                    <div class="card-text -show4Lines -show4Lines"><? /*= !empty($model->summary) ? $model->summary : mb_substr(strip_tags(nl2br($model->body)), 0, 200) */ ?>
                        <div class="overlay"></div>
                    </div>
                </a>
            </div>
            <div class="card-footer">
                <div class="transparent-bg"></div>
            </div>
        </div>
    </a>
</div>-->