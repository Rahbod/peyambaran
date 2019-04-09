<?php

namespace app\models;

use Yii;
use app\components\CustomActiveRecord;

/**
 * This is the model class for table "person_program_rel_".
 *
 * @property int $id
 * @property int $dayID
 * @property int $personID
 * @property string $start_time
 * @property string $end_time
 * @property string $description
 * @property int $alternative_personID
 *
 * @property ClinicProgram $day
 * @property Item $person
 * @property Item $alternativePerson
 */
class PersonProgramRel extends CustomActiveRecord
{
    public $doctor_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_program_rel_';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['personID', 'start_time', 'end_time'], 'required'],
//            [['dayID'], 'required', 'except' => 'ajax'],
            [['dayID', 'personID', 'alternative_personID'], 'integer'],
            [['start_time', 'end_time', 'doctor_name'], 'safe'],
            [['description'], 'string', 'max' => 1024],
            [['dayID'], 'exist', 'skipOnError' => true, 'targetClass' => ClinicProgram::className(), 'targetAttribute' => ['dayID' => 'id']],
            [['personID'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['personID' => 'id']],
            [['alternative_personID'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['alternative_personID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'dayID' => Yii::t('words', 'Day ID'),
            'personID' => Yii::t('words', 'Person ID'),
            'start_time' => Yii::t('words', 'Start Time'),
            'end_time' => Yii::t('words', 'End Time'),
            'description' => Yii::t('words', 'Description'),
            'alternative_personID' => Yii::t('words', 'Alternative Person ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(ClinicProgram::className(), ['id' => 'dayID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Item::className(), ['id' => 'personID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlternativePerson()
    {
        return $this->hasOne(Item::className(), ['id' => 'alternative_personID']);
    }
}
