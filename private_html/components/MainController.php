<?php

namespace app\components;

use app\models\Advice;
use app\models\Cooperation;
use app\models\Department;
use app\models\Reception;
use app\models\UserRequest;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;
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
    public $headerClass;
    public $theme;
    public $tmpDir = 'uploads/temp';

    public function init()
    {
        parent::init();
        Yii::$app->name = Yii::t('words', 'Payambaran Hospital');
        if (Yii::$app->session->has('language'))
            Yii::$app->language = Yii::$app->session->get('language');
        else if (isset(Yii::$app->request->cookies['language']))
            Yii::$app->language = Yii::$app->request->cookies['language']->value;
    }

    /**
     * Returns actions that excluded from user roles
     * @return array
     */
    public function getMenuActions()
    {
        return [];
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


    public function setTheme($theme, $config = [])
    {
        if ($theme) {
            Yii::$app->view->theme = new \yii\base\Theme([
                'basePath' => '@webroot/themes/' . $theme,
                'baseUrl' => '@web/themes/' . $theme,
            ]);

            foreach ($config as $key => $value)
                $this->$key = $value;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $validClasses
     * @param array $excludeClasses
     * @param bool $menuActions
     * @return array
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public function getAllActions($validClasses = [], $excludeClasses = [], $menuActions = false)
    {
        $excludeClasses = array_merge($excludeClasses, [
            'app\controllers\ApiController',
            'app\controllers\CronController'
        ]);

        $actions = [];
        foreach (glob(Yii::getAlias('@app') . '/controllers/*Controller.php') as $controller) {
            $className = 'app\controllers\\' . basename($controller, '.php');

            if ($validClasses && !in_array($className, $validClasses))
                continue;

            if (!in_array($className, $excludeClasses)) {
                $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);

                preg_match('/(app\\\\controllers\\\\)(\w*)(Controller)/', $className, $matches);
                if (!$matches)
                    continue;

                $class = Yii::$app->createControllerByID(strtolower($matches[2]));

                if ($menuActions) {
                    if (!method_exists($className, 'getMenuActions'))
                        continue;

                    $className = explode('\\', $className);
                    $className = end($className);

                    foreach ($class->getMenuActions() as $key)
                        $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = $key;
                    continue;
                }

                if (!($class instanceof AuthController))
                    continue;

                $unusableClasses = ['yii\web\Controller', 'yii\base\Controller', 'app\components\MainController'];
                foreach ($methods as $method) {
                    if (in_array($method->class, $unusableClasses))
                        continue;

                    $className = StringHelper::basename($method->class);
                    preg_match('/(app\\\\controllers\\\\)(\w*)(Controller)/', $method->class, $matches);
                    if (!$matches)
                        continue;

                    $class = Yii::$app->createControllerByID(strtolower($matches[2]));

                    if (!method_exists($method->class, 'getSystemActions'))
                        continue;

                    $excludeActions = $class->getSystemActions();
                    foreach ($class->getSamePermissions() as $permission => $samePermission) {
                        if (is_string($samePermission))
                            $excludeActions[] = $samePermission;
                        elseif (is_array($samePermission))
                            $excludeActions = array_merge($excludeActions, $samePermission);
                    }

                    if ($method->name == 'actions') {
                        $list = $class->actions();
                        foreach (array_keys($list) as $key) {
                            if (in_array($key, $excludeActions))
                                continue;

                            if (key_exists(lcfirst(substr($className, 0, strpos($className, 'Controller'))), $actions))
                                if (in_array($key, $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))]))
                                    continue;

                            $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = $key;
                        }
                    } elseif (preg_match('/action(\w*)/', $method->name) == 1) {
                        $methodBasename = substr($method->name, 6);
                        $methodBasename = lcfirst($methodBasename);

                        if (in_array($methodBasename, $excludeActions))
                            continue;
                        if (key_exists(lcfirst(substr($className, 0, strpos($className, 'Controller'))), $actions))
                            if (in_array(lcfirst(substr($method->name, 6)), $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))]))
                                continue;

                        $actions[lcfirst(substr($className, 0, strpos($className, 'Controller')))][] = lcfirst(substr($method->name, 6));
                    }
                }
            }
        }

        return $actions;
    }

    /**
     * Prepare input array to show in jsTree widget
     * @param array $array
     * @param null|array $selected
     * @param null|string $parent
     * @return array
     */
    protected function prepareForView($array, $selected = null, $parent = null)
    {
        $temp = [];
        foreach ($array as $key => $value) {
            $node = [
                'name' => is_string($key) ? $key : $parent . '-' . $value,
                'alias' => Yii::t('actions', is_string($key) ? $key : $value),
                'actions' => is_array($value) ? $this->prepareForView($value, $selected, $key) : false,
                'selected' => false,
            ];

            if (!is_null($selected) and !is_array($value) and !is_null($parent))
                if (in_array($parent . ucfirst($value), $selected))
                    $node['selected'] = true;

            $temp[] = $node;
        }
        return $temp;
    }

    public function prepareForSelect($array)
    {
        $temp = [];
        foreach ($array as $controller => $actions) {
            foreach ($actions as $action)
                $temp[$controller][lcfirst($controller) . '@' . $action] = Yii::t('actions', lcfirst($controller) . '.' . $action);
        }
        return $temp;
    }

    public static function getMenu($roleID)
    {
        $roleID = !$roleID ? 'guest' : $roleID;

        switch ($roleID) {
            case 'operator':
                $permissions = [
                    'clinic' => true,
                    'items' => [
                        'person' => true
                    ]
                ];
                $menuName = 'Operator Menu';
                break;
            case 'admin':
            case 'superAdmin':
                $permissions = true;
                $menuName = 'Management Menu';
                break;
            case 'guest':
            default:
                $permissions = [];
                $menuName = 'Guest';
                break;
        }

        $contactLinks = [];
        foreach (Department::find()->valid()->all() as $item) {
            $contactLinks[] = ['label' => "پیام های {$item->name}", 'url' => ['/message/index', 'id' => $item->id]];
        }
        $contactLinks[] = ['label' => 'همه پیام ها', 'url' => ['/message/index']];
        $contactLinks[] = ['label' => 'مدیریت بخش ها', 'url' => ['/message/department']];

        // requests count
        $total_count = UserRequest::find()->andWhere(['status' => UserRequest::STATUS_PENDING])->count();
        $total_count = $total_count>0?'<span class="m-badge m-badge--danger">'.$total_count.'</span>':'';
        $advice_count = Advice::find()->andWhere(['type' => Advice::$typeName, 'status' => UserRequest::STATUS_PENDING])->count();
        $advice_count = $advice_count>0?'<span class="m-badge m-badge--danger">'.$advice_count.'</span>':'';
        $cooperation_count = Cooperation::find()->andWhere(['type' => Cooperation::$typeName, 'status' => UserRequest::STATUS_PENDING])->count();
        $cooperation_count = $cooperation_count>0?'<span class="m-badge m-badge--danger">'.$cooperation_count.'</span>':'';
        $reception_1_count = Reception::find()->andWhere(['type' => Reception::$typeName, 'status' => UserRequest::STATUS_PENDING,
            'reception_type' => Reception::RECEPTION_TYPE_HOSPITALIZATION,
        ])->count();
        $reception_1_count = $reception_1_count>0?'<span class="m-badge m-badge--danger">'.$reception_1_count.'</span>':'';
        $reception_2_count = Reception::find()->andWhere(['type' => Reception::$typeName, 'status' => UserRequest::STATUS_PENDING,
            'reception_type' => Reception::RECEPTION_TYPE_CLINIC,
        ])->count();
        $reception_2_count = $reception_2_count>0?'<span class="m-badge m-badge--danger">'.$reception_2_count.'</span>':'';
        $reception_3_count = Reception::find()->andWhere(['type' => Reception::$typeName, 'status' => UserRequest::STATUS_PENDING,
            'reception_type' => Reception::RECEPTION_TYPE_PARA_CLINIC,
        ])->count();
        $reception_3_count = $reception_3_count>0?'<span class="m-badge m-badge--danger">'.$reception_3_count.'</span>':'';

        $requestLinks =[
            ['label' => 'درخواست بستری '.$reception_1_count, 'url' => ['/reception/hospitalization']],
            ['label' => 'درخواست کلینیک '.$reception_2_count, 'url' => ['/reception/clinic-request']],
            ['label' => 'درخواست پاراکلینیک '.$reception_3_count, 'url' => ['/reception/para-clinic']],
            ['label' => 'درخواست مشاوره '.$advice_count, 'url' => ['/advice/index']],
            ['label' => 'درخواست همکاری '.$cooperation_count, 'url' => ['/cooperation/index']],
        ];

        return [
            [
                'label' => '<i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">' . Yii::t('words', 'Dashboard') . '</span>',
                'url' => ['/admin']
            ],
            "<li class='m-menu__section'><h4 class='m-menu__section-text'>" . Yii::t('words', $menuName) . "</h4><i class='m-menu__section-icon flaticon-more-v3'></i></li>",
            [
                'label' => '<i class="m-menu__link-icon fa fa-calendar-alt"></i><span class="m-menu__link-text">' . Yii::t('words', 'Clinic Program') . '</span>',
                'items' => [
                    ['label' => Yii::t('words', 'Manage Days'), 'url' => ['/clinic/index']],
                    ['label' => Yii::t('words', 'Create New Day'), 'url' => ['/clinic/create']],
                    ['label' => Yii::t('words', 'Import csv'), 'url' => ['/clinic/import-csv-program']],
                    ['label' => Yii::t('words', 'Import excel'), 'url' => ['/clinic/import-excel-program']],
                ],
                'visible' => $permissions === true or isset($permissions['clinic'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-bars"></i><span class="m-menu__link-text">' . Yii::t('words', 'Menus') . '</span>',
                'url' => ['/menu/index'],
                'visible' => $permissions === true or isset($permissions['menu'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-server"></i><span class="m-menu__link-text">' . Yii::t('words', 'Items') . '</span>',
                'items' => [
                    ['label' => Yii::t('words', 'Slides'), 'url' => ['/slide/index'], 'visible' => $permissions === true or isset($permissions['items']['slide'])],
                    ['label' => Yii::t('words', 'Online Services'), 'url' => ['/online/index'], 'visible' => $permissions === true or isset($permissions['items']['online'])],
                    ['label' => Yii::t('words', 'Pages'), 'url' => ['/page/index'], 'visible' => $permissions === true or isset($permissions['items']['page'])],
                    ['label' => Yii::t('words', 'People'), 'url' => ['/person/index'], 'visible' => $permissions === true or isset($permissions['items']['person'])],
                    ['label' => Yii::t('words', 'Posts'), 'url' => ['/post/index'], 'visible' => $permissions === true or isset($permissions['items']['post'])],
                    ['label' => Yii::t('words', 'Insurances'), 'url' => ['/insurance/index'], 'visible' => $permissions === true or isset($permissions['items']['insurance'])],
                ],
                'visible' => $permissions === true or isset($permissions['items'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-images"></i><span class="m-menu__link-text">' . Yii::t('words', 'Gallery') . '</span>',
                'items' => [
                    ['label' => Yii::t('words', 'Picture Gallery'), 'url' => ['/gallery/index'], 'visible' => $permissions === true or isset($permissions['gallery']['picture'])],
                    ['label' => Yii::t('words', 'Video Gallery'), 'url' => ['/gallery/index-video'], 'visible' => $permissions === true or isset($permissions['gallery']['video'])],
                ],
                'visible' => $permissions === true or isset($permissions['gallery'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-th"></i><span class="m-menu__link-text">' . Yii::t('words', 'Categories') . '</span>',
                'url' => ['/category/index'],
                'visible' => $permissions === true or isset($permissions['category'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-comments"></i><span class="m-menu__link-text">' . Yii::t('words', 'Messages') . '</span>',
                'items' => $contactLinks,
                'visible' => $permissions === true or isset($permissions['message'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-users"></i><span class="m-menu__link-text">مدیریت درخواست ها</span>'.$total_count,
                'items' => $requestLinks,
                'visible' => $permissions === true or isset($permissions['user_request'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-users"></i><span class="m-menu__link-text">کاربران</span>',
                'items' => [
                    ['label' => 'مدیریت کاربران', 'url' => ['/user/index']],
                    ['label' => 'افزودن کاربر', 'url' => ['/user/create']],
                    ['label' => 'مدیریت نقش های کاربری', 'url' => ['/role/index'], 'visible' => $permissions === true or isset($permissions['user']['role'])],
                ],
                'visible' => $permissions === true or isset($permissions['user'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-language"></i><span class="m-menu__link-text">مدیریت ترجمه ها</span>',
                'url' => ['/admin/translate'],
                'visible' => $permissions === true or isset($permissions['setting'])
            ],
            [
                'label' => '<i class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-text">' . Yii::t('words', 'Setting') . '</span>',
                'items' => [
                    ['label' => 'تنظیمات عمومی', 'url' => ['/setting/index']],
                    ['label' => 'تنظیمات اسلایدر', 'url' => ['/slide/setting']],
                ],
                'visible' => $permissions === true or isset($permissions['setting'])
            ],
            [
                'label' => '<i class="m-menu__link-icon flaticon-logout"></i><span class="m-menu__link-text text-danger">' . Yii::t('words', 'Logout') . '</span>',
                'url' => ['/admin/logout'],
                'visible' => !Yii::$app->user->isGuest
            ],
            [
                'label' => '<i class="m-menu__link-icon flaticon-imac"></i><span class="m-menu__link-text">' . Yii::t('words', 'Login') . '</span>',
                'url' => ['/admin/login'],
                'visible' => !$permissions
            ]
        ];
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