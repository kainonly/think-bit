<?php

namespace think\bit\traits;

use think\Db;
use think\Validate;

/**
 * Trait DeleteModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post 请求主体
 * @property array delete_default_validate 默认验证器
 * @property array delete_before_result 前置返回结果
 * @property array delete_prep_result 操作执行前事务之后返回结果
 * @property array delete_condition
 * @property array delete_after_result 后置返回结果
 * @property array delete_fail_result 新增执行失败结果
 */
trait DeleteModel
{
    public function delete()
    {
        $validate = Validate::make($this->delete_default_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (method_exists($this, '__deleteBeforeHooks') &&
            !$this->__deleteBeforeHooks()) {
            return $this->delete_before_result;
        }

        return !Db::transaction(function () {
            if (method_exists($this, '__deletePrepHooks') &&
                !$this->__deletePrepHooks()) {
                $this->delete_fail_result = $this->delete_prep_result;
                return false;
            }

            $condition = $this->delete_condition;
            if (isset($this->post['id'])) $result = Db::name($this->model)
                ->whereIn('id', $this->post['id'])
                ->where($condition)
                ->delete();
            else $result = Db::name($this->model)
                ->where($this->post['where'])
                ->where($condition)
                ->delete();

            if (!$result) {
                Db::rollBack();
                return false;
            }

            if (method_exists($this, '__deleteAfterHooks') &&
                !$this->__deleteAfterHooks()) {
                $this->delete_fail_result = $this->delete_after_result;
                Db::rollBack();
                return false;
            }

            return true;
        }) ? $this->delete_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}