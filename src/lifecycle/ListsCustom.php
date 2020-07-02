<?php
declare (strict_types=1);

namespace think\bit\lifecycle;

use think\Collection;

/**
 * Interface ListsCustom
 * @package think\bit\lifecycle
 */
interface ListsCustom
{
    /**
     * 自定义返回
     * @param Collection $lists
     * @param int $total
     * @return array
     */
    public function listsCustomReturn(Collection $lists, int $total): array;
}