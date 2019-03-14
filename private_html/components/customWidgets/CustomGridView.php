<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/21/2019
 * Time: 8:26 PM
 */

namespace app\components\customWidgets;


use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CustomGridView extends GridView
{
    public $pager = [
        'options' => ['class' => 'pagination'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['class' => 'page-link'],
        'disabledPageCssClass' => 'disabled',
        'pageCssClass' => 'paginate_button page-item',
        'prevPageCssClass' => 'paginate_button page-item previous',
        'prevPageLabel' => '<i class="la la-angle-right"></i>',
        'nextPageCssClass' => 'paginate_button page-item next',
        'nextPageLabel' => '<i class="la la-angle-left"></i>',
    ];
    public $tableOptions = ['class' => 'table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed'];
    public $layout = "<div class='row'><div class='col-sm-12 col-md-5'>{summary}</div><div class='col-sm-12 col-md-7'><div class='dataTables_paginate paging_simple_numbers'>{pager}</div></div></div><div class='row'><div class='col-sm-12'><div class='table-responsive'>{items}</div></div></div><div class='row'><div class='col-sm-12 col-md-5'>{summary}</div><div class='col-sm-12 col-md-7'><div class='dataTables_paginate paging_simple_numbers'>{pager}</div></div></div>";
}