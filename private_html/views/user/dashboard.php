<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

/** @var $this \yii\web\View */
?>
<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/gallery-white.svg"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title">درخواست نوبت</h1>
        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
    </div>
</div>
<div class="content-body">
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
            <tr>
                <th width="50%">عنوان آزمایش</th>
                <th width="20%">نام پزشک</th>
                <th width="15%">تاریخ آزمایش</th>
                <th width="15%">تاریخ جوابدهی</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>چربی خون، کلسترل، LDL</td>
                <td>دکتر علی مقصودلو</td>
                <td>97/11/24</td>
                <td>97/11/28</td>
            </tr>
            <tr>
                <td>آزمایش تیروئید</td>
                <td>دکتر محمد پوربافرانی</td>
                <td>97/11/24</td>
                <td>97/11/28</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>