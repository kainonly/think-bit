<?php

namespace think\bit\facade;

use think\bit\common\BitTools;
use think\Facade;

/**
 * Class Tools
 * @method static array listToTree($list = [], $pk = 'id', $pid = 'parent', $child = 'children', $root = 0) 把返回的数据集转换成Tree
 * @method static string|null uuid($version = 'v4', $namespace = null, $name = null) 生成uuid
 * @method static string random() 随机数16位
 * @method static string randomShort() 随机数8位
 * @package bit\facade
 */
final class Tools extends Facade
{
    protected static function getFacadeClass()
    {
        return BitTools::class;
    }
}