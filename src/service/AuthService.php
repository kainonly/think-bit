<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\AuthFactory;
use think\Service;

final class AuthService extends Service
{
    public function register()
    {
        $this->app->bind('auth', function () {
            $config = $this->app->config
                ->get('jwt');

            return new AuthFactory($config);
        });
    }
}