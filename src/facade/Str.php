<?php

namespace think\bit\facade;

use Ramsey\Uuid\UuidInterface;
use Stringy\Stringy;
use think\Facade;

/**
 * Class Str
 * @method static Stringy data($str = '', $encoding = null)
 * @method static string random(int $length = 8)
 * @method static UuidInterface uuid()
 * @package think\bit\facade
 */
final class Str extends Facade
{
    protected static function getFacadeClass()
    {
        return 'str';
    }
}