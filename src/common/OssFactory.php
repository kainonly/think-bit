<?php

declare (strict_types=1);

namespace think\bit\common;

use OSS\Core\OssException;
use OSS\OssClient;
use think\facade\Request;

/**
 * 对象存储处理类
 * Class StrFactory
 * @package think\bit\common
 */
final class OssFactory
{
    /**
     * 阿里云配置
     * @var array
     */
    private $aliyun;

    /**
     * 对象存储客户端
     * @var OssClient
     */
    private $client;

    /**
     * OssFactory constructor.
     * @param array $aliyun
     * @throws OssException
     */
    public function __construct(array $aliyun)
    {
        $this->aliyun = $aliyun;
        $this->client = new OssClient(
            $aliyun['accessKeyId'],
            $aliyun['accessKeySecret'],
            $aliyun['oss']['endpoint']
        );
    }

    /**
     * 上传至对象存储
     * @param string $name
     * @return string
     * @throws OssException
     */
    public function put(string $name)
    {
        $file = Request::file($name);
        $fileName = date('Ymd') . '/' . $file->hash() . '.' . $file->getOriginalExtension();
        $this->client->uploadFile(
            $this->aliyun['oss']['bucket'],
            $fileName,
            $file->getRealPath()
        );

        return $fileName;
    }
}