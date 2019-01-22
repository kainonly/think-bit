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
    private $cipher;

    public function __construct()
    {
        $this->cipher = new AES();
        if (Config::has('cipher.key')) {
            $this->cipher->setKey(Config::get('key'));
        }
        if (Config::has('cipher.iv')) {
            $this->cipher->setIV(Config::get('iv'));
        }
    }

    /**
     * 加密明文
     * @param string $context 明文
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 密文
     */
    public function encrypt($context, $key = null, $iv = null)
    {
        if (!empty($key)) {
            $this->cipher->setKey($key);
        }

        if (!empty($iv)) {
            $this->cipher->setIV($iv);
        }

        return base64_encode($this->cipher->encrypt($context));
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
        if (!empty($key)) {
            $this->cipher->setKey($key);
        }

        if (!empty($iv)) {
            $this->cipher->setIV($iv);
        }

        return $this->cipher->decrypt(base64_decode($secret));
    }

    /**
     * 加密数组为密文
     * @param array $data 数组
     * @param string $key 自定义密钥
     * @param string $iv 自定义偏移量
     * @return string 密文
     */
    public function encryptArray(Array $data, $key = null, $iv = null)
    {
        if (!empty($key)) {
            $this->cipher->setKey($key);
        }

        if (!empty($iv)) {
            $this->cipher->setIV($iv);
        }

        return base64_encode($this->cipher->encrypt(msgpack_pack($data)));
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
        if (!empty($key)) {
            $this->cipher->setKey($key);
        }

        if (!empty($iv)) {
            $this->cipher->setIV($iv);
        }

        return msgpack_unpack($this->cipher->decrypt(base64_decode($secret)));
    }
}