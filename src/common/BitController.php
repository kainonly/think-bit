<?php

namespace think\bit\common;


use think\Controller;
use bit\traits\OriginListsModel;

abstract class BitController extends Controller
{
    /**
     * 模型名称
     * @var string
     */
    protected $model;

    /**
     * 请求数据
     * @var array
     */
    protected $post = [];

    /**
     * 后端无分页列表数据制约条件
     * @var array
     */
    protected $lists_origin_condition = [];

    /**
     * 无分页列表数据排序
     * @var string
     */
    protected $lists_origin_orders = 'create_time desc';

    /**
     * 无分页列表数据返回字段
     * @var array
     */
    protected $lists_origin_field = ['update_time,create_time', true];

    /**
     * 后端列表数据制约条件
     * @var array
     */
    protected $lists_condition = [];

    /**
     * 列表排序
     * @var string
     */
    protected $lists_orders = 'create_time desc';

    /**
     * 列表数据返回字段
     * @var array
     */
    protected $lists_field = ['update_time,create_time', true];

    /**
     * 单条数据验证器
     * @var array
     */
    protected $get_validate = ['id' => 'require'];

    /**
     * 单条数据制约条件
     * @var array
     */
    protected $get_condition = [];

    /**
     * 单条数据返回字段
     * @var array
     */
    protected $get_field = ['update_time,create_time', true];

    /**
     * 新增自定义前置返回
     * @var array
     */
    protected $add_before_result = [
        'error' => 1,
        'msg' => 'fail:before'
    ];

    /**
     * 新增自定义后置返回
     * @var array
     */
    protected $add_after_result = [
        'error' => 1,
        'msg' => 'fail:after'
    ];

    /**
     * 修改数据验证器
     * @var array
     */
    protected $edit_validate = [
        'id' => 'require',
        'switch' => 'bool'
    ];

    /**
     * 修改自定义前置返回
     * @var array
     */
    protected $edit_before_result = [
        'error' => 1,
        'msg' => 'fail:before'
    ];

    /**
     * 修改自定义后置返回
     * @var array
     */
    protected $edit_after_result = [
        'error' => 1,
        'msg' => 'fail:after'
    ];

    /**
     * 状态切换请求
     * @var bool
     */
    protected $edit_status_switch = false;

    /**
     * 删除数据验证器
     * @var array
     */
    protected $delete_validate = [
        'id' => 'require'
    ];

    /**
     * 删除自定义前置返回
     * @var array
     */
    protected $delete_before_result = [
        'error' => 1,
        'msg' => 'fail:before'
    ];

    /**
     * 删除自定义后置返回
     * @var array
     */
    protected $delete_after_result = [
        'error' => 1,
        'msg' => 'fail:after'
    ];


    protected function initialize()
    {
        $this->post = input('post.');
    }

    /**
     * 空函数处理
     * @return array
     */
    public function _empty()
    {
        return [];
    }

}