<?php

namespace app\models;

use app\components\MultiLangActiveQuery;

/**
 * This is the ActiveQuery class for [[Item]].
 *
 * @see Item
 */
class ItemQuery extends MultiLangActiveQuery
{
    protected $_modelName = null;
    public function __construct($modelClass, array $config = [])
    {
        $this->_modelName = $modelClass::$modelName;
        parent::__construct($modelClass, $config);
    }

    /**
     * {@inheritdoc}
     * @return Item[]|array
     */
    public function all($db = null)
    {
        $this->alias('t')->addSelect('t.*')->joinWith('model')->andWhere([
            'model.name' => $this->_modelName
        ]);
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Item|array|null
     */
    public function one($db = null)
    {
        $this->alias('t')->addSelect('t.*')->joinWith('model')->andWhere([
            'model.name' => $this->_modelName
        ]);
        return parent::one($db);
    }
}