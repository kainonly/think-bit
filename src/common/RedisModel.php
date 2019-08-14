<?php

declare (strict_types=1);

namespace think\bit\common;

use Predis\Client;
use Predis\Pipeline\Pipeline;
use Predis\Transaction\MultiExec;

/**
 * 缓存模型抽象类
 * Class RedisModel
 * @package think\bit\common
 */
abstract class RedisModel
{
    /**
     * 缓存模型键值
     * @var string
     */
    protected $key;

    /**
     * Predis 操作类
     * @var Client|Pipeline|MultiExec
     */
    protected $redis;

    /**
     * 构造处理
     * RedisModel constructor.
     * @param Client|Pipeline|MultiExec|null $redis
     */
    public function __construct($redis = null)
    {
        $this->redis = ($redis) ? $redis : app('redis');
    }
}