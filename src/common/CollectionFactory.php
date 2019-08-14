<?php

declare (strict_types=1);

namespace think\bit\common;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 集合处理类
 * Class CollectionFactory
 * @package think\bit\common
 */
final class CollectionFactory
{
    /**
     * 创建集合
     * @param array $elements 元素
     * @return ArrayCollection
     */
    public function data(array $elements)
    {
        return new ArrayCollection($elements);
    }
}