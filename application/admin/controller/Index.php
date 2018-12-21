<?php

namespace app\admin\controller;

use think\facade\Config;
use think\Controller;
use think\facade\Cache;
use think\facade\Session;

class Index extends Controller
{
    //载入后台视图
    public function index(){


        //判断登陆后session是否存入数据
        if(session('admin_id')){
            return view();
        }else{
            return $this->error('请登陆后，在进行操作！','admin/login/login');
        }
    }

    public function cache(){
        Cache::clear();
        return $this->success('缓存清理完成！！','admin/index/index');
    }
    public function clear(){
        Session::clear();
        return $this->success('退出成功！！','admin/login/login');
    }
}
