<?php

namespace think\bit\facade;

use think\bit\common\BitRedis;
use think\Facade;
use Closure;

/**
 * Class Redis
 * @method static \Redis model($index = null) Redis操作类
 * @method static boolean transaction(Closure $closure) Redis事务处理
 * @package bit\facade
 */
final class Redis extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRedis::class;
    }
}