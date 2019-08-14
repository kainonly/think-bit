<?php

declare (strict_types=1);

namespace think\bit\common;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use SecurityLib\Strength;
use Stringy\Stringy;

/**
 * 字符串处理类
 * Class StrFactory
 * @package think\bit\common
 */
final class StrFactory
{
    /**
     * 初始化 Stringy
     * @param string $str
     * @param null $encoding
     * @return Stringy
     */
    public function data($str = '', $encoding = null)
    {
        return Stringy::create($str, $encoding);
    }

    /**
     * 随机字符串
     * @param int $length 长度
     * @return string
     */
    public function random(int $length = 8)
    {
        $factory = new \RandomLib\Factory;
        $strength = new Strength(Strength::MEDIUM);
        $generator = $factory->getGenerator($strength);
        return $generator->generateString($length);
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