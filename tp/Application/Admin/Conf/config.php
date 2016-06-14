<?php
return array(
	//'配置项'=>'配置值'

    "USER_AUTH_ON" => true,                    //是否开启权限验证(必配)
    "USER_AUTH_TYPE" => 1,                     //验证方式（1、登录验证；2、实时验证）

    "USER_AUTH_KEY" => 'uid',                  //用户认证识别号(必配)
    "ADMIN_AUTH_KEY" => 'superadmin',    //                 //超级管理员识别号(必配)
    "USER_AUTH_MODEL" => 'user',               //验证用户表模型 ly_user
    'USER_AUTH_GATEWAY'  =>  '/Public/login',  //用户认证失败，跳转URL

    'AUTH_PWD_ENCODER'=>'md5',                 //默认密码加密方式

    "RBAC_SUPERADMIN" => 'admin',              //超级管理员名称


    "NOT_AUTH_MODULE" => 'Index,Public',       //无需认证的控制器
    "NOT_AUTH_ACTION" => 'addUserHandler,deleteUserHandler,resumeUserHandler,
                            addNodeHandler,deleteNodeHandler,
                            addRoleHandler,
                            accessList,accessHandler',              //无需认证的方法

//    'REQUIRE_AUTH_MODULE' =>  '',              //默认需要认证的模块
//    'REQUIRE_AUTH_ACTION' =>  '',              //默认需要认证的动作

    'GUEST_AUTH_ON'   =>  false,               //是否开启游客授权访问
    'GUEST_AUTH_ID'   =>  0,                   //游客标记

    "RBAC_ROLE_TABLE" => 'think_role',            //角色表名称(必配)
    "RBAC_USER_TABLE" => 'think_role_user',       //用户角色中间表名称(必配)
    "RBAC_ACCESS_TABLE" => 'think_access',        //权限表名称(必配)
    "RBAC_NODE_TABLE" => 'think_node',            //节点表名称(必配)


);