<?php

namespace think\bit\traits;

use Closure;
use think\Db;
use think\Exception;
use think\Validate;

/**
 * Trait OriginListsModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post 请求主体
 * @property array origin_lists_default_validate 默认验证器
 * @property array origin_lists_before_result 前置返回结果
 * @property array origin_lists_condition 固定条件
 * @property Closure origin_lists_condition_query 特殊查询
 * @property array origin_lists_field 固定返回字段
 * @property string origin_lists_orders 排序设定
 */
trait OriginListsModel
{
    public function originLists()
    {
        $validate = Validate::make($this->origin_lists_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__originListsBeforeHooks') &&
            !$this->__originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        try {
            $condition = $this->origin_lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition,
                $this->post['where']
            );

            $listsQuery = Db::name($this->model)
                ->where($condition)
                ->field($this->origin_lists_field[0], $this->origin_lists_field[1])
                ->order($this->origin_lists_orders);

            $lists = empty($this->origin_lists_condition_query) ?
                $listsQuery->select() :
                $listsQuery->where($this->origin_lists_condition_query)->select();

            return method_exists($this, '__originListsCustomReturn') ? $this->__originListsCustomReturn($lists) : [
                'error' => 0,
                'data' => $lists
            ];
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}