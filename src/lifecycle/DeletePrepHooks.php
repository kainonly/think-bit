<?php

namespace think\bit\lifecycle;

interface DeletePrepHooks
{
    /**
     * 在事务之后模型写入之前的处理
     * @return mixed
     */
    public function __deletePrepHooks();
}