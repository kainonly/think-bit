<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface OriginListsCustom
 * @package think\bit\lifecycle
 */
interface OriginListsCustom
{
    /**
     * 自定义返回
     * @param array $lists
     * @return array
     */
    public function __originListsCustomReturn(array $lists): array;
}