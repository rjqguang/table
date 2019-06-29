<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/25
 * Time: 11:47
 */
namespace app\api\controller;

use think\Controller;
use app\admin\model\Show;
use think\Request;

class Information extends Controller{

    public function tiname(){

        $show = new Show();
        $data = $show->ti_name();
        if ($data){
            $data = array_unique($data);//拿到标题名字,并删掉重复的
            $data = array_merge($data);//重新排序
            return(json_encode($data));
        }

    }

    public function titime(Request $request){

        $cond = $request->post('cond');
        $show = new Show();
        $ti_time = $show->ti_time($cond);
        $ti_time = array_unique($ti_time);//删掉重复的
        $ti_time = array_merge($ti_time);//重新排序
        return(json_encode($ti_time));

    }

    public function tiweight(Request $request){

        $cond = $request->post('cond');
        $cond = explode('-',$cond);//字符串转数组
        $info = new Show();
        $ti_wieght = $info->ti_weight($cond);
        return(json_encode($ti_wieght));

    }

    public function data(Request $request){

        $data = $request->post();
        $info = new Show();
        $ti_wieght = $info->title($data);
        return(json_encode($ti_wieght));

    }

}