<?php
/**
 * Created by PhpStorm.
 * User: y_mobasheri
 * Date: 5/6/2019
 * Time: 12:21 PM
 */

namespace app\components;


use linslin\yii2\curl\Curl;

class SmsSender
{
    private static $apiKey = '4C53506D4D337769526D425A4A6651657970446B6476424A754A687553304F67';
    private static $baseUrl = 'https://api.kavenegar.com/v1/';
    private static $verificationTemplate = 'verification';
    private static $afterSignupTemplate = 'aftersignup';
    public static $afterReceptionTemplate = 'visit';
    public static $afterChangeReceptionTemplate = 'visitchange';

    public static function SendVerification($phone, $code)
    {
        return static::Send(static::$verificationTemplate, $phone, $code);
    }

    public static function SendAfterSignup($phone, $username, $password)
    {
        return static::Send(static::$afterSignupTemplate, $phone, $username, $password);
    }

    public static function Send($template, $phone, $token, $token2 = false, $token3 = false)
    {
        $key = static::$apiKey;
        $url = static::$baseUrl . "{$key}/verify/lookup.json";

        $params = [
            'receptor' => is_array($phone) ? implode(',', $phone) : $phone,
            'token' => $token,
            'template' => $template
        ];

        if ($token2)
            $params['token2'] = $token2;
        if ($token3)
            $params['token3'] = $token3;

        try {
            $curl = new Curl();
            $curl->setPostParams($params);
            return @$curl->post($url, false);
        } catch (\Exception $e) {
            if (!is_dir(\Yii::getAlias('@app/logs/')))
                mkdir(\Yii::getAlias('@app/logs/'), 0755, true);
            $date = date('Y-m-d-H:i:s', time());
            $error = "$date : template: $template - {$e->getMessage()}\n";
            @file_put_contents(\Yii::getAlias('@app/logs/sms_logs.log'), $error, FILE_APPEND);
            return false;
        }
    }

}