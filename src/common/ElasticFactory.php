<?php

namespace think\bit\common;

use Elasticsearch\ClientBuilder;

final class ElasticFactory
{
    /**
     * @var array
     */
    private $client = [];

    /**
     * ElasticFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            $this->client[$key] = $this->factory($value);
        }
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
     * @param string $label 客户端配置 label
     * @return \Elasticsearch\Client
     */
    public function client(string $label = 'default')
    {
        return $this->client[$label];
    }
}