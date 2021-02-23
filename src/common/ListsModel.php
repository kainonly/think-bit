<?php
declare (strict_types=1);

namespace think\bit\common;

use Closure;
use Exception;
use think\Collection;
use think\facade\Db;

/**
 * Trait ListsModel
 * @package think\bit\common
 * @property string $model 模型名称
 * @property array $post 请求主体
 * @property array $lists_default_validate 默认验证器
 * @property array $lists_validate 验证器
 * @property array $lists_before_result 前置返回结果
 * @property array $lists_condition 固定条件
 * @property Closure $lists_condition_query 特殊查询
 * @property array $lists_field 固定字段
 * @property array $lists_without_field 排除字段
 * @property array $lists_orders 排序设定
 * @method bool listsBeforeHooks()
 * @method array listsCustomReturn(Collection $lists, int $total)
 */
trait ListsModel
{
    /**
     * 获取分页数据请求
     * @return array
     * @throws Exception
     */
    public function lists(): array
    {
        validate(array_merge(
            $this->lists_default_validate,
            $this->lists_validate
        ))->check($this->post);

        if (method_exists($this, 'listsBeforeHooks') && !$this->listsBeforeHooks()) {
            return $this->lists_before_result;
        }

        $condition = $this->lists_condition;
        if (!empty($this->post['where'])) {
            $condition = array_merge(
                $condition,
                $this->post['where']
            );
        }

        $orders = $this->lists_orders;
        if (!empty($this->post['order'])) {
            $orders = array_merge(
                $orders,
                (array)$this->post['order']
            );
        }

        $totalQuery = Db::name($this->model)
            ->where($condition);

        if (!empty($this->lists_condition_query)) {
            $totalQuery = $totalQuery->where($this->lists_condition_query);
        }

        $total = $totalQuery->count();

        $listsQuery = Db::name($this->model)
            ->where($condition)
            ->field($this->lists_field)
            ->withoutField($this->lists_without_field)
            ->order($orders)
            ->limit($this->post['page']['limit'])
            ->page($this->post['page']['index']);

        if (!empty($this->lists_condition_query)) {
            $listsQuery = $listsQuery->where($this->lists_condition_query);
        }
        $lists = $listsQuery->select();

        if (method_exists($this, 'listsCustomReturn')) {
            return $this->listsCustomReturn($lists, $total);
        }

        return [
            'error' => 0,
            'data' => [
                'lists' => $lists->toArray(),
                'total' => $total
            ]
        ];
    }
}