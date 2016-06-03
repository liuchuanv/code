<?php
namespace Admin\Controller;
use Think\Controller;
class SyscfgController extends Controller {
    public function __construct(){
        parent::__construct();

        //是否登录
        $admin = session("admin");
        if(empty($admin)){
            $this->error("请先登录", U("Index/index"), 3);
        }
    }

    /**
     * @函数 配置列表
     */
    public function index(){
        $title = I("post.title");
        $condition = " 1=1 ";
        if(!empty($title)){
            $condition .= " and (id=$title or title=$title) ";
        }
        $data = M("Syscfg")->where($condition)->order("modify_time desc")->select();
        $this->assign("list", $data);
        $this->display();
    }

    /**
     * @函数 编辑配置
     */
    public function edit(){
        $id = I("get.id");
        if(empty($id)){ //添加配置
            $this->assign("act", "add");
        }else{          //修改配置
            $cfg = M("Syscfg")->where("id='$id'")->find();
            $this->assign("item", $cfg);
            $this->assign("act", "update");
        }
        $this->display();
    }

    public function add(){
        $data = I("post.");
        $data["modify_time"] = date("Y-m-d H:i:s", time());
        if(M("Syscfg")->add($data)){
            $this->success("添加配置成功", U("Syscfg/index"), 1);
        }else{
            $this->error("添加配置失败", U("Syscfg/index"), 1);
        }
    }
    public function update(){
        $data = I("post.");
        $data["modify_time"] = date("Y-m-d H:i:s", time());
        if(M("Syscfg")->save($data)){
            $this->success("更新配置成功", U("Syscfg/index"), 1);
        }else{
            $this->error("更新配置失败", U("Syscfg/index"), 1);
        }
    }
}