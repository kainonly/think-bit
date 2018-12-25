<?php

namespace think\bit\facade;

use think\bit\common\BitCipher;
use think\Facade;

/**
 * Class Redis
 * @method static Encrypt(string $context) 加密明文
 * @method static Decrypt(string $secret) 解密密文
 * @method static EncryptArray(Array $data) 加密数组为密文
 * @method static DecryptArray(string $secret) 解密密文为数组
 * @package bit\facade
 */
class Cipher extends Facade
{
    protected static function getFacadeClass()
    {
        return BitCipher::class;
    }
}