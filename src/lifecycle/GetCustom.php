<?php

namespace think\bit\lifecycle;

interface GetCustom
{
    /**
     * 自定义单条数据返回
     * @param array $data
     * @return array
     */
    public function __getCustomReturn(Array $data);
}