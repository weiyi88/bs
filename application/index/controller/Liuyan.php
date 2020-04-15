<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

class Liuyan extends Controller {
    function liuyan(){
        $name = request::instance()->post('name');
        $content = request::instance()->post('content');
        $tel = request::instance()->post('tel');
        $dopost=request::instance()->post('dopost');


        if($dopost=='post'){

            if (empty($name) && empty($content) && empty($tel)) {
                $this->error('姓名，内容，电话都不能为空');

            }else{
                $arr = ['name' => "$name", 'content' => "$content", 'phone' => "$tel"];
                  Db::table('liuyan')
                    ->insert($arr);
            }
        }

        return $this->fetch();
    }
}