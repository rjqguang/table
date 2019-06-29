<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 14:17
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Login as LoginModel;

class Login extends Controller{

    public function login(Request $request){

        if ($request->isPost()){
            $data = $request->post();
            $login = new LoginModel();
            $call = $login->login($data);
            return($call);
        }
        return $this->fetch();

    }


}