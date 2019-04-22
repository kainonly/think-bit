<?php

namespace think\bit\common;

use think\bit\facade\Rabbit;
use think\facade\Config;

/**
 * Class BitQueue
 * @package think\bit\common
 */
final class BitQueue
{
    private $appid;
    private $exchange;
    private $queue;

    public function __construct()
    {
        $config = Config::get('queue.daq');
        $this->exchange = $config['exchange'];
        $this->queue = $config['queue'];
        $this->appid = Config::get('app.app_id');
    }

    /**
     * 信息收集推送
     * @param string $namespace 行为命名
     * @param array $data 存储数据
     */
    public function push(string $namespace, array $data = [])
    {
        Rabbit::start(function () use ($namespace, $data) {
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
                'appid' => $this->appid,
                'namespace' => $namespace,
                'data' => $data,
            ], [
                'exchange' => $this->exchange,
            ]);
        }, [
            'virualhost' => '/'
        ]);
    }
}