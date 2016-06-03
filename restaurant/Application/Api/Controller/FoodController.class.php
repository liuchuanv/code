<?php
namespace Api\Controller;
use Think\Controller;
use Think\Page;

class FoodController extends Controller {
    /**
     * @函数 商品列表
     * @功能 分类下的商品列表
     * @api参数  catId
     */
    public function getFoodList(){
        $catId = I("post.catId");
        $condition = " is_show=1 ";
        if(!empty($catId)){
            $condition .= " and id=$catId ";
        }

        //分类列表（分页）
        $count = M("FoodCat")->where($condition)->count();
        $size = 10;
        $pg = new Page($count,$size);
        $catList = M("FoodCat")->where($condition)->limit($pg->firstRow . "," . $pg->listRows)->select();

        //分类下的商品
        foreach($catList as $k=>$v){
            $condition = " is_show=1 and cat_id=" . $v['id'];
            $foodList = M("Food")->where($condition)->select();
            $catList[$k]["foodList"] = $foodList;
        }

        $this->ajaxReturn(array("data"=>$catList, "status"=>1, "info"=>"查询成功"), "JSON", true);
    }
}