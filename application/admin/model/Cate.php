<?php

namespace app\admin\model;

use think\Model;

class Cate extends Model
{
    //

    public function catetree(){
        $lst = $this->select();
        return $this->sort($lst);

    }

    public function sort($date,$pid=0,$level=0)
    {
        static $arr=array();
        foreach ($date as $k => $v){
            if($v['pid'] == $pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($date,$v['id'],$level+1);
            }
        }
        return $arr;
    }

    public function todels($cateid){
        $cateall = $this->select();
        return $this->allpid($cateall,$cateid);
    }

    public function allpid($cateall,$cateid){
        static $arr = array();
        foreach ($cateall as $k => $v){
            if($v['pid'] == $cateid){
                $arr[]=$v['id'];
                $this->allpid($cateall,$v['id']);
            }
        }
        return $arr;
    }
}
