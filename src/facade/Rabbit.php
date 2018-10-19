<?php

namespace bit\facade;

use bit\common\BitRabbitMQ;
use Closure;
use Symfony\Component\Cache\Traits\RedisTrait;
use think\Facade;

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