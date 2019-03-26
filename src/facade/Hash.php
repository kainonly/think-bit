<?php

namespace think\bit\facade;

use think\bit\common\BitHash;
use think\Facade;

/**
 * Class Cipher
 * @method static bool|string make($password, $options = []) 加密密码
 * @method static bool check($password, $hashPassword) 验证密码
 * @package bit\facade
 */
final class Hash extends Facade
{
    protected static function getFacadeClass()
    {
        return BitHash::class;
    }
}