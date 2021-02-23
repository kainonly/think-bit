<?php
declare (strict_types=1);

namespace think\bit\common;

use Closure;
use Exception;
use think\Collection;
use think\facade\Db;

/**
 * Trait OriginListsModel
 * @package think\bit\common
 * @property string $model 模型名称
 * @property array $post 请求主体
 * @property array $origin_lists_default_validate 默认验证器
 * @property array $origin_lists_validate 验证器
 * @property array $origin_lists_before_result 前置返回结果
 * @property array $origin_lists_condition 固定条件
 * @property Closure $origin_lists_condition_query 特殊查询
 * @property array $origin_lists_field 固定字段
 * @property array $origin_lists_without_field 排除字段
 * @property array $origin_lists_orders 排序设定
 * @method bool originListsBeforeHooks()
 * @method array originListsCustomReturn(Collection $lists)
 */
trait OriginListsModel
{
    /**
     * 获取列表数据请求
     * @return array
     * @throws Exception
     */
    public function originLists(): array
    {
        validate(array_merge(
            $this->origin_lists_default_validate,
            $this->origin_lists_validate
        ))->check($this->post);

        if (method_exists($this, 'originListsBeforeHooks') && !$this->originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        $condition = $this->origin_lists_condition;
        if (!empty($this->post['where'])) {
            $condition = array_merge(
                $condition,
                $this->post['where']
            );
        }

        $orders = $this->origin_lists_orders;
        if (!empty($this->post['order'])) {
            $orders = array_merge(
                $orders,
                (array)$this->post['order']
            );
        }

        $listsQuery = Db::name($this->model)
            ->where($condition)
            ->field($this->origin_lists_field)
            ->withoutField($this->origin_lists_without_field)
            ->order($orders);

        if (!empty($this->origin_lists_condition_query)) {
            $listsQuery = $listsQuery->where($this->origin_lists_condition_query);
        }
        $lists = $listsQuery->select();

        if (method_exists($this, 'originListsCustomReturn')) {
            return $this->originListsCustomReturn($lists);
        }

        return [
            'error' => 0,
            'data' => $lists->toArray()
        ];
    }
}