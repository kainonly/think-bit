<?php

namespace think\bit\middleware;

use think\Request;
use think\response\Json;

class Cors
{
    public function handle(Request $request, \Closure $next)
    {
        $cors = config('cors.');
        if (in_array($request->header('origin'), $cors['allow_origin'])) {
            header('Access-Control-Allow-Origin:' . $request->header('origin'));
        }
        if ($cors['withCredentials']) {
            header('Access-Control-Allow-Credentials:true');
        }
        if ($request->isOptions()) header('Access-Control-Max-Age:2592000');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:' . $cors['headers']);
        if (!$request->isPost()) return new Json([]);
        else return $next($request);
    }
}
