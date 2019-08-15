<?php

declare (strict_types=1);

namespace think\bit\middleware;

use think\Request;

/**
 * 仅允许 POST 请求
 * Class OnlyPostRequest
 * @package think\bit\middleware
 */
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
