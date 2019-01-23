<?php

namespace think\bit\facade;

use think\bit\common\BitCollection;
use think\Facade;

/**
 * Class Collection
 * @package bit\facade
 * @method static BitCollection setData(array $data) 创建集合
 */
final class Collection extends Facade
{
    protected static function getFacadeClass()
    {
        return BitCollection::class;
    }
}