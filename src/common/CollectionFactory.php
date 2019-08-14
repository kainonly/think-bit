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
    public function data(array $elements)
    {
        return new ArrayCollection($elements);
    }
}