<?php

/** @var $this \yii\web\View */
/** @var $model \app\models\Person */

$expertiseMenu = \app\models\Category::find()
    ->andWhere([
        'type' => \app\models\Category::TYPE_CATEGORY,
        'category_type' => \app\models\Category::CATEGORY_TYPE_EXPERTISE,
    ])
    ->all();
?>

<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <nav>
                    <div class="sidebar-header mt-5">
                        <h4><?= Yii::t('words', 'Payambaran Medical team') ?></h4>
                    </div>
                    <ul class="list-unstyled mt-5">
                        <?php foreach ($expertiseMenu as $item):$sc = $item->children(1)->count(); ?>
                            <li class="mb-3">
                                <?php if ($sc > 0): ?>
                                    <a href="void:;" class="text-purple"><?= $item->name ?></a>
                                    <ul class="list-unstyled submenu">
                                        <?php foreach ($item->children(1)->all() as $item_child): ?>
                                            <li>
                                                <a class="-hoverBlue text-dark-2<?= $model->expertise == $item_child->id ? " active" : "" ?>"
                                                   href="<?= $item_child->url ?>"><?= $item_child->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <a class="-hoverBlue text-dark-2<?= $model->expertise == $item->id ? " active" : "" ?>"
                                       href="<?= $item->url ?>"><?= $item->name ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-9">
                <div class="content-header">
                    <img src="./images/doctors/avatar.png" class="img-fluid content-header__image" alt="">
                    <div class="content-header__titles">
                        <h1 class="media-heading content-header__title">پزشکان</h1>
                        <h3 class="content-header__subTitle">بیمارستان پیامبران</h3>
                    </div>
                    <img src="./images/doctors/avatar-24.png" class="img-fluid doctors-image -btlr -bblr" alt="">

                </div>
                <div class="content-body">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse1">
                                                    <img class="panel-title__doctorAvatar"
                                                         src="./images/doctors/doctor-1.png" alt="">
                                                    <h4 class="panel-title__doctorName">دکتر حسین ماندگار</h4>
                                                    <p class="panel-title__doctorExpertise">
                                                        فوق تخصص جراحی قلب وعروق
                                                    </p>
                                                    <div class="panel-title__more">
                                                        <img src="./images/doctors/more-info.png" alt="">
                                                        اطلاعات بیشتر
                                                    </div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn panel-title__takeTurn" href="void:;">دریافت نوبت</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="collapse1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                    برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای
                                    کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان
                                    جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می
                                    توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به
                                    پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته
                                    اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse2">
                                                    <img class="panel-title__doctorAvatar"
                                                         src="./images/doctors/doctor-1.png" alt="">
                                                    <h4 class="panel-title__doctorName">دکتر حسین ماندگار</h4>
                                                    <p class="panel-title__doctorExpertise">
                                                        فوق تخصص جراحی قلب وعروق
                                                    </p>
                                                    <div class="panel-title__more">
                                                        <img src="./images/doctors/more-info.png" alt="">
                                                        اطلاعات بیشتر
                                                    </div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn panel-title__takeTurn" href="void:;">دریافت نوبت</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div id="collapse2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                    برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای
                                    کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان
                                    جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می
                                    توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به
                                    پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته
                                    اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse3">
                                                    <img class="panel-title__doctorAvatar"
                                                         src="./images/doctors/doctor-1.png" alt="">
                                                    <h4 class="panel-title__doctorName">دکتر حسین ماندگار</h4>
                                                    <p class="panel-title__doctorExpertise">
                                                        فوق تخصص جراحی قلب وعروق
                                                    </p>
                                                    <div class="panel-title__more">
                                                        <img src="./images/doctors/more-info.png" alt="">
                                                        اطلاعات بیشتر
                                                    </div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn panel-title__takeTurn" href="void:;">دریافت نوبت</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                    برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای
                                    کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان
                                    جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می
                                    توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به
                                    پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته
                                    اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse4">
                                                    <img class="panel-title__doctorAvatar"
                                                         src="./images/doctors/doctor-1.png" alt="">
                                                    <h4 class="panel-title__doctorName">دکتر حسین ماندگار</h4>
                                                    <p class="panel-title__doctorExpertise">
                                                        فوق تخصص جراحی قلب وعروق
                                                    </p>
                                                    <div class="panel-title__more">
                                                        <img src="./images/doctors/more-info.png" alt="">
                                                        اطلاعات بیشتر
                                                    </div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn panel-title__takeTurn" href="void:;">دریافت نوبت</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="collapse4" class="panel-collapse collapse">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                    برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای
                                    کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان
                                    جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می
                                    توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به
                                    پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته
                                    اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapse5">
                                                    <img class="panel-title__doctorAvatar"
                                                         src="./images/doctors/doctor-1.png" alt="">
                                                    <h4 class="panel-title__doctorName">دکتر حسین ماندگار</h4>
                                                    <p class="panel-title__doctorExpertise">
                                                        فوق تخصص جراحی قلب وعروق
                                                    </p>
                                                    <div class="panel-title__more">
                                                        <img src="./images/doctors/more-info.png" alt="">
                                                        اطلاعات بیشتر
                                                    </div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn panel-title__takeTurn" href="void:;">دریافت نوبت</a>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                            <div class="panel-title__doctorTimes">
                                                    <span>
                                                        <i class="icomoon-success"></i>
                                                        سه شنبه
                                                    </span>
                                                <span>14:00 الی 18:00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="collapse5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان
                                    گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و
                                    برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای
                                    کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان
                                    جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه
                                    ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می
                                    توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به
                                    پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته
                                    اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="content-footer text-center">
                    <a href="void:;" class="btn text-purple -more purple">
                        <i class="icomoon-ellipsis-h-solid"></i>
                        بارگزاری بیشتر
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
