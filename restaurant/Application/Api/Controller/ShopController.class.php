<?php
namespace Api\Controller;
use Think\Controller;
use Think\Page;

class ShopController extends Controller {
    /**
     * @函数 获取配置信息
     * @功能
     */
    public function syscfg(){
        $id = I("post.id");
        $data = M("Syscfg")->where("id='$id'")->find();
        $this->ajaxReturn(array("data"=>$data, "status"=>1, "info"=>"查询成功"), "JSON", true);
    }
}