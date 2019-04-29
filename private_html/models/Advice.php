<?php

namespace app\models;

use app\components\MultiLangActiveRecord;
use devgroup\dropzone\UploadedFiles;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_request".
 *
 * @property User $user
 */
class Advice extends UserRequest
{
    public static $typeName = self::TYPE_ADVICE;

    public $files = null;

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

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }
}
