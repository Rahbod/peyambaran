<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 */
class VideoGallery extends Gallery
{
    public static $typeName = self::TYPE_VIDEO_GALLERY;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'image' => ['CHAR', ''],
            'video' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['image', 'video'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'image' => Yii::t('words', 'Poster'),
            'video' => Yii::t('words', 'Video'),
        ]);
    }
}
