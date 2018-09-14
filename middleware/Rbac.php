<?php

namespace bit\middleware;

use think\Request;

class Rbac
{
    public function handle(Request $request, \Closure $next)
    {
        return $next($request);
    }
}