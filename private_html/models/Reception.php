<?php

namespace app\models;

use app\components\MultiLangActiveRecord;
use devgroup\dropzone\UploadedFiles;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_request".
 *
 * @property string national_code
 * @property string tell
 * @property string description
 *
 * @property User $user
 */
class Reception extends UserRequest
{
    public static $typeName = self::TYPE_RECEPTION;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_request';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'national_code' => ['CHAR', ''],
            'tell' => ['CHAR', ''],
            'description' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['national_code', 'default', 'value' => self::$typeName],
            ['tell', 'default', 'value' => self::$typeName],
            ['description', 'default', 'value' => self::$typeName],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'national_code' => Yii::t('words', 'National Code'),
            'tell' => Yii::t('words', 'Tell'),
            'description' => Yii::t('words', 'Description'),
            'files'=> Yii::t('words', 'Reception files'),
        ]);
    }
}
