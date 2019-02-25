<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 */
class Page extends \app\models\Item
{
    public static $modelName = 'page';

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
        self::$dynaDefaults = array_merge(parent::$dynaDefaults, [
            'body' => ['CHAR', ''],
            'image' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['body', 'image'], 'required'],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'body' => Yii::t('words', 'Body'),
            'image' => Yii::t('words', 'Image'),
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
