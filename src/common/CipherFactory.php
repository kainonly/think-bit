<?php

declare (strict_types=1);

namespace think\bit\common;

use phpseclib\Crypt\AES;

/**
 * 对称加密类
 * Class HashFactory
 * @package think\bit\common
 */
final class CipherFactory
{
    /**
     * 钥匙串
     * @var AES
     */
    private $cipher;

    /**
     * 构造处理
     * CipherFactory constructor.
     * @param string $key 密钥
     * @param string $iv 偏移量
     */
    public function __construct(string $key, string $iv)
    {
        $this->cipher = new AES();
        $this->cipher->setKey($key);
        $this->cipher->setIV($iv);
    }

    /**
     * 加密
     * @param string|array $context 加密内容
     * @return string 密文
     */
    public function encrypt($context)
    {
        if (is_string($context)) {
            return base64_encode($this->cipher->encrypt($context));
        } elseif (is_array($context)) {
            return base64_encode($this->cipher->encrypt(
                json_encode($context)
            ));
        } else {
            return '';
        }
    }

    /**
     * 解密
     * @param string $ciphertext 密文
     * @param bool $is_array 是否为数组
     * @return string|array 数据源
     */
    public function decrypt(string $ciphertext, bool $is_array = false)
    {
        $data = $this->cipher->decrypt(
            base64_decode($ciphertext)
        );

        return !$is_array ? $data : json_decode($data, true);
    }
}