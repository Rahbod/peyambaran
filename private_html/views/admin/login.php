<?php
/* @var $this yii\web\View */
/* @var $model \app\models\LoginForm */

use \app\components\customWidgets\CustomActiveForm;
?>


<div class="m-login__signin">
    <div class="m-login__head">
        <h3 class="m-login__title">ورود به مدیریت</h3>
    </div>

    <?php
    $form = CustomActiveForm::begin([
        'action' => ['/admin/login'],
        'options' => ['class' => 'm-login__form m-form']
    ]);
    ?>
        <?= $form->field($model, 'username')->textInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username')])->label(false)?>

        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control m-input m-login__form-input--last','autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('password')])->label(false)?>

        <div class="row m-login__form-sub">
            <div class="col m--align-left m-login__form-left">
                <label class="m-checkbox  m-checkbox--focus">
                    <input type="checkbox" name="remember"> مرا بخاطر بسپار
                    <span></span>
                </label>
            </div>
        </div>
        <div class="m-login__form-action">
            <?= \yii\helpers\Html::submitButton('ورود', ['class' => 'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary', 'id' => '']) ?>
        </div>
    <?php CustomActiveForm::end() ?>
</div>