<?php

namespace bit\common;

use Closure;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class BitRabbitMQ
{
    private $rabbitmq;

    public function __construct()
    {
        $config = config('rabbitmq.');
        $this->rabbitmq = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config['vhost']
        );
    }

    /**
     * TODO:消息队列闭包通道
     * @param Closure $closure
     */
    public function channel(Closure $closure)
    {
        $channel = $this->rabbitmq->channel();
        $closure($channel);
        $channel->close();
        $this->rabbitmq->close();
    }
}