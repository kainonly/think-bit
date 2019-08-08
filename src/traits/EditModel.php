<?php

namespace think\bit\traits;

use think\facade\Db;

/**
 * Trait EditModel
 * @package think\bit\traits
 * @property string model 模型名称
 * @property array post 请求主体
 * @property array edit_default_validate 默认验证器
 * @property boolean edit_switch 是否为状态变更请求
 * @property array edit_before_result 前置返回结果
 * @property array edit_condition 默认条件
 * @property array edit_after_result 后置返回结果
 * @property array edit_fail_result 新增执行失败结果
 */
trait EditModel
{
    public function edit()
    {
        $validate = validate($this->edit_default_validate);
        if (!$validate->check($this->post)) {
            return json([
                'error' => 1,
                'msg' => $validate->getError()
            ]);
        }

        $this->edit_switch = $this->post['switch'];
        if (!$this->edit_switch) {
            $validate = validate($this->model);
            if (!$validate->scene('edit')->check($this->post)) {
                return json([
                    'error' => 1,
                    'msg' => $validate->getError()
                ]);
            }
        }

        unset($this->post['switch']);
        $this->post['update_time'] = time();

        if (method_exists($this, '__editBeforeHooks') &&
            !$this->__editBeforeHooks()) {
            return json($this->edit_before_result);
        }

        return !Db::transaction(function () {
            $condition = $this->edit_condition;

            if (isset($this->post['id'])) {
                array_push(
                    $condition,
                    ['id', '=', $this->post['id']]
                );
            } else {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            unset($this->post['where']);
            $result = Db::name($this->model)
                ->where($condition)
                ->update($this->post);

            if (!$result) {
                return false;
            }
            if (method_exists($this, '__editAfterHooks') &&
                !$this->__editAfterHooks()) {
                $this->edit_fail_result = $this->edit_after_result;
                Db::rollBack();
                return false;
            }

            return true;
        }) ? json($this->edit_fail_result) : json([
            'error' => 0,
            'msg' => 'ok'
        ]);
    }
}
