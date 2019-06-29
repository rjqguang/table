<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Del extends Model{

    public function del($data){
        $title = Db::name('title')->where('ti_name',$data)->select();
        $i = 0;
        foreach($title as $v){
            $title[$i] = $v['ti_id'];
            $i++;
        }
        //$character = implode(',',$title);
        $ti = Db::name('title')->delete($title);
        $info = Db::name('information')->where('info_title','in',$title)->delete();
        if ($ti || $info){
            $data = [
                'code' => 1,
                'hint' => '删除成功',
            ];
        }else{
            $data = [
                'code' => 0,
                'hint' => '删除失败，请稍后再试',
            ];
        }
        return($data);
    }

}