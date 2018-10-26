<?php

namespace think\bit\common;

class BitMongoDB
{
    private $client;

    public function __construct()
    {
        $config = config('mongo.');
        $dsn = "mongodb://{$config['username']}:{$config['password']}@{$config['host']}/{$config['database']}";
        if ($config['replicaSet']) $dsn = $dsn . '?replicaSet=' . $config['replicaSet'];
        $mongodb = new \MongoDB\Client($dsn);
        $this->client = $mongodb->selectDatabase($config['database']);
    }

    /**
     * Mongo集合
     * @param $collection_name
     * @return \MongoDB\Collection
     */
    public function collection($collection_name)
    {
        return $this->client->selectCollection($collection_name);
    }
}