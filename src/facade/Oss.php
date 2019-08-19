<?php

namespace think\bit\facade;

use think\Facade;

/**
 * Class Oss
 * @method static string put(string $name)
 * @package think\bit\facade
 */
final class Oss extends Facade
{
    protected static function getFacadeClass()
    {
        return 'oss';
    }
}