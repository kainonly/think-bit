<?php

namespace think\bit\facade;

use think\bit\common\BitMongoDB;
use think\Facade;

/**
 * Class Mongo
 * @method static \MongoDB\Collection collection($collection_name)
 * @package bit\facade
 */
class Mongo extends Facade
{
    protected static function getFacadeClass()
    {
        return BitMongoDB::class;
    }
}