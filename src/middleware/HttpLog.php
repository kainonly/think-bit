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
            Rabbit::exchange('sys.http.log')->create('direct');
            Rabbit::publish([
                'publish' => $publish,
                'time' => $request->time(),
                'data' => [
                    'user' => $request->user,
                    'role' => $request->role,
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'param' => $request->param(),
                    'ip' => $request->server('REMOTE_ADDR'),
                    'user_agent' => $request->server('HTTP_USER_AGENT')
                ],
            ], [
                'exchange' => 'sys.http.log',
            ]);
        }, [
            'virualhost' => '/'
        ]);
        return $next($request);
    }
}