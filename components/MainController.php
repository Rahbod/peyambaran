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
}


function dd($vars)
{
    $args = func_get_args();
    echo Html::beginTag('pre',['class' => 'xdebug-var-dump', 'dir' => 'ltr']);
    foreach ($args as $arg){
        var_dump($arg);
        echo "\n";
    }
    echo Html::endTag('pre');
    exit();
}