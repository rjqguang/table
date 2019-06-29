<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/24
 * Time: 8:59
 */
namespace app\admin\model;

use think\Model;
use think\Db;

class Upload extends Model{

    public function lead($data, $one)
    {

        $where = [
            'ti_name' => $data[0],
            'ti_time' => $data[1],
            'ti_weight' => $data[2],
        ];
        $title = Db::name('title')->where($where)->find();
        if ($title) {

            Db::name('information')->where('info_title',$title['ti_id'])->delete();

            return $title['ti_id'];
        } else {
            $condition = [
                'ti_name' => $data[0],
                'ti_time' => $data[1],
                'ti_weight' => $data[2],
                'ti_title' => $one,
                'ti_addtime' => time(),
            ];
            $title_id = Db::name('title')->insertGetId($condition);
            return $title_id;
        }

    }


}