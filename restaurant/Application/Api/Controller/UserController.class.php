<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller {

    /**
     * @函数 发送短信验证码
     * @功能 各种类型（注册1、登录2）
     * @param verifyType、phone
     */
    public function sendSmsCode(){
        $type = I("post.smsCodeType");
        //验证手机号
        $phone = $this->checkPhone();
        $code = CommonController::randString(6);
        $rst = null;
        switch($type){
            case 1 :{   //注册验证码
                $param = array(
                    "signName"      =>  "注册验证",
                    "templateId"    =>  "SMS_7360273",
                    "code"          =>  $code,
                    "product"       =>  C("ShopName"),
                    "phone"         =>  $phone
                );
                $rst = CommonController::sendMsg($param);
            }break;
            case 2 :{   //登录验证码
                $param = array(
                    "signName"      =>  "登录验证",
                    "templateId"    =>  "SMS_7360275",
                    "code"          =>  $code,
                    "product"       =>  C("ShopName"),
                    "phone"         =>  $phone
                );
                $rst = CommonController::sendMsg($param);
            }break;
            default : {
                break;
            }
        }
        //短信发送成功
        if(!empty($rst) && $rst["result"]["success"]){
            $data = array(
                "userId"        =>  I("post.userId"),
                "phone"         =>  $phone,
                "check_code"    =>  $code,
                "status"        =>  0,  //0未使用
                "code_type"     =>  $type,
                "add_time"      =>  date("Y-m-d H:i:s", time())
            );
            if(M("Smscode")->add($data)){
                $this->ajaxReturn(array( "status"=>1,"info" =>"发送成功"),"JSON", true);
            }
        }
        $this->ajaxReturn(array("status"=>0,"info"=> "发送失败", "data"=>$rst), "JSON", true);
    }

    /**
     * @函数 注册
     * @功能 添加一条用户表记录
     * @param phone 、smscode、[uname]
     */
    public function register(){
        $data["phone"] = $this->checkPhone();
        //校验短信验证码
        $smscode = $this->checkSmsCode();
        //验证码即密码
        $data["password"] = $this->encrypt($smscode);
        $data["reg_time"] = date("Y-m-d H:i:s", time());
        $data["uname"] = $_POST["uname"] ? $_POST["uname"] : $data["phone"];

        if($id = M("User")->add($data)){
            //注册成功，执行登录
            $user = M("User")->where("id=$id")->find();
            $this->ajaxReturn(array("info"=>"注册成功", "status"=>1, "data"=>$user), "JSON", true);
        }else{
            $this->ajaxReturn(array("info"=>"注册失败", "status"=>0), "JSON", true);
        }

    }

    /**
     * @函数 登录
     * @功能 用户名密码登录、手机号验证码登录
     */
    public function login(){
        $login_way = $_POST["loginWay"] ? $_POST["loginWay"] : 1;
        $user = null;
        if($login_way == 1){        //用户名密码登录
            //验证用户名和密码
            $uname = $_POST["uname"];
            $pwd = $_POST["password"];
            $password = $this->encrypt($pwd);
            $user = M("User")->where("(uname='$uname' or email='$uname' or phone='$uname') and password='$password'")->find();

        }else if($login_way == 2){  //手机验证码登录
            $phone = I("post.phone");
            $smscode = $this->checkSmsCode();
            $user = M("User")->where("phone='$phone'")->find();
        }
        //验证用户名和密码成功
        if($user){
            M("User")->where("id=" . $user["id"])->setField("last_visit", date("Y-m-d H:i:s", time()));
            unset($user["password"]);
            $this->ajaxReturn(array("data"=>$user, "info"=>"登录成功", "status"=>1), "JSON", true);
        }else{
            $this->ajaxReturn(array("info"=>"用户名或密码错误", "status"=>0), "JSON", true);
        }


    }

    /**
     * @函数 校验手机是否唯一
     */
    public function checkUniquePhone(){
        $phone = $this->checkPhone();
        $this->ajaxReturn(array("status"=>1), "JSON", true);
    }

    /**
     * @函数 图片验证码
     */
    public function getPicCode(){
        $verify = new \Think\Verify(array(
            "imageH"    =>  38,
            "imageW"    =>  100,
            "useCurve"  =>  false,
            "fontSize"  =>  20
        ));
        $verify->entry();
    }

    /**
     * @函数 校验图形验证码
     * @param {code}
     * @return status 0假1真
     */
    public function checkPicCode(){
        $code = I("post.picCode");
        $verify = new \Think\Verify();
        $status = $verify->check($code);
        $this->ajaxReturn(array("status"=>$status), "JSON", true);
    }

    /**
     * @函数 修改用户信息
     * @功能
     */
    public function update(){
        $userId = I("post.userId");
        $data["uname"] = I("post.uname");
        $data["email"] = I("post.email");

        //修改密码
        $newPwd = I("post.password");
        if(!empty($newPwd)){
            $oldPwd = $this->encrypt(I("post.oldPassword"));
            $user = M("User")->where("id=$userId and password='$oldPwd'")->find();
            if(!$user){
                $this->ajaxReturn(array("status"=>0, "info"=>"密码输入错误"), "JSON", true);
            }
        }
        $data["password"] = $this->encrypt($newPwd);

        //修改手机号
        $data["phone"] = I("post.phone");
        if(!empty($data["phone"])){
            $this->checkSmsCode();
        }


        $data["sex"] = I("post.sex");
        $data["age"] = I("post.age");
        $data["head_img"] = I("post.head_img");
        $data["id"] =  $userId;
        //清除空值
        $data = array_filter($data);
        if(M("User")->save($data)){
            $this->ajaxReturn(array("status"=>1, "info"=>"更新成功"), "JSON", true);
        }else{
            $this->ajaxReturn(array("status"=>0), "JSON", true);
        }
    }

/***********************************************************************/

    /**
     * @函数 校验手机号
     * @功能 失败则直接返回接口json字符串；成功则返回手机号
     */
    private function checkPhone(){
        $phone = $_POST["phone"];
        if($phone){
            if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $phone)){
                $this->ajaxReturn(array("info"=>"手机号格式不正确", "status"=>0), "JSON", true);
            }
            if(M("User")->where("phone=$phone")->find()){
                $this->ajaxReturn(array("info"=>"该手机号已注册", "status"=>0), "JSON", true);
            }
        }else{
            $this->ajaxReturn(array("info"=>"手机号不能为空", "status"=>0), "JSON", true);
        }
        return $phone;
    }

    /**
     * @函数 验证短信验证码
     * @功能 校验短信验证码，失败则直接返回接口json字符串；成功则返回短信验证码
     */
    private function checkSmsCode(){
        $smscode = $_POST["smsCode"];
        $phone = $_POST['phone'];
        $last_sms = null;
        if($smscode){
            $mixTime = date("Y-m-d H:i:s",time() - 3*60);   //3分钟过期
            $condition = "phone=$phone and status=0 and add_time>'$mixTime'";
            $last_sms = M("Smscode")->where($condition)->order("add_time desc")->find();    //最近一条短信验证码
            if($smscode != $last_sms['check_code']){
                $this->ajaxReturn(array("info"=>"短信验证码错误", "status"=>0), "JSON", true);
            }
        }else{
            $this->ajaxReturn(array("info"=>"短信验证码不能为空", "status"=>0), "JSON", true);
        }
        M("Smscode")->where("id=" . $last_sms['id'])->setField("status", 1);
        return $smscode;
    }

    /**
     * @函数 加密密码
     * @功能 统一的加密规则
     */
    private function encrypt($str){
        return md5($str);
    }

}