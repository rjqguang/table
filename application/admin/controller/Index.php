<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 11:56
 */
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;
use think\Request;

class Index extends Common{

    public function index(){
        $this->assign('name',session('name'));
        return $this->fetch();

    }

    public function home(){



        return $this->fetch();

    }
    public function edit(Request $request){

        if ($request->isPost()){

            $data = $request->post();
            $data['id'] = session('id');
            $admin = new Admin();
            $list = $admin->edit($data);
            return($list);


        }


        return $this->fetch();
    }

    public function out(){

        session(null);
        $data = [
            "code" => 0,
            "msg" => "退出成功",
            "data" => null
        ];
        return($data);

    }



}