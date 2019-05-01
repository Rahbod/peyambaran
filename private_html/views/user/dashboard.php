<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;

/** @var $this \yii\web\View */
?>
<div class="content-header">
    <img src="<?= $this->theme->baseUrl ?>/svg/user.svg"
         class="img-fluid content-header__image" alt="">
    <div class="content-header__titles">
        <h1 class="media-heading content-header__title"><?= Yii::t('words', 'Dashboard') ?></h1>
        <h3 class="content-header__subTitle"><?= Yii::t('words', 'Payambaran Hospital') ?></h3>
    </div>
</div>
<div class="content-body">
    <div class="row mt-5 mb-5">
        <div class="col-sm-4">
            <a href="<?= Url::to(['']) ?>">
                <div class="card bg-success">
                    <div class="card-header text-center">
                            <h4 class="card-title"><?= Yii::t('words', 'Get Visit') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'New Visit Request') ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= Url::to(['']) ?>">
                <div class="card bg-cyan">
                    <div class="card-header text-center">
                        <h4 class="card-title"><?= Yii::t('words', 'Laboratory response') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'Result Inquiry') ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= Url::to(['']) ?>">
                <div class="card bg-blue">
                    <div class="card-header text-center">
                        <h4 class="card-title"><?= Yii::t('words', 'Imaging response') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'Result Inquiry') ?></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-4">
            <a href="<?= Url::to(['/reception/request']) ?>">
                <div class="card bg-pink">
                    <div class="card-header text-center">
                        <h4 class="card-title"><?= Yii::t('words', 'Reception request') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'New Request') ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= Url::to(['/advice/request']) ?>">
                <div class="card bg-warning">
                    <div class="card-header text-center">
                        <h4 class="card-title"><?= Yii::t('words', 'Medical advice request') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'New Request') ?></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="<?= Url::to(['/cooperation/request']) ?>">
                <div class="card bg-danger">
                    <div class="card-header text-center">
                        <h4 class="card-title"><?= Yii::t('words', 'Cooperation request') ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= Yii::t('words', 'New Request') ?></p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>