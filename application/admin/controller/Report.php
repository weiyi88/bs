<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Report extends Login {

    function getbrief(){
        $brief=Db::table('brief')
            ->where('state',1)
            ->whereOr('state',-1)
            ->select();

        return $brief;
    }

    function brief(){

        $dopost=Request::instance()->param('dopost');



        if ($dopost=='brief'){

            $brief=$this->getbrief();


            returnJson(0,0,0,$brief);

        }




        $this->assign('count',count(Db::table('brief')->where('state',1)->select()));
        return $this->fetch();
    }

    function briefedit(){
        $dopost = Request::instance()->param('dopost');
        $id = Request::instance()->param('id');



        $mes=Db::table('brief')
            ->where('id',$id)
            ->find();

        //输出到前端
        $this->assign('msg',$mes);  //整个数组打包过去
        $this->assign('img',$mes['img']);
        $this->assign('title',$mes['title']);
        $this->assign('content',$mes['content']);
        $this->assign('id',$mes['id']);







        return $this->fetch('report/briefedit');
    }

    function briefpd(){
        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');

        //添加信息语句
        if($dopost=='update')
        {

            if(!empty($id))
            {
                $pic=Request::instance()->param('pic');
                if (empty($pic))returnJson(2,"图片不能为空");
                $name=Request::instance()->param('name');
                if (empty($name))returnJson(2,"名称不能为空");
                $content=Request::instance()->param('content');
                if (empty($content))returnJson(2,"内容不能为空");
                $status=Request::instance()->param('status');
                if (empty($status))returnJson(2,"状态不能为空");

                if ($status=='显示'){
                    $status=1;
                }
                else{
                    $status=-1;
                }

                $date=[
                    "img"=>$pic,
                    "title"=>$name,
                    "content"=>$content,
                    "state"=>$status,
                ];

                $ap=Db::table('brief')
                    ->where('id', $id)
                    ->update($date);

                if ($ap!='0') {returnJson(0, "编辑成功");}
                else{returnJson(2,"编辑失败");}


            }

        }
    }

    function getliuyan($data){
    $ly=Db::table('liuyan')
        ->where('state',1)
        ->where('name','like','%'.$data['name'].'%')
        ->where('phone','like','%'.$data['phone'].'%')
        ->select();


    return $ly;
}


    function liuyan(){


        $dopost=Request::instance()->post('dopost');
        $name=Request::instance()->param('name');
        $phone=Request::instance()->param('phone');
        $yiyue=Request::instance()->param('yiyue');
        $id=Request::instance()->param('id');



        if ($dopost=='getnews'){

            $data=[
                'name'=>$name,
                'phone'=>$phone,
            ];

            $ly=$this->getliuyan($data);

            returnJson(0,0,0,$ly);
        }


        if ($yiyue=='yiyue'){
            Db::table('liuyan')
                ->where('id',$id)
                ->update(['state'=>-1]);

        }


        $this->assign('count',count(Db::table('liuyan')->where('state',1)->select()));

        return $this->fetch();
    }



}