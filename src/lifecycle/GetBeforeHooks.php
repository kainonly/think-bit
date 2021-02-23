<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface GetBeforeHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface GetBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function getBeforeHooks(): bool;
}