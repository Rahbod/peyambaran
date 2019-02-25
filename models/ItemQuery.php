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
        $this->andWhere([
            'modelID' => Model::findOne(['name' => $this->_modelName])->id
        ]);
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Item|array|null
     */
    public function one($db = null)
    {
        $this->andWhere([
            'modelID' => Model::findOne(['name' => $this->_modelName])->id
        ]);
        return parent::one($db);
    }
}