<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 */
class Insurance extends Item
{
    const TYPE_OUTPATIENT = 1;
    const TYPE_INPATIENT = 2;

    public static $modelName = 'insurance';

    public static $typeLabels = [
        self::TYPE_OUTPATIENT => 'outpatient',
        self::TYPE_INPATIENT => 'inpatient'
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
            'image' => ['CHAR', ''],
            'code' => ['INTEGER', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['image', 'code'], 'safe'],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'image' => Yii::t('words', 'Logo'),
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
