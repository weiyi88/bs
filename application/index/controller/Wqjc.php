<?php
namespace app\index\controller;

use think\Controller;
use think\request;
use think\Db;
class Wqjc extends Controller{

    function wqjc(){
        $list='';
        $id=request::instance()->get('id');
        $type=request::instance()->get('type');

        if (isset($type)){
            if ($type==1){
                $type='敬老活动';
            }
            if ($type==2){
                $type='万福小学';
            }
            if ($type==3){
                $type='公益活动';
            }
        } else{
            $type='敬老活动';
        }

        $arr=Db::table('activity')->where('type',"$type")->select();

       for ($i=0;$i<count($arr);$i++){

               $list .= '<div class="layui-col-lg6 content">
                            <div>
                                <div class="news-img"><a href="/index/acdetail/acdetail?id=' . $arr[$i]["id"] . '"><img src="' . $arr[$i]["img"] . '"></a></div><div class="news-panel">
                                <strong><a href="/index/acdetail/acdetail?id=' . $arr[$i]["id"] . '">' . $arr[$i]["title"] . '</a></strong>
                                <p class="detail">
                                <span>' . mb_substr( $arr[$i]["content"] ,0,50) . '</span><a href="/index/acdetail/acdetail?id=' . $arr[$i]["id"] . '">[详细]</a></p>
                            </div>
                            </div>
                        </div>';


       }

       $this->assign('content',$list);


        return $this->fetch();
        }


    }
