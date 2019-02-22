<?php
$menuItems = \app\components\MainController::getMenu(Yii::$app->user->identity->roleID);
?>

<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark"
     style="position: relative;">
    <?
    echo \app\components\customWidgets\CustomMenu::widget([
        'encodeLabels' => false,
        'options' => ['class' => 'm-menu__nav  m-menu__nav--dropdown-submenu-arrow'],
        'itemOptions' => ['class' => 'm-menu__item'],
        'items' => $menuItems,
    ]);
    ?>
</div>
