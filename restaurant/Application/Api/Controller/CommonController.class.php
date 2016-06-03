<?php
namespace Api\Controller;
use Think\Controller;

use Alidayu\TopClient;
use Alidayu\AlibabaAliqinFcSmsNumSendRequest;
use Think\Upload;

class CommonController extends Controller {
    /**
     * @函数 发送短信
     * @param signName、templateId、code、product、phone
     * @return result=>[err_code=>0, model=>xxx,success=>true], request_id=>xx
     */
    public static function sendMsg($arr){
        $c = new TopClient;
        $c->appkey = "23348250";
        $c->secretKey = "7c2e73221e986df496259637b3f9adeb";
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("demo");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName($arr['signName']);
        $req->setSmsParam("{\"code\":\"".$arr["code"]."\",\"product\":\"".$arr["product"]."\"}");
        $req->setRecNum($arr["phone"]);
        $req->setSmsTemplateCode($arr["templateId"]);
        $resp = $c->execute($req);
        $arrResp = json_decode(json_encode($resp), true);
        return $arrResp;
    }

    /**
     * 获取随机位数数字
     * @param  integer $len 长度
     * @return string
     */
    public static function randString($len = 6){
        $chars = str_repeat('0123456789', $len);
        $chars = str_shuffle($chars);
        $str   = substr($chars, 0, $len);
        return $str;
    }

    /**
     * @函数 随机字符串
     * @param $length
     * @return null|string
     */
    function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }
    /**
     * @函数	upload
     * @功能	ajax上传文件
     */
    public function upload() {
        $headers = getallheaders();
        $fn = $headers['X_FILENAME'];
        //获取后缀
        $suffix = substr($fn, stripos($fn, "."));
        $name = $this->getRandChar(10) . $suffix;   //文件名
        $dir = "Uploads/" . date("Y-m-d", time()) ."/"; //目录
        if (!file_exists($dir)){ mkdir($dir);};//如果不存在改目录，则创建
        $path = $dir. $name;
        if($fn){
            file_put_contents(
                $path,
                file_get_contents('php://input')
            );
            echo $path;
        }else{
			echo '';
		}
		exit();
    }
}