<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\CollectionFactory;
use think\Service;

final class CollectionService extends Service
{
    public $bind = [
        'collection' => CollectionFactory::class,
    ];
}