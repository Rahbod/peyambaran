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
class Person extends \app\models\Item
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
        self::$dynaDefaults = array_merge(parent::$dynaDefaults, [
            'firstname' => ['CHAR', ''],
            'surename' => ['CHAR', ''],
            'avatar' => ['CHAR', ''],
            'expertise' => ['INTEGER', ''],
            'experience' => ['INTEGER', ''],
            'resume' => ['CHAR', ''],
            'link' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['avatar', 'expertise'], 'required'],
            [['expertise', 'experience'], 'number'],
            [['avatar', 'link', 'resume', 'firstname', 'surename'], 'string'],
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
}
