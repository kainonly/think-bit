<?php

namespace think\bit\facade;

use think\Facade;

/**
 * Class Jwt
 * @method static boolean|string setToken(string $scene, array $symbol = [])
 * @method static boolean|string verify(string $scene, string $token)
 * @package think\bit\facade
 */
final class Jwt extends Facade
{
    protected static function getFacadeClass()
    {
        return 'jwt';
    }
}