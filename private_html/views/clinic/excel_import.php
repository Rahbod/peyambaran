<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use faravaghi\jalaliDatePicker\jalaliDatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ClinicProgram */

$this->title = Yii::t('words', 'Import excel program');
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">' . Yii::t('words', 'Clinic Program') . '</span>', 'url' => ['index'], 'class' => 'm-nav__link'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="m-portlet m-portlet--tab">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = CustomActiveForm::begin([
        'id' => 'clinic-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content">
            <?= $this->render('//layouts/_flash_message') ?>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'date')->widget(jalaliDatePicker::className(), [
                    'options' => array(
                        'format' => 'yyyy/mm/dd',
                        'viewformat' => 'yyyy/mm/dd',
                        'placement' => 'right',
                    ),
                    'htmlOptions' => [
                        'class' => 'form-control m-input m-input--solid',
                        'autocomplete' => 'off'
                    ]
                ]); ?>
            </div>
        </div>

        <?php echo $form->field($model, 'excel_file')->widget(\devgroup\dropzone\DropZone::className(), [
            'url' => Url::to(['upload-excel']),
            'removeUrl' => Url::to(['delete-excel']),
            'storedFiles' => isset($file) ? $file : [],
            'sortable' => false, // sortable flag
            'sortableOptions' => [], // sortable options
            'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId($model, 'excel_file')],
            'options' => [
                'createImageThumbnails' => true,
                'addRemoveLinks' => true,
                'dictRemoveFile' => 'حذف',
                'addViewLinks' => true,
                'dictViewFile' => '',
                'dictDefaultMessage' => 'جهت آپلود فایل کلیک کنید',
                'acceptedFiles' => 'xlsx, xls',
                'maxFiles' => 1,
                'maxFileSize' => 10,
            ],
        ])
            ->hint(Html::a(Yii::t('words', 'Get sample file'),Yii::getAlias('@web/uploads/sample-excel/').\app\components\Setting::get('sampleExcel'),['class' => 'btn btn-primary btn-sm']))
        ?>
        
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(Yii::t('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= Yii::t('words', 'Cancel') ?></button>
        </div>
    </div>
    <?php CustomActiveForm::end(); ?>
    <!--end::Form-->
</div>