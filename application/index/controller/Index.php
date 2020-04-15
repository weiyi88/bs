<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends Controller
{




    public function index()
    {
        //第一框内容
        $gy=Db::table('brief')->find(1);
        $this->assign('gtitle',"$gy[title]");
        $this->assign('gcontent',mb_substr($gy["content"],0,30));

        $dh=Db::table('brief')->find(2);
        $this->assign('dtitle',"$dh[title]");
        $this->assign('dcontent',mb_substr($dh["content"],0,30));

        $jk=Db::table('brief')->find(3);
        $this->assign('jtitle',"$jk[title]");
        $this->assign('jcontent',mb_substr($jk["content"],0,30));



        //第二框内容，往期精彩
        $list='';
        $arr=Db::table('activity')->limit(6)->select();
        for ($i=0;$i<count($arr);$i++){
            $list.='<div class="layui-col-sm6">
                <div class="content">
                    <div class="content-left"><a href="/index/acdetail/acdetail?id='.$arr[$i]["id"].'"><img src="' . $arr[$i]["img"] . '" style="width: 230px;height: 230px;"></a></div>
                    <div class="content-right">
                        <p class="label"><a href="/index/acdetail/acdetail?id='.$arr[$i]["id"].'">' . $arr[$i]["title"] . '</a>></p>
                        <span></span>
                        <p><a href="/index/acdetail/acdetail?id='.$arr[$i]["id"].'">' . mb_substr( $arr[$i]["content"] ,0,50) . '</a></p>
                    </div>
                </div>
            </div>';
        }

        $this->assign('list',$list);


        //部门图片
        $img=Db::table('brief')
            ->select();

        $this->assign('gybrief',$img[0]["img"]);
        $this->assign('dhbrief',$img[1]["img"]);
        $this->assign('jkbrief',$img[2]["img"]);



        //登陆后台判断
        $name = request::instance()->post('name');
        $password = request::instance()->post('password');
        $dopost = request::instance()->post('dopost');


        if($dopost=='post'){

            $admin=Db::table('admin')
                ->where('member',"$name")
                ->where('password',"$password")
                ->where('state','>',0)
                ->find();

            if (isset($admin))
            {
                if ($admin['state']==2) {
                    Session::set('biaoji', 'super');
                }

                Session::set('name',$name);
                $this->success('正在跳转后台','admin/index/index');

            }else{
                session(null);
               $this->error('用户名或密码错误,或用户已经被注销','index/index/index');
            }
        }

       return $this->fetch();
    }


}
