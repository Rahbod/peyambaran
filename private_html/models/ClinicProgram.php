<?php

namespace app\models;

use Yii;
use app\components\DynamicActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clinic_program".
 *
 * @property int $id
 * @property int $date
 * @property resource $dyna
 * @property string $created
 * @property string $userID
 *
 * @property PersonProgramRel $day
 */
class ClinicProgram extends DynamicActiveRecord
{
    public $doctors = [];
    public $csv_file;
    public $excel_file;
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
            [['date'], 'unique'],
            [['dyna'], 'string'],
            [['is_holiday'], 'integer'],
            [['doctors'], 'safe'],
            [['is_holiday'], 'default', 'value' => 1],
            [['created'], 'string', 'max' => 20],
            [['csv_file', 'excel_file'], 'string'],
            [['userID'], 'default', 'value' => Yii::$app->user->id],
            [['created'], 'default', 'value' => time()],
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
            'userID' => Yii::t('words', 'Creator'),
            'doctors' => Yii::t('words', 'Doctors'),
            'csv_file' => Yii::t('words', 'Csv File'),
            'excel_file' => Yii::t('words', 'Excel File'),
        ]);
    }

    public function getLastDay()
    {
        /** @var $last ClinicProgram */
        $today = strtotime(date("Y-m-d 00:00:00", time()));
        $last = self::find()->orderBy(['id' => SORT_DESC])->one();
        if ($last) {
            if ($last->date >= $today) {
                $lastDate = $last->date;
                return (string)($lastDate + (24 * 60 * 60));
            } else
                return $today;
        }
        return (string)$today;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    public function getPersonsRel()
    {
        return $this->hasMany(PersonProgramRel::className(), ['dayID' => 'id'])->orderBy(['start_time' => SORT_ASC]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // save relations

        if ($this->is_holiday && !$this->isNewRecord)
            PersonProgramRel::deleteAll(['dayID' => $this->id]);

        if (!$this->is_holiday && $this->doctors) {
            // delete old relations
            if (!$this->isNewRecord)
                PersonProgramRel::deleteAll(['dayID' => $this->id]);
            // save news
            foreach ($this->doctors as $relID => $doctor) {
                if (!isset($doctor['personID']))
                    continue;

                $model = new PersonProgramRel();
                $model->dayID = $this->id;
                $model->personID = $doctor['personID'];
                $model->start_time = $doctor['start_time'];
                $model->end_time = $doctor['end_time'];
                $model->description = $doctor['description'];
                $model->alternative_personID = $doctor['alternative_personID'];
                if (@$model->save())
                    unset($this->doctors[$relID]);
                else
                    $this->addErrors($model->errors);
            }
        }
    }
}
