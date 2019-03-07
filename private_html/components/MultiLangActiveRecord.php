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
        $this->lang = Yii::$app->language;
    }

    public function rules()
    {
        return [
            [['lang'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'lang' => Yii::t('words', 'Lang')
        ];
    }
}