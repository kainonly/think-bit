<?php

namespace think\bit\lifecycle;

interface DeleteBeforeHooks
{
    /**
     * 删除前置处理
     * @return boolean
     */
    public function __deleteBeforeHooks();
}