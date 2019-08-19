<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\ExtFactory;
use think\Service;

final class ExtService extends Service
{
    public $bind = [
        'ext' => ExtFactory::class,
    ];
}