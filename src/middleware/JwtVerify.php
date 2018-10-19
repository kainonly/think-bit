<?php

namespace think\bit\middleware;

use Firebase\JWT\JWT;
use Exception;
use think\Request;
use think\response\Json;

class JwtVerify
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            $identify = JWT::decode(session('identify'), config('jwt.sign'), ['HS256']);
            $token = JWT::decode($request->header('X-Token'), config('jwt.public'), ['RS256']);
            if ($identify->aud == $token->aud) {
                $request->token = $token;
                return $next($request);
            } else {
                return new Json([
                    'error' => 1,
                    'msg' => 'suspected tampering!'
                ]);
            }
        } catch (Exception $e) {
            return new Json([
                'error' => 1,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
