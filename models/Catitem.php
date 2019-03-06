<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catitem".
 *
 * @property int $itemID
 * @property int $catID
 * @property string $type Some types are defined in list like: 'cat', 'tax'
 * @property int $status
 *
 * @property Item $item
 * @property Category $cat
 */
class Catitem extends ActiveRecord
{
    const TYPE_CATEGORY = 'cat';
    const TYPE_TAXONOMY = 'tax';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemID', 'catID', 'type'], 'required'],
            [['itemID', 'catID', 'status'], 'integer'],
            [['type'], 'string'],
            [['status'], 'default', 'value' => 1],
            [['itemID', 'catID', 'type'], 'unique', 'targetAttribute' => ['itemID', 'catID', 'type']],
            [['itemID'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['itemID' => 'id']],
            [['catID'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['catID' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'itemID' => 'Item I D',
            'catID' => 'Cat I D',
            'type' => 'Some types are defined in list like: \'cat\', \'tax\'',
            'status' => '-1: Suspended
0: Unpublished
1: Published',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'itemID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'catID']);
    }
}
