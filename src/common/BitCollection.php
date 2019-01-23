<?php

namespace think\bit\common;

final class BitCollection
{
    private $data = [];

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 加入集合
     * @param mixed $data
     */
    public function add(...$data)
    {
        array_push($this->data, ...$data);
    }

    /**
     * 设置集合键值
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * 判断是否存在
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * 获取键值
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->data[$key];
    }

    /**
     * 移除键值
     * @param $key
     */
    public function delete($key)
    {
        unset($this->data[$key]);
    }

    /**
     * 清除数据
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * 获取数组
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * 转为Json
     * @param int $options
     * @param int $depth
     * @return false|string
     */
    public function toJson($options = 0, $depth = 512)
    {
        return json_encode($this->data, $options, $depth);
    }

    /**
     * 转为二进制
     * @return mixed
     */
    public function toBinary()
    {
        return msgpack_pack($this->data);
    }
}