<?php

namespace think\bit\common;

use Closure;
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
    public function channel(Closure $closure,
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
     * 创建消息对象
     * @param string|array $text 文本
     * @param array $config
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

        dump($config);

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
     * 创建队列对象
     * @param string $queue_name 队列名称
     * @return Queue
     */
    public function queue($queue_name)
    {
        return new Queue($this->channel, $queue_name);
    }
}