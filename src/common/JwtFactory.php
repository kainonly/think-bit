<?php

declare (strict_types=1);

namespace think\bit\common;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use think\bit\facade\Ext;
use think\helper\Str;

/**
 * 令牌操作类
 * Class JwtFactory
 * @package think\bit\common
 */
final class JwtFactory
{
    /**
     * JWT 配置
     * @var array $config
     */
    private $config;
    /**
     * App 密钥
     * @var string $secret
     */
    private $secret;
    /**
     * Jwt signer
     * @var Sha256 $signer
     */
    private $signer;
    /**
     * 令牌
     * @var Token
     */
    private $token;

    /**
     * 构造处理
     * @param string $secret 应用密钥
     * @param array $config 令牌配置
     */
    public function __construct(string $secret,
                                array $config)
    {
        $this->secret = $secret;
        $this->config = $config;
        $this->signer = new Sha256();
    }

    /**
     * 获取令牌
     * @param string $token 令牌字符创
     * @return Token
     */
    public function getToken(string $token = null)
    {
        return empty($token) ?
            $this->token :
            (new Parser())->parse($token);
    }

    /**
     * 设置令牌
     * @param string $scene 场景
     * @param array $symbol 标识
     * @return bool|string
     * @throws \Exception
     */
    public function setToken(string $scene,
                             array $symbol = [])
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        $jti = Ext::uuid()->toString();
        $ack = Str::random();

        $this->token = (new Builder())
            ->issuedBy($this->config[$scene]['issuer'])
            ->permittedFor($this->config[$scene]['audience'])
            ->identifiedBy($jti, true)
            ->withClaim('ack', $ack)
            ->withClaim('symbol', $symbol)
            ->expiresAt(time() + $this->config[$scene]['expires'])
            ->getToken($this->signer, new Key($this->secret));

        if (!empty($this->config[$scene]['auto_refresh'])) {
            $result = (new \think\redis\library\RefreshToken)
                ->factory($jti, $ack, $this->config[$scene]['auto_refresh']);

            if ($result == false) {
                return false;
            }
        }

        return (string)$this->token;
    }

    /**
     * 令牌验证
     * @param string $scene 令牌场景
     * @param string $token 字符串令牌
     * @return bool|string
     * @throws \Exception
     */
    public function verify(string $scene,
                           string $token)
    {
        if (empty($this->config[$scene])) {
            throw new \Exception('not exists scene: ' . $scene);
        }

        $this->token = (new Parser())->parse($token);

        if (!$this->token->verify($this->signer, $this->secret)) {
            return false;
        }

        if ($this->token->getClaim('iss') != $this->config[$scene]['issuer'] ||
            $this->token->getClaim('aud') != $this->config[$scene]['audience']) {
            return false;
        }

        if ($this->token->isExpired()) {
            if (empty($this->config[$scene]['auto_refresh'])) {
                return false;
            }

            $result = (new \think\redis\library\RefreshToken)->verify(
                $this->token->getClaim('jti'),
                $this->token->getClaim('ack')
            );

            if (!$result) {
                return false;
            }

            $newToken = (new Builder())
                ->issuedBy($this->config[$scene]['issuer'])
                ->permittedFor($this->config[$scene]['audience'])
                ->identifiedBy($this->token->getClaim('jti'), true)
                ->withClaim('ack', $this->token->getClaim('ack'))
                ->withClaim('symbol', $this->token->getClaim('symbol'))
                ->expiresAt(time() + $this->config[$scene]['expires'])
                ->getToken($this->signer, new Key($this->secret));

            $this->token = $newToken;
            return (string)$this->token;
        }

        return true;
    }
}