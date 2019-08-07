<?php

namespace think\bit\facade;

use think\facade\Config;

final class Hash
{
    /**
     * 加密密码
     * @param string $password 密码值
     * @param array $options
     * @return bool|string
     */
    public static function make($password, $options = [])
    {
        return password_hash($password, self::getAlgo(), $options);
    }

    /**
     * 验证密码
     * @param string $password 密码值
     * @param string $hashPassword Hash值
     * @return bool
     */
    public static function check($password, $hashPassword)
    {
        return password_verify($password, $hashPassword);
    }

    /**
     * 获取加密配置
     * @return int
     */
    private static function getAlgo()
    {
        switch (Config::get('app.app_hash')) {
            case 'argon2id':
                return PASSWORD_ARGON2ID;
            case 'argon2i':
                return PASSWORD_ARGON2I;
            case 'bcrypt':
                return PASSWORD_BCRYPT;
            default:
                return PASSWORD_ARGON2ID;
        }
    }
}