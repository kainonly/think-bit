<?php

namespace think\bit\facade;

use think\facade\Config;
use phpseclib\Crypt\AES;

final class Cipher
{
    /**
     * 加密明文
     * @param string $context 明文
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 密文
     */
    public static function encrypt($context, $key = null, $iv = null)
    {
        $cipher = self::getAES($key, $iv);
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
        $cipher = self::getAES($key, $iv);
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
        $cipher = self::getAES($key, $iv);
        return base64_encode($cipher->encrypt(json_encode($data)));
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
        return json_decode($cipher->decrypt(base64_decode($secret)), true);
    }

    /**
     * 初始化 AES 加密
     * @param string $key 密钥
     * @param string $iv 偏移量
     * @return AES
     */
    private static function getAES($key, $iv)
    {
        $cipher = new AES();
        $cipher->setKey($key ? $key : Config::get('app.app_secret'));
        $cipher->setIV($iv ? $iv : Config::get('app.app_id'));
        return $cipher;
    }
}