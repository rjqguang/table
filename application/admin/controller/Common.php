<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 17:45
 */
namespace app\admin\controller;

use think\Controller;

class Common extends Controller{

    public function initialize(){
        if (!session('name')){
            $this->redirect('admin/login/login');
        }
    }

}