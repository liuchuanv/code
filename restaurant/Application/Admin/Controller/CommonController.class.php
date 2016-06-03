<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Think\Upload;

class CommonController extends Controller {

    public function __construct(){
        parent::__construct();

        //是否登录
        $admin = session("admin");
        if(empty($admin)){
            $this->error("请先登录", U("Index/index"), 3);
        }
    }

    /**
     * @函数	uploadify
     * @功能	上传文件
     * @兼容性 thinkphp 3.2
     */
    public function uploadify() {
        if (! empty ( $_FILES )) {
            // 实例化Upload类
            $upload = new Upload();

            $upload->maxSize = 2048000;
            $upload->allowExts = array (
                'jpg',
                'gif',
                'png',
                'jpeg'
            );
            $upload->saveRule = "time";
            $upload->autoSub = true;
            $upload->subType = 'date';
            $upload->dateFormat = 'Ymd';

            $images = $upload->upload();

            // 判断是否有图
            if ($images) {
                //$uploadList = $upload->getUploadFileInfo ();
                $fileInfo = $images["Filedata"];
                $path = $fileInfo["savepath"] . $fileInfo['savename'];
                // 返回文件地址和名给JS作回调用
                echo $path;
            } else {
                echo $this->error($upload->getError()); // 获取失败信息
            }
        }
    }
}