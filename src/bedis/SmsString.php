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
     * @return bool
     */
    function factory($phone, $code)
    {
        try {
            return $this->redis->set($this->key . $phone, $code, 60);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 验证手机验证码
     * @param string $phone 手机号
     * @param string $code 验证码
     * @return bool
     */
    function check($phone, $code)
    {
        return $code === $this->redis->get($phone);
    }

}