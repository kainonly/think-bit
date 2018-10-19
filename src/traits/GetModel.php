<?php

namespace think\bit\traits;

use think\Db;
use think\Exception;
use think\Validate;

trait GetModel
{
    public function get()
    {
        $validate = Validate::make($this->get_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        try {
            $normal = [];
            if (isset($this->post['id'])) {
                $normal['id'] = $this->post['id'];
            }
            $condition = $this->get_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition, $this->post['where']
            );
            $data = Db::name($this->model)
                ->where($normal)
                ->where($condition)
                ->field($this->get_field[0], $this->get_field[1])
                ->find();
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