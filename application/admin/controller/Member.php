<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Log;
use think\Request;

class Member extends Login {

    function member(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');
        $dopost=Request::instance()->param('dopost');


        if ($dopost=='cy'){

            $memb=Db::table('member')
                ->where('state',1)
                ->select();

            returnJson(0,0,0,$memb);

        }

        $this->assign('count',count(Db::table('member')->where('state',1)->select()));

        return $this->fetch();
    }

    function memberedit(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');
        $edit=Request::instance()->param('edit');


        $msg=Db::table('member')
            ->where('id',$id)
            ->find();

        //传到前端
        $this->assign('title',$msg['name']);
        $this->assign('sex',$msg['sex']);
        $this->assign('department',$msg['department']);
        $this->assign('student_id',$msg['student_id']);
        $this->assign('major',$msg['major']);
        $this->assign('phone',$msg['phone']);
        $this->assign('email',$msg['email']);
        $this->assign('des',$msg['des']);
        $this->assign('state',$msg['state']);
        $this->assign('msg',$msg);       //整个打包过去
        $this->assign('img',$msg['img']);
        $this->assign('id',$id);






        return $this->fetch('member/memberedit');
    }

    function memberpd(){

        $dopost = Request::instance()->param('dopost');
        $id = Request::instance()->param('id');



        $this->assign('id',$id);

        //添加信息语句
        if($dopost=='update')
        {
            if(!empty($id))
            {

                $name=Request::instance()->param('name');
                if (empty($name))returnJson(2,"名字不能为空");
                $img=Request::instance()->param('pic');
                if (empty($img))returnJson(2,"图片不能为空");
                $sex=Request::instance()->param('sex');
                if (empty($sex))returnJson(2,"性别不能为空");
                $department=Request::instance()->param('department');
                if (empty($department))returnJson(2,"部门不能为空");
                $studentid=Request::instance()->param('studentid');
                if (empty($studentid))returnJson(2,"学号不能为空");
                $major=Request::instance()->param('major');
                if (empty($major))returnJson(2,"专业不能为空");
                $phone=Request::instance()->param('phone');
                if (empty($phone))returnJson(2,"电话不能为空");
                $email=Request::instance()->param('email');
                if (empty($email))returnJson(2,"邮箱不能为空");
                $des=Request::instance()->param('des');
                if (empty($des))returnJson(2,"自我介绍不能为空");

                $date=[
                    "img"=>$img,
                    "name"=>$name,
                    "sex"=>$sex,
                    "department"=>$department,
                    "student_id"=>$studentid,
                    "major"=>$major,
                    "phone"=>$phone,
                    "email"=>$email,
                    "des"=>$des,
                ];

                $ap=Db::table('member')
                    ->where('id', $id)
                    ->update($date);

                if ($ap!='0') {returnJson(0, "编辑成功");}

                else{returnJson(2,"编辑失败");}

            }

        }


        if ($dopost=='tuichu'){
            $an=Db::table('member')
                ->where('id',$id)
                ->setField('state',-1);

            if ($an!='0'){
                returnJson(0,'该会员已退出协会');
            }
            else{
                returnJson(2,"出问题了");
            }
        }


    }

    function zx(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');
        $dopost=Request::instance()->param('dopost');
        $dopost=Request::instance()->param('dopost');


        if ($dopost=='zx'){

            $memb=Db::table('member')
                ->where('state',2)
                ->whereOr('state',-1)
                ->order('state desc')
                ->select();

            returnJson(0,0,0,$memb);

        }

        $this->assign('count',count(Db::table('member')->where('state',2)->whereOr('state',-1)->select()));

        return $this->fetch();

    }

    function zxedit(){
        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');
        $edit=Request::instance()->param('edit');


        $msg=Db::table('member')
            ->where('id',$id)
            ->find();

        //传到前端
        $this->assign('title',$msg['name']);
        $this->assign('sex',$msg['sex']);
        $this->assign('department',$msg['department']);
        $this->assign('student_id',$msg['student_id']);
        $this->assign('major',$msg['major']);
        $this->assign('phone',$msg['phone']);
        $this->assign('email',$msg['email']);
        $this->assign('des',$msg['des']);
        $this->assign('state',$msg['state']);
        $this->assign('msg',$msg);       //整个打包过去
        $this->assign('img',$msg['img']);
        $this->assign('id',$id);



        return $this->fetch('member/zxedit');

    }

    function zxpd(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');


        //判断是否录用
        if ($dopost=='luyong'){
            Db::table('member')
                ->where('id',$id)
                ->update(['state'=>1]);
        }
        if ($dopost=='jujue'){
            Db::table('member')
                ->where('id',$id)
                ->update(['state'=>-1]);
        }
        returnJson(0,"恭喜你成为青年志愿者协会的一员",0,0);
    }

    function acmember(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');

        if ($dopost=='acmember'){
            $acmember=Db::table('sigup')
                ->where('state',1)
                ->whereOr('state','-1')
                ->order('state desc')
                ->select();

            returnJson(0,0,0,$acmember);
        }

        $this->assign('count',count(Db::table('sigup')->where('state',1)->select()));

        return $this->fetch();
    }

    function acmemberedit(){
        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');
        $duty=Request::instance()->param('duty');
        $post=Request::instance()->param('post');
        $act=Request::instance()->param('act');



        $msg=Db::table('sigup')
            ->where('id',$id)
            ->find();

        //传到前端
        $this->assign('title',$msg['name']);
        $this->assign('department',$msg['department']);
        $this->assign('phone',$msg['tel']);
        $this->assign('state',$msg['state']);
        $this->assign('msg',$msg);       //整个打包过去
        $this->assign('id',$id);





        return $this->fetch('member/acmemberedit');
    }

    function acmembercl(){

        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');

        //添加信息语句
        if($dopost=='update')
        {

            if(!empty($id))
            {
                $duty=Request::instance()->param('duty');
                if (empty($duty))returnJson(2,"职责不能为空");
                $post=Request::instance()->param('post');
                if (empty($post))returnJson(2,"岗位不能为空");
                $act=Request::instance()->param('act');

                $ap=Db::table('sigup')
                    ->where('id', $id)
                    ->update(['post' => $post, 'duty' => $duty, 'state' => -1]);

                if ($ap=='1') {returnJson(0, "编辑成功");}
                else{returnJson(2,"编辑失败");}


            }

        }

    }

}