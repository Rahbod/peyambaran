<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use richardfan\sortable\SortableAction;
use Yii;
use \app\components\MultiLangActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parentID
 * @property string $type ENUM:
 * 'cat': Category
 * 'tag': Tag/Taxonomy
 * 'lst': List 'mnu': Menu
 * @property string $name
 * @property resource $dyna
 * @property string $extra
 * @property string $created
 * @property int $status
 * @property int $en_status
 * @property int $ar_status
 * @property int $left
 * @property int $right
 * @property int $depth
 * @property int $tree
 * @property int $show_always
 * @property int $show_in_home
 * @property string $fullName
 *
 * @property Page[] $pages
 * @property Catitem[] $catitems
 * @property Item[] $items
 */
class Category extends MultiLangActiveRecord
{
    public static $multiLanguage = false;

    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    const TYPE_CATEGORY = 'cat';
    const TYPE_TAG = 'tag';
    const TYPE_LIST = 'lst';
    const TYPE_MENU = 'mnu';
    const TYPE_DEPARTMENT = 'dep';
    const TYPE_ONLINE = 'onl';

    const CATEGORY_TYPE_NEWS = 'news';
    const CATEGORY_TYPE_PICTURE_GALLERY = 'image_gallery';
    const CATEGORY_TYPE_VIDEO_GALLERY = 'video_gallery';
    const CATEGORY_TYPE_INSURANCE = 'insurance';
    const CATEGORY_TYPE_EXPERTISE = 'expertise';

    public static $typeName = self::TYPE_CATEGORY;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'left',
                'rightAttribute' => 'right',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function init()
    {
        parent::init();
        preg_match('/(app\\\\models\\\\)(\w*)(Search)/', $this::className(), $matches);
        if (!$matches) {
            $this->status = 1;
            $this->en_status = 1;
            $this->ar_status = 1;
        }
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'category_type' => ['CHAR', ''],
            'en_name' => ['CHAR', ''],
            'ar_name' => ['CHAR', ''],
            'sort' => ['INTEGER', ''],
            'show_in_home' => ['INTEGER', ''],
            'show_always' => ['INTEGER', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['parentID', 'status', 'left', 'right', 'depth', 'tree', 'sort'], 'integer'],
            [['name'], 'required'],
            [['en_name', 'ar_name'], 'string'],
            [['sort'], 'required', 'on' => SortableAction::SORTING_SCENARIO],
            [['type', 'dyna', 'extra', 'category_type'], 'string'],
            [['created'], 'safe'],
            ['created', 'default', 'value' => time()],
            [['left', 'right', 'depth', 'tree'], 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_PUBLISHED],
            ['show_in_home', 'default', 'value' => 0],
            ['show_always', 'default', 'value' => 0],
            [['name'], 'string', 'max' => 511],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'parentID' => Yii::t('words', 'Parent ID'),
            'type' => Yii::t('words', 'Type'),
            'category_type' => Yii::t('words', 'Category Type'),
            'name' => Yii::t('words', 'Name'),
            'dyna' => Yii::t('words', 'Dyna'),
            'extra' => Yii::t('words', 'Extra'),
            'created' => Yii::t('words', 'Created'),
            'status' => Yii::t('words', 'Status'),
            'left' => Yii::t('words', 'Left'),
            'right' => Yii::t('words', 'Right'),
            'depth' => Yii::t('words', 'Depth'),
            'tree' => Yii::t('words', 'Tree'),
            'en_name' => Yii::t('words', 'En Name'),
            'ar_name' => Yii::t('words', 'Ar Name'),
            'show_in_home' => 'نمایش در صفحه اصلی',
            'show_always' => 'نمایش ویژه',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parentID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parentID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatitems()
    {
        return $this->hasMany(Catitem::className(), ['catID' => 'id']);
    }


    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'itemID'])
            ->viaTable('catitem', ['catID' => 'id'])->andWhere(['status' => Item::STATUS_PUBLISHED]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function getCategoryTypeLabels()
    {
        $statusLabels = [
            self::CATEGORY_TYPE_NEWS => Yii::t('words', 'News & Articles'),
            self::CATEGORY_TYPE_PICTURE_GALLERY => Yii::t('words', 'Picture Gallery'),
            self::CATEGORY_TYPE_VIDEO_GALLERY => Yii::t('words', 'Video Gallery'),
            self::CATEGORY_TYPE_INSURANCE => Yii::t('words', 'Insurance'),
            self::CATEGORY_TYPE_EXPERTISE => Yii::t('words', 'Expertise'),
        ];
        return $statusLabels;
    }

    public static function getCategoryTypeLabel($status = null)
    {
        return isset(self::getCategoryTypeLabels()[$status]) ? self::getCategoryTypeLabels()[$status] : null;
    }

    public function getStatusLabel($status = null)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'Deleted',
            self::STATUS_DISABLED => 'Disabled',
            self::STATUS_PUBLISHED => 'Published',
        ];
        if (!$status)
            $status = $this->status;
        return Yii::t('words', ucfirst($statusLabels[$status]));
    }

    public static function getStatusLabels($status = null, $html = false)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (is_null($status))
            return $statusLabels;

        if ($html) {
            switch ($status) {
                case self::STATUS_PUBLISHED:
                    $class = 'success';
                    $icon = '<i class="fa fa-check-circle"></i>';
                    break;
                case self::STATUS_DISABLED:
                    $class = 'warning';
                    $icon = '<i class="fa fa-times-circle"></i>';
                    break;
                case self::STATUS_DELETED:
                    $class = 'danger';
                    $icon = '<i class="fa fa-times-circle"></i>';
                    break;
            }
            return "<span class='text-{$class}'>$icon</span>";
        }
        return Yii::t('words', ucfirst($statusLabels[$status]));
    }

    public static function getStatusFilter()
    {
        $statusLabels = [
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        return $statusLabels;
    }

    public function beforeSave($insert)
    {
        if ($insert)
            $this->sort = self::getMaxSort() + 1;
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * Return maximum saved sort
     * @return integer
     */
    public static function getMaxSort()
    {
        return self::find()->max(self::columnGetString('sort'));
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

    public function getFullName()
    {
        if (!$this->parentID)
            return $this->getName();

        $name = $this->getName();
        $parent = $this->getParent()->one();
        while ($parent) {
            $name = "$parent->name/$name";
            $parent = $parent->getParent()->one();
        }
        return $name;
    }

    public static function getWithType($type, $return = 'array', $valid = false)
    {
        $models = self::find()->andWhere([self::columnGetString('category_type') => $type]);
        if ($valid)
            $models = $models->valid();
        $models = $models->all();
        if ($return == 'array')
            return ArrayHelper::map($models, 'id', 'fullName');
        return $models;
    }

    public function getName()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->name;
            else
                return $this->{Yii::$app->language . '_name'} ?: $this->name;
        }
        return $this->name;
    }
}