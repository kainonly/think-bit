<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

use think\Collection;

/**
 * Interface OriginListsCustom
 * @package think\bit\lifecycle
 * @deprecated
 */
interface OriginListsCustom
{
    /**
     * 自定义返回
     * @param Collection $lists
     * @return array
     */
    public function originListsCustomReturn(Collection $lists): array;
}