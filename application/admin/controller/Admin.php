<?php

namespace app\admin\controller;

use function PHPSTORM_META\elementType;
use think\Controller;
use think\facade\Validate;
use think\Request;
use app\admin\validate\admin as Avlidate;
use app\Admin\model\Admin as Dadmin;

class Admin extends Controller
{
    //载入管理员管理模版
    public function index(){

        return view();
    }

    public function lst(){
        $user = Dadmin::paginate(10);
        return view() ->assign('lst',$user);
    }

    public function eitd($id){

        $user = Dadmin::find($id);
        return view() -> assign('user',$user);
    }

    public function posteitd(Request $request){
        $post = $request->post();
        $validate = new Avlidate();
        $status = $validate->scene('edit')->check($post);
        if($status){
            $fh = Dadmin::find($post['id']);
            if($fh){

                if($post['password'] == ''){
                    $post['password'] = $fh['password'];
                    Dadmin::where('id',$post['id'])->update($post);
                    return $this->success('账号修改成功！！','lst');
                }else{
                    $post['password'] = md5($post['password']);
                    Dadmin::where('id',$post['id'])->update($post);
                    return $this->success('账号修改成功！！','lst');
                }

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
                $validate = new Avlidate();
                $post = input('post.');
                $status = $validate->scene('add')->check($post);
                if($status){
                    //查找用户是否已经存在
                    $user = Dadmin::where('username',$post['username'])->find();
                    if(!$user){ //如果不存在就往下走
                        $post['password'] = md5($post['password']);
                        $user = new Dadmin;
                        $user ->allowField(true)->save($post);
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

    public function del($id){
        $user =  Dadmin::get($id);
        if($user){
            $user->delete();
            return $this->success('删除成功！！','lst');
        }else{
            return $this->error('找不到该用户！！');
        }
    }
}
