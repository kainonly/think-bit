<?php

namespace think\bit\facade;

use think\Facade;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Collection
 * @method static ArrayCollection data($element)
 * @package think\bit\facade
 */
final class Collection extends Facade
{
    protected static function getFacadeClass()
    {
        return 'collection';
    }
}