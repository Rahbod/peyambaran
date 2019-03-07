<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "model".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $extra JSON array to store fields, order of fields and aliases
 *
 * @property Item[] $items
 */
class Model extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['extra'], 'string'],
            [['name', 'alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('words', 'ID'),
            'name' => Yii::t('words', 'Name'),
            'alias' => Yii::t('words', 'Alias'),
            'extra' => Yii::t('words', 'Extra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['modelID' => 'id']);
    }
}
