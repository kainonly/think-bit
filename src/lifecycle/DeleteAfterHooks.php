<?php

namespace think\bit\lifecycle;

interface DeleteAfterHooks
{
    /**
     * 删除后置处理
     * @return mixed
     */
    public function __deleteAfterHooks();
}