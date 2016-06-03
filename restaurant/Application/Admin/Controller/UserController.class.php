<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class UserController extends Controller {

    public function __construct(){
        parent::__construct();

        //是否登录
        $admin = session("admin");
        if(empty($admin)){
            $this->error("请先登录", U("Index/index"), 3);
        }
    }
    /**
     * @函数 用户列表
     * @分页
     */
    public function index(){
        $uname = I("post.username");
        $condition = " 1=1 ";
        if(!empty($uname)){
            $condition .= " and uname like '%$uname%' ";
        }
        $count = M("User")->where($condition)->count();
        $size = 10;
        $Page = new Page($count,$size);
        $show = $Page->show();
        $data = M("User")->where($condition)->order("id desc")->limit($Page->firstRow . "," . $Page->listRows)->select();

        $this->assign("list", $data);
        $this->assign("page", $show);
        $this->assign("username", $uname);
        $this->display();
    }

    /**
     * @函数 编辑用户
     * @功能 添加或修改用户信息
     */
    public function edit(){
        $uid = I("get.id");
        if(empty($uid)){    //添加用户
            $this->assign("act", "add");
        }else{
            $user = M("User")->where("id=$uid")->find();
            $this->assign("item", $user);
            $this->assign("act", "update");
        }
        $this->display();
    }

    /**
     * @函数 添加用户
     */
    public function add(){
        $data["uname"] = I("post.uname");
        $data["password"] = $this->encrypt(I("post.password"));
        $data["email"] = I("post.email");
        $data["phone"] = I("post.phone");
        $data["sex"] = I("post.sex");
        $data["age"] = I("post.age");
        $data["reg_time"] = date("Y-m-d H:i:s");

        if(M("User")->add($data)){
            $this->success("添加用户成功", U("User/index"), 2);
        }else{
            $this->error("添加用户失败", U("User/index"), 3);
        }
    }

    /**
     * @函数 更新用户信息
     */
    public function update(){
        $data["id"] = I("post.id");
        $data["uname"] = I("post.uname");
        $data["password"] = $this->encrypt(I("post.password"));
        $data["email"] = I("post.email");
        $data["phone"] = I("post.phone");
        $data["sex"] = I("post.sex");
        $data["age"] = I("post.age");
        $data["reg_time"] = date("Y-m-d H:i:s");

        if(M("User")->save($data)){
            $this->success("更新用户成功", U("User/index"), 2);
        }else{
            $this->error("更新用户失败", U("User/index"), 3);
        }
    }
    /**
     * @函数 加密密码
     * @功能 统一的加密规则
     */
    private function encrypt($str){
        return md5($str);
    }
}