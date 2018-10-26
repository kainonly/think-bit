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

    protected $message = [
        'page.require' => 'fail:page_require',
        'page.limit.require' => 'fail:page_limit_require',
        'page.limit.number' => 'fail:page_limit_number',
        'page.limit.between' => 'fail:page_limit_between',
        'page.index.require' => 'fail:page_index_require',
        'page.index.number' => 'fail:page_index_number',
        'page.index.between' => 'fail:page_index_between',
        'like.array' => 'fail:like_array'
    ];

    protected $scene = [
        'origin' => ['like'],
        'page' => ['page', 'like']
    ];
}