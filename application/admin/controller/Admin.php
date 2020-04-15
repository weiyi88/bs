<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Admin extends Login
{





    function getadmin($data){
        $admin=Db::table('admin')
            ->where('state','>=','1')
            ->where('member','like','%'.$data['member'].'%')
            ->where('name','like','%'.$data['name'].'%')
            ->order('state desc')
            ->select();


        return $admin;
    }

    function admincx(){
        $act = Request::instance()->param('act');
        $id = Request::instance()->param('id');
        $dopost=Request::instance()->param('dopost');
        $member = Request::instance()->param('member');
        $name = Request::instance()->param('name');




        //搜索

        $data=[
            'member'=>$member,
            'name'=>$name,
        ];

        echo $member;
        echo $name;
        $cx=Db::table('admin')->where($data)->select();


        returnJson(0,0,0,$cx);


        //return $this->fetch('admin/admin');

    }

    function admin()
    {
        $act = Request::instance()->param('act');
        $id = Request::instance()->param('id');
        $dopost=Request::instance()->param('dopost');
        $member = Request::instance()->param('member');
        $name = Request::instance()->param('name');







        if ($dopost=='getnews'){


            $data=[
                'member'=>$member,
                'name'=>$name,
            ];

            $admin=$this->getadmin($data);

            returnJson(0,0,0,$admin);
        }









        $this->assign('member',$member);
        $this->assign('name',$name);
        $this->assign('biaoji',2);

        //输出用户状态
        $s_t='';
        $s_t.='<option value="1">显示</option>
                 <option value="2">删除</option>';
        $this->assign('status',1);


        //输出统计条数
        $count = Db::table('admin')->where('state','>=',1)->select();

        $this->assign('count',count($count));


        //用户类型
        $s_t='';
        $s_t.='<option value="1">管理员</option>';
        $this->assign('state',$s_t);

        //输出用户状态
        $s_t='';
        $s_t.='<option value="1">显示</option>
                 <option value="2">删除</option>';
        $this->assign('status',$s_t);







        return $this->fetch();
    }

    function adminedit(){

        $dopost=Request::instance()->param('dopost');



        //添加信息语句
        if($dopost=='update')
        {
            if(empty($id))
            {
                $name=Request::instance()->param('name');
                if (empty($name))returnJson(2,"姓名不能为空");
                $number=Request::instance()->param('number');
                if (empty($number))returnJson(2,"账号不能为空");
                $password1=Request::instance()->param('password1');
                if (empty($password1))returnJson(2,"密码不能为空");
                $password2=Request::instance()->param('password2');
                if (empty($password2))returnJson(2,"密码不能为空");
                $department=Request::instance()->param('department');
                if (empty($department))returnJson(2,"部门不能为空");

                if ($password1==$password2) returnJson(2,"两次密码不能相同");

                $data=[
                    "name"=>$name,
                    "member"=>$number,
                    "password"=>$password1,
                    "department"=>$department,
                ];

                $ap=Db::table('admin')
                    ->insertGetId($data);

                if ($ap !='0') {returnJson(0, "编辑成功");}
                else{returnJson(2,"编辑失败");}

            }
            else{
                returnJson(2,"你想干啥");
            }

        }

        return $this->fetch('admin/adminedit');
    }

    function adminadd(){


        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');

        $bioaji=Session::get('biaoji');

        if ($bioaji=='super') {

            $msg = Db::table('admin')
                ->where('id', $id)
                ->find();

            //传到前端
            $this->assign('name', $msg['name']);
            $this->assign('department', $msg['department']);
            $this->assign('member', $msg['member']);
            $this->assign('password', $msg['password']);
            $this->assign('msg', $msg);       //整个打包过去
            $this->assign('id', $id);

            return $this->fetch('admin/adminedit');
        }
        else{
            $this->error('对不起你没有权限');
        }
    }

    function adminpd(){

        $dopost = Request::instance()->param('dopost');
        $id = Request::instance()->param('id');


        if ($dopost=='tichu'){
            $an=Db::table('admin')
                ->where('id',$id)
                ->setField('state',-1);

            if ($an!='0'){
                returnJson(0,'已经剔除管理员资格');
            }
            else{
                returnJson(2,"出问题了");
            }
        }
    }

    function admima(){


        $dopost=Request::instance()->param('dopost');
        $id=Request::instance()->param('id');



        //添加信息语句
        if($dopost=='update')
        {

                $password=Request::instance()->param('password');
                if (empty($name))returnJson(2,"旧密码不能为空");
                $newpassword=Request::instance()->param('newpassword');
                if (empty($number))returnJson(2,"新密码不能为空");
                $repassword=Request::instance()->param('repassword');
                if (empty($password1))returnJson(2,"新密码不能为空");


                if ($password==$newpassword) returnJson(2,"新旧密码不能相同");

                $data=[
                    "password"=>$newpassword,
                ];

                $ap=Db::table('admin')
                    ->where('id',$id)
                    ->update($data);

                if ($ap !='0') {returnJson(0, "编辑成功");}
                else{returnJson(2,"编辑失败");}


        }


        return $this->fetch('admin/admima');
    }
}