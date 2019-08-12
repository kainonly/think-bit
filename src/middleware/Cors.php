<?php

namespace think\bit\middleware;

use think\facade\Config;
use think\Request;

class Cors
{
    public function handle(Request $request, \Closure $next)
    {
        $config = Config::get('cors');
        if (in_array($request->header('origin'), $config['allow_origin'])) {
            header('Access-Control-Allow-Origin:' . $request->header('origin'));
        }

        if ($config['allow_credentials']) {
            header('Access-Control-Allow-Credentials:true');
        }

        if ($request->isOptions()) {
            header('Access-Control-Max-Age:' . $config['option_max_age']);
        }

        header('Access-Control-Allow-Headers:' . $config['headers']);
        if (isset($config['only_post']) &&
            $config['only_post'] &&
            !$request->isPost()) {
            return json([]);
        } else {
            header('Access-Control-Allow-Methods:' . $config['methods']);
            return $next($request);
        }
    }
}
