<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * MultiLangActiveRecord
 *
 * @property $lang string
 */
abstract class MultiLangActiveRecord extends DynamicActiveRecord
{
    public static $multiLanguage = true;

    public static $langArray = [
        'fa' => 'فارسی',
        'ar' => 'عربی',
        'en' => 'انگلیسی',
    ];

    public $dynaDefaults = [
        'lang' => ['CHAR', ''],
    ];

    /**
     * @param $form ActiveForm
     * @param $model DynamicActiveRecord
     * @return mixed
     */
    public static function renderSelectLangInput($form, $model)
    {
        $html = Html::beginTag('div', ['class' => 'row']);
        $html .= Html::beginTag('div', ['class' => 'col-md-4 col-sm-6 col-xs-12']);
        $html .= $form->field($model, 'lang')->dropDownList(self::$langArray, ['class' => 'form-control m-input m-input--solid']);
        $html .= Html::endTag('div');
        $html .= Html::endTag('div');
        return $html;
    }

    public function init()
    {
        parent::init();
        if (static::$multiLanguage) {
            $this->lang = Yii::$app->language;
        } else {
            $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'en_status' => ['INTEGER', ''],
                'ar_status' => ['INTEGER', ''],
            ]);
        }
    }

    public function rules()
    {
        if (static::$multiLanguage)
            return [
                [['lang'], 'required'],
            ];
        return [
            [['en_status', 'ar_status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        if (static::$multiLanguage)
            return [
                'lang' => Yii::t('words', 'Lang')
            ];
        return [
            'en_status' => Yii::t('words', 'En Status'),
            'ar_status' => Yii::t('words', 'Ar Status'),
        ];
    }
}