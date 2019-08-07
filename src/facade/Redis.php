<?php

namespace think\bit\facade;

use Predis\Client;
use think\facade\Config;

final class Redis
{
    public static function client($multiple = 'default')
    {
        $parameters = Config::get('database.redis.' . $multiple);
        if (empty($parameters['password'])) unset($parameters['password']);
        return new Client($parameters);
    }
}