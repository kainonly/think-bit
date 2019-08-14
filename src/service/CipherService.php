<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\CipherFactory;
use think\Service;

final class CipherService extends Service
{
    public function register()
    {
        $this->app->bind('cipher', function () {
            $config = $this->app
                ->make('config')
                ->get('app');

            return new CipherFactory(
                $config['app_secret'],
                $config['app_id']
            );
        });
    }
}