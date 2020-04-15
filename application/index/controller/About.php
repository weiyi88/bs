<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class About extends Controller{
    function about(){
        //高要部门
        $gaoyao=Db::table('brief')->find(1);

        $this->assign('gytitle',"$gaoyao[title]");
        $this->assign('gycontent',"$gaoyao[content]");

        //鼎湖部门
        $dh=Db::table('brief')->find(2);

        $this->assign('dhtitle',"$dh[title]");
        $this->assign('dhcontent',"$dh[content]");
        //健康使者
        $jk=Db::table('brief')->find(3);

        $this->assign('jktitle',"$jk[title]");
        $this->assign('jkcontent',"$jk[content]");

        return $this->fetch();
    }
}