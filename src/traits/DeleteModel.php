<?php

namespace think\bit\traits;

use think\Db;
use think\Validate;

/**
 * Trait DeleteModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post POST请求
 * @property array delete_validate 前置验证器
 * @property array delete_before_result 前置返回结果
 * @property array delete_prep_result 操作执行前事务之后返回结果
 * @property array delete_after_result 后置返回结果
 * @property array delete_fail_result 新增执行失败结果
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

        // 执行事务删除
        $transaction = Db::transaction(function () {
            if (method_exists($this, '__deletePrepHooks')) {
                $prep_result = $this->__deletePrepHooks();
                if (!$prep_result) {
                    $this->delete_fail_result = $this->delete_prep_result;
                    Db::rollback();
                    return false;
                }
            }

            // 判断是通用主键删除或条件删除
            if (isset($this->post['id']) && !empty($this->post['id'])) {
                $result = Db::name($this->model)->where('id', 'in', $this->post['id'])->delete();
            } elseif (isset($this->post['where']) &&
                !empty($this->post['where']) &&
                is_array($this->post['where'])) {
                $result = Db::name($this->model)->where($this->post['where'])->delete();
            } else {
                Db::rollback();
                return false;
            }

            if (!$result) {
                Db::rollback();
                return false;
            }

            // 判断是否有后置处理
            if (method_exists($this, '__deleteAfterHooks')) {
                $after_result = $this->__deleteAfterHooks();
                if (!$after_result) {
                    $this->delete_fail_result = $this->delete_after_result;
                    Db::rollback();
                    return false;
                }
            }

            return true;
        });
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ]; else {
            return $this->delete_fail_result;
        }
    }
}