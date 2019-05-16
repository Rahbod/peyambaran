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
 * @property string $fellowship
 * @property string $medical_number
 * @property string $priority
 *
 */
class Person extends Item
{
    public static $multiLanguage = false;

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
            'fellowship' => ['INTEGER', ''],
            'priority' => ['INTEGER', ''],

            'en_name' => ['CHAR', ''],
            'ar_name' => ['CHAR', ''],

            'en_resume' => ['CHAR', ''],
            'ar_resume' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['en_name','ar_name', 'en_resume','ar_resume'], 'string'],
            [['expertise'], 'required'],
            [['expertise', 'experience','priority'], 'integer'],
            [['avatar', 'link', 'resume', 'firstname', 'surename', 'medical_number'], 'string'],
            [['type'], 'default', 'value' => self::TYPE_DOCTOR],
            [['fellowship'], 'safe'],
            [['fellowship'], 'default', 'value' => 0],
            [['priority'], 'default', 'value' => 0],
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
            'en_name' => Yii::t('words', 'En Name'),
            'ar_name' => Yii::t('words', 'Ar Name'),
            'en_resume' => Yii::t('words', 'En Resume'),
            'ar_resume' => Yii::t('words', 'Ar Resume'),
            'firstname' => Yii::t('words', 'First Name'),
            'surename' => Yii::t('words', 'Sure Name'),
            'avatar' => Yii::t('words', 'Avatar'),
            'expertise' => Yii::t('words', 'Expertise'),
            'experience' => Yii::t('words', 'Experience'),
            'resume' => Yii::t('words', 'Resume'),
            'link' => Yii::t('words', 'Link'),
            'medical_number' => Yii::t('words', 'Medical system number'),
            'fellowship' => Yii::t('words', 'Fellowship'),
            'priority' => Yii::t('words', 'Priority'),
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
