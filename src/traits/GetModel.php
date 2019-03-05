<?php

namespace think\bit\traits;

use think\Db;
use think\Exception;
use think\Validate;

/**
 * Trait GetModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post 请求主体
 * @property array get_default_validate 默认验证器
 * @property array get_before_result 前置返回结果
 * @property array get_condition 固定条件
 * @property array get_field 固定返回字段
 */
trait GetModel
{
    public function get()
    {
        $validate = Validate::make($this->get_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__getBeforeHooks') &&
            !$this->__getBeforeHooks()) {
            return $this->get_before_result;
        }

        try {
            $condition = $this->get_condition;
            if (isset($this->post['id'])) array_push(
                $condition,
                ['id', '=', $this->post['id']]
            ); else $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $data = Db::name($this->model)
                ->where($condition)
                ->field($this->get_field[0], $this->get_field[1])
                ->find();

            return method_exists($this, '__getCustomReturn') ? $this->__getCustomReturn($data) : [
                'error' => 0,
                'data' => $data
            ];
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}