<?php

namespace app\models;

use Yii;
use app\components\DynamicActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clinic_program".
 *
 * @property int $id
 * @property string $date
 * @property resource $dyna
 * @property string $created
 * @property string $userID
 */
class ClinicProgram extends DynamicActiveRecord
{
    public $doctors = [];

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
            [['doctors'], 'safe'],
            [['is_holiday'], 'default', 'value' => 1],
            [['date', 'created'], 'string', 'max' => 20],
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
        ]);
    }

    public function getLastDay()
    {
        /** @var $last ClinicProgram */
        $last = self::find()->orderBy(['id' => SORT_DESC])->one();
        if ($last)
            return '' . strtotime(date("Y-m-d 00:00:00", $last->date) . "+1 day");
        return '' . strtotime(date("Y-m-d 00:00:00", time()));
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }

    public function getPersonRel()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
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
            foreach ($this->doctors as $id => $doctor) {
                if (!isset($doctor['personID']))
                    continue;

                $model = new PersonProgramRel();
                $model->dayID = $this->id;
                $model->personID = $doctor['personID'];
                $model->start_time = $doctor['start_time'];
                $model->end_time = $doctor['end_time'];
                $model->description = $doctor['description'];
                if (@$model->save())
                    unset($this->doctors[$id]);
                else
                    $this->addErrors($model->errors);
            }
        }
    }
}
