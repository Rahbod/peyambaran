<?php
/* @var $this \yii\web\View */

// echo Yii::getAlias('@web/themes/frontend/images/menu-logo.png')
?>
<header class="<?= Yii::$app->controller->bodyClass?:'' ?>">
    <div class="container">
        <div class="top row">
            <div class="col-lg-8 col-md-8 col-sm-8 hidden-xs">
                <div class="dropdown language-select">
                    <label>Language</label>
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="icon icon-chevron-down"></span>
                        eng
                        <span class="language-icon"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">فارسی</a></li>
                        <li><a href="#">العربیة</a></li>
                        <li><a href="#">English</a></li>
                    </ul>
                </div>
                <a href="#" class="btn btn-green btn-sm" data-toggle="modal" target="#signup">
                    <i class="user-icon"></i>
                    ثبت نام
                </a>
                <a href="#" class="btn btn-purple btn-sm" data-toggle="modal" target="#login">
                    <i class="user-icon"></i>
                    ورود
                </a>
                <form class="search-form">
                    <div class="input-group search-container">
                        <input class="form-control" placeholder="متن جستجو">
                        <span class="input-group-addon">
                            <button type="submit" class="search-btn"><i class="search-icon"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs logo pull-left">
                <img src="<?= $this->theme->baseUrl.(Yii::$app->controller->bodyClass == 'blueHeader'?"logo-white.png":"/images/logo.png")?>">
                <div class="logo-right">
                    <h1>بیمارســتان پیامبران</h1>
                    <h2>Payambaran</h2>
                    <h3 class="font-light">Tamilnadu Government<br>Multi Super Speciality Hospital</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-container">
        <div class="container">
            <ul class="nav navbar nav-pills">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target='#deps' href="#">
                        <i class="icon icon-chevron-down"></i>
                        بخش های بیمارستان
                    </a>
                    <div class="dropdown-menu" id="deps">
                        <div class="container">
                            <ul class="menu-part">
                                <li><a href="#" >بستری</a></li>
                                <li><a href="#" >لاله</a></li>
                                <li><a href="#" >ارکیده</a></li>
                                <li><a href="#" >یاس</a></li>
                                <li><a href="#" >شبنم</a></li>
                                <li><a href="#" >شکوفه</a></li>
                                <li><a href="#" >نیلوفر</a></li>
                                <li><a href="#" >شقایق</a></li>
                                <li><a href="#" >غزال</a></li>
                                <li><a href="#" >سپیده</a></li>
                                <li><a href="#" >سوئیت</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >جراحی</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >مراقبت های ویژه</a></li>
                                <li><a href="#" >ICU</a></li>
                                <li><a href="#" >ICU.OH</a></li>
                                <li><a href="#" >CCU</a></li>
                                <li><a href="#" >NICU</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >سرپایی</a></li>
                                <li><a href="#" >آندوسکوپی</a></li>
                                <li><a href="#" >کلینیک پوست لیزر و جراحی</a></li>
                                <li><a href="#" >کلینیک زخم</a></li>
                                <li><a href="#" >اورژانس</a></li>
                                <li><a href="#" >کلینیک</a></li>
                            </ul>
                            <ul class="menu-part">
                                <li><a href="#" >جراحی</a></li>
                                <li><a href="#" >اتاق عمل قلب</a></li>
                                <li><a href="#" >اتاق عمل جنرال</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="#">پاراکلینیک ها</a></li>
                <li><a href="#">پزشکان</a></li>
                <li><a href="#">تعرفه ها</a></li>
                <li><a href="#">برنامه کلینیک ها</a></li>
                <li><a href="#">گردشگری سلامت</a></li>
                <li><a href="#">اعتباربخشی</a></li>
            </ul>
        </div>
    </div>
</header>