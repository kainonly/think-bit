<?php

namespace think\bit\common;

use phpseclib\Crypt\AES;

/**
 * Class BitCipher
 * @package think\bit\common
 * @see composer require phpseclib/phpseclib
 */
class BitCipher
{
    private $cipher;

    public function __construct()
    {
        $config = config('cipher.');
        $this->cipher = new AES();
        $this->cipher->setKey($config['key']);
        $this->cipher->setIV($config['iv']);
    }

    /**
     * 加密明文
     * @param string $context 明文
     * @return string 密文
     */
    public function Encrypt(string $context)
    {
        return base64_encode($this->cipher->encrypt($context));
    }

    /**
     * 解密密文
     * @param string $secret
     * @return string 明文
     */
    public function Decrypt(string $secret)
    {
        return $this->cipher->decrypt(base64_decode($secret));
    }

    /**
     * 加密数组为密文
     * @param array $data 数组
     * @return string 密文
     */
    public function EncryptArray(Array $data)
    {
        return base64_encode($this->cipher->encrypt(msgpack_pack($data)));
    }

    /**
     * 解密密文为数组
     * @param string $secret 密文
     * @return array 数组
     */
    public function DecryptArray(string $secret)
    {
        return msgpack_unpack($this->cipher->decrypt(base64_decode($secret)));
    }
}