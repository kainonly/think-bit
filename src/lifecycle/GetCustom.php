<?php

namespace bit\lifecycle;

interface GetCustom
{
    /**
     * TODO:自定义单条数据返回
     * @param array $data
     * @return array
     */
    public function __getCustomReturn(Array $data);
}