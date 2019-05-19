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
    public static $languageCondition = true;

    /**
     * {@inheritdoc}
     * @return DynamicActiveRecord[]|array
     */
    public function all($db = null)
    {
        if (static::$languageCondition) {
            $class = $this->modelClass;
            $field = $class::columnGetString('lang');
            $this->andWhere([
                $field => \Yii::$app->language
            ]);
        }

        return parent::all($db);
    }

    public function count($q = '*', $db = null)
    {
        if (static::$languageCondition) {
            $class = $this->modelClass;
            $field = $class::columnGetString('lang');
            $this->andWhere([
                $field => \Yii::$app->language
            ]);
        }
        return parent::count($q, $db);
    }

    /**
     * {@inheritdoc}
     * @return DynamicActiveRecord|array|null
     */
    public function one($db = null)
    {
//        $class = $this->modelClass;
//        $field = $class::columnGetString('lang');
//        $this->andWhere([
//            $field => \Yii::$app->language
//        ]);
        return parent::one($db);
    }

    public function setLanguageConditionDisable()
    {
        static::$languageCondition = false;
        return $this;
    }
}