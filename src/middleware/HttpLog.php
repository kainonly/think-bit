<?php

namespace think\bit\middleware;

use think\bit\facade\Rabbit;
use think\facade\Config;
use think\Request;

class HttpLog
{
    public function handle(Request $request, \Closure $next)
    {
        $publish = Config::get('log.publish');
        Rabbit::start(function () use ($request, $publish) {
            Rabbit::publish([
                'publish' => $publish,
                'time' => time(),
                'data' => [
                    'user' => $request->user,
                    'role' => $request->role,
                    'url' => Request::url(),
                    'method' => Request::method(),
                    'param' => Request::param(),
                    'ip' => Request::server('REMOTE_ADDR'),
                    'user_agent' => Request::server('HTTP_USER_AGENT')
                ],
            ], [
                'exchange' => 'sys.log.http',
            ]);
        }, [
            'virualhost' => '/'
        ]);
        return $next($request);
    }
}