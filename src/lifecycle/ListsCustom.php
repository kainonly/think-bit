<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

/**
 * Interface ListsCustom
 * @package think\bit\lifecycle
 */
interface ListsCustom
{
    /**
     * 自定义返回
     * @param array $lists
     * @param int $total
     * @return array
     */
    public function __listsCustomReturn(array $lists, int $total): array;
}