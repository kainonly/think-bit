<?php

namespace think\bit\traits;

use Closure;
use think\facade\Db;

/**
 * Trait OriginListsModel
 * @package think\bit\traits
 * @property string $model 模型名称
 * @property array $post 请求主体
 * @property array $origin_lists_default_validate 默认验证器
 * @property array $origin_lists_before_result 前置返回结果
 * @property array $origin_lists_condition 固定条件
 * @property Closure $origin_lists_condition_query 特殊查询
 * @property array $origin_lists_field 固定字段
 * @property array $origin_lists_without_field 排除字段
 * @property array $origin_lists_orders 排序设定
 */
trait OriginListsModel
{
    public function originLists()
    {
        $validate = validate($this->origin_lists_default_validate);
        if (!$validate->check($this->post)) {
            return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        if (method_exists($this, '__originListsBeforeHooks') &&
            !$this->__originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        try {
            $condition = $this->origin_lists_condition;
            if (isset($this->post['where'])) {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            $orders = $this->origin_lists_orders;
            if (isset($this->post['order'])) {
                $condition = array_merge(
                    $orders,
                    $this->post['order']
                );
            }

            $listsQuery = Db::name($this->model)
                ->where($condition)
                ->field($this->origin_lists_field)
                ->withoutField($this->origin_lists_field)
                ->order($orders);

            $lists = empty($this->origin_lists_condition_query) ?
                $listsQuery->select() :
                $listsQuery->where($this->origin_lists_condition_query)
                    ->select();

            return method_exists($this, '__originListsCustomReturn') ?
                $this->__originListsCustomReturn($lists) : [
                    'error' => 0,
                    'data' => $lists->toArray()
                ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}