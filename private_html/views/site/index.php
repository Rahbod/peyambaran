<?php
use \app\models\Slide;
use \yii\helpers\Html;

/* @var $this yii\web\View */
?>

<section class="slider-container">
    <div class="slider owl-carousel owl-theme" data-items="1">
        <?php foreach (Slide::find()->valid()->all() as $slide):
        if($slide->image && is_file(Yii::getAlias('@webroot/uploads/slide/').$slide->image)):?>
            <div class="slide-item relative">
                <div class="image-container">
                    <img src="<?= Yii::getAlias('@web/uploads/slide/').$slide->image ?>" alt="<?= Html::encode($slide->name) ?>">
                </div>
            </div>
        <?php endif;endforeach; ?>
    </div>
</section>
<section class="texture-bg circle-texture">
    <div class="container">
        <div class="row online-services-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
                <div class="online-services-icon"></div>
                <h3 class="section-title">سرویس های آنلاین</h3>
                <p class="title-description">بیمارستان پیامبران</p>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 text-right">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="clock-icon online-services-icons"></div>
                                    <div class="clock-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">نوبت دهی</h4>
                                <p class="item-description">جهت دریافت نوبت<br>جهت مراجعه به متخصصان بیمارستان</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="magnifier-icon online-services-icons"></div>
                                    <div class="magnifier-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">جوابدهی آزمایشگاه</h4>
                                <p class="item-description">دریافت جواب آزمایشات ویژه مراجعین به همراه نظر پزشک
                                    آزمایشگاه</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="images-icon online-services-icons"></div>
                                    <div class="images-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">تصاویر <span class="open-sans">PACS</span></h4>
                                <p class="item-description">دریافت تصاویر PACS به همراه نظر پزشک برای تمامی
                                    تصویربرداری های انجام شده</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="reception-icon online-services-icons"></div>
                                    <div class="reception-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">درخواست پذیرش</h4>
                                <p class="item-description">ارسال درخواست پذیرش بستری، کلینیک و پاراکلینیک
                                    بیمارستان</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="association-icon online-services-icons"></div>
                                    <div class="association-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">درخواست همکاری</h4>
                                <p class="item-description">ارسال درخواست همکاری پزشکان، کادر درمان و موارد مربوط به
                                    بیمارستان</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 online-item">
                    <div class="online-item-inner">
                        <a href="#">
                            <div class="item-image">
                                <div class="item-image-circle">
                                    <div class="advice-icon online-services-icons"></div>
                                    <div class="advice-icon-white -hover-show"></div>
                                </div>
                            </div>
                            <div class="item-details">
                                <h4 class="item-title">درخواست مشاوره پزشکی</h4>
                                <p class="item-description">ارسال درخواست مشاوره پزشکی با پزشکان و متخصصان
                                    بیمارستان</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="texture-bg umbrella-texture">
    <div class="container">
        <div class="row insurance-container">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                <div class="umbrella-icon"></div>
                <h3 class="section-title">بیمه های<span class="hidden">طرف قرارداد پیامبران</span></h3>
                <p class="title-description">طرف قرارداد پیامبران</p>
                <div class="row">
                    <div class="insurance-btn-box">
                        <ul>
                            <li class="active"><a href="#" data-toggle="tab" data-target="#insurance-box-1">
                                    <span>بیمه های</span>
                                    <small>طرف قرارداد بستری</small>
                                    <i class="icon icon-chevron-left"></i>
                                </a></li>
                            <li><a href="#" data-toggle="tab" data-target="#insurance-box-2">
                                    <span>بیمه های</span>
                                    <small>طرف قرارداد بستری</small>
                                    <i class="icon icon-chevron-left"></i>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 text-right">
                <div class="tab-content insurance-box">
                    <div class="tab-pane fade active in" id="insurance-box-1">
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="insurance-box-2">
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-2.png">
                                    </div>
                                    <h4>بیمه البرز</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-3.png">
                                    </div>
                                    <h4>بیمه آسیا</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-1.png">
                                    </div>
                                    <h4>بیمه کارآفرین</h4>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-4.png">
                                    </div>
                                    <h4 class="with-small">بیمه سلامت</h4>
                                    <small>(کارمندی_ایرانیان_سایر اقشار)</small>
                                </a>
                            </div>
                        </div>
                        <div class="insurance-item">
                            <div class="insurance-item-inner">
                                <a href="#">
                                    <div class="item-image">
                                        <img class="grayscale" src="uploads/bime-5.png">
                                    </div>
                                    <h4>بیمه ایران</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="texture-bg health-texture">
    <div class="container">
        <div class="row insurance-container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <div class="news-icon"></div>
                <div class="inline-title">
                    <h3 class="section-title">اخبار و مقالات</h3>
                    <p class="title-description">بیمارستان پیامبران</p>
                </div>
            </div>
        </div>
        <div class="news-carousel owl-carousel owl-theme" data-stagePadding="50" data-rtl="true"
             data-autoWidth="true" data-nav="true" data-items="3" data-margin="15">
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news1.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>راه اندازی بخش جدید NICU در فاز توسعه بیمارستان</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news2.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>تعرفه جدید بستری وزارت بهداشت به بیمارستان ها ابلاغ شد</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news3.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>استفاده از تجهیزات جدید جلوگیری از پیری پوست</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news1.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>استفاده از تجهیزات جدید جلوگیری از پیری پوست</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news2.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>تعرفه جدید بستری وزارت بهداشت به بیمارستان ها ابلاغ شد</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news3.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>استفاده از تجهیزات جدید جلوگیری از پیری پوست</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="news-item">
                <div class="news-item-inner">
                    <a href="#">
                        <div class="statics-row">
                            <span class="comments-count text-right">49<i class="comment-icon"></i></span>
                            <span class="view-count text-center">105<i class="eye-icon"></i></span>
                            <span class="news-date text-left">1397/7/11<i class="calendar-icon"></i></span>
                        </div>
                        <div class="news-image">
                            <div class="news-image-inner">
                                <img src="uploads/news1.png">
                            </div>
                        </div>
                        <div class="news-details">
                            <h3>استفاده از تجهیزات جدید جلوگیری از پیری پوست</h3>
                            <div class="news-description">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ
                                و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و
                                سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف
                                بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده
                                شناخت فراوان جامعه و متخصصان را می طلبد.
                                <div class="overlay"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="gallery-bg">
    <div class="container">
        <div class="row gallery-tabs">
            <ul class="pull-left nav nav-tabs">
                <li><a href="#" data-toggle="tab" data-target="#gallery-category-1">پزشکان</a></li>
                <li><a href="#" data-toggle="tab" data-target="#gallery-category-2">محیط داخلی</a></li>
                <li><a href="#" data-toggle="tab" data-target="#gallery-category-3">محیط بیرونی</a></li>
                <li class="active"><a href="#" data-toggle="tab" data-target="#gallery-category-4">تجهیزات</a></li>
                <li><a href="#" data-toggle="tab" data-target="#gallery-category-5">اتاق ها</a></li>
            </ul>
        </div>
        <div class="row gallery-container">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right">
                <div class="gallery-icon"></div>
                <h3 class="section-title">گالری تصاویر</h3>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 gallery-left-box">
                <div class="tab-content row">
                    <div class="tab-pane fade" id="gallery-category-1"></div>
                    <div class="tab-pane fade" id="gallery-category-2"></div>
                    <div class="tab-pane fade" id="gallery-category-3"></div>
                    <div class="tab-pane fade active in" id="gallery-category-4">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right gallery-list-box nicescroll"
                             data-cursorcolor="#4d82f2" data-cursorborder="none"
                             data-railpadding='js:{"top":0,"right":-5,"bottom":0,"left":0}'
                             data-autohidemode="false">
                            <div class="gallery-list relative">
                                <div class="gallery-item active">
                                    <a href="#" data-toggle="tab" data-target="#gallery-details-1">
                                        <div class="item-image">
                                            <img src="uploads/gallery1.png">
                                        </div>
                                        <div class="item-details">
                                            <h4 class="with-small">اتاق بیهوشی</h4>
                                            <p>بیهوشی موضعی و کامل</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="gallery-item">
                                    <a href="#" data-toggle="tab" data-target="#gallery-details-2">
                                        <div class="item-image">
                                            <img src="uploads/gallery2.png">
                                        </div>
                                        <div class="item-details">
                                            <h4 class="with-small">اتاق ریکاوری</h4>
                                            <p>اتاق مجزا و کامل با 10 تخت</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="gallery-item">
                                    <a href="#" data-toggle="tab" data-target="#gallery-details-3">
                                        <div class="item-image">
                                            <img src="uploads/gallery3.png">
                                        </div>
                                        <div class="item-details">
                                            <h4 class="with-small">اتاق عمل</h4>
                                            <p>شامل 5 اتاق عمل مجهز</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="gallery-item">
                                    <a href="#" data-toggle="tab" data-target="#gallery-details-4">
                                        <div class="item-image">
                                            <img src="uploads/gallery1.png">
                                        </div>
                                        <div class="item-details">
                                            <h4 class="with-small">اتاق ریکاوری</h4>
                                            <p>جهت آماده سازی برای عمل</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="gallery-item">
                                    <a href="#" data-toggle="tab" data-target="#gallery-details-5">
                                        <div class="item-image">
                                            <img src="uploads/gallery1.png">
                                        </div>
                                        <div class="item-details">
                                            <h4 class="with-small">اتاق ریکاوری</h4>
                                            <p>جهت آماده سازی برای عمل</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 text-right">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="gallery-details-1">
                                    <div class="gallery-item-details">
                                        <div class="item-image-big">
                                            <img src="uploads/gallery-big-1.png">
                                        </div>
                                        <div class="gallery-details">
                                            <h3>اتاق بیهوشی</h3>
                                            <p>بیهوشی موضعی و کامل</p>
                                            <div class="font-light">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی
                                                می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت
                                                فراوان جامعه و متخصصان را می طلبد.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="gallery-details-2">
                                    <div class="gallery-item-details">
                                        <div class="item-image-big">
                                            <img src="uploads/gallery-big-1.png">
                                        </div>
                                        <div class="gallery-details">
                                            <h3>اتاق ریکاوری</h3>
                                            <p>اتاق مجزا و کامل با 10 تخت</p>
                                            <div class="font-light">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی
                                                می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت
                                                فراوان جامعه و متخصصان را می طلبد.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="gallery-details-3">
                                    <div class="gallery-item-details">
                                        <div class="item-image-big">
                                            <img src="uploads/gallery-big-1.png">
                                        </div>
                                        <div class="gallery-details">
                                            <h3>اتاق عمل</h3>
                                            <p>شامل 5 اتاق عمل مجهز</p>
                                            <div class="font-light">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی
                                                می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت
                                                فراوان جامعه و متخصصان را می طلبد.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="gallery-details-4">
                                    <div class="gallery-item-details">
                                        <div class="item-image-big">
                                            <img src="uploads/gallery-big-1.png">
                                        </div>
                                        <div class="gallery-details">
                                            <h3>اتاق عمل</h3>
                                            <p>شامل 5 اتاق عمل مجهز</p>
                                            <div class="font-light">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی
                                                می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت
                                                فراوان جامعه و متخصصان را می طلبد.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="gallery-details-5">
                                    <div class="gallery-item-details">
                                        <div class="item-image-big">
                                            <img src="uploads/gallery-big-1.png">
                                        </div>
                                        <div class="gallery-details">
                                            <h3>اتاق عمل</h3>
                                            <p>شامل 5 اتاق عمل مجهز</p>
                                            <div class="font-light">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از
                                                صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه
                                                روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                                                تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی
                                                می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت
                                                فراوان جامعه و متخصصان را می طلبد.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="gallery-category-5"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="map-bg">
    <div class="map"></div>
