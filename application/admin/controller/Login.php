<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller{

   protected  function _initialize()
   {
       parent::_initialize(); // TODO: Change the autogenerated stub

       if (!session('name')){
           $this->error("非法登陆",'index/index/index');
       }

   }
}