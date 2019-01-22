<?php

namespace think\bit\facade;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use think\bit\common\BitRabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;
use think\bit\common\rabbitmq\Consumer;
use think\bit\common\rabbitmq\Exchange;
use think\bit\common\rabbitmq\Queue;
use think\Facade;
use Closure;

/**
 * Class Rabbit
 * @method static void start(Closure $closure, array $args = [], array $config = []) 创建默认信道
 * @method static void connect(Closure $closure, array $args = [], array $config = []) 创建自定义信道
 * @method static AMQPStreamConnection native() 获取连接
 * @method static AMQPChannel channel() 获取信道
 * @method static AMQPMessage message(string|array $text = '', array $config = []) 创建消息
 * @method static void publish(string|array $text = '', array $config = []) 发布消息
 * @method static void ack(string $delivery_tag, $multiple = false) 确认信息
 * @method static void reject(string $delivery_tag, $requeue = false) 拒绝传入的消息
 * @method static void nack(string $delivery_tag, $multiple = false, $requeue = false) 拒绝一个或多个收到的消息
 * @method static mixed revover($requeue = false) 重新发送未确认的消息
 * @method static Exchange exchange(string $exchange) 交换器操作
 * @method static Queue queue(string $queue) 队列操作
 * @method static Consumer consumer(string $consumer) 消费者操作
 * @package bit\facade
 */
final class Rabbit extends Facade
{
    protected static function getFacadeClass()
    {
        return BitRabbitMQ::class;
    }
}