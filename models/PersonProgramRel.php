<?php

namespace app\models;

use Yii;
use \app\components\CustomActiveRecord;

/**
 * This is the model class for table "person_program_rel".
 *
 * @property int $dayID
 * @property int $personID
 * @property string $start_time
 * @property string $end_time
 * @property string $description
 */
class PersonProgramRel extends CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person_program_rel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dayID', 'personID'], 'required'],
//            [['dayID', 'personID'], 'unique'],
            [['dayID', 'personID'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['description'], 'string', 'max' => 1024],
            [['dayID', 'personID'], 'unique', 'targetAttribute' => ['dayID', 'personID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dayID' => Yii::t('words', 'Day ID'),
            'personID' => Yii::t('words', 'Person ID'),
            'start_time' => Yii::t('words', 'Start Time'),
            'end_time' => Yii::t('words', 'End Time'),
            'description' => Yii::t('words', 'Description'),
        ];
    }
}
