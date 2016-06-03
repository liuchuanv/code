<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    /**
     * @函数 默认跳转到登录页面
     */
    public function index(){
        $this->display("login");
    }
    public function main(){
        $adminUser = session("admin");
        $this->assign("uname", $adminUser['uname']);
        $this->display();
    }
    /**
     * @函数 登录
     */
    public function login(){
        $data["uname"] = I("post.uname");
        $data["password"] = $this->encrypt(I("post.password"));

        $adminUser = M("Admin")->where($data)->find();
        if($adminUser){
            //更新上次登录时间
            M("Admin")->where($data)->setField("last_visit", date("Y-m-d H:i:s"));
            //session管理员信息
            session("admin", $adminUser);
            $this->success("登录成功", U("Index/main"), 3);
        }else{
            $this->error("登录失败", U("Index/index"), 3);
        }
    }

    /**
     * @函数 退出
     */
    public function logout(){
        session("admin", null);
        $this->success("",U("Index/index"));
    }

    /**
     * @函数 加密密码
     * @功能 统一的加密规则
     */
    private function encrypt($str){
        return md5($str);
    }
}