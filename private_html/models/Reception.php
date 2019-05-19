<?php

namespace app\models;

use Yii;
use app\controllers\ReceptionController;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "user_request".
 *
 * @property string $reception_type
 * @property string $family
 * @property string $national_code
 * @property string $tell
 * @property string $description
 * @property string $visit_date
 *
 * @property User $user
 */
class Reception extends UserRequest
{
    const RECEPTION_TYPE_HOSPITALIZATION = 1;
    const RECEPTION_TYPE_CLINIC = 2;
    const RECEPTION_TYPE_PARA_CLINIC = 3;

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
            'reception_type' => ['INTEGER', ''],
            'family' => ['CHAR', ''],
            'national_code' => ['CHAR', ''],
            'tell' => ['CHAR', ''],
            'description' => ['CHAR', ''],
            'visit_date' => ['CHAR', ''],
        ]);
    }

    /**
     * @return array
     */
    public function formAttributes()
    {
        return [
            'reception_type' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => static::getReceptionTypeLabels(),
                'containerCssClass' => 'col-sm-12'
            ],
            'name' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'family' => ['type' => static::FORM_FIELD_TYPE_TEXT],
            'national_code' => ['type' => static::FORM_FIELD_TYPE_TEXT, 'options' => ['maxLength' => 10]],
            'tell' => ['type' => static::FORM_FIELD_TYPE_TEXT, 'options' => ['maxLength' => 11]],
            'description' => [
                'type' => static::FORM_FIELD_TYPE_TEXT_AREA,
                'containerCssClass' => 'col-sm-12',
                'options' => [
                    'rows' => 5
                ]
            ],
            'files' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'path' => Attachment::$attachmentPath,
                'filesOptions' => ReceptionController::$attachmentOptions,
                'options' => [
                    'url' => Url::to(['upload-attachment']),
                    'removeUrl' => Url::to(['delete-attachment']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '','id' => Html::getInputId(new self(), 'files')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود فایل کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg, pdf, doc, docx',
                        'maxFiles' => 3,
                        'maxFileSize' => 0.2,
                    ],
                ]
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['family','national_code','tell'], 'required'],
            ['type', 'default', 'value' => self::$typeName],
            [['visit_date', 'family', 'national_code', 'tell', 'description'], 'string'],
            [['tell'], 'string', 'min' => 11, 'max' => 13],
            [['reception_type'], 'integer'],
            [['national_code'], 'checkNationalCode'],
            [['tell'], 'checkTell'],
        ]);
    }

    public function checkTell($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!preg_match('/^09[0-9]{9}+$/', $this->$attribute))
                $this->addError($attribute, Yii::t('words', 'Tel number invalid.'));
        }
    }

    public function checkNationalCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $temp = $this->$attribute;
            $sum = 0;
            $len = 10;
            while (strlen($temp) != 1) {
                $i = substr($temp, 0, 1);
                $temp = substr($temp, 1);
                $sum += $i * $len;
                $len--;
            }
            $controlNumber = (int)$temp;
            $div = (int)$sum % 11;
            $mod = $div < 2 ? $div : 11 - $div;
            if ($controlNumber != $mod)
                $this->addError($attribute, Yii::t('words', 'National code invalid.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'reception_type' => Yii::t('words', 'Reception Type'),
            'name' => Yii::t('words', 'First Name'),
            'family' => Yii::t('words', 'Sure Name'),
            'national_code' => Yii::t('words', 'National Code'),
            'tell' => Yii::t('words', 'Tel'),
            'description' => Yii::t('words', 'Description'),
            'files' => Yii::t('words', 'Reception files'),
            'visit_date' => Yii::t('words', 'Visit date'),
        ]);
    }

    public static $receptionTypeLabels = [
        1  => 'Hospitalization',
        2  => 'Fertility Clinic',
        3  => 'Clinical & Medical Laboratory',
        4  => 'Medical Imaging Center',
        5  => 'Nuclear Medicine',
        6  => 'Endoscopy & Colonoscopy Center',
        7  => 'Physiotherapy & Rehabilitation Clinic',
        8  => 'Dental & Orthodontic Clinic',
        9  => 'Sleep Medicine Clinic',
        10  => 'Wound Care Clinic',
        11 => 'The Lifestyle Health & Beauty Clinic',
    ];

    public function getReceptionTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->reception_type;
        return Yii::t('words', ucfirst(self::$receptionTypeLabels[$type]));
    }

    public static function getReceptionTypeLabels()
    {
        $lbs = [];
        foreach (self::$receptionTypeLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    public function getPatientName()
    {
        return "$this->name $this->family";
    }
}
