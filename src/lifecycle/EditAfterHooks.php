<?php

namespace think\bit\lifecycle;

interface EditAfterHooks
{
    /**
     * 修改后置处理
     * @return mixed
     */
    public function __editAfterHooks();
}