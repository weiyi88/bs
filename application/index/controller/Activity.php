<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\request;
class Activity extends Controller{
    function activity ()
    {

        $bm = Db::table('acsig')->where('state', 1)->find();

        $this->assign('title', "$bm[title]");
        $this->assign('type', "$bm[type]");
        $this->assign('content', "$bm[content]");


        $name = request::instance()->post('name');
        $bumen = request::instance()->post('bumen');
        $tel = request::instance()->post('tel');
        $dopost=request::instance()->post('dopost');



        if($dopost=='post'){

            if (empty($name) && empty($bumen) && empty($tel)) {
                $this->error('姓名，部门，电话都不能为空');

            }else{
                $arr = ['name' => "$name", 'department' => "$bumen", 'tel' => "$tel"];
                  Db::table('sigup')
                    ->insert($arr);
            }
        }


        return $this->fetch();
    }
}