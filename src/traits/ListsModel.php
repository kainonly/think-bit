<?php

namespace think\bit\traits;

use think\Db;
use think\db\Query;
use think\Exception;
use think\bit\validate;

/**
 * Trait ListsModel
 * @package bit\traits
 */
trait ListsModel
{
    public function lists()
    {
        // TODO:验证分页参数
        $validate = new validate\Lists;
        if (!$validate->scene('page')->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];
        try {
            $condition = $this->lists_condition;
            if (isset($this->post['where'])) $condition = array_merge(
                $condition, $this->post['where']
            );
            $like = function (Query $query) {
                if (isset($this->post['like'])) foreach ($this->post['like'] as $key => $like) {
                    if (empty($like['value'])) continue;
                    $query->where($like['field'], 'like', "%{$like['value']}%");
                }
            };
            $total = Db::name($this->model)->where($condition)->where($like)->count();
            $divided = $total % $this->post['page']['limit'] == 0;
            if ($divided) $max = $total / $this->post['page']['limit'];
            else $max = ceil($total / $this->post['page']['limit']);
            if ($max == 0) $max = $max + 1;
            // TODO:页码超出最大分页数
            if ($this->post['page']['index'] > $max) return [
                'error' => 1,
                'msg' => lang('page index between')
            ];
            // TODO:分页查询
            $lists = Db::name($this->model)
                ->where($condition)
                ->where($like)
                ->field($this->lists_field[0], $this->lists_field[1])
                ->order($this->lists_orders)
                ->limit($this->post['page']['limit'])
                ->page($this->post['page']['index'])
                ->select();

            return [
                'error' => 0,
                'data' => [
                    'lists' => $lists,
                    'total' => $total,
                ]
            ];
        } catch (Exception $e) {
            return [
                'error' => 1,
                'msg' => (string)$e->getMessage()
            ];
        }
    }
}