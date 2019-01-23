<?php

namespace think\bit\facade;

use think\bit\common\BitLists;
use think\Facade;

/**
 * Class Lists
 * @package bit\facade
 * @method static BitLists data(array $lists) 创建列表数组
 */
final class Lists extends Facade
{
    protected static function getFacadeClass()
    {
        return BitLists::class;
    }
}