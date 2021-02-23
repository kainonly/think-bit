<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface AddBeforeHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface AddBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function addBeforeHooks(): bool;
}