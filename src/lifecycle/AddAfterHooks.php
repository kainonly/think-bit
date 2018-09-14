<?php

namespace bit\lifecycle;

interface AddAfterHooks
{
    /**
     * TODO:新增后置处理
     * @param string|int $pk 主键
     * @return mixed
     */
    public function __addAfterHooks($pk);
}