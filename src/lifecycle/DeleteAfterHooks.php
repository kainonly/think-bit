<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface DeleteAfterHooks
 * @package think\bit\lifecycle
 */
interface DeleteAfterHooks
{
    /**
     * 后置处理
     * @return bool
     */
    public function __deleteAfterHooks(): bool;
}