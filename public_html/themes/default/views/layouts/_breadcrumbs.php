<?php
/* @var $this \yii\web\View */

if (isset($this->params['breadcrumbs'])):
    ?>
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><?= $this->title ?></h3>
                <?php
                echo \yii\widgets\Breadcrumbs::widget([
                    'itemTemplate' => "<li class='m-nav__item'>{link}</li> <li class='m-nav__separator'>-</li> ", // template for all links
                    'activeItemTemplate' => "<li class='m-nav__item active'>{link}</li> ",
                    'encodeLabels' => false,
                    'homeLink' => [
                        'label' => 'Home',
                        'url' => ['/admin/index'],
                        'template' => '<li class="m-nav__item m-nav__item--home"><a href="'.\yii\helpers\Url::to(['/admin/index']).'" class="m-nav__link m-nav__link--icon"><i class="m-nav__link-icon la la-home"></i></a></li>'
                    ],
                    'links' => $this->params['breadcrumbs'],
                    'options' => ['class' => 'm-subheader__breadcrumbs m-nav m-nav--inline']
                ]);
                ?>
            </div>
        </div>
    </div>
<?php
endif;