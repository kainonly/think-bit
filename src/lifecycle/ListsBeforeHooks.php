<?php

namespace think\bit\lifecycle;

interface ListsBeforeHooks
{
    /**
     * 分页数据获取前置处理
     * @return boolean
     */
    public function __listsBeforeHooks();
}