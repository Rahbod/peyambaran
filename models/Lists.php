<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 */
class Lists extends \app\models\Category
{
    public static $typeName = self::TYPE_LIST;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
        return array_merge(parent::rules(), [
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }
}
