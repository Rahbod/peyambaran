<?php
/**
 * Created by PhpStorm.
 * User: y_mobasheri
 * Date: 2/20/2019
 * Time: 11:10 AM
 */

namespace app\components;

use yii\web\UrlManager;

class MultilingualUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        $params = (array)$params;
        $language = isset($params['lang']) ? $params['lang'] : false;
        unset($params['lang']);

        if (!$language) {
            if (\Yii::$app->session->has('language'))
                $language = \Yii::$app->session->get('language');
            else if (isset(\Yii::$app->request->cookies['language']))
                $language = \Yii::$app->request->cookies['language']->value;
        }

        $route = trim($params[0], '/');
        if ($language)
            $route = "$language/$route";
        $params[0] = $route;
        return parent::createUrl($params);
    }
}