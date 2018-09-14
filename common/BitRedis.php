<?php

namespace bit\common;

use Redis;
use Closure;

class BitRedis
{
    private $redis;

    public function __construct()
    {
        $config = config('redis.');
        $this->redis = new Redis();
        $this->redis->pconnect($config['connect'], $config['port']);
        $this->redis->auth($config['auth']);
        $this->redis->select($config['select']);
    }

    /**
     * TODO:Redis操作类
     * @param null $index 库索引
     * @return Redis
     */
    public function model($index = null)
    {
        if ($index) $this->redis->select($index);
        return $this->redis;
    }

    /**
     * TODO:Redis事务处理
     * @param Closure $closure
     * @return boolean
     */
    public function transaction(Closure $closure)
    {
        $this->redis->multi();
        $result = $closure($this->redis);
        $this->redis->exec();
        return $result;
    }
}