<?php

namespace think\bit\facade;

use think\bit\common\BitRabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
use think\bit\common\rabbitmq\Queue;
use think\Facade;
use Closure;

/**
 * Class Rabbit
 * @method static void channel(Closure $closure) 创建信道
 * @method static AMQPMessage message(string|array $text = '', array $config = []) 创建消息
 * @method static void publish(string|array $text = '', array $config = []) 发布消息
 * @method static Queue queue(string $queue_name) 队列对象
 * @package bit\facade
 */
class Rabbit extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRabbitMQ::class;
    }
}