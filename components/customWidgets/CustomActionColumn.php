<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/21/2019
 * Time: 7:40 PM
 */

namespace app\components\customWidgets;


use yii\grid\ActionColumn;
use yii\helpers\Html;

class CustomActionColumn extends ActionColumn
{
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'fas fa-eye text-info');
        $this->initDefaultButton('update', 'far fa-edit text-success');
        $this->initDefaultButton('delete', 'far fa-trash-alt text-danger', [
            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = \Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = \Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = \Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => $iconName]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}