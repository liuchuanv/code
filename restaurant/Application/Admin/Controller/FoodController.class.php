<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class FoodController extends Controller {

    public function __construct(){
        parent::__construct();

        //是否登录
        $admin = session("admin");
        if(empty($admin)){
            $this->error("请先登录", U("Index/index"), 3);
        }
    }

    /**
     * @函数 菜品分类列表
     */
    public function foodCat(){
        $title = I("post.title");
        $condition = " 1=1 ";
        if(!empty($title)){
            $condition .= " and title like '%$title%'";
        }
        $count = M("FoodCat")->where($condition)->count();
        $size = 10;
        $Page = new Page($count, $size);
        $show = $Page->show();
        $data = M("FoodCat")->where($condition)->order("id desc")->limit($Page->firstRow . "," . $Page->listRows)->select();

        $this->assign("list", $data);
        $this->assign("page", $show);
        $this->assign("title", $title);
        $this->display();
    }
    public function foodCatEdit(){
        $id = I("get.id");
        if(empty($id)){ //添加菜品分类
            $this->assign("act", "foodCatAdd");
        }else{          //更新菜品分类
            $foodCat = M("FoodCat")->where("id=$id")->find();
            $this->assign("item", $foodCat);
            $this->assign("act", "foodCatUpdate");
        }
        $this->display();
    }
    public function foodCatUpdate(){
        $data['id'] = I("post.id");
        $data['title'] = I("post.title");
        $data['is_show'] = I("post.is_show");
        $data['remark'] = I("post.remark");
        if(M("FoodCat")->save($data)){
            $this->success("更新菜品成功", U("Food/foodCat"),3);
        }else{
            $this->success("更新菜品失败", U("Food/foodCat"),3);
        }
    }
    public function foodCatAdd(){
        $data['title'] = I("post.title");
        $data['is_show'] = I("post.is_show");
        $data['remark'] = I("post.remark");
        if(M("FoodCat")->add($data)){
            $this->success("添加菜品成功", U("Food/foodCat"),3);
        }else{
            $this->success("添加菜品失败", U("Food/foodCat"),3);
        }
    }

    /*** 菜品 ***/
    /**
     * @函数 菜品列表
     */
    public function food(){
        $title = I("post.title");
        $condition = " 1=1 ";
        if(!empty($title)){
            $condition .= " and f.title like '%$title%'";
        }
        $count = M("Food")->alias("f")->where($condition)->count();
        $size = 10;
        $Page = new Page($count, $size);
        $show = $Page->show();
        $sql = "select f.*, fc.title catname from bs_food f join bs_food_cat fc on f.cat_id=fc.id where $condition order by f.id desc limit $Page->firstRow,$Page->listRows";
        $data = M()->query($sql);
        $this->assign("list", $data);
        $this->assign("page", $show);
        $this->assign("title", $title);
        $this->display();
    }
    public function foodEdit(){
        $id = I("get.id");
        if(empty($id)){ //添加菜品分类
            $this->assign("act", "foodAdd");
        }else{          //更新菜品分类
            $foodCat = M("Food")->where("id=$id")->find();
            $this->assign("item", $foodCat);
            $this->assign("act", "foodUpdate");
        }
        //菜品分类
        $clist = M("FoodCat")->where("is_show=1")->select();
        $this->assign("catList", $clist);
        $this->display();
    }
    public function foodUpdate(){
        $data['id'] = I("post.id");
        $data['title'] = I("post.title");
        $data['cat_id'] = I("post.cat_id");
        $data['price'] = I("post.price");
        $data['img_url'] = I("post.img_url");
        $data['is_show'] = I("post.is_show");
        $data['remark'] = I("post.remark");
        $data['modify_time'] = date("Y-m-d H:i:s", time());
        if(M("Food")->save($data)){
            $this->success("更新菜品成功", U("Food/food"),1);
        }else{
            $this->success("更新菜品失败", U("Food/food"),1);
        }
    }
    public function foodAdd(){
        $data['title'] = I("post.title");
        $data['cat_id'] = I("post.cat_id");
        $data['price'] = I("post.price");
        $data['img_url'] = I("post.img_url");
        $data['is_show'] = I("post.is_show");
        $data['remark'] = I("post.remark");
        $data['modify_time'] = date("Y-m-d H:i:s", time());
        if(M("Food")->add($data)){
            $this->success("添加菜品成功", U("Food/food"),1);
        }else{
            $this->success("添加菜品失败", U("Food/food"),1);
        }
    }
}