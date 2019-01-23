<?php

namespace think\bit\bedis;

use think\bit\common\Bedis;

final class SmsString extends Bedis
{
    protected $key = 'sms:';

    /**
     * 生成1分钟的手机验证计时缓存
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param int $timeout 超时设置，默认60秒
     * @return bool
     */
    public function factory($phone, $code, $timeout = 60)
    {
        try {
            $data = msgpack_pack([
                'code' => $code,
                'publish_time' => time(),
                'timeout' => $timeout
            ]);
            return $this->redis->set($this->key . $phone, $data, $timeout);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 验证手机验证码
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param boolean $once 验证一次有效,验证完成即删除
     * @return bool
     */
    public function check($phone, $code, $once = false)
    {
        try {
            if (!$this->redis->exists($this->key . $phone)) return false;
            $data = msgpack_unpack($this->redis->get($this->key . $phone));

            $result = ($code === $data['code']);
            if ($once && $result) {
                $this->redis->delete($this->key . $phone);
            }

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取验证时间
     * @param string $phone 手机号
     * @return array|bool
     */
    public function time($phone)
    {
        try {
            if (!$this->redis->exists($this->key . $phone)) return false;
            $data = msgpack_unpack($this->redis->get($this->key . $phone));

            return [
                'publish_time' => $data['publish_time'],
                'timeout' => $data['timeout']
            ];
        } catch (\Exception $e) {
            return false;
        }
    }
}