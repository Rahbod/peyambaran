<?php

namespace app\models;

use function app\components\dd;
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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'body'], 'required'],
            [['type', 'dyna', 'email', 'subject'], 'string'],
            [['name'], 'string', 'max' => 511],
            [['tel'], 'string', 'max' => 15],
            [['body'], 'string', 'max' => 255],
            [['created'], 'string', 'max' => 20],
            [['department_id'], 'safe'],
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
}
