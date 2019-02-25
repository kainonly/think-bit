<?php

namespace think\bit\facade;

use MongoDB\Database;
use think\bit\common\BitMongo;
use think\Facade;

/**
 * Class Mgo
 * @method static Database Db($database = '') 指向数据库
 * @package bit\facade
 */
final class Mgo extends Facade
{
    protected static function getFacadeClass()
    {
        return BitMongo::class;
    }
}