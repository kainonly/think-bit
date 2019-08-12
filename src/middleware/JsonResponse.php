<?php

namespace think\bit\middleware;

use think\Request;
use think\Response;

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