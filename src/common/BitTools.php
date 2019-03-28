<?php

namespace think\bit\common;

use Ramsey\Uuid\Uuid;

final class BitTools
{
    /**
     * 数组二进制序列化
     * @param array $array
     * @return mixed
     */
    public function pack(array $array)
    {
        return msgpack_pack($array);
    }

    /**
     * 二进制反序列化数组
     * @param $byte
     * @return array
     */
    public function unpack($byte)
    {
        return msgpack_unpack($byte);
    }

    /**
     * 生成uuid
     * @param string $version
     * @return string|null
     */
    public function uuid($version = 'v4', $namespace = null, $name = null)
    {
        try {
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
        } catch (\Exception $e) {
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
    public function orderNumber($service_code, $product_code, $user_code)
    {
        return $service_code . rand(0, 9) . $product_code . time() . rand(0, 99) . $user_code;
    }

    /**
     * 随机数16位
     * @return string
     */
    public function random()
    {
        return \ShortCode\Random::get(16);
    }

    /**
     * 随机数8位
     * @return string
     */
    public function randomShort()
    {
        return \ShortCode\Random::get(8);
    }
}