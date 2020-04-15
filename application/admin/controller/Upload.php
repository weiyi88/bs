<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;

class Upload extends Controller{

    public function upload()
    {
        $dopost = Request::instance()->param('dopost');
        // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        //echo $_FILES["file"]["size"];
        $extension = end($temp);     // 获取文件后缀名
        if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/jpg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/x-png")
                || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 10485760)   // 小于 10m
            && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                $err = "错误：: " . $_FILES["file"]["error"] . "<br>";
                returnJson(0, $err);
            } else {

                //设置图片上传的路径
                if ($dopost == 'member') {
                    $file_e = 'upload/member/';
                }
                if ($dopost == 'activity') {
                    $file_e = 'upload/activity/';
                }
                if ($dopost == 'brief') {
                    $file_e = 'upload/brief/';
                }
                if (file_exists($file_e.$_FILES["file"]["name"])){
                    $cz = $_FILES["file"]["name"] . " 文件已经存在。 ";
                    returnJson(0, $cz);
                }else{
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$file_e" . $_FILES["file"]["name"]);

                    $cc = "文件上传成功";
                    $date['url']=$file_e.$_FILES["file"]["name"];
                    returnJson(1, $cc,0,$date);
                }

            }
        } else {
            returnJson(0, "非法的文件格式");
        }

    }
}