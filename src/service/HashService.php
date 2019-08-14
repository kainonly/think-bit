<?php

declare (strict_types=1);

namespace think\bit\service;

use Predis\Client;
use think\bit\common\HashFactory;
use think\facade\Config;
use think\Service;

final class HashService extends Service
{
    public function register()
    {
        $this->app->bind('hash', function () {
            $type = $this->app
                ->make('config')
                ->get('app.app_hash');

            return new HashFactory($type);
        });
    }
}