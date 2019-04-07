<?php
/* @var $this \yii\web\View */

// echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png')
?>
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="<?= Yii::$app->getHomeUrl() ?>" class="m-brand__logo-wrapper" target="_blank">
                            <!--                            <img alt="" src="assets/demo/default/media/img/logo/logo_default_dark.png"/>-->
                            <h4 class="text-white"><?= Yii::$app->name ?></h4>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
                        id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width"
                                m-dropdown-toggle="click" aria-expanded="true">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                                    <span class="m-nav__link-icon">
                                        <span class="m-nav__link-text"><b><?php
                                                switch (Yii::$app->language){
                                                    case 'fa': echo'فارسی';break;
                                                    case 'ar': echo'عربی';break;
                                                    case 'en': echo'انگلیسی';break;
                                                }
                                                ?></b></span>
                                        <i class="m-nav__link-icon fas fa-globe"></i>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper" style="z-index: 101;">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                          style="right: auto; left: 5px;"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url(<?= $this->theme->baseUrl ?>/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">
                                            <span class="m-dropdown__header-subtitle">انتخاب زبان</span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__item m-nav__item--active">
                                                        <a href="<?= \yii\helpers\Url::to(['/fa']) ?>" class="m-nav__link m-nav__link--active">
                                                            <span class="m-nav__link-icon"><i class="flag-icon flag-icon-ir flag-icon-squared flag-icon-rounded"></i></span>
                                                            <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">فارسی</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="<?= \yii\helpers\Url::to(['/ar']) ?>" class="m-nav__link">
                                                            <span class="m-nav__link-icon"><i class="flag-icon flag-icon-sa flag-icon-squared flag-icon-rounded"></i></span>
                                                            <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">عربی</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="<?= \yii\helpers\Url::to(['/en']) ?>" class="m-nav__link">
                                                            <span class="m-nav__link-icon"><i class="flag-icon flag-icon-us flag-icon-squared flag-icon-rounded"></i></span>
                                                            <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">انگلیسی</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        <img src="<?= $this->theme->baseUrl ?>/assets/app/media/img/users/user4.jpg"
                                             class="m--img-rounded m--marginless" alt=""/>
                                    </span>
                                    <span class="m-topbar__username m--hide"><?= Yii::$app->user->isGuest ? "Guest" : Yii::$app->user->identity->username ?></span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url(<?= $this->theme->baseUrl ?>/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="<?= $this->theme->baseUrl ?>/assets/app/media/img/users/user4.jpg"
                                                         class="m--img-rounded m--marginless" alt=""/>
                                                    <!--                                                    <span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span>-->
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500"><?= Yii::$app->user->isGuest ? "Guest" : Yii::$app->user->identity->username ?></span>
                                                    <a href=""
                                                       class="m-card-user__email m--font-weight-300 m-link"><?= Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->email ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text"></span>
                                                    </li>
<!--                                                    <li class="m-nav__item">-->
<!--                                                        <a href="header/profile.html" class="m-nav__link">-->
<!--                                                            <i class="m-nav__link-icon flaticon-cogwheel-1"></i>-->
<!--                                                            <span class="m-nav__link-text">مشخصات کاربری</span>-->
<!--                                                        </a>-->
<!--                                                    </li>-->
                                                    <li class="m-nav__item">
                                                        <a href="<?= \yii\helpers\Url::to(['/user/change-password']) ?>" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lock-1"></i>
                                                            <span class="m-nav__link-text">تغییر کلمه عبور</span>
                                                        </a>
                                                    </li>
                                                    <!--                                                    <li class="m-nav__item">-->
                                                    <!--                                                        <a href="header/profile.html" class="m-nav__link">-->
                                                    <!--                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>-->
                                                    <!--                                                            <span class="m-nav__link-text">Messages</span>-->
                                                    <!--                                                        </a>-->
                                                    <!--                                                    </li>-->
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <!--                                                    <li class="m-nav__item">-->
                                                    <!--                                                        <a href="header/profile.html" class="m-nav__link">-->
                                                    <!--                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>-->
                                                    <!--                                                            <span class="m-nav__link-text">Support</span>-->
                                                    <!--                                                        </a>-->
                                                    <!--                                                    </li>-->
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="<?= \yii\helpers\Url::to(['/admin/logout']) ?>"
                                                           class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-danger m-btn--bolder">خروج</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>