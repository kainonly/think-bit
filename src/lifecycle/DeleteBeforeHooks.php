<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface DeleteBeforeHooks
 * @package think\bit\lifecycle
 */
interface DeleteBeforeHooks
{
    /**
     * 前置处理
     * @return bool
     */
    public function deleteBeforeHooks(): bool;
}