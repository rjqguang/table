<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 15:57
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Admin extends Model{
  protected $autoWriteTimestamp = true;
  
  public function lis(){
  
  		$list = Db::name('admin')->order('admin_id','desc')->select();
        $count = Db::name('admin')->count();
        $data = [
            'code' => 0,
            'msg' => '',
            "count" => $count,
            'data' => $list,
        ];
        return($data);
  }

    public function add($data){

        if (Db::name('admin')->where('admin_name',$data['name'])->find()){
            $call = [
                'code' => 0,
                'hint' => '该用户已存在！',
            ];
            return $call;
        }else{
            $itive = [
                'admin_name' => $data['name'],
                'admin_pwd' => md5($data['password']),
                'admin_addtime' => time(),
                'admin_listtime' => time(),
            ];
            if (Db::name('admin')->insert($itive)){
                $call = [
                    'code' => 1,
                    'hint' => '添加成功！',
                ];
                return $call;
            }else{
                $call = [
                    'code' => 2,
                    'hint' => '添加失败！',
                ];
                return $call;
            }
        }

    }

    public function del($id){
        $admin_id = Db::name('admin')->where('admin_name','admin')->field('admin_id')->find();
        if ($id == $admin_id['admin_id']){
            $call = [
                'code' => 3,
                'hint' => '初始账号不可删除',
            ];
            return $call;
        }else{  //还缺少一个正在登陆不可删除
            if(session('id')){
                if ($id == session('id')){
                    $call = [
                        'code' => 4,
                        'hint' => '此账号正在登陆，无法删除',
                    ];
                    return $call;
                }
            }else{
                if (Db::name('admin')->where('admin_id',$id)->delete()){
                    $call = [
                        'code' => 1,
                        'hint' => '删除成功',
                    ];
                    return $call;
                }else{
                    $call = [
                        'code' => 2,
                        'hint' => '初始账号不可删除',
                    ];
                    return $call;
                }
            }
        }
    }

    public function edit($data){

        $admin = Db::name('admin')->where('admin_id',$data['id'])->find();
        if (md5($data['password']) == $admin['admin_pwd']){
            Db::name('admin')->where('admin_id',$data['id'])->update(['admin_pwd' => md5($data['new_password'])]);
            $call = [
                'code' => 1,
                'hint' => '密码修改成功',
            ];
            return $call;
        }else{
            $call = [
                'code' => 2,
                'hint' => '原密码错误，请重新输入',
            ];
            return $call;
        }


    }

}