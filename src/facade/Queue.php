<?php

namespace think\bit\facade;

use think\bit\common\BitQueue;
use think\Facade;

/**
 * Class Collect
 * @method static void push(string $namespace, array $data = []) 信息收集推送
 * @package bit\facade
 */
final class Queue extends Facade
{
    protected static function getFacadeClass()
    {
        return BitQueue::class;
    }
}