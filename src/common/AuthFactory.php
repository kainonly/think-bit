<?php

declare (strict_types=1);

namespace think\bit\common;

use think\bit\facade\Jwt;
use think\facade\Cookie;

/**
 * Class AuthFactory
 * @package think\bit\common
 */
final class AuthFactory
{
    /**
     * JWT 配置
     * @var array $config
     */
    private $config;

    /**
     * 构造处理
     * @param array $config 认证配置
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 获取标识
     * @param string $scene
     * @return mixed
     * @throws \Exception
     */
    public function symbol(string $scene)
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        if (empty($this->config[$scene]['auth'])) {
            throw new \Exception('must set auth token name');
        }

        return Jwt::getToken()->getClaim('symbol');
    }

    /**
     * 设置授权认证
     * @param string $scene 场景
     * @param array $symbol 标识
     * @return bool
     * @throws \Exception
     */
    public function set(string $scene,
                        array $symbol)
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        if (empty($this->config[$scene]['auth'])) {
            throw new \Exception('must set auth token name');
        }

        $token = Jwt::setToken($scene, $symbol);
        if (!$token) {
            return false;
        }

        Cookie::set($this->config[$scene]['auth'], $token);
        return true;
    }

    /**
     * 验证授权认证
     * @param string $scene 场景
     * @return bool|string
     * @throws \Exception
     */
    public function verify(string $scene)
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        if (empty($this->config[$scene]['auth'])) {
            throw new \Exception('must set auth token name');
        }

        if (!Cookie::has($this->config[$scene]['auth'])) {
            return false;
        }

        $result = Jwt::verify(
            $scene,
            Cookie::get($this->config[$scene]['auth'])
        );

        if (is_string($result)) {
            Cookie::set($this->config[$scene]['auth'], $result);
            return true;
        }

        return $result;
    }

    /**
     * 清除授权认证
     * @param string $scene 场景
     * @throws \Exception
     */
    public function clear(string $scene)
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        if (empty($this->config[$scene]['auth'])) {
            throw new \Exception('must set auth token name');
        }

        Cookie::delete($this->config[$scene]['auth']);
    }

}