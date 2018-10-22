<?php

namespace think\bit\middleware;

use think\Request;
use think\response\Json;

class Cors
{
    public function handle(Request $request, \Closure $next)
    {
        $cors = Config('cors.');
        if (in_array($request->header('origin'), $cors['allow_origin'])) {
            header('Access-Control-Allow-Origin:' . $request->header('origin'));
        }
        if ($cors['with_credentials']) {
            header('Access-Control-Allow-Credentials:true');
        }
        if ($request->isOptions()) header('Access-Control-Max-Age:' . $cors['option_max_age']);
        header('Access-Control-Allow-Methods:' . $cors['methods']);
        header('Access-Control-Allow-Headers:' . $cors['headers']);
        if (!$request->isPost()) return new Json([]);
        else return $next($request);
    }
}
