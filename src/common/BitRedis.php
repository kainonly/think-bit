<?php

namespace think\bit\common;

use Predis\Client;
use Predis\Pipeline\Pipeline;
use Predis\Transaction\MultiExec;
use think\bit\facade\Redis;

/**
 * Class BitCache
 * @package think\bit\common
 * @property string $key 缓存键
 * @property Client|Pipeline|MultiExec $redis Predis Client
 */
abstract class BitRedis
{
    protected $key;
    protected $redis;

    public function __construct($redis = null)
    {
        $this->redis = ($redis) ? $redis : Redis::client();
    }
}