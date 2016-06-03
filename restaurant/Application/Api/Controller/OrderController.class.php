<?php
namespace Api\Controller;
use Think\Controller;
use Think\Page;

class OrderController extends Controller {
    /**
     * @函数 订单列表
     * @功能
     * @api参数  orderId
     */
    public function getOrderList(){
        $orderId = I("post.orderId");
        $userId = I("post.userId");
        //（30分钟未付款的取消订单）
        $before30Min = date("Y-m-d H:i:s", strtotime("now -3 minute"));  //30分钟前
        M("Order")->where("status=0 and add_time<'$before30Min'")->setField("status", -1);

        $before3Month = date("Y-m-d H:i:s", strtotime("now -3 month"));  //3个月前
        $condition = " add_time>'$before3Month' and user_id=$userId ";
        if(!empty($orderId)){
            $condition .= " and id=$orderId ";
        }

        //分类列表（分页）
        $count = M("Order")->where($condition)->count();
        $size = 10;
        $pg = new Page($count,$size);
        $list = M("Order")->where($condition)->order("id desc")->limit($pg->firstRow . "," . $pg->listRows)->select();

        //分类下的商品和收货地址
        foreach($list as $k=>$v){
            //订单商品
            //$foodList = M("OrderFood")->where("id=" . $v["id"])->select();
            $foodList = M()->query("select fo.*, f.title, f.img_url from bs_order_food fo join bs_food f on f.id=fo.food_id where fo.order_id=" . $v["id"]);
            $list[$k]["foodList"] = $foodList;

            //收货地址
            $accept_address = M("AcceptAddress")->where("id=" . $v["accept_address_id"])->find();
            $list[$k]["accept_address"] = $accept_address;

            //附加费用信息
            $extra_arr = json_decode($v["extra"], true);
            //var_dump($extra_arr);
            foreach($extra_arr as $key=>$val){
                foreach($val as $k3=>$v3){
                    $cfg = M("Syscfg")->where("id='".$k3."'")->find();
                    $list[$k][$k3] = $cfg;
                }
            }
            //优惠信息
            $favor_arr = json_decode($v["favor"], true);
            foreach($favor_arr as $key=>$val){
                foreach($val as $k3=>$v3) {
                    $cfg = M("Syscfg")->where("id='" . $k3 . "'")->find();
                    $arr = json_decode($cfg["content"], true);
                    $cfg["value"] = $arr[$v3];
                    $cfg["key"] = $v3;
                    $list[$k][$k3] = $cfg;
                }
            }

        }

        $this->ajaxReturn(array("data"=>$list, "status"=>1, "info"=>"查询成功"), "JSON", true);
    }

    /**
     * @函数 提交订单
     * @功能
     */
    public function submitOrder(){
        $data["user_id"] = I("post.user_id");
        $data["accept_address_id"] = I("post.accept_address_id");
        $data["remark"] = I("post.remark", "");
        $data["order_type"] = I("post.order_type");
        $data["book_time"] = I("post.book_time");
        $data["status"] = 0;
        $data["order_no"] = $this->generateOrderNo();
        $data["add_time"] = date("Y-m-d H:i:s", time());

        //商品数组
        $foods = I("post.foods");
        $total_money = 0;   //总价
        foreach($foods as $k=>$v){
            $foods[$k]["price"] = M("Food")->where("id=" . $v["food_id"])->getField("price");
            $foods[$k]["sum_money"] = $foods[$k]["price"] * $v["amount"];
            $total_money += $foods[$k]["sum_money"];
        }
        //最大的优惠
        $fillFavor = M("Syscfg")->where("id='fillFavor'")->find();
        $fillFavorArr = json_decode($fillFavor["content"], true);
        $maxK = 0;
        $maxV = 0;
        foreach($fillFavorArr as $k=>$v){
            if($total_money>=$k && $v>$maxV){
                $maxK = $k;
                $maxV = $v;
            }
        }
        $data["favor"] = "[{\"fillFavor\":\"" .$maxK. "\"}]";
        $data["favor_money"] = $maxV;
        //餐盒费
        $foodBoxFee = M("Syscfg")->where("id='foodBoxFee'")->find();
        //配送费
        $deliverFee = M("Syscfg")->where("id='deliverFee'")->find();
        if($data["order_type"] == 2){   //自提
            //额外费用
            $data["extra"] = "[{\"".$foodBoxFee['id']."\" : \"".$foodBoxFee["content"]."\"}]";
            $data["extra_money"] = $foodBoxFee["content"];
        }else if($data["order_type"] == 1){ //外卖
            //额外费用
            $data["extra"] = "[{\"".$foodBoxFee['id']."\" : \"".$foodBoxFee["content"]."\"},{\"".$deliverFee['id']."\":\"".$deliverFee["content"]."\"}]";
            $data["extra_money"] = $foodBoxFee["content"] + $deliverFee["content"];
        }

        $data["old_money"] = $total_money;
        $data["total_money"] = $data["old_money"] - $data["favor_money"] + $data["extra_money"];

        //添加订单
        if($id = M("Order")->add($data)){
            //添加订单商品
            foreach($foods as $k=>$v){
                $v["order_id"] = $id;
                M("OrderFood")->add($v);
            }
            $this->ajaxReturn(array("info"=>"提交订单成功", "status"=>1), "JSON", true);
        }
        $this->ajaxReturn(array("info"=>"提交订单失败", "status"=>0), "JSON", true);
    }

    /**
     * @函数 订单额外信息（如餐盒费、配送费、优惠等）
     * @功能
     * @api参数 total_money
     */
    public function extraInfo(){
        //满优惠
        $total_money = I("post.total_money");
        $fillFavor = M("Syscfg")->where("id='fillFavor'")->find();
        $fillFavorArr = json_decode($fillFavor["content"], true);
            //最大的优惠
        $maxK = 0;
        $maxV = 0;
        foreach($fillFavorArr as $k=>$v){
            if($total_money>=$k && $v>$maxV){
                $maxK = $k;
                $maxV = $v;
            }
        }
        if(!empty($maxK)){
            $fillFavor["content"] = $maxV;
            $fillFavor["title"] = "满".$maxK."元优惠";
        }else{
            $fillFavor = null;
        }

        //餐盒费
        $foodBoxFee = M("Syscfg")->where("id='foodBoxFee'")->find();
        //配送费
        $deliverFee = M("Syscfg")->where("id='deliverFee'")->find();

        $data = array(
            "fillFavor"     =>  $fillFavor,
            "foodBoxFee"    =>  $foodBoxFee,
            "deliverFee"    =>  $deliverFee,
            "realPay"       =>  $total_money - $maxV + $foodBoxFee["content"] + $deliverFee["content"]
        );
        $this->ajaxReturn(array("data"=>$data, "status"=>1, "info"=>"查询成功"), "JSON", true);
    }

    /**
     * @函数 订单编号
     */
    private function generateOrderNo(){
        return time();
    }
}