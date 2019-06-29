<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 17:37
 */
namespace app\admin\controller;

use think\Controller;
use think\facade\Env;
use think\Db;
use app\admin\model\Upload as UploadModel;
use app\admin\model\Show as ShowModel;
use think\Request;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;

class Introduction extends Common{

    public function show(){

        $show = new ShowModel();
        $data = $show->ti_name();
        if ($data){
            $data = array_unique($data);//拿到标题名字,并删掉重复的
            $data = array_merge($data);//重新排序
            $this->assign('ti_name',$data);
        }

        return $this->fetch();

    }

    public function ti_time(Request $request){

        $cond = $request->post('cond');
        $show = new ShowModel();
        $ti_time = $show->ti_time($cond);
        $ti_time = array_unique($ti_time);//删掉重复的
        $ti_time = array_merge($ti_time);//重新排序
        return(json_encode($ti_time));

    }

    public function ti_weight(Request $request){

        $cond = $request->post('cond');
        $cond = explode('-',$cond);//字符串转数组
        $info = new ShowModel();
        $ti_wieght = $info->ti_weight($cond);
        return(json_encode($ti_wieght));

    }

    public function information(Request $request){
        $data = $request->post();
        $info = new ShowModel();
        $ti_wieght = $info->title($data);
        return(json_encode($ti_wieght));
    }

    public function lead(){

        if(request() -> isPost()) {
            $objPHPExcel = new \PHPExcel();
            //获取表单上传文件
            $file = request()->file('file');
            $info = $file->validate(['ext' => 'xlsx,xls'])->move(Env::get('root_path') . 'public'.'/'.'upload');  //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public
            if($info) {
                $exclePath = $info->getSaveName();  //获取文件名
                $file_name = Env::get('root_path') . 'public' . '/' . 'upload' . '/' . $exclePath;//上传文件的地址
                $file_types = explode ( ".", $_FILES ['file'] ['name'] );
                $file_type = $file_types [count ( $file_types ) - 1];
                if($file_type=='xls'){
                    $objReader =\PHPExcel_IOFactory::createReader("Excel5");
                }
                else if($file_type=='xlsx'){
                    $objReader =\PHPExcel_IOFactory::createReader("Excel2007");
                }

                $obj_PHPExcel =$objReader->load($file_name, $encode = 'utf-8');//加载文件内容,编码utf-8
                $excel_array=$obj_PHPExcel->getSheet(0)->toArray();   //转换为数组格式
                $name = array_shift($excel_array);  //获得文件名字
                $one = reset($name);//获取数组第一个
                $element = explode("-",$one);//转换为数组
                $upload = new UploadModel();
                $title_id = $upload->lead($element,$one);
                array_shift($excel_array);//去掉标题
                $data = [];
                $i=0;

                foreach($excel_array as $k=>$v) {
                    $data[$k]['info_serial'] = $v[0];//编号
                    $data[$k]['info_tasting'] = $v[1];//品鉴中心
                    $data[$k]['info_experence'] = $v[2];//体验店
                    $data[$k]['info_customer'] = $v[3];//顾客信息
                    $data[$k]['info_means'] = $v[4];//购买方式
                    $data[$k]['info_title'] = $title_id;
                    $data[$k]['info_addtime'] = time();
                    $i++;
                }
                $re=    Db::name("information")->insertAll($data);
                if($re){
                    $msg=[
                        'code'=>1,
                        'msg'=>'文件导入成功',
                    ];
                    return json_encode($msg);
                }
                else{
                    $msg=[
                        'code'=>0,
                        'msg'=>'文件导入失败，请重试',
                    ];
                    return json_encode($msg);
                }

            }else {
                echo $file->getError();
            }
        }
        return $this->fetch();


        return $this->fetch();

    }

}