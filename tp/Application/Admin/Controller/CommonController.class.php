<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/4
 * Time: 10:07
 */

namespace Admin\Controller;

use Org\Util\Rbac;
use Think\Controller;

class CommonController extends Controller{

    function _initialize(){
        if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $this->redirect('Admin/Login/index');
        }

        //权限验证
        if(!Rbac::AccessDecision()){
            $this->error("您没有权限访问该功能");
        }

        //左侧菜单
        $node = array();

        if(isset($_SESSION['nodeList'])){
            $node = $_SESSION['nodeList'];
        }else{
            if(session(C('ADMIN_AUTH_KEY'))){
                //取出所有的节点
                $node = D('Node')->where('level=2')->order('sort')->relation(true)->select();
            }else {
                //取出所有的节点
                $node = D('Node')->where('level=2')->order('sort')->relation(true)->select();
                //var_dump($node);
                //取出当前登录用户拥有的模块权限（取英文名称）和操作权限（取id）
                $module = "";
                $node_id = '';
                $accessList = $_SESSION['_ACCESS_LIST'];
                foreach($accessList as $k=>$v){
                    foreach ($v as $k1=>$v1) {
                        $module = $module . ',' . $k1;
                        foreach($v1 as $k2=>$v2){
                            $node_id = $node_id . ',' . $v2;
                        }
                    }
                }
                //var_dump($node);
                //对所有的权限进行遍历，先匹配模板，不存在删除，存在则匹配操作权限
                foreach($node as $k=>$v){
                    if(!in_array(strtoupper($v['name']), explode(',',$module))){
                        unset($node[$k]);
                    }else{
                        foreach($v['nodes'] as $k1=>$v1){
                            if(!in_array($v1['id'], explode(',', $node_id))){
                                unset($node[$k]['nodes'][$k1]);
                            }
                        }
                    }
                }
            }
            session('nodeList', $node);
        }
        $this->assign('nodeList', $node);
        $this->assign('controller_name', CONTROLLER_NAME);
        $this->assign('action_name', ACTION_NAME);
    }
}





















