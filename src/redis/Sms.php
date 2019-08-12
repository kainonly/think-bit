<?php

namespace think\bit\redis;

use think\bit\common\BitRedis;

final class Sms extends BitRedis
{
    protected $key = 'sms:';

    /**
     * 生成手机验证缓存
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param int $timeout 有效时间，默认120秒
     * @return bool
     */
    public function factory($phone, $code, $timeout = 120)
    {
        /**
         * publish_time 发布时间
         * timeout 有效时间
         */
        $data = json_encode([
            'code' => $code,
            'publish_time' => time(),
            'timeout' => $timeout
        ]);

        return $this->redis->setex($this->key . $phone, $timeout, $data);
    }

    /**
     * 验证手机验证码
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param boolean $once 验证仅一次有效，验证完成即不存在
     * @return bool
     */
    public function check($phone, $code, $once = false)
    {
        if (!$this->redis->exists($this->key . $phone)) {
            return false;
        }

        $data = json_decode($this->redis->get($this->key . $phone), true);
        $result = ($code === $data['code']);
        if ($once && $result) {
            $this->redis->del([
                $this->key . $phone
            ]);
        }

        return $result;
    }

    /**
     * 获取验证时间信息
     * @param string $phone 手机号
     * @return array|bool
     */
    public function time($phone)
    {
        if (!$this->redis->exists($this->key . $phone)) {
            return false;
        }

        $data = json_decode($this->redis->get($this->key . $phone), true);
        /**
         * publish_time 发布时间
         * timeout 有效时间
         */
        return [
            'publish_time' => $data['publish_time'],
            'timeout' => $data['timeout']
        ];
    }
}
