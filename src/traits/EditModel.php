<?php

namespace think\bit\traits;

use think\Db;
use think\Validate;

/**
 * Trait EditModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post POST请求
 * @property array edit_validate 前置验证器
 * @property array edit_before_result 前置返回结果
 * @property array edit_after_result 后置返回结果
 * @property array edit_fail_result 新增执行失败结果
 */
trait EditModel
{
    public function edit()
    {
        // 通用验证
        $validate = Validate::make($this->edit_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否为开关请求
        if (isset($this->post['switch']) && !empty($this->post['switch'])) {
            $this->edit_status_switch = true;
        } else {
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        // 判断是否有前置处理
        unset($this->post['switch']);
        $this->post['update_time'] = time();
        if (method_exists($this, '__editBeforeHooks')) {
            $before_result = $this->__editBeforeHooks();
            if (!$before_result) {
                return $this->edit_before_result;
            }
        }

        $transaction = Db::transaction(function () {
            // 判断是通用主键或条件修改
            if (isset($this->post['id']) && !empty($this->post['id'])) {
                unset($this->post['where']);
                Db::name($this->model)->update($this->post);
            } elseif (isset($this->post['where']) &&
                !empty($this->post['where']) &&
                is_array($this->post['where'])) {
                $condition = $this->post['where'];
                unset($this->post['where']);
                Db::name($this->model)->where($condition)->update($this->post);
            } else {
                return false;
            }

            // 判断是否有后置处理
            if (method_exists($this, '__editAfterHooks')) {
                $after_result = $this->__editAfterHooks();
                if (!$after_result) {
                    $this->edit_fail_result = $this->edit_after_result;
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
            return $this->edit_fail_result;
        }
    }
}