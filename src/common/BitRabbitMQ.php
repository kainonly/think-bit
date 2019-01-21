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
     * @param string|array $body 文本
     * @param array $properties
     * @return AMQPMessage
     */
    public function message($body = '', $properties = [])
    {
        if (is_array($body)) {
            $body = json_encode($body);
        }
        return new AMQPMessage($body, $properties);
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