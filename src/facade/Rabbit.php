<?php

namespace think\bit\facade;

use PhpAmqpLib\Channel\AMQPChannel;
use think\bit\common\BitRabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
use think\bit\common\rabbitmq\Exchange;
use think\bit\common\rabbitmq\Queue;
use think\Facade;
use Closure;

/**
 * Class Rabbit
 * @method static void start(Closure $closure) 创建信道
 * @method static AMQPChannel channel() 获取信道
 * @method static AMQPMessage message(string|array $text = '', array $config = []) 创建消息
 * @method static void publish(string|array $text = '', array $config = []) 发布消息
 * @method static void ack(string $delivery_tag, $multiple = false) 确认信息
 * @method static Exchange exchange(string $exchange) 交换器操作
 * @method static Queue queue(string $queue) 队列操作
 * @package bit\facade
 */
class Rabbit extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRabbitMQ::class;
    }
}