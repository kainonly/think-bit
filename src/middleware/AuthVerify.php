<?php

declare (strict_types=1);

namespace think\bit\middleware;

use think\bit\facade\Auth;
use think\Request;

/**
 * 授权认证验证中间件
 * Class JsonResponse
 * @package think\bit\middleware
 */
abstract class AuthVerify
{
    /**
     * 场景
     * @var string
     */
    protected $scene;

    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed|\think\response\Json
     */
    public function handle(Request $request, \Closure $next)
    {
        if (empty($this->scene)) {
            return $next($request);
        }

        $result = Auth::verify($this->scene);
        if ($result) {
            return json([
                'error' => 1,
                'msg' => 'token invalid'
            ]);
        } else {
            $this->definedSymbol($request);
            return $next($request);
        }
    }

    protected function definedSymbol(Request $request)
    {
        $symbol = Auth::symbol($this->scene);
        $request->user = $symbol['user'];
        $request->role = $symbol['role'];
    }
}