<?php

namespace think\bit\facade;

use think\bit\common\BitRabbitMQ;
use think\Facade;
use Closure;

/**
 * Class Rabbit
 * @method static channel(Closure $closure) 创建消息队列通道
 * @package bit\facade
 */
class Rabbit extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRabbitMQ::class;
    }
}