<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 */
class Menu extends Category
{
    const MENU_TYPE_PAGE_LINK = 1;
    const MENU_TYPE_ACTION = 2;
    const MENU_TYPE_EXTERNAL_LINK = 3;

    public static $typeName = self::TYPE_MENU;

    public static $menuTypeLabels = [
        self::MENU_TYPE_PAGE_LINK => 'Page Link',
        self::MENU_TYPE_ACTION => 'Action',
        self::MENU_TYPE_EXTERNAL_LINK => 'External Link',
    ];

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
            'content' => ['INTEGER', ''],
            'menu_type' => ['INTEGER', ''],
            'link' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['content', 'default', 'value' => 0]
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
            'content' => Yii::t('words', 'Content'),
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

    public static function parents()
    {
        $parents = [];
        $roots = self::find()->roots()->all();
        foreach ($roots as $root) {
            $parents[$root->id] = $root->name;
            $childrens = $root->children(1)->all();
            if ($childrens) {
                foreach ($childrens as $children)
                    $parents[$children->id] = "$root->name/$children->name";
            }
        }
        return $parents;
    }


    public function getMenuTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->type;
        return Yii::t('words', ucfirst(self::$menuTypeLabels[$type]));
    }

    public static function getMenuTypeLabels()
    {
        $lbs = [];
        foreach (self::$menuTypeLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }
}