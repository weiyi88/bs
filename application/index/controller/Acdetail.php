<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use traits\think\Instance;
use think\request;
class Acdetail extends Controller{
    function acdetail(){
        $id=request::instance()->get('id');
        if (isset($id)){

        $message=Db::table('activity')->find("$id");

        $this->assign('title',"$message[title]");
        $this->assign('id',"$message[id]");
        $this->assign('content',"$message[content]");
        $this->assign('type',"$message[type]");
        }
        else{
            $this->error("id不允许为空");
        }

        return $this->fetch();

    }
}