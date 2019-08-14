<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\StrFactory;
use think\Service;

final class StrService extends Service
{
    public $bind = [
        'str' => StrFactory::class,
    ];
}