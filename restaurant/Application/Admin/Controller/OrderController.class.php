<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class OrderController extends Controller {

    public function __construct(){
        parent::__construct();
        //是否登录
        $admin = session("admin");
        if(empty($admin)){
            $this->error("请先登录", U("Index/index"), 3);
        }
    }

    /**
     * @函数 订单列表
     * @功能 显示订单简要信息
     */
    public function index(){
        $status = I("get.status") ? I("get.status") : 1;    //默认已付款订单
        $uname = I("post.uname");
        $condition = " o.status=$status ";
        if(!empty($uname)){
            $condition .= " and u.uname=$uname";
        }
        $sql_count = "select count(*) count from bs_order o join bs_user u on u.id=o.user_id where $condition ";
        $count = M()->query($sql_count)[0]['count'];
        $size = 10;
        $Page = new Page($count, $size);
        $show = $Page->show();

        $sql_list = "select u.uname,a.contact, a.address, a.phone,o.id, o.order_no, o.order_type, o.book_time, o.total_money, o.add_time from bs_order o
                            join bs_user u on u.id=o.user_id join bs_accept_address a on o.accept_address_id=a.id
                     where $condition order by o.id desc limit $Page->firstRow,$Page->listRows";
        $data = M()->query($sql_list);

        $this->assign("list",$data);
        $this->assign("page",$show);
        $this->assign("uname",$uname);
        $this->assign("status",$status);

        $this->display();
    }

    /**
     * @函数 订单详情
     * @功能
     */
    public function detail(){
        $id = I("get.id");

        $this->display();
    }
}