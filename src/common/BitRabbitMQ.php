<?php

namespace think\bit\common;

use Closure;
use think\bit\common\rabbitmq\Exchange;
use think\facade\Env;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use think\bit\common\rabbitmq\Queue;

/**
 * Class BitRabbitMQ
 * @package think\bit\common
 * @property AMQPStreamConnection $rabbitmq
 * @property AMQPChannel $channel
 */
class BitRabbitMQ
{
    private $rabbitmq;
    private $channel;

    /**
     * 创建信道
     * @param Closure $closure
     */
    public function start(Closure $closure,
                          $channel_id = null,
                          $reply_code = 0,
                          $reply_text = '',
                          $method_sig = array(0, 0))
    {
        $this->rabbitmq = new AMQPStreamConnection(
            Env::get('rabbitmq.hostname', 'localhost'),
            Env::get('rabbitmq.port', 5672),
            Env::get('rabbitmq.username', 'guest'),
            Env::get('rabbitmq.password', 'guest'),
            Env::get('rabbitmq.virualhost', '/')
        );
        $this->channel = $this->rabbitmq->channel($channel_id);
        $closure($this->channel);
        $this->channel->close($reply_code, $reply_text, $method_sig);
        $this->rabbitmq->close($reply_code, $reply_text, $method_sig);
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
     * @param string|array $text 文本
     * @param array $config 配置
     * @return AMQPMessage
     */
    public function message($text = '', array $config = [])
    {
        if (is_array($text)) {
            $body = json_encode($text);
        }
        return new AMQPMessage($body, $config);
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
     * @param bool $multiple 批量处理
     */
    public function ack($delivery_tag, $multiple = false)
    {
        $this->channel->basic_ack($delivery_tag, $multiple);
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
}