</section>
<section class="bottom-section">
    <div class="container">
        <div class="overflow-fix">
            <div class="form-container">
                <h3>تماس با ما</h3>
                <div class="text">در صورتی که مایل به تماس با ما هستید، می توانید از طریق فرم زیر بخش مورد نظر خود
                    را انتخاب و موضوع خود را مطرح کنید.<br>همچنین می توانید با شماره تماس های درج شده نیز تماس حاصل
                    فرمایید.
                </div>
                <form>
                    <div class="row">
                        <div class="form-row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="select">بخش موردنظر</label>
                                <select id="select">
                                    <option>مدیریت</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="name">نام و نام خانوادگی</label>
                                <input id="name" type="text" placeholder="نام و نام خانوادگی">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="email">پست الکترونیکی</label>
                                <input id="email" type="text" placeholder="exampel@email.com">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="mobile">شماره تلفن همراه</label>
                                <input id="mobile" type="text" placeholder="09xxxxxxxx">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label for="text">متن پیام</label>
                                <textarea id="text" placeholder="بنویسید"></textarea>
                            </div>
                        </div>
                        <div class="form-row last">
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 captcha">
                                <img src="uploads/captcha.png">
                                <a href="#">کد جدید ایجاد کنید</a>
                                <input type="text" placeholder="صورة أمنية">
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                <input type="submit" value="ارسال به بخش مربوطه">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="info-container">
                <ul>
                    <li>
                        <i class="icon point-icon"></i>
                        <div>آدرس بیمارستان پیامبران<br> تهران - میدان دوم صادقیه - بلوارآیت الله کاشانی - بلوار
                            اباذر - بیمارستان تخصصی و فوق تخصصی پیامبران
                        </div>
                    </li>
                    <li>
                        <i class="icon phone-icon"></i>
                        <div>تلفن و فکس<br> 44079131-41 - 44078392</div>
                    </li>
                    <li class="email">
                        <i class="icon email-icon"></i>
                        <div>info@payambaranhospital.com</div>
                    </li>
                    <li>
                        <i class="icon share-icon"></i>
                        <div>
                            <a href="#" class="icon instagram-icon"></a>
                            <a href="#" class="icon facebook-icon"></a>
                            <a href="#" class="icon google-icon"></a>
                            <a href="#" class="icon twitter-icon"></a>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="certificate-block">
                    <h3>مدارک معتبر</h3>
                    <div class="certs">
                        <div class="cert-item">
                            <div class="cert-item-inner">
                                <h4 class="bolder open-sans">ISO 9001:2008</h4>
                                <p>Professional of medical therapeutic & diginic service</p>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-item-inner">
                                <h4 class="bolder open-sans">IPD</h4>
                                <p>International Patient Department</p>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-item-inner">
                                <h4 class="bolder open-sans">ISO 14001:2004</h4>
                                <p>Professional of medical therapeutic & diginic service</p>
                            </div>
                        </div>
                        <div class="cert-item">
                            <div class="cert-item-inner">
                                <h4 class="bolder open-sans">OHSAS 18001:207</h4>
                                <p>Professional of medical therapeutic & diginic service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>