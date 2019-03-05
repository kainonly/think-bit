<?php

namespace think\bit\traits;

use think\Db;
use think\Exception;
use think\Validate;

/**
 * Trait ListsModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post POST请求
 * @property array lists_default_validate 默认验证器
 * @property array lists_before_result 前置返回结果
 * @property array lists_condition 固定条件
 * @property array lists_field 固定返回字段
 * @property string lists_orders 排序设定
 */
trait ListsModel
{
    public function lists()
    {
        $validate = Validate::make($this->lists_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__listsBeforeHooks') &&
            !$this->__listsBeforeHooks()) {
            return $this->lists_before_result;
        }

        try {
            $condition = $this->lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $total = Db::name($this->model)->where($condition)->count();
            $lists = Db::name($this->model)
                ->where($condition)
                ->field($this->lists_field[0], $this->lists_field[1])
                ->order($this->lists_orders)
                ->limit($this->post['page']['limit'])
                ->page($this->post['page']['index'])
                ->select();

            return method_exists($this, '__listsCustomReturn') ? $this->__listsCustomReturn($lists, $total) : [
                'error' => 0,
                'data' => [
                    'lists' => $lists,
                    'total' => $total
                ]
            ];
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}