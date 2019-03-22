<?php

namespace think\bit\common;

use Closure;
use think\bit\common\rabbitmq\Consumer;
use think\facade\Config;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use think\bit\common\rabbitmq\Queue;
use think\bit\common\rabbitmq\Exchange;

/**
 * Class BitRabbitMQ
 * @package think\bit\common
 * @property AMQPStreamConnection $rabbitmq
 * @property AMQPChannel $channel
 */
final class BitRabbitMQ
{
    private static $default_args = [
        'virualhost' => '/',
        'insist' => false,
        'login_method' => 'AMQPLAIN',
        'login_response' => null,
        'locale' => 'en_US',
        'connection_timeout' => 3.0,
        'read_write_timeout' => 3.0,
        'context' => null,
        'keepalive' => false,
        'heartbeat' => 0,
        'channel_rpc_timeout' => 0.0
    ];

    private $rabbitmq;
    private $channel;

    /**
     * 创建默认信道
     * @param Closure $closure
     * @param array $args 连接参数
     * @param array $config 操作配置
     */
    public function start(Closure $closure, array $args = [], array $config = [])
    {
        // 组合连接参数
        $args = array_merge(BitRabbitMQ::$default_args, Config::get('queue.rabbitmq'), $args);
        // 初始化连接
        $this->createConnection($args);
        // 创建信道
        $this->createChannel($closure, $config);
    }

    /**
     * 创建自定义信道
     * @param Closure $closure
     * @param array $args 连接参数
     * @param array $config 操作配置
     */
    public function connect(Closure $closure, array $args = [], array $config = [])
    {
        // 组合连接参数
        $args = array_merge(BitRabbitMQ::$default_args, $args);
        // 初始化连接
        $this->createConnection($args);
        // 创建信道
        $this->createChannel($closure, $config);
    }

    private function createConnection($args = [])
    {
        $this->rabbitmq = new AMQPStreamConnection(
            $args['hostname'],
            $args['port'],
            $args['username'],
            $args['password'],
            $args['virualhost'],
            $args['insist'],
            $args['login_method'],
            $args['login_response'],
            $args['locale'],
            $args['connection_timeout'],
            $args['read_write_timeout'],
            $args['context'],
            $args['keepalive'],
            $args['heartbeat'],
            $args['channel_rpc_timeout']
        );
    }

    /**
     * 创建信道
     * @param Closure $closure
     * @param array $config 操作配置
     */
    private function createChannel(Closure $closure, $config = [])
    {
        $config = array_merge([
            'transaction' => false,
            'channel_id' => null,
            'reply_code' => 0,
            'reply_text' => '',
            'method_sig' => [0, 0]
        ], $config);

        $this->channel = $this->rabbitmq->channel($config['channel_id']);
        if ($config['transaction']) {
            $this->channel->tx_select();
            $result = $closure($this->channel);
            if ($result) {
                $this->channel->tx_commit();
            } else {
                $this->channel->tx_rollback();
            }
        } else {
            $closure($this->channel);
        }

        $this->channel->close($config['reply_code'], $config['reply_text'], $config['method_sig']);
        $this->rabbitmq->close($config['reply_code'], $config['reply_text'], $config['method_sig']);
    }

    /**
     * 获取连接对象
     * @return AMQPStreamConnection
     */
    public function native()
    {
        return $this->rabbitmq;
    }

    /**
     * 获取信道
     * @return AMQPChannel
     */
    public function channel()
    {
        return $this->channel;
    }

    /**
     * 创建消息对象
     * @param string|array $text 消息
     * @param array $config 配置
     * @return AMQPMessage
     */
    public function message($text = '', array $config = [])
    {
        if (is_array($text)) {
            $text = json_encode($text);
        }
        return new AMQPMessage($text, $config);
    }

    /**
     * 发布消息
     * @param string|array $text 文本
     * @param array $config 配置
     */
    public function publish($text = '', array $config = [])
    {

        $config = array_merge([
            'exchange' => '',
            'routing_key' => '',
            'mandatory' => false,
            'immediate' => false,
            'ticket' => null
        ], $config);

        $this->channel->basic_publish(
            $this->message($text),
            $config['exchange'],
            $config['routing_key'],
            $config['mandatory'],
            $config['immediate'],
            $config['ticket']
        );
    }

    /**
     * 确认消息
     * @param string $delivery_tag 标识
     * @param bool $multiple 批量
     */
    public function ack($delivery_tag, $multiple = false)
    {
        $this->channel->basic_ack($delivery_tag, $multiple);
    }

    /**
     * 拒绝传入的消息
     * @param string $delivery_tag 标识
     * @param bool $requeue 重新发送
     */
    public function reject($delivery_tag, $requeue = false)
    {
        $this->channel->basic_reject($delivery_tag, $requeue);
    }

    /**
     * 拒绝一个或多个收到的消息
     * @param string $delivery_tag 标识
     * @param bool $multiple 批量
     * @param bool $requeue 重新发送
     */
    public function nack($delivery_tag, $multiple = false, $requeue = false)
    {
        $this->channel->basic_nack($delivery_tag, $multiple, $requeue);
    }

    /**
     * 重新发送未确认的消息
     * @param bool $requeue 重新发送
     * @return mixed
     */
    public function revover($requeue = false)
    {
        return $this->channel->basic_recover($requeue);
    }

    /**
     * 交换器操作类
     * @param $exchange
     * @return Exchange
     */
    public function exchange($exchange)
    {
        return new Exchange($this->channel, $exchange);
    }

    /**
     * 队列操作类
     * @param string $queue 队列名称
     * @return Queue
     */
    public function queue($queue)
    {
        return new Queue($this->channel, $queue);
    }

    /**
     * 消费者操作类
     * @param string $consumer 消费者名称
     * @return Consumer
     */
    public function consumer($consumer)
    {
        return new Consumer($this->channel, $consumer);
    }
}