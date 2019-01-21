<?php

namespace think\bit\common\rabbitmq;

use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class Queue
 * @package think\bit\common\rabbitmq
 * @property AMQPChannel $channel 信道
 * @property string $queue 队列名称
 */
class Queue
{
    private $channel;
    private $queue;

    public function __construct(AMQPChannel $channel, $queue)
    {
        $this->channel = $channel;
        $this->queue = $queue;
    }

    /**
     * 声明队列
     * @param array $config 配置数组
     * @return mixed|null
     */
    public function create(array $config = [])
    {
        if (!empty($config)) $config = array_merge([
            'passive' => false,
            'durable' => false,
            'exclusive' => false,
            'auto_delete' => true,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_declare(
            $this->queue,
            $config['passive'],
            $config['durable'],
            $config['exclusive'],
            $config['auto_delete'],
            $config['nowait'],
            $config['arguments'],
            $config['ticket']
        );
    }

    /**
     * 绑定队列
     * @param string $exchange 交换器
     * @param array $config 配置数组
     * @return mixed|null
     */
    public function bind($exchange, array $config = [])
    {
        if (!empty($config)) $config = array_merge([
            'routing_key' => '',
            'nowait' => false,
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_bind(
            $this->queue,
            $exchange,
            $config['routing_key'],
            $config['nowait'],
            $config['arguments'],
            $config['ticket']
        );
    }

    /**
     * 解除绑定
     * @param string $exchange 交换器
     * @param array $config 配置数组
     * @return mixed
     */
    public function unbind($exchange, array $config = [])
    {
        if (!empty($config)) $config = array_merge([
            'routing_key' => '',
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_unbind(
            $this->queue,
            $exchange,
            $config['routing_key'],
            $config['arguments'],
            $config['ticket']
        );
    }

    /**
     * 清除队列
     * @param array $config 配置数组
     * @return mixed|null
     */
    public function purge(array $config = [])
    {
        if (!empty($config)) $config = array_merge([
            'nowait' => false,
            'ticket' => null
        ], $config);

        return $this->channel->queue_purge(
            $this->queue,
            $config['nowait'],
            $config['ticket']
        );
    }

    /**
     * 删除队列
     * @param array $config 配置数组
     * @return mixed|null
     */
    public function delete(array $config = [])
    {
        if (!empty($config)) $config = array_merge([
            'if_unused' => false,
            'if_empty' => false,
            'nowait' => false,
            'ticket' => null
        ], $config);

        return $this->channel->queue_delete(
            $this->queue,
            $config['if_unused'],
            $config['if_empty'],
            $config['nowait'],
            $config['ticket']
        );
    }
}