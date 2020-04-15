<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//返回json函数
function returnJson($code='',$msg='',$count='',$data='')
{
    echo  json_encode(array("code"=>$code,"msg"=>$msg,"count"=>$count,"data"=>$data));
    exit();
}
function returnJson2($code,$msg)
{
    echo  json_encode(array("code"=>$code,"msg"=>$msg));
    exit();
}