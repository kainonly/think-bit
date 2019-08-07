<?php

namespace think\bit\common;

use think\bit\facade\Redis;

class BitCache
{
    protected $key;
    protected $redis = null;

    public static function create($mutli = null)
    {
        return new BitCache($mutli);
    }

    public function __construct($mutli)
    {
        $this->redis = ($mutli) ? $mutli : Redis::model();
    }
}