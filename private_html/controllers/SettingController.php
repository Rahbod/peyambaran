<?php

namespace app\controllers;

use app\components\Setting;
use app\components\AuthController;
use yii\helpers\Json;

class SettingController extends AuthController
{
    /**
     * Show setting page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->setTheme("default", ['bodyClass' => 'innerPages']);

        if(\Yii::$app->request->post()) {
            $postData = \Yii::$app->request->post('Setting');

            ## region validation post data
            $config = Setting::getAll();
            ## endregion validation post data

            Setting::createOrUpdateDefaults($config);
            \app\components\dd($postData);
            foreach ($config as $key => $value) {
                if (!isset($postData[$key]))
                    continue;
                if ($postData[$key] && $value != $postData[$key])
                    $config[$key] = $postData[$key];
            }
            if(Setting::setAll($config))
                \Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => \Yii::t('words', 'setting.successMsg')]);
            else
                \Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => \Yii::t('words', 'base.dangerMsg')]);
        }
        $settings = Setting::getAll(true);
        return $this->render('index', compact('settings'));
    }
}
