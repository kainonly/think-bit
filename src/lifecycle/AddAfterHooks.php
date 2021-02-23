<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface AddAfterHooks
 * @package think\bit\lifecycle
 * @deprecated
 */
interface AddAfterHooks
{
    /**
     * 后置处理
     * @param int|string $id
     * @return bool
     */
    public function addAfterHooks($id): bool;
}