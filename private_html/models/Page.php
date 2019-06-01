<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 * @property $body
 *
 */
class Page extends Item
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
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
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
            [['body'], 'required'],
            [['image'], 'string'],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
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


    public static function getList()
    {
        return ArrayHelper::map(Page::find()->valid()->all(), 'id', 'name');
    }

    public function getUrl()
    {
        return Url::to(['/page/show', 'id' => $this->id, 'title' => self::encodeUrl($this->name)]);
    }
}
