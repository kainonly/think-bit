<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\ElasticFactory;
use think\Service;

final class ElasticService extends Service
{
    public function register()
    {
        $this->app->bind('elastic', function () {
            $config = $this->app->config
                ->get('elastic');

            return new ElasticFactory($config);
        });
    }
}