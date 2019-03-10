<?php

namespace app\components\customWidgets;

use yii\captcha\CaptchaAction;

class CustomCaptchaAction extends CaptchaAction
{
    public function validate($input, $caseSensitive)
    {
        // Skip validation on AJAX requests, as it expires the captcha.
        if (\Yii::$app->request->isAjax) {
            return true;
        }
        return parent::validate($input, $caseSensitive);
    }
}