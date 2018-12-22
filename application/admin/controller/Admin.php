<?php

namespace app\admin\controller;

use function PHPSTORM_META\elementType;
use think\Controller;
use think\Db;
use think\facade\Validate;
use think\Request;

class Admin extends Controller
{
    //载入管理员管理模版
    public function index(){

        return view();
    }

    public function lst(){

        $user = Db::table('xx_admin')->paginate(10);
        return view() ->assign('lst',$user);
    }

    public function eitd($id){
        $user = Db('admin')->where('id',$id)->find();
        return view() -> assign('user',$user);
    }

    public function posteitd(Request $request){
        $post = $request->post();
//        array_filter()方法过滤空数组和null，0
//        array_diff（）写入要过滤的规则
//        $post = array_diff($post,array(''));
        $validate = Validate::make([
            'username|账号' => 'min:5|max:20',
            'password|密码' => 'min:8|max:32',   //验证是否必填,最小8位，最大32位
            'nick|昵称'     => 'require|min:2|max:20',
            'email|邮箱'     => 'require|email'
            ]);
        $status = $validate->check($post);
        if($status){
            $fh = Db('admin')->where('id',$post['id'])->find();
            if($fh){
              Db('admin')->where('id',$post['id'])->update($post);
              return $this->success('账号修改成功！！','lst');
            }else{
                return $this->error('写入数据失败！！');
            }
        }else{
            return  $this->error($validate->getError());
        }
    }

    public function addadmin(){
        $user = request()->ispost();
            if($user){
                $validate = Validate::make([
                    'username|账号' => 'require|min:5|max:20',
                    'password|密码' => 'require|min:8|max:32|confirm',   //验证是否必填,最小8位，最大32位
                    'nick|昵称'     => 'require|min:2|max:20',
                    'email|邮箱'     => 'require|email'
                ]);
                $post = input('post.');
                $status = $validate->check($post);
                if($status){
                    //查找用户是否已经存在
                    $user = Db('admin')->where('username',$post['username'])->find();
                    if(!$user){ //如果不存在就往下走
                        unset($post['password_confirm']);
                        Db('admin')->data($post)->insert();
                        return $this->success('添加管理员成功！！','lst');
                    }else{
                       return $this->error('账号已存在，请换其他账号注册！！！');
                    }
                }else{
                    return $this->error($validate->getError());
                }
            }
        return view();
    }
}
