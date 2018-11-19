<?php

namespace think\bit\lifecycle;

interface DeletePrepHooks
{
    /**
     * 删除后置处理
     * @return mixed
     */
    public function __deletePrepHooks();
}