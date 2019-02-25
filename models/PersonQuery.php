<?php

namespace app\models;

use app\components\MultiLangActiveQuery;

/**
 * This is the ActiveQuery class for [[Item]].
 *
 * @see Item
 */
class PersonQuery extends ItemQuery
{
    protected $languageCondition = false;
}