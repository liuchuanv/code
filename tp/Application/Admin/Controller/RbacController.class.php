<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/4
 * Time: 10:06
 */

namespace Admin\Controller;

//权限管理
use Think\Page;
use Org\Util\Tree;

class RbacController extends CommonController {

    //初始化操作
    function _initialize(){
        //if(!IS_AJAX) $this->error('你访问的页面不存在，请稍后再试');
        parent::_initialize();
    }

    //用户列表
    public function userList(){
        $db = D('user');
        $count = $db->count();
        $Page = new Page($count, 10);
        $this->page = $Page->show();
        $this->list = $db->relation(true)->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->display();
    }

    //添加编辑用户弹层表单
    public function addUser(){
        //如果设置了uid，则为编辑用户，否则为增加用户
        $this->roleList = M('role')->where('status = 1')->field('id,name')->select();

        $data = array(
            'username' => '用户名'
        );
        if(isset($_GET['id'])) {
            $data = M('user')->where( "id = $_GET[id]" )->find();
        }
        $this->item = $data;
        $this->display();
    }

    //添加及编辑用户表单处理
    public function addUserHandler(){
        $db = M('user');
        if($_POST['id']) {
            //如果存在ID，即表示更新
            $data = array(
                'id' => I('post.id','','int'),
                'username' => I('username', '', 'string'),
                'status' => I('status','', 'int'),
                'remark' => I('remark'),
                'create_time' => date('Y-m-d H:i:s',time()),
                'login_ip' => get_client_ip()
            );

            if($_POST['password']) $data['password'] = I('password','', 'md5');
            if($db->save($data)) {
                $roleuser = M('role_user');
                $roleuser->where("id = $data[id]")->delete();
                $roleuser->add(array(
                    'role_id' => I('role_id','','intval'),
                    'user_id' => $data[id]
                ));
                $this->success('更新成功', U('Rbac/userList'));
            } else {
                $this->error('更新失败', U('Rbac/userList'));
            }
            return ;
        }

        //添加表单处理
        $data = array(
            'username' => I('username', '', 'string'),
            'password' => I('password', '', 'md5'),
            'status' => I('status','', 'int'),
            'remark' => I('remark'),
            'create_time' => date('Y-m-d H:i:s',time()),
            'login_ip' => get_client_ip()
        );
        if($uid = M('user')->add($data)) {
            $roleuser = M('role_user');

            $roleuser->where("id = $uid")->delete();

            $roleuser->add(array(
                'role_id' => I('role_id','','intval'),
                'user_id' => $uid
            ));

            $this->success('添加成功', U('Rbac/userList'));
        } else {
            $this->error('添加失败', U('Rbac/userList'));
        }
    }

    //启用或锁定用户
    public function resumeUserHandler(){
        $id = I('get.id','0','int');
        $db = M('user');
        $status = $db->where("id = $id")->getField('status');
        $status = ($status == 1)? 0 : 1 ;
        if($db->where("id = $id")->setField('status', $status)){
            $this->success('操作成功', U('Rbac/userList'));
        } else {
            $this->error('操作失败', U('Rbac/userList'));
        }
    }

    //删除用户
    public function deleteUserHandler(){
        $id = I('get.id',0,'int');
        if( M('user')->delete($id) ) {
            $this->success('操作成功', U('Rbac/userList'));
        } else {
            $this->error('操作失败', U('Rbac/userList'));
        }
    }

    //节点列表
    public function nodeList(){
        $db = M('node');
        $count      = $db->where('status=1')->count();// 查询满足要求的总记录数
        $Page       = new Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $db->where('status=1')->order('sort')->select();
        $this->list = array_slice(Tree::create($list),$Page->firstRow,$Page->listRows);
        $this->page = $show;
        $this->display();
    }

    //添加及编辑节点表单
    public function addNode(){
        if($_GET['id']) {
            //编辑模式
            $this->item = M('node')->where(array('id'=>$_GET['id']))->find();
        }
        $this->node = M('node')->where('level<3')->order('id ')->select();
        $this->display();
    }

