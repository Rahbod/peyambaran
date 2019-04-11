<?php

namespace app\models;

use Yii;
use app\components\DynamicActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $name
 * @property string $type Enum: cnt: contact us, sgn: suggestions, cmp: complaints
 * @property string $tel
 * @property string $body
 * @property string $subject
 * @property string $email
 * @property string $department_id
 * @property resource $dyna All fields
 * @property string $created
 * @property int $degree
 */
class Message extends DynamicActiveRecord
{
    const TYPE_CONTACT_US = 'cnt';
    const TYPE_SUGGESTIONS = 'sgn';
    const TYPE_COMPLAINTS = 'cmp';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'subject' => ['CHAR', ''],
            'email' => ['CHAR', ''],
            'department_id' => ['CHAR', ''],
            'degree' => ['CHAR', ''],
            'country' => ['CHAR', ''],
            'city' => ['CHAR', ''],
            'address' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'body'], 'required'],
            [['type', 'dyna', 'email', 'subject', 'country', 'city', 'address'], 'string'],
            [['name'], 'string', 'max' => 511],
            [['tel'], 'string', 'max' => 15],
            [['body'], 'string'],
            [['created'], 'string', 'max' => 20],
            [['department_id'], 'safe'],
            [['degree'], 'string'],
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
            'type' => Yii::t('words', 'Type'),
            'created' => Yii::t('words', 'Created'),
            'name' => Yii::t('words', 'Name and Family'),
            'email' => Yii::t('words', 'Email'),
            'subject' => Yii::t('words', 'Subject'),
            'body' => Yii::t('words', 'Body'),
            'department_id' => Yii::t('words', 'Department ID'),
            'tel' => Yii::t('words', 'Tel'),
            'degree' => Yii::t('words', 'Degree'),
            'country' => Yii::t('words', 'Country'),
            'city' => Yii::t('words', 'City'),
            'address' => Yii::t('words', 'Address'),
        ]);
    }

    public static function getStatusLabels($status = null)
    {
        $statusLabels = [
            self::TYPE_CONTACT_US => 'تماس باما',
            self::TYPE_SUGGESTIONS => 'انتقادات و پیشنهادات',
            self::TYPE_COMPLAINTS => 'شکایات',
        ];
        if (is_null($status))
            return $statusLabels;
        return $statusLabels[$status];
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public static function getDegrees($id = null)
    {
        $degrees = [
            1 => Yii::t('words', 'Diploma'),
            2 => Yii::t('words', 'Associate Degree'),
            3 => Yii::t('words', 'Bachelor'),
            4 => Yii::t('words', 'Senior'),
            5 => Yii::t('words', 'PhD Degree'),
            6 => Yii::t('words', 'Professor'),
        ];
        if (is_null($id))
            return $degrees;
        return $degrees[$id];
    }

    public static function getSubjects($id = null)
    {
        $subjects = [
            1 => Yii::t('words', 'Suggestions'),
            2 => Yii::t('words', 'Critics'),
        ];
        if (is_null($id))
            return $subjects;
        return $subjects[$id];
    }
}
