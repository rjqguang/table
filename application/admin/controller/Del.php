<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\model\Show;
use think\Request;
use app\admin\model\Del as DelModel;

class Del extends Controller{

    public function delete(Request $request){

        $show = new Show();
        $name = $show->ti_name();
        if ($name){
            $name = array_unique($name);//拿到标题名字,并删掉重复的
            $name = array_merge($name);//重新排序
            $this->assign('name',$name);
        }

        if ($request->isPost()){
            $ti_name = $request->post('name');
            $del = new DelModel();
            $data = $del->del($ti_name);
            return($data);
        }

        return $this->fetch();

    }

}
