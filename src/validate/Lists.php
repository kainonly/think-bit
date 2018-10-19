<?php

namespace think\bit\validate;

use think\Validate;

class Lists extends Validate
{
    protected $rule = [
        'page' => 'require',
        'page.limit' => 'require|number|between:1,50',
        'page.index' => 'require|number|min:1',
        'like' => 'array'
    ];

    protected $scene = [
        'origin' => ['like'],
        'page' => ['page', 'like']
    ];
}