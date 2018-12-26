<?php

namespace think\bit\facade;

use think\bit\common\BitCipher;
use think\Facade;

/**
 * Class Cipher
 * @method static string encrypt(string $context) 加密明文
 * @method static string decrypt(string $secret) 解密密文
 * @method static string encryptArray(Array $data) 加密数组为密文
 * @method static array decryptArray(string $secret) 解密密文为数组
 * @package bit\facade
 */
class Cipher extends Facade
{
    protected static function getFacadeClass()
    {
        return BitCipher::class;
    }
}