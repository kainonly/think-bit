<?php

namespace think\bit\bedis;

use think\bit\common\Bedis;

final class SmsString extends Bedis
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
        try {
            /**
             * publish_time 发布时间
             * timeout 有效时间
             */
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
     * @param boolean $once 验证仅一次有效，验证完成即不存在
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
     * 获取验证时间信息
     * @param string $phone 手机号
     * @return array|bool
     */
    public function time($phone)
    {
        try {
            if (!$this->redis->exists($this->key . $phone)) return false;
            $data = msgpack_unpack($this->redis->get($this->key . $phone));
            /**
             * publish_time 发布时间
             * timeout 有效时间
             */
            return [
                'publish_time' => $data['publish_time'],
                'timeout' => $data['timeout']
            ];
        } catch (\Exception $e) {
            return false;
        }
    }
}