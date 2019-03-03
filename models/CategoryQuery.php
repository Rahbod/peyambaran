<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use app\components\DynamicActiveQuery;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends DynamicActiveQuery
{
    protected $_typeName = null;

    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    public function __construct($modelClass, array $config = [])
    {
        $this->_typeName = $modelClass::$typeName;
        parent::__construct($modelClass, $config);
    }

    /**
     * {@inheritdoc}
     * @return Item[]|array
     */
    public function all($db = null)
    {
        if ($this->_typeName) {
            $this->andWhere([
                'type' => $this->_typeName
            ]);
        }
        $this->orderBySort();
        return parent::all($db);
    }

    public function count($q = '*', $db = null)
    {
        if ($this->_typeName) {
            $this->andWhere([
                'type' => $this->_typeName
            ]);
        }
        return parent::count($q, $db); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     * @return Item|array|null
     */
    public function one($db = null)
    {
        if ($this->_typeName) {
            $this->andWhere([
                'type' => $this->_typeName
            ]);
        }
        return parent::one($db);
    }

    public function valid()
    {
        $this->andWhere(['status' => Category::STATUS_PUBLISHED])->orderBySort();
        return $this;
    }

    public function orderBySort()
    {
        $this->orderBy([Category::columnGetString('sort') => SORT_ASC]);
        return $this;
    }
}
