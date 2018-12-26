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
    public function addid($id){
        $cid = DB('cate')->where('id',$id)->find();
        if(!$cid){
            return $this->error('提交数据错误，请返回重新提交！');
        }else{
            return view()->assign('cid',$cid);
        }

    }

    public function edit($id){

        $did = Db('cate')->where('id',$id)->find();

        if($did){
            //能查询到数据

            $qt['qid'] = Db('cate')->select();
            $eid=array_merge($did,$qt);
            if(!$eid){
                return $this->error('提交数据错误，请返回重新提交！');
            }else{
                return view()->assign('eid',$eid);
            }

        }else{
            //不能查询到数据
            return $this->error('未找到编辑栏目，请重新提交查询！！！');
        }

    }

    public function editpost(){
        $post = Request()->ispost();
        if($post){
            $validate = Validate::make([
                'catename|中文栏目名称' => 'require|chs',
                'cate_ename|英文栏目名称' => 'require|alpha',
            ]);
            $post = input('post.');
            $status = $validate -> check($post);
            if($status){
                $cpost = Db('cate')->where('id',$post['id'])->find();
                if($cpost){
                    Db('cate')->where('id',$post['id'])->update($post);
                    return $this->success('更新栏目成功','lst');
                }else{
                    return $this->error('未找到此栏目，请添加后修改！');
                }
            }else{
                return $this->error($validate->getError());
            }
        }else{
            return $this->error('请求错误，请使用正确请求方式！');
        }

    }

    public function del($id){
        $did = Db('cate')->where('id',$id)->find();
        if($did){
            \db('cate')->where('id',$id)->delete();
            return $this->success('删除成功！！');
        }else{
            return $this->error('未找到该栏目！！');
        }
    }

}
