<?php

namespace think\bit\bedis;

use think\bit\common\Bedis;

class SmsString extends Bedis
{
    protected $key = 'sms:';

    /**
     * 生成1分钟的手机验证计时缓存
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param int $timeout 超时设置，默认60秒
     * @return bool
     */
    function factory($phone, $code, $timeout = 60)
    {
        try {
            return $this->redis->set($this->key . $phone, $code, $timeout);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 验证手机验证码
     * @param string $phone 手机号
     * @param string $code 验证码
     * @param boolean $once 验证一次有效
     * @return bool
     */
    function check($phone, $code, $once = false)
    {
        $result = ($code === $this->redis->get($this->key . $phone));
        if ($once && $result) {
            $this->redis->delete($this->key . $phone);
        }
        return $result;
    }

}