<?php

namespace think\bit\common;

use Redis;
use Closure;
use think\facade\Config;

final class BitRedis
{
    private $redis;

    public function __construct()
    {
        $config = Config::get('database.redis');
        $this->redis = new Redis();
        $this->redis->connect($config['host'], $config['port']);
        $this->redis->auth($config['password']);
        $this->redis->select($config['database']);
    }

    /**
     * Redis操作类
     * @param null $index 库索引
     * @return Redis
     */
    public function model($index = null)
    {
        if ($index) $this->redis->select($index);
        return $this->redis;
    }

    /**
     * Redis事务处理
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