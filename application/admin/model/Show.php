<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 10:05
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Show extends Model{

    public function ti_name(){

        $title_name = Db::name('title')->field('ti_name')->select();
        if (count($title_name) != 0){
            $array = [];
            foreach ($title_name as $key => $value){
                $array[] = $value['ti_name'];
            }
            return $array;
        }

    }

    public function ti_time($cond){
        $title_time = Db::name('title')->where('ti_name',$cond)->order('ti_id desc')->field('ti_time')->select();
        if (count($title_time) != 0){
            $array = [];
            foreach ($title_time as $key => $value){
                $array[] = $value['ti_time'];
            }
            return $array;
        }
    }

    public function ti_weight($cond){
        $data = [
            'ti_name' => $cond[0],
            'ti_time' => $cond[1],
        ];
        $title_weight = Db::name('title')->where($data)->order('ti_id desc')->select();
        if (count($title_weight) != 0){
            $array = [];
            foreach ($title_weight as $key => $value){
                $array[] = $value;
            }
            return $array;
        }
    }

    public function title($data){
        if ($data['serial'] == ''){
            $ti = Db::name('title')->where('ti_title',$data['weight'])->find();
            $call = Db::name('information')->where('info_title',$ti['ti_id'])->where('info_tasting','not null')->where('info_experence','not null')->where('info_customer','not null')->order('info_id','asc')->select();
            $count = Db::name('information')->where('info_serial','not null')->where('info_tasting','null')->where('info_experence','null')->where('info_customer','null')->where('info_means','null')->where('info_title',$ti['ti_id'])->count();
            $datum = [
                'state' => 2,
              	'cash' => $count,
                'client' => $ti,
                'message' => $call,
            ];
        }else{
            $ti = Db::name('title')->where('ti_title',$data['weight'])->find();
          	
            $info = [
                'info_serial' => $data['serial'],
                'info_title' => $ti['ti_id'],
            ];
            $call = Db::name('information')->where($info)->where('info_tasting','not null')->where('info_experence','not null')->where('info_customer','not null')->find();
          	$is_exist = Db::name('information')->where($info)->find();
            if($is_exist){
            	if($call){
                $datum = [
                    'state' => 1,
                    'client' => $ti,
                    'message' => $call,
                    'serial' => $data['serial'],
                ];

            }else{
                $datum = [
                    'client' => $ti,
                    'state' => 0,
                    'serial' => $data['serial'],
                ];
            }
            
            }else{
            	$datum = [
                	'client' => $ti,
                    'state' => 3,
                    'serial' => $data['serial'],
                ];
            
            }

        }
        return $datum;
    }
  public function count(){
  	
  }
}