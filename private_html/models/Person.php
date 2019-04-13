<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 * @property string $firstname
 * @property string $surename
 * @property string $avatar
 * @property int $expertise
 * @property int $experience
 * @property string $resume
 * @property string $link
 *
 */
class Person extends Item
{
    const TYPE_DOCTOR = 1;
    const TYPE_PERSONAL = 2;

    public static $modelName = 'person';

    public static $typeLabels = [
        self::TYPE_DOCTOR => 'doctor',
        self::TYPE_PERSONAL => 'personal'
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
            'firstname' => ['CHAR', ''],
            'surename' => ['CHAR', ''],
            'avatar' => ['CHAR', ''],
            'expertise' => ['INTEGER', ''],
            'experience' => ['INTEGER', ''],
            'resume' => ['CHAR', ''],
            'link' => ['CHAR', ''],
            'medical_number' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['expertise'], 'required'],
            [['expertise', 'experience'], 'integer'],
            [['avatar', 'link', 'resume', 'firstname', 'surename', 'medical_number'], 'string'],
            [['type'], 'default', 'value' => self::TYPE_DOCTOR],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => Yii::t('words', 'Full Name'),
            'firstname' => Yii::t('words', 'First Name'),
            'surename' => Yii::t('words', 'Sure Name'),
            'avatar' => Yii::t('words', 'Avatar'),
            'expertise' => Yii::t('words', 'Expertise'),
            'experience' => Yii::t('words', 'Experience'),
            'resume' => Yii::t('words', 'Resume'),
            'link' => Yii::t('words', 'Link'),
            'medical_number' => Yii::t('words', 'Medical system number'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }

    public function getExpertiseLabel()
    {
        return $this->expertise ? Category::findOne($this->expertise) : null;
    }

    public static function getWithType($type)
    {
        return self::find()->valid()->andWhere(['type' => $type])->orderBy(['name' => SORT_ASC])->all();
    }


    public $programRelModel = null;
    public function getProgramRel($dayID)
    {
        if (!$this->programRelModel)
            $this->programRelModel = $this->hasOne(PersonProgramRel::className(), ['personID' => 'id'])->andWhere(['dayID' => $dayID])->one();
        return $this->programRelModel;
    }

    /**
     * @param int $until
     * @return array|ClinicProgram[]
     */
    public function getVisitDays($until = 7)
    {
        $now = strtotime(date('Y/m/d 00:00:00', time()));
        $aweek = $now + $until * 24 * 60 * 60;

        return ClinicProgram::find()
            ->alias('t')
            ->select(['t.*'])
            ->innerJoinWith('personsRel')
            ->andWhere(['person_program_rel_.personID' => $this->id])
            ->andWhere(['>=', 'date', $now])
            ->andWhere(['<=', 'date', $aweek])
            ->all();
    }
}
