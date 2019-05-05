<?php

namespace app\models;

use app\components\MultiLangActiveRecord;
use app\controllers\AdviceController;
use devgroup\dropzone\UploadedFiles;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "user_request".
 *
 * @property string $family
 * @property string $tell
 * @property string $question
 * @property string $answer
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
            'family' => ['CHAR', ''],
            'tell' => ['CHAR', ''],
            'question' => ['CHAR', ''],
            'answer' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'family', 'tell', 'question'], 'required'],
            [['question', 'answer'], 'string'],
            ['type', 'default', 'value' => self::$typeName],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'name' => Yii::t('words', 'First Name'),
            'family' => Yii::t('words', 'Sure Name'),
            'tell' => Yii::t('words', 'Tell'),
            'question' => Yii::t('words', 'Question'),
            'files' => Yii::t('words', 'Tests result files'),
            'answer' => Yii::t('words', 'Answer'),
        ]);
    }

    public function formAttributes()
    {
        return [
            'name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'family' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'tell' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'question' => [
                'type' => static::FORM_FIELD_TYPE_TEXT_AREA,
                'containerCssClass' => 'col-sm-12',
                'options'=>['rows' => 5]
            ],

            'files' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'path' => Attachment::$attachmentPath,
                'filesOptions' => AdviceController::$attachmentOptions,
                'options' => [
                    'url' => Url::to(['upload-attachment']),
                    'removeUrl' => Url::to(['delete-attachment']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'files')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود فایل ها کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg, pdf, doc, docx',
                        'maxFiles' => 3,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
        ];
    }

    public function getFullName()
    {
        return "$this->name $this->family";
    }
}