<?php

namespace think\bit\middleware;

use think\Request;

class OnlyPostRequest
{
    public function handle(Request $request, \Closure $next)
    {
        return $request->isPost() ? $next($request) : json([
            'error' => 1,
            'msg' => 'this method is not supported'
        ]);
    }
}
