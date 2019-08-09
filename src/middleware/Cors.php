<?php

namespace think\bit\middleware;

use think\Request;

class Cors
{
    public function handle(Request $request, \Closure $next)
    {
        $config = config('cors');
        if (!empty($config['allow_origin']) &&
            is_array($config['allow_origin'])) {
            if (in_array(
                '*',
                $config['allow_origin'])
            ) {
                header('Access-Control-Allow-Origin:*');
            } elseif (in_array(
                $request->header('origin'),
                $config['allow_origin'])
            ) {
                header('Access-Control-Allow-Origin:' .
                    $request->header('allow_origin')
                );
            }
        }

        if (!empty($config['allow_credentials']) &&
            is_bool($config['allow_credentials']) &&
            $config['allow_credentials'] === true) {
            header('Access-Control-Allow-Credentials:' . true);
        }

        if (!empty($config['expose_headers']) &&
            is_array($config['expose_headers'])) {
            header('Access-Control-Expose-Headers:' .
                implode(',', $config['expose_headers'])
            );
        }

        if (!empty($config['allow_headers']) &&
            is_array($config['allow_headers'])) {
            header('Access-Control-Allow-Headers:' .
                implode(',', $config['allow_headers'])
            );
        }

        if (!empty($config['allow_headers']) &&
            is_array($config['allow_headers'])) {
            header('Access-Control-Allow-Headers:' .
                implode(',', $config['allow_headers'])
            );
        }

        if (!empty($config['max_age']) &&
            is_integer($config['max_age'])) {
            header('Access-Control-Max-Age:' . $config['max_age']);
        }

        return $next($request);
    }
}
