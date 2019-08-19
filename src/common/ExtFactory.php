<?php

declare (strict_types=1);

namespace think\bit\common;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Stringy\Stringy;

/**
 * 扩展处理类
 * Class StrFactory
 * @package think\bit\common
 */
final class ExtFactory
{
    /**
     * @param string $str
     * @param null $encoding
     * @return Stringy
     */
    public function stringy($str = '', $encoding = null)
    {
        return Stringy::create($str, $encoding);
    }

    /**
     * 生成 UUID Version4
     * @return UuidInterface
     * @throws \Exception
     */
    public function uuid()
    {
        return Uuid::uuid4();
    }
}