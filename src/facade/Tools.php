<?php

namespace think\bit\facade;

use think\bit\common\BitTools;
use think\Facade;

/**
 * Class Redis
 * @method static listToTree($list = [], $pk = 'id', $pid = 'parent', $child = 'children', $root = 0) 把返回的数据集转换成Tree
 * @method static uuid($version = 'v4', $namespace = null, $name = null) 生成uuid
 * @method static random() 随机数16位
 * @method static randomShort() 随机数8位
 * @package bit\facade
 */
class Tools extends Facade
{
    protected static function getFacadeClass()
    {
        return BitTools::class;
    }
}