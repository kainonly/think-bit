<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface EditBeforeHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface EditBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function editBeforeHooks(): bool;
}