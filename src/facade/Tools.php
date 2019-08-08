<?php

namespace think\bit\facade;

use Ramsey\Uuid\Uuid;

final class Tools
{
    /**
     * 生成uuid
     * @param string $version
     * @return string|null
     * @throws \Exception
     */
    public static function uuid($version = 'v4', $namespace = null, $name = null)
    {
        switch ($version) {
            case 'v1':
                return Uuid::uuid1()->toString();
            case 'v3':
                if (empty($namespace) || empty($name)) return null;
                return Uuid::uuid3($namespace, $name)->toString();
            case 'v4':
                return Uuid::uuid4()->toString();
            case 'v5':
                if (empty($namespace) || empty($name)) return null;
                return Uuid::uuid5($namespace, $name)->toString();
            default:
                return null;
        }
    }

    /**
     * 生产订单号
     * @param string $service_code 2位业务码
     * @param string $product_code 3位产品码
     * @param string $user_code 4位用户码
     * @return string
     */
    public static function orderNumber($service_code, $product_code, $user_code)
    {
        return $service_code .
            rand(0, 9) .
            $product_code .
            time() .
            rand(0, 99) .
            $user_code;
    }

    /**
     * 随机数16位
     * @return string
     */
    public static function random()
    {
        return \ShortCode\Random::get(16);
    }

    /**
     * 随机数8位
     * @return string
     */
    public static function randomShort()
    {
        return \ShortCode\Random::get(8);
    }
}