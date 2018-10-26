<?php

namespace think\bit\traits;

use think\Db;
use think\Exception;
use think\Validate;

trait GetModel
{
    public function get()
    {
        // 通用验证
        $validate = Validate::make($this->get_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        try {
            $normal = [];
            // 判断是否存在id
            if (isset($this->post['id'])) {
                $normal['id'] = $this->post['id'];
            }

            // 判断是否存在条件
            $condition = $this->get_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            // 执行查询
            $data = Db::name($this->model)
                ->where($normal)
                ->where($condition)
                ->field($this->get_field[0], $this->get_field[1])
                ->find();

            // 判断是否自定义返回
            if (method_exists($this, '__getCustomReturn')) {
                return $this->__getCustomReturn($data);
            } else {
                return [
                    'error' => 0,
                    'data' => $data
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}