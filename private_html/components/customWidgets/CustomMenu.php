<?php
/**
 * Created by PhpStorm.
 * User: Yusef
 * Date: 2/22/2019
 * Time: 1:21 AM
 */

namespace app\components\customWidgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class CustomMenu extends Menu
{
    public $menuLinkTemplate = '<a href="javascript:;" class="m-menu__link m-menu__toggle">{label}{caret}</a>';
    public $submenuTemplate = '<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav">{items}</ul></div>';
    public $submenuLinkTemplate = '<a href="{url}" class="m-menu__link"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">{label}</span></a>';
    public $submenuCssClass = 'm-menu__item  m-menu__item--submenu';
    public $submenuLinkCssClass = 'm-menu__link m-menu__toggle';

    public $linkTemplate = '<a href="{url}" class="m-menu__link">{label}</a>';
    public $dropDownCaret = '<i class="m-menu__ver-arrow la la-angle-left"></i>';


    protected function renderItems($items, $submenu = false)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            if (is_array($item)) {
                $class = [];
                if ($item['active']) {
                    $class[] = $this->activeCssClass;
                }
                if ($i === 0 && $this->firstItemCssClass !== null) {
                    $class[] = $this->firstItemCssClass;
                }
                if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                    $class[] = $this->lastItemCssClass;
                }
                Html::addCssClass($options, $class);

                $menu = $this->renderItem($item, $submenu);
                if (!empty($item['items'])) {
                    $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                    $menu .= strtr($submenuTemplate, [
                        '{items}' => $this->renderItems($item['items'], true),
                    ]);
                }
            }else
                $menu = $item;
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    protected function renderItem($item, $submenu = false)
    {
        if (!is_array($item))
            return $item;

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $submenu?$this->submenuLinkTemplate:$this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
            ]);
        }



        if (!empty($item['items'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->menuLinkTemplate);
            return strtr($template, [
                    '{label}' => $item['label'],
                    '{caret}' => $this->dropDownCaret,
                ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);
        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (is_string($item))
                continue;
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof \Closure) {
                $active = $items[$i]['active'] = call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this);
            } elseif ($item['active']) {
                $active = true;
            }
        }

        return array_values($items);
    }
}