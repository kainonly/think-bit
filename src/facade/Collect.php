<?php

namespace think\bit\facade;

use think\bit\common\BitCollect;
use think\Facade;

/**
 * Class Collect
 * @method static void push(string $motivation, array $data = [], array $time_field = []) 信息收集推送
 * @package bit\facade
 */
final class Collect extends Facade
{
    protected static function getFacadeClass()
    {
        return BitCollect::class;
    }
}