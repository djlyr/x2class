<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 管理员相关操作定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected  $rule = [
        'username|账号' => 'require|min:5|max:20',
        'password|密码' => 'require|min:8|max:32|confirm',   //验证是否必填,最小8位，最大32位
        'nick|昵称'     => 'require|min:2|max:20',
        'email|邮箱'    => 'require|email',
        'type|账号状态'  => 'in:0,1',

    ];

    /**
     * 管理员定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'username.require' => '账号必填',
        'username.min' => '账号不能少于5位',
        'username.max' => '账号不能多于20位',
        'password.require' => '密码必填',
        'password.min' => '密码不能多于8位',
        'password.max' => '密码不能多于32位',
        'password.confirm' => '两次密码不一致',
        'nick.require' =>  '昵称不能为空',
        'nick.min' =>  '昵称最小2个字',
        'nick.max' =>  '昵称最最大20个字',
        'email.require' => '邮箱必填',
        'email.email' => '邮箱格式错误',
        'type.num'     => '管理员状态出错',
    ];


    /**
     * 场景自定义验证规则
     * only(['需要验证字段'],['需要验证字段2']...)
     * 剔除某字段定义规则
     * remove('字段名','规则')
     * 给字段追加定义规则
     * append('字段','规则')
     */

    protected function sceneEdit()
    {
        return $this->only(['username','password','nick','email','type'])->remove('password', 'require|confirm')->remove('username', 'require');
    }

    protected function sceneAdd(){
        return $this->only(['username','password','nick','email']);
    }
}