    //添加及编辑节点表单处理
    public function addNodeHandler(){
        $id = $_POST['id'];
        $data = $_POST;
        $data['level'] = $data['type'] > 3 ? 3 : $data['type'];
        $db = M('node');
        if($id) {
            //更新
            if($db->save($data)) {
                $this->success('更新成功', U('Rbac/nodeList'));
            } else {
                $this->error('更新失败', U('Rbac/nodeList'));
            }
        }else {
            //保存
            if($db->add($data)) {
                $this->success('添加成功', U('Rbac/nodeList'));
            } else {
                $this->error('添加失败', U('Rbac/nodeList'));
            }
        }
    }

    //删除节点
    public function deleteNodeHandler(){
        $id = I('get.id','0','int');
        $db = M('node');
        $data = $db->where(array('pid'=>$id))->field('id')->find();
        if($data) {
            $this->error('你请求删除的节点存在子节点，不可直接删除', U('Rbac/nodeList'));
        } else {
            if($db->delete($id)) {
                $this->success('删除成功', U('Rbac/nodeList'));
            } else {
                $this->error('删除失败', U('Rbac/nodeList'));
            }
        }
    }

    //角色管理
    public function roleList(){
        $role = M('role');
        $count      = $role->where('status=1')->count();// 查询满足要求的总记录数
        $Page       = new Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $role->where('status=1')->order('id')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

    //添加及编辑角色
    public function addRole(){
        if($_GET['rid']) {
            $id = I('get.rid',0,'int');
            $role = M('role')->find($id);
            $this->assign('item', $role);
        }
        $this->display();
    }

    //添加角色表单处理
    public function addRoleHandler(){
        //Post数据
        $data = $_POST; //create_time在数据库mysql中类型是timestamp，并且设置了根据当前时间戳更新

        $db = M('role');
        if($_POST['id']) {
            //更新
            if($db->save($data)) {
                $this->success('角色信息更新成功', U('Rbac/roleList'));
            } else {
                $this->error('角色信息更新失败', U('Rbac/roleList'));
            }
        } else {
            //添加表单处理
            if($db ->add($data)){
                $this->success('角色添加成功', U('Rbac/roleList'));
            }else {
                $this->error('角色添加失败', U('Rbac/roleList'));
            }
        }
    }

    //给角色添加节点权限
    public function accessList(){
        $rid = I('rid',0 ,'intval');
        $this->role = M('role')->where("id=$rid")->find();
        $node = M('node')->where(array('status'=>1))->field(array('id','title','pid','name','type','level'))->order('sort')->select();

        $arr = array('', '项目', '模块', '操作', '功能');
        //获取原有权限
        $access = M('access')->where("role_id = $rid")->getField('node_id',true);
        foreach($node as $k=>$v){
            foreach($access as $k2=>$v2){
                if($v2 == $v['id']){
                    $node[$k]['checked'] = true;
                }
            }
            $node[$k]['open'] = true;
            $node[$k]['name'] = '['.$arr[$v['type']] .'] '. $node[$k]['title'] . $node[$k]['name'];
        }
        $this->nodeJsonStr = json_encode($node);
        $this->assign('rid',$rid)->display();
    }

    //添加节点权限表单处理
    public function accessHandler(){
        $rid = I('rid', '', 'intval');
        $db = M('access');
        //清空原有权限
        $db->where("role_id = $rid")->delete();

        //插入新的权限
        $data = array();
        foreach ($_POST['access'] as $v) {
            $data[] = array(
                'role_id'=> $rid,
                'node_id'=> $v
            );
        }
        if($db->addAll($data)) {
            $this->ajaxReturn(array(
                'statusCode' => 1,
                'message' => '操作成功'
            ));
        } else {
            $this->ajaxReturn(array(
                'statusCode' => 0,
                'message' => '操作失败'
            ));
        }
    }
}