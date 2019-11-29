<?php
declare (strict_types=1);

namespace think\bit\common;

use Closure;
use think\facade\Db;

/**
 * Trait ListsModel
 * @package think\bit\common
 * @property string $model 模型名称
 * @property array $post 请求主体
 * @property array $lists_default_validate 默认验证器
 * @property array $lists_before_result 前置返回结果
 * @property array $lists_condition 固定条件
 * @property Closure $lists_condition_query 特殊查询
 * @property array $lists_field 固定字段
 * @property array $lists_without_field 排除字段
 * @property array $lists_orders 排序设定
 */
trait ListsModel
{
    /**
     * 获取分页数据请求
     * @return array
     */
    public function lists(): array
    {
        try {
            validate($this->lists_default_validate)
                ->check($this->post);

            if (method_exists($this, '__listsBeforeHooks') &&
                !$this->__listsBeforeHooks()) {
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
                $condition = array_merge(
                    $orders,
                    $this->post['order']
                );
            }

            $totalQuery = Db::name($this->model)
                ->where($condition);

            $total = empty($this->lists_condition_query) ?
                $totalQuery->count() :
                $totalQuery->where($this->lists_condition_query)->count();

            $listsQuery = Db::name($this->model)
                ->where($condition)
                ->field($this->lists_field)
                ->withoutField($this->lists_without_field)
                ->order($orders)
                ->limit($this->post['page']['limit'])
                ->page($this->post['page']['index']);

            if (empty($this->lists_condition_query)) {
                $lists = $listsQuery
                    ->select();
            } else {
                $lists = $listsQuery
                    ->where($this->lists_condition_query)
                    ->select();
            }

            if (method_exists($this, '__listsCustomReturn')) {
                return $this->__listsCustomReturn($lists, $total);
            } else {
                return [
                    'error' => 0,
                    'data' => [
                        'lists' => $lists->toArray(),
                        'total' => $total
                    ]
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }
}