<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Accontrol extends Login {

    function activity(){
        $dopost = Request::instance()->param('dopost');
        $name = Request::instance()->param('name');


        $wqedit=Db::table('acsig')
            ->where('state',1)
            ->find();

        //传到前端
        $this->assign('msg',$wqedit);
        $this->assign('title',$wqedit['title']);
        $this->assign('content',$wqedit['content']);
        $this->assign('type',$wqedit['type']);
        $this->assign('id',$wqedit['id']);


        return $this->fetch('accontrol/activity');
    }

    function acpd(){

        $dopost=Request::instance()->param('dopost');
        $id = Request::instance()->param('id');



        //添加信息语句
        if($dopost=='update')
        {


                $title=Request::instance()->param('title');
                if (empty($title))returnJson(0,"题目不能为空");

                $content=Request::instance()->param('content');
                if (empty($content))returnJson(0,"正文不能为空");

                $leixing=Request::instance()->param('leixing');
                if (empty($leixing))returnJson(0,"类型不能为空");

                $date=[
                    "title"=>$title,
                    "content"=>$content,
                    "type"=>$leixing,

                ];


                $ap=Db::table('acsig')
                    ->insertGetId($date);


                Db::table('acsig')
                    ->where('id','=',$ap)
                    ->setInc('state',1);

                if (!empty($ap)) {returnJson(0, "编辑成功");}
                else{returnJson(0,"编辑失败");}




        }
    }

    function wqhd(){

        $dopost = Request::instance()->param('dopost');
        $id = Request::instance()->param('id');
        $name = Request::instance()->param('name');

        if ($dopost=='wqjc') {
            $wqjc = Db::table('activity')
                ->where('state', 1)
                ->whereOr('state',-1)
                ->order('state desc')
                ->select();

            returnJson(0,0,0,$wqjc);
        }


        $this->assign('count',count(Db::table('activity')->where('state',1)->select()));
        return $this->fetch();
    }

    function wqhdedit(){

        $dopost = Request::instance()->param('dopost');
        $id = Request::instance()->param('id');
        $name = Request::instance()->param('name');


        $wqedit=Db::table('activity')
            ->where('id',$id)
            ->where('state',1)
            ->find();

        //传到前端
        $this->assign('type',$wqedit['type']);
        $this->assign('msg',$wqedit);
        $this->assign('id',$id);
        $this->assign('img',$wqedit['img']);
        $this->assign('title',$wqedit['title']);
        $this->assign('content',$wqedit['content']);

        //输出类型
        $lx = '';
        //统计类型的总数
        $alxtj=Db::table('activity')
            ->where('state',1)
            ->field('type')
            ->select();

        //将二维数组中相同的剔除
        $alxtj=array_unique($alxtj,SORT_REGULAR);

        //将二维数组转化为一维数组
        $alxtj=array_column($alxtj,'type');

        for ($i=0;$i<count($alxtj);$i++){
                   $lx.= '<option value="'.$alxtj[$i].'">'.$alxtj[$i].'</option>';
        }

        $this->assign('leixing',$lx);





        return $this->fetch('accontrol/wqjcedit');
    }

    function wqhdpd(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');


        //添加信息语句
        if($dopost=='update')
        {
            if(!empty($id))
            {

                $img=Request::instance()->param('pic');
                if (empty($img))returnJson(0,"图片不能为空");

                $title=Request::instance()->param('title');
                if (empty($title))returnJson(0,"题目不能为空");

                $content=Request::instance()->param('content');
                if (empty($content))returnJson(0,"正文不能为空");

                $status=Request::instance()->param('status');
                if (empty($status))returnJson(0,"状态不能为空");

                $leixing=Request::instance()->param('leixing');
                if (empty($leixing))returnJson(0,"类型不能为空");

                if ($status=='显示'){
                    $status=1;
                }
                else{
                    $status=-1;
                }

                $ap=Db::table('activity')
                    ->where('id', $id)
                    ->update(['img' => $img, 'title' => $title, 'content' => $content, 'type' => $leixing, 'state' => $status]);


                if ($ap=='1') {returnJson(0, "编辑成功");}
                else{returnJson(0,"编辑失败");}


            }

        }
    }
}