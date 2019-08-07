<?php

namespace think\bit\common;

use think\facade\Config;

/**
 * Class BitHash
 * @package think\bit\common
 */
final class BitHash
{
    private $mode = PASSWORD_ARGON2I;

    /**
     * 加密密码
     * @param string $password 密码值
     * @param array $options
     * @return bool|string
     */
    public function make($password, $options = [])
    {
        if (Config::get('app.app_hash') == 'argon2id') {
            $this->mode = PASSWORD_ARGON2ID;
        }
        return password_hash($password, $this->mode, $options);
    }

    /**
     * 验证密码
     * @param string $password 密码值
     * @param string $hashPassword Hash值
     * @return bool
     */
    public function check($password, $hashPassword)
    {
        return password_verify($password, $hashPassword);
    }
}