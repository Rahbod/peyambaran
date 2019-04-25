<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 */
class Department extends Category
{
    public static $multiLanguage = false;
    public static $typeName = self::TYPE_DEPARTMENT;

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
            'en_name' => ['CHAR', ''],
            'ar_name' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['en_name','ar_name'], 'string'],
            ['type', 'default', 'value' => self::$typeName],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'en_name' => Yii::t('words', 'En Name'),
            'ar_name' => Yii::t('words', 'Ar Name'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentQuery(get_called_class());
    }
}
