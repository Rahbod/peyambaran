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
 * @property int $marital_status
 * @property int $children_count
 * @property int $birth_day
 * @property int $avatar
 * @property int $national_code
 * @property int $passport_id
 * @property int $issued
 * @property int $postal_code
 * @property int $city
 * @property int $area
 * @property int $email
 * @property int $edu_history
 * @property int $job_history
 * @property int $language_level
 * @property int $military_status
 * @property int $military_date
 * @property int $skills
 * @property int $activity_requested
 * @property int $medical_number
 * @property int $work_permits_status
 * @property int $work_permits_expire
 * @property int $resume
 * @property int $resume_file
 * @property int $activity_date
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

    const MARITAL_SINGLE = 1;
    const MARITAL_MARRIED = 2;

    const GRADE_DIPLOMA = 'diploma';
    const GRADE_ASSOCIATE_DEGREE = 'associate_degree';
    const GRADE_BACHELOR = 'bachelor';
    const GRADE_MASTER = 'master';
    const GRADE_DOCTORATE = 'doctorate';
    const GRADE_GENERAL_PRACTITIONER = 'General practitioner';
    const GRADE_EXPERTISE = 'Expertise';
    const GRADE_FELLOWSHIP = 'Fellowship';
    const GRADE_SPECIALTY = 'Specialty';
    const GRADE_PROFESSOR = 'Professor';

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
            'avatar' => ['CHAR', ''],
            'resume_file' => ['CHAR', ''],
            'cooperation_type' => ['INTEGER', ''],
            'family' => ['CHAR', ''],
            'tell' => ['CHAR', ''],
            'father_name' => ['CHAR', ''],
            'gender' => ['CHAR', ''],
            'marital_status' => ['CHAR', ''],
            'children_count' => ['INTEGER', ''],
            'birth_day' => ['CHAR', ''],
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
            'language_cert' => ['CHAR', ''],
            'other_language_cert' => ['CHAR', ''],

            // cooperation type official fields
            // cooperation type assistance fields
            'military_status' => ['CHAR', ''],
            'military_reason' => ['CHAR', ''],
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
            [['cooperation_type', 'family', 'tell'], 'required'],
            ['type', 'default', 'value' => self::$typeName],
            [['cooperation_type', 'tell', 'children_count', 'national_code', 'postal_code', 'medical_number'], 'integer'],
            [['tell'], 'string', 'max' => 11, 'min' => 11],
            [['postal_code'], 'string', 'max' => 10, 'min' => 10],
            [[
                'tell',
                'family',
                'father_name',
                'gender',
                'marital_status',
                'children_count',
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
                'activity_date',
                'language_cert',
                'other_language_cert',
                'military_reason',
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
            'tell' => Yii::t('words', 'Tel'),
            'family' => Yii::t('words', 'Sure Name'),
            'father_name' => Yii::t('words', 'Father name'),
            'gender' => Yii::t('words', 'Gender'),
            'marital_status' => Yii::t('words', 'Marital status'),
            'children_count' => Yii::t('words', 'Number of children'),
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
            'military_reason' => Yii::t('words', 'Military expulsion reason'),
            'military_date' => Yii::t('words', 'Military End date'),
            'skills' => Yii::t('words', 'Skills'),
            'activity_requested' => Yii::t('words', 'Type of activity requested'),
            'medical_number' => Yii::t('words', 'Medical number'),
            'work_permits_status' => Yii::t('words', 'Work permits status'),
            'work_permits_issued' => Yii::t('words', 'issuance date'),
            'work_permits_expire' => Yii::t('words', 'expire date'),
            'resume' => Yii::t('words', 'Brief resume'),
            'resume_file' => Yii::t('words', 'Resume file'),
            'activity_date' => Yii::t('words', 'Activity start date'),
            'language_cert' => Yii::t('words', 'Language certification'),
            'other_language_cert' => Yii::t('words', 'Other language certification'),
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
                'options' => ['id' => 'cooperation-type-trigger', 'prompt' => Yii::t('words', 'Select cooperation type')]
            ],
            'name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'family' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'father_name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'tell' => [
                'type' => static::FORM_FIELD_TYPE_TEXT,
                'options' => ['class' => 'form-control numberFormat', 'maxLength' => 11]
            ],
            'gender' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => static::getGenderLabels()
            ],
            'birth_day' => [
                'type' => static::FORM_FIELD_TYPE_DATE,
                'options' => [
                    'options' => [
                        'format' => 'yyyy/mm/dd',
                        'viewformat' => 'yyyy/mm/dd',
                        'placement' => 'right',
                    ],
                    'htmlOptions' => [
//                        'id' => ,
                        'class' => 'form-control ltr',
                        'autocomplete' => 'off',
//                        'value' => $model->visit_date ? \jDateTime::date('Y/m/d', $model->visit_date) : ''
                    ]
                ]
            ],
            'national_code' => [
                'type' => static::FORM_FIELD_TYPE_TEXT,
                'options' => ['class' => 'form-control numberFormat', 'maxLength' => 10]
            ],

//            'passport_id' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'issued' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'postal_code' => [
                'type' => static::FORM_FIELD_TYPE_TEXT,
                'options' => ['class' => 'form-control numberFormat', 'maxLength' => 10]
            ],
            'city' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'area' => ['type' => static::FORM_FIELD_TYPE_TEXT],
//            'email' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'marital_status' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => static::getMaritalLabels()
            ],
            'children_count' => [
                'type' => static::FORM_FIELD_TYPE_TEXT,
                'options' => ['class' => 'form-control numberFormat']
            ],
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

    public static $maritalLabels = [
        self::MARITAL_SINGLE => 'Single',
        self::MARITAL_MARRIED => 'Married',
    ];

    public function getMaritalLabel($marital = false)
    {
        if (!$marital)
            $marital = $this->marital_status;
        return Yii::t('words', ucfirst(self::$maritalLabels[$marital]));
    }

    public static function getMaritalLabels()
    {
        $lbs = [];
        foreach (self::$maritalLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    public static $gradeLabels = [
        self::GRADE_DIPLOMA => 'Diploma',
        self::GRADE_ASSOCIATE_DEGREE => 'Associate Degree',
        self::GRADE_BACHELOR => 'Bachelor',
        self::GRADE_MASTER => 'Master',
//        self::GRADE_DOCTORATE => 'Doctorate',
    ];

    public static $medicalGradeLabels = [
        self::GRADE_GENERAL_PRACTITIONER => 'General practitioner',
        self::GRADE_EXPERTISE => 'Expertise',
        self::GRADE_FELLOWSHIP => 'Fellowship',
        self::GRADE_SPECIALTY => 'Specialty',
        self::GRADE_PROFESSOR => 'Professor',
    ];


    public function getGradeLabel($grade, $medical = false)
    {
        return Yii::t('words', ucfirst($medical ? self::$medicalGradeLabels[$grade] : self::$gradeLabels[$grade]));
    }

    public static function getGradeLabels($medical = false)
    {
        $lbs = [];
        $list = $medical ? self::$medicalGradeLabels : self::$gradeLabels;
        foreach ($list as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    public function getFullName()
    {
        return "$this->name $this->family";
    }
}