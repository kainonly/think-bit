<?php

namespace think\bit\common;

use think\Validate;

final class BitValidate
{
    public function run()
    {
        Validate::extend('requireWithout', function ($value, $rule, $data) {
            return array_key_exists($rule, $data) ? true : !empty($value);
        });
    }
}