<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Login {



    public function index(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');



        $msg=Db::table('admin')
            ->where('id',$id)
            ->find();

        //传到前端
        $this->assign('name',$msg['name']);
        $this->assign('department',$msg['department']);
        $this->assign('member',$msg['member']);
        $this->assign('msg',$msg);       //整个打包过去
        $this->assign('id',$id);



        //判断退出
        if ($dopost=='tuichu'){

            session(null);
            $this->success("正在退出",'index/index/index',0,1);
        }



        return $this->fetch();
    }


}
