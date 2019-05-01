<?php

namespace app\models;

use Yii;
use app\controllers\CooperationController;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "user_request".
 *
 * @property int $cooperation_type
 * @property int $family
 * @property int $father_name
 * @property int $gender
 * @property int $birth_day
 * @property int $avatar
 * @property int $national_code
 * @property int $passport_id
 * @property int $issued
 * @property int $postal_code
 * @property int $city
 * @property int $area
 * @property int $email
 *
 * @property User $user
 */
class Cooperation extends UserRequest
{
    const COOPERATION_TYPE_OFFICIAL = 1;
    const COOPERATION_TYPE_ASSISTANCE = 2;
    const COOPERATION_TYPE_MEDICAL = 3;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public static $typeName = self::TYPE_COOPERATION;

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
            'cooperation_type' => ['INTEGER', ''],
            'family' => ['CHAR', ''],
            'father_name' => ['CHAR', ''],
            'gender' => ['CHAR', ''],
            'birth_day' => ['CHAR', ''],
            'avatar' => ['CHAR', ''],
            'national_code' => ['CHAR', ''],
            'passport_id' => ['CHAR', ''],
            'issued' => ['CHAR', ''],
            'postal_code' => ['CHAR', ''],
            'city' => ['CHAR', ''],
            'area' => ['CHAR', ''],
            'email' => ['CHAR', ''],
            'edu_history' => ['CHAR', ''],
            'job_history' => ['CHAR', ''],
            'language_level' => ['CHAR', ''],

            // cooperation type official fields
            // cooperation type assistance fields
            'military_status' => ['CHAR', ''],
            'military_date' => ['CHAR', ''],
            'skills' => ['CHAR', ''],
            'activity_requested' => ['CHAR', ''],

            // cooperation type medical fields
            'medical_number' => ['CHAR', ''],
            'work_permits_status' => ['CHAR', ''],
            'work_permits_expire' => ['CHAR', ''],
            'resume' => ['CHAR', ''],
            'activity_date' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['cooperation_type', 'number'],
            [[
                'family',
                'father_name',
                'gender',
                'birth_day',
                'avatar',
                'national_code',
                'passport_id',
                'issued',
                'postal_code',
                'city',
                'area',
                'email',
                'military_status',
                'military_date',
                'activity_requested',
                'medical_number',
                'work_permits_status',
                'work_permits_expire',
                'resume',
                'activity_date'
            ], 'string'],
            [['language_level', 'skills', 'edu_history', 'job_history',], 'safe']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'cooperation_type' => Yii::t('words', 'Cooperation type'),
            'name' => Yii::t('words', 'First Name'),
            'family' => Yii::t('words', 'Sure Name'),
            'father_name' => Yii::t('words', 'Father name'),
            'gender' => Yii::t('words', 'Gender'),
            'birth_day' => Yii::t('words', 'Birthday'),
            'avatar' => Yii::t('words', 'Picture'),
            'national_code' => Yii::t('words', 'National code'),
            'passport_id' => Yii::t('words', 'Passport ID'),
            'issued' => Yii::t('words', 'Issued'),
            'postal_code' => Yii::t('words', 'Postal code'),
            'city' => Yii::t('words', 'City'),
            'area' => Yii::t('words', 'Area'),
            'email' => Yii::t('words', 'Email'),
            'edu_history' => Yii::t('words', 'Education History'),
            'job_history' => Yii::t('words', 'Job History'),
            'language_level' => Yii::t('words', 'Language Level'),
            'military_status' => Yii::t('words', 'Military status'),
            'military_date' => Yii::t('words', 'Military End date'),
            'skills' => Yii::t('words', 'Skills'),
            'activity_requested' => Yii::t('words', 'Type of activity requested'),
            'medical_number' => Yii::t('words', 'Medical number'),
            'work_permits_status' => Yii::t('words', 'Work permits status'),
            'work_permits_issued' => Yii::t('words', 'issuance date'),
            'work_permits_expire' => Yii::t('words', 'expire date'),
            'resume' => Yii::t('words', 'Brief resume'),
            'activity_date' => Yii::t('words', 'Activity start date'),
        ]);
    }

    public function formAttributes()
    {
        return [
            'avatar' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'path' => CooperationController::$avatarPath,
                'filesOptions' => [],
                'options' => [
                    'url' => Url::to(['upload-avatar']),
                    'removeUrl' => Url::to(['delete-avatar']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId(new self(), 'avatar')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.2,
                    ],
                ]
            ],
            'cooperation_type' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => static::getCooperationTypeLabels(),
                'containerCssClass' => 'col-sm-12',
                'options' => ['id' => 'cooperation-type-trigger']
            ],
            'name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'family' => ['type' => static::FORM_FIELD_TYPE_TEXT],

            'father_name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'gender' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => static::getGenderLabels()
            ],
            'birth_day' => ['type' => static::FORM_FIELD_TYPE_DATE],
            'national_code' => ['type' => static::FORM_FIELD_TYPE_TEXT, 'options' => ['maxLength' => 10]],

            'passport_id' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'issued' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'postal_code' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'city' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'area' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'email' => ['type' => static::FORM_FIELD_TYPE_TEXT],
//            'edu_history' => ['CHAR', ''],
//            'job_history' => ['CHAR', ''],
//            'language_level' => ['CHAR', ''],

//            'files' => [
//                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
//                'containerCssClass' => 'col-sm-12',
//                'path' => Attachment::$attachmentPath,
//                'filesOptions' => CooperationController::$attachmentOptions,
//                'options' => [
//                    'url' => Url::to(['upload-attachment']),
//                    'removeUrl' => Url::to(['delete-attachment']),
//                    'sortable' => false, // sortable flag
//                    'sortableOptions' => [], // sortable options
//                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'files')],
//                    'options' => [
//                        'createImageThumbnails' => true,
//                        'addRemoveLinks' => true,
//                        'dictRemoveFile' => 'حذف',
//                        'addViewLinks' => true,
//                        'dictViewFile' => '',
//                        'dictDefaultMessage' => 'جهت آپلود فایل کلیک کنید',
//                        'acceptedFiles' => 'png, jpeg, jpg, pdf, doc, docx',
//                        'maxFiles' => 3,
//                        'maxFileSize' => 0.2,
//                    ],
//                ]
//            ],
        ];
    }

    public static $cooperationTypeLabels = [
        self::COOPERATION_TYPE_OFFICIAL => 'Official',
        self::COOPERATION_TYPE_ASSISTANCE => 'Medical assistance',
        self::COOPERATION_TYPE_MEDICAL => 'Medical',
    ];

    public function getCooperationTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->cooperation_type;
        return Yii::t('words', ucfirst(self::$cooperationTypeLabels[$type]));
    }

    public static function getCooperationTypeLabels()
    {
        $lbs = [];
        foreach (self::$cooperationTypeLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    public static $genderLabels = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];

    public function getGenderLabel($gender = false)
    {
        if (!$gender)
            $gender = $this->gender;
        return Yii::t('words', ucfirst(self::$genderLabels[$gender]));
    }

    public static function getGenderLabels()
    {
        $lbs = [];
        foreach (self::$genderLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    public function getPatientName()
    {
        return "$this->name $this->family";
    }
}