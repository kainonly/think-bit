<?php

namespace think\bit\traits;

use think\Db;
use think\Validate;

trait EditModel
{
    public function edit()
    {
        // TODO:通用验证
        $validate = Validate::make($this->edit_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        // 判断是否为开关请求
        if (isset($this->post['switch']) && $this->post['switch']) {
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
            if (!$before_result) return $this->edit_before_result;
        }

        // 执行修改事务
        $result_fail = [
            'error' => 0,
            'msg' => 'fail'
        ];
        $transaction = Db::transaction(function () {
            // 判断是通用主键或条件修改
            if (isset($this->post['id'])) {
                unset($this->post['where']);
                $result = Db::name($this->model)->update($this->post);
            } else {
                $condition = $this->post['where'];
                unset($this->post['where']);
                $result = Db::name($this->model)->where($condition)->update($this->post);
            }

            // 判断是否有后置处理
            if (method_exists($this, '__editAfterHooks')) {
                $after_result = $this->__editAfterHooks();
                if (!$after_result) {
                    $result_fail = $this->edit_after_result;
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