<?php

namespace think\bit\middleware;

use think\bit\facade\Rabbit;
use think\facade\Config;
use think\Request;

class SystemLog
{
    public function handle(Request $request, \Closure $next)
    {
        if (strpos($request->action(), 'valided') !== false) return $next($request);
        $config = Config::get('queue.daq');
        $exchange = $config['exchange'];
        $queue = $config['queue'];
        $appid = Config::get('app.app_id');
        Rabbit::start(function () use ($appid, $exchange, $queue, $request) {
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
                'appid' => $appid,
                'namespace' => 'system',
                'data' => [
                    'user' => $request->user,
                    'role' => $request->role,
                    'symbol' => $request->symbol,
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'param' => $request->post(),
                    'ip' => $request->server('REMOTE_ADDR'),
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'create_time' => time()
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