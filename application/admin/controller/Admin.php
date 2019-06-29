<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 13:38
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\Admin as AdminModel;


class Admin extends Common{
  protected $createTime = 'admin_addtime';
  protected $autoWriteTimestamp = true;

    public function lis(){

        return $this->fetch();

    }

    public function lis_api(){

        $admin = new AdminModel;
      	$data = $admin->lis();
        return($data);


    }

    public function add(Request $request){

        if ($request->isPost()){
            $data = $request->post();
            $admin = new AdminModel();
            $data = $admin->add($data);
            return($data);
        }

        return $this->fetch();

    }

    public function del(Request $request){

        if ($request->isPost()){
            $data = $request->post();
            $admin = new AdminModel();
            $data = $admin->del($data['admin_id']);
            return($data);
        }

    }

    public function edit(Request $request){

        if ($request->isPost()){

            $data = $request->post();
            print_r($data);
        }


        return $this->fetch();
    }




}