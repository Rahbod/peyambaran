<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\models\User;

/**
 * Class MainController
 * @package app\components
 *
 * @property User $user
 */
abstract class MainController extends Controller
{
    public $bodyClass;
    public $theme;
    public $tmpDir = 'uploads/temp';

    public function init()
    {
        parent::init();
        if (Yii::$app->session->has('language'))
            Yii::$app->language = Yii::$app->session->get('language');
        else if (isset(Yii::$app->request->cookies['language']))
            Yii::$app->language = Yii::$app->request->cookies['language']->value;
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getSystemActions()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getSamePermissions()
    {
        return [];
    }

    public function userCanAccess($action, $isPermissionName = false)
    {
        /* @var $role \yii\rbac\Role */
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        foreach ($roles as $role)
            if ($role->name == 'superAdmin')
                return true;

        if ($isPermissionName)
            return Yii::$app->user->can($action);
        else
            return Yii::$app->user->can($this->id . ucfirst($action));
    }


    public function setTheme($theme)
    {
        if ($theme) {
            Yii::$app->view->theme = new \yii\base\Theme([
                'basePath' => '@app/themes/' . $theme,
                'baseUrl' => '@webapp/themes/' . $theme,
            ]);
            return true;
        } else {
            return false;
        }
    }

    public static function getMenu($roleID)
    {
        $roleID = $roleID == 'superAdmin'?'admin':$roleID;
        $menu = [
            /* ADMIN MENU */
            'admin' => [
                [
                    'label' => '<i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">داشبورد</span>',
                    'url' => ['/admin'],
                ],
                "<li class='m-menu__section'><h4 class='m-menu__section-text'>منوی مدیریت</h4><i class='m-menu__section-icon flaticon-more-v3'></i></li>",
                [
                    'label' => '<i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">آیتم ها</span>',
                    'items' => [
                        ['label' => 'مدیریت صفحات', 'url' => ['/page/index']],
                        ['label' => 'مدیریت اسلاید', 'url' => ['/slide/index']],
                        ['label' => 'مدیریت اشخاص', 'url' => ['/person/index']],
                        ['label' => 'مدیریت بیمه ها', 'url' => ['/insurance/index']],
                    ]
                ],
                [
                    'label' => '<i class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">دسته بندی ها</span>',
                    'items' => [
                        ['label' => 'مدیریت منو', 'url' => ['/menu/index']],
                        ['label' => 'دسته بندی اخبار و مقالات', 'url' => ['/menu/index']],
                    ]
                ],
                [
                    'label' => '<i class="m-menu__link-icon flaticon-logout"></i><span class="m-menu__link-text text-danger">خروج</span>',
                    'url' => ['/admin/logout']
                ]
            ],

            /* GUEST MENU */
            'guest' => [
                "<li class='m-menu__section'><h4 class='m-menu__section-text'>ورود به سامانه مدیریت</h4><i class='m-menu__section-icon flaticon-more-v3'></i></li>",
                [
                    'label' => '<i class="m-menu__link-icon flaticon-imac"></i><span class="m-menu__link-text">ورود</span>',
                    'url' => ['/admin'],
                ]
            ],

        ];
        return isset($menu[$roleID])?$menu[$roleID]:$menu['guest'];
    }
}


function dd($vars)
{
    $args = func_get_args();
    echo Html::beginTag('pre', ['class' => 'xdebug-var-dump', 'dir' => 'ltr']);
    foreach ($args as $arg) {
        var_dump($arg);
        echo "\n";
    }
    echo Html::endTag('pre');
    exit();
}