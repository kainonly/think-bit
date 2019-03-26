<?php

namespace think\bit\common;

use phpseclib\Crypt\AES;
use think\facade\Config;

/**
 * Class BitCipher
 * @package think\bit\common
 * @property AES $cipher
 */
final class BitCipher
{
    /**
     * 加密明文
     * @param string $context 明文
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 密文
     */
    public function encrypt($context, $key = null, $iv = null)
    {
        $cipher = $this->getAES($key, $iv);
        return base64_encode($cipher->encrypt($context));
    }

    /**
     * 解密密文
     * @param string $secret
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 明文
     */
    public function decrypt($secret, $key = null, $iv = null)
    {
        $cipher = $this->getAES($key, $iv);
        return $cipher->decrypt(base64_decode($secret));
    }

    /**
     * 加密数组为密文
     * @param array $data 数组
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 密文
     */
    public function encryptArray(array $data, $key = null, $iv = null)
    {
        $cipher = $this->getAES($key, $iv);
        return base64_encode($cipher->encrypt(msgpack_pack($data)));
    }

    /**
     * 解密密文为数组
     * @param string $secret 密文
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return array 数组
     */
    public function decryptArray($secret, $key = null, $iv = null)
    {
        $cipher = $this->getAES($key, $iv);
        return msgpack_unpack($cipher->decrypt(base64_decode($secret)));
    }

    /**
     * 初始化 AES 加密
     * @param string $key 密钥
     * @param string $iv 偏移量
     * @return AES
     */
    private function getAES($key, $iv)
    {
        $cipher = new AES();
        $cipher->setKey($key ? $key : Config::get('app.app_secret'));
        $cipher->setIV($iv ? $iv : Config::get('app.app_id'));
        return $cipher;
    }
}