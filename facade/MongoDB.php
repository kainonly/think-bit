<?php

namespace bit\facade;

use bit\common\BitMongoDB;
use think\Facade;

/**
 * Class Redis
 * @method static \MongoDB\Collection mgo($collection)
 * @package bit\facade
 */
class MongoDB extends Facade
{
    protected static function getFacadeClass()
    {
        return BitMongoDB::class;
    }
}