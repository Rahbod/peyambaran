<?php
/**
 * @link https://github.com/tom--/dynamic-ar
 * @copyright Copyright (c) 2015 Spinitron LLC
 * @license http://opensource.org/licenses/ISC
 */

namespace app\components;

use Yii;
use yii\base\Exception;
use yii\base\UnknownPropertyException;
use yii\helpers\Json;

/**
 * MultiLangActiveRecord
 *
 * @property $lang string
 */
abstract class MultiLangActiveRecord extends DynamicActiveRecord
{
    public static $dynaDefaults = [
        'lang' => ['CHAR', ''],
    ];

    public function init()
    {
        parent::init();
        $this->lang = Yii::$app->language;
    }

    public static function find($langFilter = true)
    {
        /** @var $query DynamicActiveQuery */
        $query = Yii::createObject(DynamicActiveQuery::className(), [get_called_class()]);
        if($langFilter)
            $query->where([self::columnGetString('lang') => Yii::$app->language]);
        return $query;
    }
}