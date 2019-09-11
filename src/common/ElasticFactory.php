<?php

namespace think\bit\common;

use Elasticsearch\ClientBuilder;

final class ElasticFactory
{
    /**
     * 配置
     * @var array
     */
    private $config = [];
    /**
     * 客户端
     * @var \Elasticsearch\Client
     */
    private $client;

    /**
     * ElasticFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = $this->factory($config['default']);
    }

    /**
     * 客户端生产
     * @param string $config 客户端配置
     * @return \Elasticsearch\Client
     */
    private function factory(array $config)
    {
        $clientBuilder = ClientBuilder::create()
            ->setHosts($config['hosts'])
            ->setRetries($config['retries'])
            ->setConnectionPool($config['connectionPool'])
            ->setSelector($config['selector'])
            ->setSerializer($config['serializer']);

        if (!empty($config['SSLVerification'])) {
            $clientBuilder->setSSLVerification($config['SSLVerification']);
        }

        if (!empty($config['logger'])) {
            $clientBuilder->setLogger($config['logger']);
        }

        if (!empty($config['handler'])) {
            $clientBuilder->setHandler($config['handler']);
        }

        return $clientBuilder->build();
    }

    /**
     * ElasticSearch 客户端
     * @return \Elasticsearch\Client
     */
    public function client()
    {
        return $this->client;
    }

    /**
     * 创建 ElasticSearch 客户端
     * @param string $label 客户端配置标识
     * @return \Elasticsearch\Client
     */
    public function create(string $label)
    {
        return $this->factory($this->config[$label]);
    }
}