<?php

declare (strict_types=1);

namespace think\bit\service;

use think\bit\common\OssFactory;
use think\Service;

final class OssService extends Service
{
    public function register()
    {
        $this->app->bind('oss', function () {
            $config = $this->app->config
                ->get('aliyun');

            return new OssFactory($config);
        });
    }
}