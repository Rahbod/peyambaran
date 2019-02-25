<?php

namespace app\models;

use Yii;
use \app\components\MultiLangActiveRecord;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int $userID Book creator
 * @property int $modelID
 * @property string $type
 * @property string $name عنوان
 * @property resource $dyna All fields
 * @property string $extra JSON array keeps all other options
 * @property string $created
 * @property int $status
 *
 * @property Catitem[] $catitems
 * @property User $user
 * @property Model $model
 */
abstract class Item extends MultiLangActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    public static $modelName = null;

    public function init()
    {
        $this->status = 1;
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['userID', 'modelID', 'status'], 'integer'],
            [['type'], 'number'],
            [['dyna', 'extra'], 'string'],
            [['name'], 'string', 'max' => 511],
            [['created'], 'string', 'max' => 20],
            ['created', 'default', 'value' => time()],
            ['userID', 'default', 'value' => Yii::$app->user->getId()],
            ['status', 'default', 'value' => self::STATUS_PUBLISHED],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            [['modelID'], 'exist', 'skipOnError' => true, 'targetClass' => Model::className(), 'targetAttribute' => ['modelID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'userID' => Yii::t('words', 'Creator'),
            'modelID' => Yii::t('words', 'Model'),
            'type' => Yii::t('words', 'Type'),
            'name' => Yii::t('words', 'Name'),
            'dyna' => Yii::t('words', 'All fields'),
            'extra' => Yii::t('words', 'Extra'),
            'created' => Yii::t('words', 'Created'),
            'status' => Yii::t('words', 'Status'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'modelID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatitems()
    {
        return $this->hasMany(Catitem::className(), ['itemID' => 'id']);
    }

    public static function getStatusLabels($status = null)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (is_null($status))
            return $statusLabels;
        return $statusLabels[$status];
    }

    public static function getStatusFilter()
    {
        $statusLabels = [
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        return $statusLabels;
    }
}
