<?php

namespace think\bit\lifecycle;

interface AddAfterHooks
{
    /**
     * 新增后置处理
     * @param string|int $pk 主键
     * @return mixed
     */
    public function __addAfterHooks($pk);
}