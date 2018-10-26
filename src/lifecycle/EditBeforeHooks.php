<?php

namespace think\bit\lifecycle;

interface EditBeforeHooks
{
    /**
     * 修改前置处理
     * @return boolean
     */
    public function __editBeforeHooks();
}