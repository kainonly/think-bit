<?php

namespace bit\traits;

use think\Db;
use think\Validate;

trait EditModel
{
    public function edit()
    {
        // 修改基本参数验证
        $validate = Validate::make($this->edit_validate);
        if (!$validate->check($this->post)) return [
            'error' => 1,
            'msg' => $validate->getError()
        ];

        if (isset($this->post['switch']) && $this->post['switch']) {
            $this->edit_status_switch = true;
        } else {
            // 修改独立验证处理
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) return [
                'error' => 1,
                'msg' => $validate->getError()
            ];
        }

        unset($this->post['switch']);
        $this->post['update_time'] = time();
        if (method_exists($this, '__editBeforeHooks')) {
            $before_result = $this->__editBeforeHooks();
            if (!$before_result) return [
                'error' => 1,
                'msg' => 'before hooks failed!'
            ];
        }

        // 数据库事务
        $transaction = Db::transaction(function () {
            if (isset($this->post['id'])) {
                unset($this->post['where']);
                $result = Db::name($this->model)->update($this->post);
            } else {
                $condition = $this->post['where'];
                unset($this->post['where']);
                $result = Db::name($this->model)->where($condition)->update($this->post);
            }
            if (method_exists($this, '__editAfterHooks')) {
                $after_result = $this->__editAfterHooks();
                if (!$after_result) Db::rollback();
                return $result && $after_result;
            } else {
                return $result;
            }
        });
        // 返回结果
        if ($transaction) return [
            'error' => 0,
            'msg' => 'ok'
        ];
        else return [
            'error' => 1,
            'msg' => 'fail'
        ];
    }
}