<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface ListsBeforeHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface ListsBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function listsBeforeHooks(): bool;
}