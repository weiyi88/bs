<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
class Sig extends Controller{
    function sig(){

        $name = request::instance()->post('name');
        $sex = request::instance()->post('sex');
        $department = request::instance()->post('department');
        $stuid = request::instance()->post('stuid');
        $major = request::instance()->post('major');
        $phone = request::instance()->post('phone');
        $email= request::instance()->post('email');
        $des = request::instance()->post('des');
        $dopost=request::instance()->post('dopost');



        if($dopost=='post'){

            if (empty($name) && empty($stuid) && empty($phone)) {
                $this->error('姓名，学号，电话不能为空');

            }else{
                $arr = ['name' => "$name", 'sex' => "$sex",'department' => "$department",'student_id' => "$stuid",'major' => "$major",'phone' => "$phone",'email' => "$email", 'des' => "$des"];
                Db::table('member')
                    ->insert($arr);

                $this->success('报名成功','index/index/index');
            }
        }

        return $this->fetch();
    }
}