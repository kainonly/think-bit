<?php

namespace think\bit\common;


use think\Controller;
use bit\traits\OriginListsModel;

abstract class BitController extends Controller
{
    /**
     * TODO:模型名称
     * @var string
     */
    protected $model;

    /**
     * TODO:请求数据
     * @var array
     */
    protected $post = [];

    /**
     * TODO:后端无分页列表数据制约条件
     * @var array
     */
    protected $lists_origin_condition = [];

    /**
     * TODO:无分页列表数据排序
     * @var string
     */
    protected $lists_origin_orders = 'create_time desc';

    /**
     * TODO:无分页列表数据返回字段
     * @var array
     */
    protected $lists_origin_field = ['update_time,create_time', true];

    /**
     * TODO:后端列表数据制约条件
     * @var array
     */
    protected $lists_condition = [];

    /**
     * TODO:列表排序
     * @var string
     */
    protected $lists_orders = 'create_time desc';

    /**
     * TODO:列表数据返回字段
     * @var array
     */
    protected $lists_field = ['update_time,create_time', true];

    /**
     * TODO:单条数据验证器
     * @var array
     */
    protected $get_validate = [
        'id' => 'require'
    ];

    /**
     * TODO:单条数据制约条件
     * @var array
     */
    protected $get_condition = [];

    /**
     * TODO:单条数据返回字段
     * @var array
     */
    protected $get_field = ['update_time,create_time', true];

    /**
     * TODO:修改数据验证器
     * @var array
     */
    protected $edit_validate = [
        'id' => 'require',
        'switch' => 'bool'
    ];

    /**
     * TODO:状态切换请求
     * @var bool
     */
    protected $edit_status_switch = false;

    /**
     * TODO:删除数据验证器
     * @var array
     */
    protected $delete_validate = [
        'id' => 'require'
    ];


    protected function initialize()
    {
        $this->post = input('post.');
    }

    /**
     * TODO:空函数处理
     * @return array
     */
    public function _empty()
    {
        return [];
    }

}