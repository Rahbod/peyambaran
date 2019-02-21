<?php
namespace app\components;

use app\models\Log;
use yii\base\Behavior;
use yii\web\Controller;

class LogFilter extends Behavior
{
    public $after = [];
    public $before = [];


    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction', Controller::EVENT_AFTER_ACTION => 'afterAction'];
    }

    public function afterAction($event)
    {
        $action = $event->action->id;
        if(!isset($this->after[$action]))
            return;
        $config = $this->after[$action];
        $logAction = isset($config['logAction'])?$config['logAction']:Log::ACTION_GLOBAL;
        $logCode = isset($config['code'])?$config['code']:Log::EVENT_GLOBAL;
        Log::create($logAction, $logCode);
        return;
    }

    public function beforeAction($event)
    {
        $action = $event->action->id;
        if(!isset($this->before[$action]))
            return true;
        $config = $this->before[$action];
        $logAction = isset($config['logAction'])?$config['logAction']:Log::ACTION_GLOBAL;
        $logCode = isset($config['code'])?$config['code']:Log::EVENT_GLOBAL;
        Log::create($logAction, $logCode);
        return true;
    }
}