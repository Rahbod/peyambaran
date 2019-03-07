<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 3/6/2019
 * Time: 9:03 PM
 */

namespace app\components\customWidgets;

use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Json;

class CustomCheckboxColumn extends CheckboxColumn
{
    public $cssClass = 'm-checkable';
    public $disabled = false;

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content !== null) {
            return parent::renderDataCellContent($model, $key, $index);
        }

        if ($this->checkboxOptions instanceof \Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }

        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }

        if ($this->cssClass !== null) {
            Html::addCssClass($options, $this->cssClass);
        }
        return '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand'.($this->disabled?' disabled':'').'">'.
                    Html::checkbox(isset($options['name'])?$options['name']:$this->name, !empty($options['checked']), $options).'<span></span>
                </label>';
    }
}