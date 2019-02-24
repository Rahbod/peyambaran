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
        return parent::all($db);
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
}
