<?php

namespace app\components;

/**
 * Class MultiLangActiveQuery
 * @package app\components
 *
 * @property DynamicActiveRecord $modelClass
 */
class MultiLangActiveQuery extends DynamicActiveQuery
{
    /**
     * {@inheritdoc}
     * @return DynamicActiveRecord[]|array
     */
    public function all($db = null)
    {
        $class = $this->modelClass;
        $field = $class::columnGetString('lang');
        $this->andWhere([
            $field => \Yii::$app->language
        ]);
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DynamicActiveRecord|array|null
     */
    public function one($db = null)
    {
        $class = $this->modelClass;
        $field = $class::columnGetString('lang');
        $this->andWhere([
            $field => \Yii::$app->language
        ]);
        return parent::one($db);
    }
}