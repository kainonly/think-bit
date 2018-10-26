<?php

namespace think\bit\lifecycle;

interface AddBeforeHooks
{
    /**
     * 新增前置处理
     * @return boolean
     */
    public function __addBeforeHooks();
}