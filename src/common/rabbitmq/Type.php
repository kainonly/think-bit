<?php

namespace think\bit\common\rabbitmq;

use PhpAmqpLib\Channel\AMQPChannel;

class Type
{
    protected $channel;
    protected $name;

    public function __construct(AMQPChannel $channel, $name)
    {
        $this->channel = $channel;
        $this->name = $name;
    }
}