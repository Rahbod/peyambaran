<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/23/2019
 * Time: 1:05 AM
 */

namespace app\components\customWidgets;


use dosamigos\tinymce\TinyMce;

class CustomTinyMce extends TinyMce
{
    public $language = 'fa';
    public $clientOptions = [
        'rtl' => true,
        'image_title' => true,
        'automatic_uploads' => true,
        'file_picker_types' => 'file image',
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste",
            "image imagetools",
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ];

    public function init()
    {
        $this->clientOptions['file_picker_callback'] = new \yii\web\JsExpression("function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                  var file = this.files[0];
                
                  var reader = new FileReader();
                  reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                  };
                  reader.readAsDataURL(file);
                };
                input.click();
            }");

        $this->clientOptions['images_upload_url'] = \yii\helpers\Url::to(['/editor_uploader.php']);
        parent::init();
    }
}