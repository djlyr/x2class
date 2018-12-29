<?php

namespace app\Admin\controller;

use think\Controller;
use think\Db;
use think\facade\Validate;
use think\Request;
use think\response\Redirect;
use app\admin\model\Cate as Dcate;
use app\Admin\validate\Cate as Cvalidate;

class Cate extends Controller
{
    protected $beforeActionList = [
        'dels'  =>  ['only'=>'del'],
    ];





    //载入视图文件
    public function lst(){
        $clst  = new Dcate();
        $lst = $clst->catetree();
//        $page = $lst->render();
//        $this->assign('page',$page);
        $this->assign('lst',$lst);
        return view();
    }

    public function add(){
        $cpost = \request()->ispost();
        if($cpost){
            $validate = new Cvalidate();
            $post = input('post.');
            $status = $validate -> check($post);
            if($status){
                //查找栏目是否存在
                $cateto = Dcate::where('catename',$post['catename'])->find();
                if(!$cateto){
                    Dcate::insert($post);
                    return $this->success('添加栏目成功！！','cate/lst');
                }else{
                    return $this->error('栏目已经存在请更换栏目名称！！！');
                }

            }else{
                return $this->error($validate->getError());
            }

        }else{
            $clst  = new Dcate();
            $lst = $clst->catetree();
            return view()->assign('lst',$lst);
        }

    }
    public function addid($id){
        $cid = Dcate::find($id);
        if(!$cid){
            return $this->error('提交数据错误，请返回重新提交！');
        }else{
            return view()->assign('cid',$cid);
        }

    }

    public function edit($id){

        $did = Dcate::find($id);
        if($did){
            //能查询到数据
            $qt1 = new Dcate();
            $qt = $qt1->catetree();
            $this->assign('qt',$qt);
            $this->assign('eid',$did);
                return view();
            } else{
            //不能查询到数据
            return $this->error('未找到编辑栏目，请重新提交查询！！！');
        }

    }

    public function editpost(){
        $post = Request()->ispost();
        if($post){
            $validate = new Cvalidate();
            $post = input('post.');
            $status = $validate -> check($post);
            if($status){
                $cpost = Dcate::where('id',$post['id'])->find();
                if($cpost){
                    Dcate::where('id',$post['id'])->update($post);
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
        $did = Dcate::find($id);
        if($did){
            Dcate::delete($did);
            return $this->success('删除成功！！');
        }else{
            return $this->error('未找到该栏目！！');
        }
    }

    public function dels(){
        $cateid = input('id');
        $catem = new Dcate();
        $delid=$catem->todels($cateid);
        if($delid){
            $catem->delete($delid);
        }
    }

}
