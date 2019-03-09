<?php
/** @var $this \yii\web\View */
?>

<section class="register">
    <div class="container">
        <div class="row register-container">
            <div class="col-xs-12 px-0">
                <div class="content-header">
                    <img src="./svg/user.svg" class="img-fluid content-header__image"
                         alt="">
                    <div class="titles">
                        <h1 class="media-heading content-header__title galleryHeader__title"><?= Yii::t('words', 'Register') ?></h1>
                        <h3 class="content-header__subTitle galleryHeader__subTitle"><?= Yii::t('words', 'Create user account') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 px-0 bg-white -bbrr -bblr">
                <div class="register-form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-6 vertical-separator-line">
                                <div class="register-form-container">
                                    <h4 class="register-form-container__title"><?= Yii::t('words', 'Account information') ?></h4>
                                    <p class="register-form-container__description"><?= Yii::t('words','register_text') ?></p>

                                    <form action="#" class="forms"
                                          enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <input placeholder="نام و نام خانوادگی" type="text"
                                                       class="toggleLabel form-control"
                                                       autocomplete="full_name" spellcheck="false" tabindex="1"
                                                       name="user_name">
                                            </div>
                                            <div class="form-group col-12">
                                                <input placeholder="کد ملی" type="text"
                                                       class="toggleLabel form-control"
                                                       autocomplete="name" spellcheck="false" tabindex="2"
                                                       name="code_melli" id="codeMelli">
                                            </div>
                                            <div class="form-group col-12">
                                                <input placeholder="شماره تماس" type="text"
                                                       class="toggleLabel form-control"
                                                       autocomplete="name" spellcheck="false" tabindex="3"
                                                       name="phone" id="phone">
                                            </div>

                                            <div class="form-group col-12">
                                                <div class="clearfix">
                                                    <a class="floatToRight form-control securityCode__image">
                                                        <!--<img src="" alt="">-->
                                                        RCii7485
                                                    </a>
                                                    <input class="floatToRight securityCode__input form-control"
                                                           placeholder="تصویر امنیتی"
                                                           type="text">
                                                    <button type="submit" class="btn submitBtn">ثبت نام</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="social-accounts-container">
                                    <div class="social-accounts login-with-google">
                                        <a href="void:;">
                                            ورود با حساب گوگل
                                            <img src="./images/register/google.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-facebook">
                                        <a href="void:;">
                                            ورود با حساب فیسبوک
                                            <img src="./images/register/facebook.png" alt="">
                                        </a>
                                    </div>
                                    <div class="social-accounts login-with-twitter">
                                        <a href="void:;">
                                            ورود با حساب تویتتر
                                            <img src="./images/register/twitter.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
