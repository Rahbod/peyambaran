<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 */
class Menu extends Category
{
    const MENU_TYPE_LINK = 1;
    const MENU_TYPE_ACTION = 2;
    const MENU_TYPE_EXTERNAL_LINK = 3;

    public static $typeName = self::TYPE_MENU;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'menu_type' => ['INTEGER', 1],
            'link' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'menu_type' => Yii::t('words', 'Menu Type'),
            'link' => Yii::t('words', 'Link'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}