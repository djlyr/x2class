<?php

namespace app\Admin\controller;

use think\Controller;
use think\Db;
use think\facade\Validate;
use think\Request;
use think\response\Redirect;

class Cate extends Controller
{
    //载入视图文件
    public function lst(){
        $lst = Db::table('xx_cate')->select();


        return view()->assign('lst',$lst);
    }

    public function add(){
        $cpost = \request()->ispost();
        if($cpost){
            $validate = Validate::make([
                'catename|中文栏目名称' => 'require|chs',
                'cate_ename|英文栏目名称' => 'require|alpha',   //验证是否必填,最小8位，最大32位
            ]);
            $post = input('post.');
            $status = $validate -> check($post);

            if($status){
                //查找栏目是否存在
                $cateto=\db('cate')->where('catename',$post['catename'])->find();
                if(!$cateto){
                    \db('cate')->data($post)->insert();
                    return $this->success('添加栏目成功！！','cate/lst');
                }else{
                    return $this->error('栏目已经存在请更换栏目名称！！！');
                }

            }else{
                return $this->error($validate->getError());
            }

        }else{
            $lst = Db::table('xx_cate')->select();
            return view()->assign('lst',$lst);
        }

    }
}
