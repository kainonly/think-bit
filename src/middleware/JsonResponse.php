<?php

declare (strict_types=1);

namespace think\bit\middleware;

use think\Request;
use think\Response;

/**
 * 返回 JSON 中间件
 * Class JsonResponse
 * @package think\bit\middleware
 */
class JsonResponse
{
    public function handle(Request $request, \Closure $next)
    {
        /**
         * @var $response Response
         */
        $response = $next($request);
        $data = $response->getData();
        return (is_array($data) || is_object($data)) ? json($data) : $response;
    }
}