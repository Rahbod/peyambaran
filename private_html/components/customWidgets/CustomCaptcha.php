<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 3/10/2019
 * Time: 9:33 PM
 */

namespace app\components\customWidgets;


use yii\captcha\Captcha;
use yii\helpers\Html;

class CustomCaptcha extends Captcha
{
    public $template = '{image}{url} {input}';
    public $linkOptions = [];

    public function run()
    {
        if(!isset($this->linkOptions['id']))
            $this->linkOptions['id'] = uniqid();
        if(!isset($this->linkOptions['label']))
            $this->linkOptions['label'] = 'refresh';

        $this->registerClientScript();
        $input = $this->renderInputHtml('text');
        $route = $this->captchaAction;
        if (is_array($route)) {
            $route['v'] = uniqid('', true);
        } else {
            $route = [$route, 'v' => uniqid('', true)];
        }
        $image = Html::img($route, $this->imageOptions);

        $refresh_a = \yii\helpers\Html::a($this->linkOptions['label'], '#', $this->linkOptions);

        echo strtr($this->template, [
            '{input}' => $input,
            '{image}' => $image,
            '{url}' => $refresh_a,
        ]);
    }


    public function registerClientScript()
    {
        $view = $this->getView();
        $view->registerJs(" $('#{$this->linkOptions['id']}').on('click', function(e){ e.preventDefault(); $('#{$this->imageOptions['id']}').yiiCaptcha('refresh'); }) ");
        parent::registerClientScript();
    }
}