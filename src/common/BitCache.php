<?php

namespace think\bit\common;

use think\bit\facade\Redis;

abstract class BitCache
{
    protected $key;
    protected $redis = null;

    public function __construct($mutli)
    {
        $this->redis = ($mutli) ? $mutli : Redis::model();
    }
}