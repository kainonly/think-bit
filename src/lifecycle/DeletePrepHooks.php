<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface DeletePrepHooks
 * @package think\bit\lifecycle
 */
interface DeletePrepHooks
{
    /**
     * 事务开始之后与数据删除之前的处理
     * @return bool
     */
    public function deletePrepHooks(): bool;
}