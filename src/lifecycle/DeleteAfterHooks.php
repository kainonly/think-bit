<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface DeleteAfterHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface DeleteAfterHooks
{
    /**
     * 后置处理
     * @return bool
     */
    public function deleteAfterHooks(): bool;
}