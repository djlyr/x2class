<?php

namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'catename|中文栏目名称'     =>    'require|chs',
        'cate_ename|英文栏目名称'   =>    'require|alpha',
        'describe|栏目描述'        =>    'min:10|max:255',
        'keyword|栏目关键词'       =>    'min:10|max:255',
        'sort|排序'               =>    'number|between:0,255',
        'type|类型'               =>    'number|in:0,1',
        'pid|上级栏目'             =>    'number',

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'catename.require'   => '栏目名称必填',
        'catename.chs'       => '只能填写中文',
        'cate_ename.require' => '只能填写中文',
        'cate_ename.alpha'   => '只能填写字母',
        'describe.min'       => '最少填写10个字',
        'describe.max'       => '最多填写255个字',
        'keyword.min'        => '最少填写10个字',
        'keyword.max'        => '最多填写255个字',
        'sort.number'        => '只能是数字',
        'sort.between'       => '只能是0-255之间',
        'type.number'        => '只能是数字',
        'type.in'            => '只能是0或1',
        'pid.number'         => '只能是数字',
    ];

    /**
     * 场景自定义验证规则
     * only(['需要验证字段'],['需要验证字段2']...)
     * 剔除某字段定义规则
     * remove('字段名','规则')
     * 给字段追加定义规则
     * append('字段','规则')
     */

//    protected function sceneEdit()
//    {
//        return $this->only(['username','password','nick','email','type'])->remove('password', 'require|confirm')->remove('username', 'require');
//    }
//
//    protected function sceneAdd(){
//        return $this->only(['username','password','nick','email']);
//    }
}
