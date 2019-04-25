<?php

namespace app\models;

use app\components\MainController;
use app\controllers\MenuController;
use Yii;
use yii\base\ViewContextInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "category".
 *
 * @property boolean $content
 * @property int $menu_type
 * @property int $page_id
 * @property string $action_name
 * @property string $external_link
 * @property string $show_in_footer
 *
 */
class Menu extends Category
{
    public static $multiLanguage = true;

    const MENU_TYPE_PAGE_LINK = 1;
    const MENU_TYPE_ACTION = 2;
    const MENU_TYPE_EXTERNAL_LINK = 3;

    public static $typeName = self::TYPE_MENU;

    public static $menuTypeLabels = [
        self::MENU_TYPE_PAGE_LINK => 'Page Link',
        self::MENU_TYPE_ACTION => 'Action',
        self::MENU_TYPE_EXTERNAL_LINK => 'External Link',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'content' => ['INTEGER', ''],
            'menu_type' => ['INTEGER', ''],
            'page_id' => ['INTEGER', ''],
            'action_name' => ['CHAR', ''],
            'external_link' => ['CHAR', ''],
            'show_in_footer' => ['INTEGER', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['menu_type', 'page_id'], 'integer'],
            [['external_link'], 'url'],
            [['action_name', 'external_link'], 'string'],
            [['show_in_footer'], 'safe'],
            ['show_in_footer', 'default', 'value' => 0],
            ['content', 'default', 'value' => 0]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'menu_type' => Yii::t('words', 'Menu Type'),
            'content' => Yii::t('words', 'Content'),
            'page_id' => Yii::t('words', 'Page Name'),
            'action_name' => Yii::t('words', 'Module Name'),
            'show_in_footer' => Yii::t('words', 'Show in footer'),
            'external_link' => Yii::t('words', 'External Link')
        ]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public static function parentsList()
    {
        $parents = [];
        $roots = self::find()->roots()->all();
        foreach ($roots as $root) {
            $parents[$root->id] = $root->name;
            $childrens = $root->children(1)->all();
            if ($childrens) {
                foreach ($childrens as $children)
                    $parents[$children->id] = "$root->name/$children->name";
            }
        }
        return $parents;
    }


    public function getMenuTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->menu_type;
        return $type?Yii::t('words', ucfirst(self::$menuTypeLabels[$type])):'-';
    }

    public static function getMenuTypeLabels()
    {
        $lbs = [];
        foreach (self::$menuTypeLabels as $key => $label)
            $lbs[$key] = Yii::t('words', ucfirst($label));
        return $lbs;
    }

    /**
     * @param $context ViewContextInterface|MainController
     * @param $model Menu
     * @param $attribute string
     * @param $form ActiveForm
     *
     * @return string
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderMenuActionsSelect($context, $model, $attribute, $options = [], $form = false)
    {
        $validControllers = [
            'app\controllers\Controller',
            'app\controllers\PersonController',
            'app\controllers\SiteController',
            'app\controllers\PostController',
        ];
        $controllers = $context->getAllActions([], [], true);
        $controllers = $context->prepareForSelect($controllers);

        $selection = $model->isNewRecord ? null : $model->$attribute;

        Html::addCssClass($options, 'form-control');
        $options['name'] = Html::getInputName($model, $attribute);

        $html = Html::beginTag('div', ['class' => 'form-group m-form__group']);
        if ($form)
            $html .= $form->field($model, $attribute, ['template' => '{label}'])->label();
        $html .= Html::beginTag('select', $options);
        foreach ($controllers as $controller => $actions) {
            $html .= Html::beginTag('optgroup', ['label' => Yii::t('actions', $controller)]);
            $html .= Html::renderSelectOptions($selection, $actions);
            $html .= Html::endTag('optgroup');
        }
        $html .= Html::endTag('select');
        if ($form)
            $html .= $form->field($model, $attribute, ['template' => '{error}'])->error();
        $html .= Html::endTag('div');

        return $html;
    }

    public function getUrl()
    {
        switch ($this->menu_type) {
            case self::MENU_TYPE_PAGE_LINK:
                $page = Page::findOne($this->page_id);
                if (!$page)
                    return '#';
                return $page->getUrl();
            case self::MENU_TYPE_ACTION:
                $url = str_replace('@', '/', $this->action_name);
                return Url::to(["/$url"]);
            case self::MENU_TYPE_EXTERNAL_LINK:
                return $this->external_link;
            default:
                return '#';
        }
    }
}