<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface OriginListsBeforeHooks
 * @package think\bit\lifecycle
 */
interface OriginListsBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function originListsBeforeHooks(): bool;
}