<?php

namespace app\models;

use function app\components\dd;
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
 * @property int $status -1: Suspended
 * 0: Unpublished
 * 1: Published
 * @property int $left
 * @property int $right
 * @property int $depth
 * @property int $tree
 * @property string $fullName
 *
 * @property Page[] $pages
 * @property Catitem[] $catitems
 * @property Item[] $items
 */
class Category extends MultiLangActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_PUBLISHED = 1;

    const TYPE_CATEGORY = 'cat';
    const TYPE_TAG = 'tag';
    const TYPE_LIST = 'lst';
    const TYPE_MENU = 'mnu';
    const TYPE_DEPARTMENT = 'dep';
    const TYPE_ONLINE = 'online';

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
        if(!$matches)
            $this->status = 1;
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'category_type' => ['CHAR', ''],
            'sort' => ['INTEGER', '']
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
//            [['sort'], 'required', 'on' => SortableAction::SORTING_SCENARIO],
            [['type', 'dyna', 'extra', 'category_type'], 'string'],
            [['created'], 'safe'],
            ['created', 'default', 'value' => time()],
            [['left', 'right', 'depth', 'tree'], 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_PUBLISHED],
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



    public function getItems() {
        return $this->hasMany(Item::className(), ['id' => 'itemID'])
            ->viaTable('catitem', ['catID' => 'id']);
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
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (!$status)
            $status = $this->status;
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
            return $this->name;

        $name = $this->name;
        $parent = $this->getParent()->one();
        while ($parent) {
            $name = "$parent->name/$name";
            $parent = $parent->getParent()->one();
        }
        return $name;
    }

    public static function getWithType($type, $return = 'array')
    {
        $models = self::find()->valid()->andWhere([self::columnGetString('category_type') => $type])->all();
        if ($return == 'array')
            return ArrayHelper::map($models, 'id', 'fullName');
        return $models;
    }
}
