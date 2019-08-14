<?php

namespace think\bit\facade;

use think\Facade;

/**
 * Class Cipher
 * @method static encrypt($context)
 * @method static decrypt(string $ciphertext, bool $is_array = false)
 * @package think\bit\facade
 */
final class Cipher extends Facade
{
    protected static function getFacadeClass()
    {
        return 'cipher';
    }
}