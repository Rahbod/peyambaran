<?php

use yii\helpers\Url;

/** @var $this \yii\web\View */
?>

<ul class="list-unstyled">
    <li class="active">
        <a href="#user-tab-1"><i class=""></i><span>درخواست نوبت</span></a>
    </li>
    <li>
        <a href="<?= Url::to(['/reception/list']) ?>"><i class=""></i><span>درخواست پذیرش بستری</span></a>
    </li>
    <li><a href="#user-tab-3"><i class=""></i><span>درخواست پذیرش کلینیک</span></a></li>
    <li><a href="#user-tab-4"><i class=""></i><span>درخواست پذیرش پاراکلینیک</span></a></li>
    <li>
        <a href="#user-tab-5"><i class=""></i><span>جوابدهی آزمایشگاه</span></a>
    </li>
    <li>
        <a href="#user-tab-6"><i class=""></i><span>جوابدهی تصویربرداری</span></a>
    </li>
    <li>
        <a href="#user-tab-7"><i class=""></i><span>درخواست همکاری</span></a>
    </li>
    <li>
        <a href="#user-tab-8"><i class=""></i><span>درخواست مشاوره پزشکی</span></a>
    </li>
    <li class="text-danger"><a href="<?= \yii\helpers\Url::to(['/user/logout']) ?>"><i
                    class=""></i><span>خروج</span></a></li>
</ul>
