<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 * @property $short_description
 * @property $body
 * @property $catID
 */
class Gallery extends Item
{
    const TYPE_PICTURE_GALLERY = 1;
    const TYPE_VIDEO_GALLERY = 2;

    public static $modelName = 'gallery';

    public static $typeLabels = [
        self::TYPE_PICTURE_GALLERY => 'Picture Gallery',
        self::TYPE_VIDEO_GALLERY => 'Video Gallery'
    ];

    public function getTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->type;
        return Yii::t('words', ucfirst(self::$typeLabels[$type]));
    }

    public static function getTypeLabels()
    {
        $lbs = [];
        foreach (self::$typeLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'short_description' => ['CHAR', ''],
            'body' => ['CHAR', ''],
            'catID' => ['INTEGER', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['short_description'], 'required'],
            [['short_description'], 'string', 'max' => 255],
            [['body'], 'string', 'max' => 1024],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
//            [['catID'], 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['catID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'short_description' => Yii::t('words', 'Short Description'),
            'body' => Yii::t('words', 'Description'),
            'catID' => Yii::t('words', 'Category'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }
}
