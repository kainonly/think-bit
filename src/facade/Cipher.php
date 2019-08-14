<?php

namespace think\bit\facade;

use think\Facade;

/**
 * Class Cipher
 * @method static string encrypt($context)
 * @method static string|array decrypt(string $ciphertext, bool $auto_conver = true)
 * @package think\bit\facade
 */
final class Cipher extends Facade
{
    protected static function getFacadeClass()
    {
        return 'cipher';
    }
}