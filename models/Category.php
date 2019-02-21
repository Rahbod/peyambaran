<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

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
 */
class Category extends \app\components\MultiLangActiveRecord
{
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
        self::$dynaDefaults = array_merge(parent::$dynaDefaults, [

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentID', 'status', 'left', 'right', 'depth', 'tree'], 'integer'],
            [['type', 'name', 'created', 'left', 'right', 'depth'], 'required'],
            [['type', 'dyna', 'extra'], 'string'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parentID' => Yii::t('app', 'Parent I D'),
            'type' => Yii::t('app', 'ENUM:
\'cat\': Category
\'tag\': Tag/Taxonomy
\'lst\': List \'mnu\': Menu'),
            'name' => Yii::t('app', 'Name'),
            'dyna' => Yii::t('app', 'Dyna'),
            'extra' => Yii::t('app', 'Extra'),
            'created' => Yii::t('app', 'Created'),
            'status' => Yii::t('app', '-1: Suspended
0: Unpublished
1: Published'),
            'left' => Yii::t('app', 'Left'),
            'right' => Yii::t('app', 'Right'),
            'depth' => Yii::t('app', 'Depth'),
            'tree' => Yii::t('app', 'Tree'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['cat_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
