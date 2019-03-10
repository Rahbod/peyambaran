<?php

namespace app\models;

use app\components\MainController;
use app\controllers\MenuController;
use Yii;
use yii\base\ViewContextInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "category".
 *
 * @property boolean $content
 * @property int $menu_type
 * @property int $page_id
 * @property string $action_name
 * @property string $external_link
 *
 */
class OnlineService extends Menu
{
    public static $typeName = self::TYPE_ONLINE;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['content', 'default', 'value' => 1]
        ]);
    }

    public function behaviors()
    {
        return [];
    }
}