<?php

namespace think\bit\facade;

use Ramsey\Uuid\UuidInterface;
use Stringy\Stringy;
use think\Facade;

/**
 * Class Str
 * @method static Stringy stringy($str = '', $encoding = null)
 * @method static UuidInterface uuid()
 * @package think\bit\facade
 */
final class Ext extends Facade
{
    protected static function getFacadeClass()
    {
        return 'ext';
    }
}