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

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'body'], 'required'],
            [['type', 'dyna'], 'string'],
            [['name'], 'string', 'max' => 511],
            [['tel'], 'string', 'max' => 15],
            [['body'], 'string', 'max' => 255],
            [['created'], 'string', 'max' => 20],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'name' => Yii::t('words', 'First and Last Name'),
            'type' => Yii::t('words', 'Type'),
            'tel' => Yii::t('words', 'Tell'),
            'body' => Yii::t('words', 'Body'),
            'created' => Yii::t('words', 'Created'),
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
}
