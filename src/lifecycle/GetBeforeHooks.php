<?php

namespace think\bit\lifecycle;

interface GetBeforeHooks
{
    /**
     * 获取单个数据的前置处理
     * @return boolean
     */
    public function __getBeforeHooks();
}