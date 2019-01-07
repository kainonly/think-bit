<?php

namespace think\bit\lifecycle;

interface GetBeforeHooks
{
    /**
     * 单点数据获取前置处理
     * @return boolean
     */
    public function __getBeforeHooks();
}