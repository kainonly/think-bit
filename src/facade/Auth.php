<?php

namespace think\bit\facade;

use think\Facade;

/**
 * Class Auth
 * @method static mixed symbol(string $scene)
 * @method static bool set(string $scene, array $symbol)
 * @method static bool|string verify(string $scene)
 * @method static void clear(string $scene)
 * @package think\bit\facade
 */
final class Auth extends Facade
{
    protected static function getFacadeClass()
    {
        return 'auth';
    }
}