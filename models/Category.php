<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use \app\components\MultiLangActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parentID
 * @property string $type ENUM:
 'cat': Category
 'tag': Tag/Taxonomy
 'lst': List 'mnu': Menu
 * @property string $name
 * @property resource $dyna
 * @property string $extra
 * @property string $created
 * @property int $status -1: Suspended
 0: Unpublished
 1: Published
 * @property int $left
 * @property int $right
 * @property int $depth
 * @property int $tree
 *
 * @property Page[] $pages
 * @property Catitem[] $catitems
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
    const TYPE_EXP = 'exp';

    public static $typeName = null;

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
        $this->status = 1;
        self::$dynaDefaults = array_merge(parent::$dynaDefaults, [

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['parentID', 'status', 'left', 'right', 'depth', 'tree'], 'integer'],
            [['name'], 'required'],
            [['type', 'dyna', 'extra'], 'string'],
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
            'id' => Yii::t('app', 'ID'),
            'parentID' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'dyna' => Yii::t('app', 'Dyna'),
            'extra' => Yii::t('app', 'Extra'),
            'created' => Yii::t('app', 'Created'),
            'status' => Yii::t('app', 'Status'),
            'left' => Yii::t('app', 'Left'),
            'right' => Yii::t('app', 'Right'),
            'depth' => Yii::t('app', 'Depth'),
            'tree' => Yii::t('app', 'Tree'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['cat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatitems()
    {
        return $this->hasMany(Catitem::className(), ['catID' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function getStatusLabels($status = null)
    {
        $statusLabels = [
            self::STATUS_DELETED => 'حذف شده',
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        if (is_null($status))
            return $statusLabels;
        return $statusLabels[$status];
    }

    public static function getStatusFilter()
    {
        $statusLabels = [
            self::STATUS_DISABLED => 'غیرفعال',
            self::STATUS_PUBLISHED => 'منتشر شده',
        ];
        return $statusLabels;
    }
}
