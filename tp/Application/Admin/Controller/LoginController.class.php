<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/4
 * Time: 10:11
 */

namespace Admin\Controller;


use Org\Util\Rbac;
use Think\Controller;

class LoginController extends Controller{
    //用户登录视图
    public function index(){
        //...
        $this->display();
    }

    //用户登录处理表单
    public function loginHandle(){
        if(!IS_POST) halt('页面不存在，请稍后再试');
        if(session('verify') != I('param.verify','','md5')) {
            $this->error('验证码错误', U('Admin/Login/index'));
        }

        $user = I('username','','string');
        $passwd = I('password','','md5');


        $db = M('user');
        $userinfo = $db->where("username = '$user' AND password = '$passwd'")->find();

        if(!$userinfo) $this->error('用户名或密码错误', U('Admin/Login/index'));

        if(!$userinfo['status']) $this->error('该用户被锁定，暂时不可登录', U('Admin/Login/index'));

        //更新登录信息
        $db->save(array("id"=> $userinfo["id"], "login_time"=> time(), "login_ip" => get_client_ip()));

        //写入session值
        session(C("USER_AUTH_KEY"), $userinfo["id"]);
        session("username", $userinfo["username"]);
        session("login_time", $userinfo["login_time"]);
        session("login_ip",$userinfo["login_ip"]);

        if($userinfo['username'] == C('RBAC_SUPERADMIN')){
            session(C('ADMIN_AUTH_KEY'), true);
        }else{
            //保存用户权限到session中
            Rbac::saveAccessList();
        }
        $this->success('登录成功', U('Index/index'));
    }

    //登出登录
    public function logOut(){
        //...
        session(null);  //清空当前的session
        $this->success('退出成功', U('Index/index'));
    }

    //验证码
    public function verify(){
        //...
    }

}