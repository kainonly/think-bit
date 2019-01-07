<?php

namespace think\bit\lifecycle;

interface OriginListsBeforeHooks
{
    /**
     * 列表数据获取前置处理
     * @return boolean
     */
    public function __originListsBeforeHooks();
}