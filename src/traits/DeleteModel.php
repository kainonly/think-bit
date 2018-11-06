<?php

namespace think\bit\traits;

use think\Db;
use think\Validate;

/**
 * 关系型模型删除处理
 * Trait DeleteModel
 * @package think\bit\traits
 */
trait DeleteModel
{
    public function delete()
    {
        // 通用验证
        $validate = Validate::make($this->delete_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否有前置处理
        if (method_exists($this, '__deleteBeforeHooks')) {
            $before_result = $this->__deleteBeforeHooks();
            if (!$before_result) return $this->delete_before_result;
        }

        $result_fail = [
            'error' => 0,
            'msg' => 'fail'
        ];

        // 执行事务删除
        $transaction = Db::transaction(function () {
            // 判断是通用主键删除或条件删除
            if (isset($this->post['id'])) {
                $result = Db::name($this->model)->where('id', 'in', $this->post['id'])->delete();
            } else {
                $result = Db::name($this->model)->where($this->post['where'])->delete();
            }
            
            // 判断是否有后置处理
            if (method_exists($this, '__deleteAfterHooks')) {
                $after_result = $this->__deleteAfterHooks();
                if (!$after_result) {
                    $result_fail = $this->delete_after_result;
                    Db::rollback();
                }
                return $result && $after_result;
            } else {
                return $result;
            }
        });
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ];
        else return $result_fail;
    }
}