<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Validate;

class Login extends Controller
{

    //登陆页面
    public function login(){


        return view();
    }
    //获取POST数据
    public function post(Request $request)
    {
        $post =$request->post();    //获取POST数据
        //halt($post);
        //对POST数据验证，定义一个验证规则
        $validate = Validate::make([
            'username|账号' => 'require|min:5|max:20',
            'password|密码' => 'require|min:8|max:32',   //验证是否必填,最小8位，最大32位
            'code|验证码'  => 'require|captcha',
        ]);
        //用验证器对POST进行验证
        $status = $validate -> check($post);
        //可以通过判断真假来返回数据
        if ($status){
            //为真走进这里
            $user = Db::table('xx_admin')->where('username',$post['username'])->where('password',md5($post['password']))->find();
            if ($user){
                //找到数据就执行这里
                //如果账号密码正确，就把id和账号存入session
                session('id',$user['id']);
                session('username',$user['nick']);
                return $this->success('登陆成功！！','admin/index/index');
            }else{
                //找不到数据就走这里
                return $this->error('账号或密码错误！！');
            }
        }else{
            //为假走进这里
            return $this->error($validate->getError());
        }

    }
}
