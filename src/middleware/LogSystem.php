<?php

namespace think\bit\middleware;

use think\bit\facade\Rabbit;
use think\facade\Config;
use think\Request;

class LogSystem
{
    public function handle(Request $request, \Closure $next)
    {
        $publish = Config::get('log.publish');
        $exchange = Config::get('log.exchange');
        $queue = Config::get('log.queue');
        Rabbit::start(function () use ($publish, $exchange, $queue, $request) {
            Rabbit::exchange($exchange)->create('direct', [
                'durable' => true,
                'auto_delete' => false,
            ]);
            $queue = Rabbit::queue($queue);
            $queue->create([
                'durable' => true,
                'auto_delete' => false,
            ]);
            $queue->bind($exchange);
            Rabbit::publish([
                'publish' => $publish,
                'time' => time(),
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
                'exchange' => $exchange,
            ]);
        }, [
            'virualhost' => '/'
        ]);
        return $next($request);
    }
}