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
 * @property string $icon_hover
 * @property string $icon
 * @property string $short_description
 *
 */
class OnlineService extends Menu
{
    public static $typeName = self::TYPE_ONLINE;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'icon' => ['CHAR', ''],
            'hover_icon' => ['CHAR', ''],
            'short_description' => ['CHAR', ''],
        ]);
    }


    public function rules()
    {
        return array_merge(Category::rules(), [
            [['menu_type', 'page_id'], 'integer'],
            [['external_link'], 'url'],
            [['action_name', 'external_link', 'icon', 'hover_icon', 'short_description'], 'string'],
            ['type', 'default', 'value' => self::$typeName],
            ['content', 'default', 'value' => 1]
        ]);
    }

    public function behaviors()
    {
        return [];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'hover_icon' => Yii::t('words', 'Hover icon'),
            'icon' => Yii::t('words', 'Icon'),
            'short_description' => Yii::t('words', 'Short Description'),
        ]);
    }
}