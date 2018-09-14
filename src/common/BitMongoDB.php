<?php

namespace bit\common;

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
     * TODO:Mongo集合
     * @param $collection
     * @return \MongoDB\Collection
     */
    public function mgo($collection)
    {
        return $this->client->selectCollection($collection);
    }
}