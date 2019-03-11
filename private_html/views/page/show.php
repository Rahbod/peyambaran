<?php

use app\models\Menu;

/** @var $this \yii\web\View */
/** @var $model \app\models\Page */
/** @var $relatedMenu Menu */

$relatedMenu = Menu::find()->andWhere([Menu::columnGetString('page_id') => $model->id])->one();
if($relatedMenu){
    $parent = Menu::findOne($relatedMenu->parentID);
    $sideMenu = $parent->children(1)->all();
}
//\app\components\dd($sideMenu);

?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <nav id="sidebar">
                    <ul class="list-unstyled mt-3">
                        <li class="active mb-3">
                            <strong><a href="void:;" class="text-purple">جراحی</a></strong>
                            <ul class="list-unstyled submenu">
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">اتاق عمل قلب</a>
                                </li>
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">اتاق عمل عمومی</a>
                                </li>
                            </ul>
                        </li>
                        <li class="mb-3">
                            <a class="text-purple" href="void:;">سرپایی</a>
                            <ul class="list-unstyled submenu">
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">آندوسکوپی</a>
                                </li>
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">کلینیک پوست لیزر و جراحی پلاستیک</a>
                                </li>
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">کلینیک زخم</a>
                                </li>
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">اورژانس</a>
                                </li>
                                <li>
                                    <a class="-hoverBlue text-dark-2" href="void:;">کلینیک</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-sm-9">
                <div class="content-header">
                    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title"><?= $model->name ?></h1>
                    </div>
                </div>
                <div class="content-body">
                    <div class="mt-4 mb-4 text-center" style="display: block;overflow: hidden;width: 100%;">
                        <img class="rounded" style="border-radius:10px;max-width: 100%;overflow: hidden;" src="<?= Yii::getAlias('@web/uploads/pages/').$model->image ?>">
                    </div>
                    <div class="mb-5 text-justify"><?= $model->body ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
