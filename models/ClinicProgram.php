<?php

namespace app\models;

use Yii;
use app\components\DynamicActiveRecord;

/**
 * This is the model class for table "clinic_program".
 *
 * @property int $id
 * @property string $date
 * @property resource $dyna
 * @property string $created
 */
class ClinicProgram extends DynamicActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_program';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'is_holiday' => ['INTEGER', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['date'], 'required'],
            [['dyna'], 'string'],
            [['is_holiday'], 'integer'],
            [['is_holiday'], 'default', 'value' => 1],
            [['date', 'created'], 'string', 'max' => 20],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'date' => Yii::t('words', 'Date'),
            'dyna' => Yii::t('words', 'Dyna'),
            'created' => Yii::t('words', 'Created'),
            'is_holiday' => Yii::t('words', 'Holiday'),
        ]);
    }

    public function getLastDay()
    {
        /** @var $last ClinicProgram */
        $last = self::find()->orderBy(['id' => SORT_DESC])->one();
        if ($last)
            return strtotime(date("Y-m-d 00:00:00", $this->date) . "+1 day");
        return strtotime(date("Y-m-d 00:00:00", time()));
    }
}
