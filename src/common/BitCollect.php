<?php

namespace think\bit\common;

use think\bit\facade\Rabbit;
use think\facade\Config;

/**
 * Class BitCollect
 * @package think\bit\common
 */
final class BitCollect
{
    private $authorization;
    private $exchange;
    private $queue;

    public function __construct()
    {
        $config = Config::get('collect.');
        $this->authorization = $config['authorization'];
        $this->exchange = $config['exchange'];
        $this->queue = $config['queue'];
    }

    /**
     * 信息收集推送
     * @param string $motivation 行为命名
     * @param array $data 存储数据
     * @param array $time_field 时间字段
     */
    public function push(string $motivation, array $data = [], array $time_field = [])
    {
        Rabbit::start(function () use ($motivation, $data, $time_field) {
            Rabbit::exchange($this->exchange)->create('direct', [
                'durable' => true,
                'auto_delete' => false,
            ]);
            $queue = Rabbit::queue($this->queue);
            $queue->create([
                'durable' => true,
                'auto_delete' => false,
            ]);
            $queue->bind($this->exchange);
            Rabbit::publish([
                'authorization' => [
                    'appid' => $this->authorization['appid'],
                    'secret' => $this->authorization['secret']
                ],
                'motivation' => $motivation,
                'data' => $data,
                'time_field' => $time_field
            ], [
                'exchange' => $this->exchange,
            ]);
        }, [
            'virualhost' => '/'
        ]);
    }
}