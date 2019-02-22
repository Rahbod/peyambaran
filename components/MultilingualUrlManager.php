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
        $language = isset($params['lang']) ? $params['lang'] : 0;
        unset($params['lang']);

        if ($language !== 0 && $language !== false) {
            $route = trim($params[0], '/');
            $route = "$language/$route";
            $params[0] = $route;
        }

        return parent::createUrl($params);
    }
}