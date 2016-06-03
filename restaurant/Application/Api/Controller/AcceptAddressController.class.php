<?php
namespace Api\Controller;
use Think\Controller;
use Think\Page;

class AcceptAddressController extends Controller {
    /**
     * @函数 我的收货地址
     * @功能
     */
    public function get(){
        $userId = I("post.userId");
        $condition = " user_id=$userId";
        //分类列表（分页）
        $count = M("AcceptAddress")->where($condition)->count();
        $size = 10;
        $pg = new Page($count,$size);
        $list = M("AcceptAddress")->where($condition)->order("is_default desc,id desc")->limit($pg->firstRow . "," . $pg->listRows)->select();
        $this->ajaxReturn(array("data"=>$list, "status"=>1, "info"=>"查询成功"), "JSON", true);
    }

    /**
     * @函数 添加收货地址
     */
    public function add(){
        $data = I("post.");
        $data["modify_time"] = date("Y-m-d H:i:s", time());
        if(M("AcceptAddress")->add($data)){
            $this->ajaxReturn(array("status"=>1, "info"=>"添加成功"), "JSON", true);
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"添加失败"), "JSON", true);
        }
    }
    /**
     * @函数 更新收货地址
     */
    public function update(){
        $data = I("post.");
        $data["modify_time"] = date("Y-m-d H:i:s", time());
        if(M("AcceptAddress")->save($data)){
            $this->ajaxReturn(array("status"=>1, "info"=>"更新成功"), "JSON", true);
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"更新失败"), "JSON", true);
        }
    }
    /**
     * @函数 删除收货地址
     * @api参数 id
     */
    public function del(){
        $data = I("post.");
        if(M("AcceptAddress")->where($data)->delete()){
            $this->ajaxReturn(array("status"=>1, "info"=>"删除成功"), "JSON", true);
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"删除失败"), "JSON", true);
        }
    }
}