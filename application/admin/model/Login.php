<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 14:17
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Login extends Model{

    public function login($data){

        $user = Db::name('admin')->where('admin_name',$data['username'])->find();

        if ($user){
            if (md5($data['password']) == $user['admin_pwd']){
                Db::name('admin')->where('admin_name',$user['admin_name'])->update(['admin_listtime' => time()]);
                session('name',$user['admin_name']);
                session('id',$user['admin_id']);
                $call = [
                    'state' => 1,
                    'hint' => '登陆成功',
                ];
                return $call;
            }else{
                $call = [
                    'state' => 0,
                    'hint' => '账号或密码错误，请重新输入'
                ];
                return $call; //密码错误
            }
        }else{
            $call = [
                'state' => 0,
                'hint' => '该用户不存在，请重新输入',
            ];
            return $call;//用户不存在
        }

    }


}