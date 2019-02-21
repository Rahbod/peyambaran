<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/21/2019
 * Time: 8:43 PM
 */

namespace app\components\customWidgets;


use yii\widgets\ActiveForm;

class CustomActiveForm extends ActiveForm
{
    public $errorCssClass = 'error has-danger';
    public $fieldConfig = [
        'template' => "{label}\n{input}\n{hint}\n{error}",
        'labelOptions' => ['class' => 'col-form-label control-label'],
        'inputOptions' => ['class' => 'form-control m-input m-input--solid'],
        'hintOptions' => ['class' => 'm-form__help', 'tag' => 'span'],
        'errorOptions' => ['class' => 'form-control-feedback'],
        'options' => [
            'class' => 'form-group m-form__group'
        ],
    ];
    public $options = ['class' => 'm-form m-form--fit m-form--label-align-right','data-pjax' => false];
}