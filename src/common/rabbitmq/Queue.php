<?php

namespace think\bit\common\rabbitmq;

use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class Queue
 * @package think\bit\common\rabbitmq
 * @property AMQPChannel $channel 信道
 * @property string $name 队列名称
 */
final class Queue extends Type
{
    /**
     * 声明队列
     * @param array $config 操作配置
     * @return mixed|null
     */
    public function create(array $config = [])
    {
        $config = array_merge([
            'passive' => false,
            'durable' => false,
            'exclusive' => false,
            'auto_delete' => true,
            'nowait' => false,
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_declare(
            $this->name,
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
     * @param string $exchange 交换器名称
     * @param array $config 操作配置
     * @return mixed|null
     */
    public function bind($exchange, array $config = [])
    {
        $config = array_merge([
            'routing_key' => '',
            'nowait' => false,
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_bind(
            $this->name,
            $exchange,
            $config['routing_key'],
            $config['nowait'],
            $config['arguments'],
            $config['ticket']
        );
    }

    /**
     * 解除绑定
     * @param string $exchange 交换器名称
     * @param array $config 操作配置
     * @return mixed
     */
    public function unbind($exchange, array $config = [])
    {
        $config = array_merge([
            'routing_key' => '',
            'arguments' => [],
            'ticket' => null
        ], $config);

        return $this->channel->queue_unbind(
            $this->name,
            $exchange,
            $config['routing_key'],
            $config['arguments'],
            $config['ticket']
        );
    }

    /**
     * 清除队列
     * @param array $config 操作配置
     * @return mixed|null
     */
    public function purge(array $config = [])
    {
        $config = array_merge([
            'nowait' => false,
            'ticket' => null
        ], $config);

        return $this->channel->queue_purge(
            $this->name,
            $config['nowait'],
            $config['ticket']
        );
    }

    /**
     * 删除队列
     * @param array $config 操作配置
     * @return mixed|null
     */
    public function delete(array $config = [])
    {
        $config = array_merge([
            'if_unused' => false,
            'if_empty' => false,
            'nowait' => false,
            'ticket' => null
        ], $config);

        return $this->channel->queue_delete(
            $this->name,
            $config['if_unused'],
            $config['if_empty'],
            $config['nowait'],
            $config['ticket']
        );
    }

    /**
     * 获取队列信息
     * @param array $config 操作配置
     * @return mixed
     */
    public function get(array $config = [])
    {
        $config = array_merge([
            'no_ack' => false,
            'ticket' => null
        ], $config);

        return $this->channel->basic_get(
            $this->name,
            $config['no_ack'],
            $config['ticket']
        );
    }
}