<?php

namespace think\bit\facade;

use think\bit\common\BitTools;
use think\Facade;

/**
 * Class Tools
 * @method static string|null uuid(string $version = 'v4', string $namespace = null, string $name = null) 生成uuid
 * @method static orderNumber(string $service_code, string $product_code, string $user_code) 生成订单号
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