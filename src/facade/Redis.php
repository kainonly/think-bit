<?php

namespace think\bit\facade;

use think\bit\common\BitRedis;
use think\Facade;
use Closure;

/**
 * Class Redis
 * @method static \Redis model($index = null)
 * @method static transaction(Closure $closure)
 * @package bit\facade
 */
class Redis extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRedis::class;
    }
}