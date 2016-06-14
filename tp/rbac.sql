/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : rbac

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-06-14 11:26:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `think_access`
-- ----------------------------
DROP TABLE IF EXISTS `think_access`;
CREATE TABLE `think_access` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1298 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_access
-- ----------------------------
INSERT INTO `think_access` VALUES ('1297', '9', '140');
INSERT INTO `think_access` VALUES ('1296', '9', '139');
INSERT INTO `think_access` VALUES ('1295', '9', '138');
INSERT INTO `think_access` VALUES ('1128', '2', '121');
INSERT INTO `think_access` VALUES ('1127', '2', '124');
INSERT INTO `think_access` VALUES ('1126', '2', '12');
INSERT INTO `think_access` VALUES ('1125', '2', '116');
INSERT INTO `think_access` VALUES ('1124', '2', '115');
INSERT INTO `think_access` VALUES ('9', '3', '1');
INSERT INTO `think_access` VALUES ('10', '3', '12');
INSERT INTO `think_access` VALUES ('11', '3', '121');
INSERT INTO `think_access` VALUES ('12', '3', '122');
INSERT INTO `think_access` VALUES ('13', '3', '123');
INSERT INTO `think_access` VALUES ('1123', '2', '114');
INSERT INTO `think_access` VALUES ('1122', '2', '113');
INSERT INTO `think_access` VALUES ('1121', '2', '112');
INSERT INTO `think_access` VALUES ('1120', '2', '111');
INSERT INTO `think_access` VALUES ('1119', '2', '11');
INSERT INTO `think_access` VALUES ('1118', '2', '1');
INSERT INTO `think_access` VALUES ('1294', '9', '121');
INSERT INTO `think_access` VALUES ('1293', '9', '124');
INSERT INTO `think_access` VALUES ('1292', '9', '12');
INSERT INTO `think_access` VALUES ('1291', '9', '134');
INSERT INTO `think_access` VALUES ('1290', '9', '135');
INSERT INTO `think_access` VALUES ('1289', '9', '133');
INSERT INTO `think_access` VALUES ('1288', '9', '132');
INSERT INTO `think_access` VALUES ('1287', '9', '131');
INSERT INTO `think_access` VALUES ('1286', '9', '130');
INSERT INTO `think_access` VALUES ('1285', '9', '129');
INSERT INTO `think_access` VALUES ('1284', '9', '128');
INSERT INTO `think_access` VALUES ('1283', '9', '116');
INSERT INTO `think_access` VALUES ('1282', '9', '115');
INSERT INTO `think_access` VALUES ('1281', '9', '114');
INSERT INTO `think_access` VALUES ('1280', '9', '113');
INSERT INTO `think_access` VALUES ('1279', '9', '112');
INSERT INTO `think_access` VALUES ('1278', '9', '111');
INSERT INTO `think_access` VALUES ('1277', '9', '11');
INSERT INTO `think_access` VALUES ('1276', '9', '1');

-- ----------------------------
-- Table structure for `think_article`
-- ----------------------------
DROP TABLE IF EXISTS `think_article`;
CREATE TABLE `think_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(20) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词，以逗号分隔',
  `content` text,
  `link_url` varchar(255) DEFAULT NULL,
  `add_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_article
-- ----------------------------
INSERT INTO `think_article` VALUES ('3', '37', '测试', '特使', '原创', '测试，文章，查看，页面', '<h2>\r\n	2016-06-12 天晴 星期天\r\n</h2>\r\n<p>\r\n	&nbsp; &nbsp; 被6:20的闹钟吵醒了，但困的要死，打了个盹，结果一看手机都7点了，于是乎就没去跑步。<img src=\"/tp/Public/upload/attached/image/20160612/20160612144826_24710.gif\" alt=\"\" />\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp; 把昨天的西红柿鸡蛋热了热，浇在昨天的米饭上，当作早饭了，真是吃的都要吐了。<img src=\"/tp/Public/upload/attached/image/20160612/20160612144950_82822.png\" alt=\"\" />\r\n</p>', null, '2014-06-12 14:49:57');

-- ----------------------------
-- Table structure for `think_form`
-- ----------------------------
DROP TABLE IF EXISTS `think_form`;
CREATE TABLE `think_form` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_form
-- ----------------------------

-- ----------------------------
-- Table structure for `think_group`
-- ----------------------------
DROP TABLE IF EXISTS `think_group`;
CREATE TABLE `think_group` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `title` varchar(50) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_group
-- ----------------------------
INSERT INTO `think_group` VALUES ('2', 'App', '应用中心', '1222841259', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for `think_node`
-- ----------------------------
DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `sort` smallint(6) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_node
-- ----------------------------
INSERT INTO `think_node` VALUES ('114', 'nodeList', '权限管理', '11', '3', '3', '1', '4', '');
INSERT INTO `think_node` VALUES ('138', 'addHandler', '添加文章', '12', '4', '3', '1', '2', '');
INSERT INTO `think_node` VALUES ('121', 'edit', '发布文章', '12', '3', '3', '1', '1', '');
INSERT INTO `think_node` VALUES ('12', 'Article', '文章管理', '1', '2', '2', '1', '2', '');
INSERT INTO `think_node` VALUES ('116', 'userList', '用户管理', '11', '3', '3', '1', '6', '');
INSERT INTO `think_node` VALUES ('139', 'deleteHandler', '文章删除', '12', '4', '3', '1', '3', '');
INSERT INTO `think_node` VALUES ('115', 'addUser', '添加用户', '11', '3', '3', '1', '5', '');
INSERT INTO `think_node` VALUES ('113', 'addNode', '添加权限', '11', '3', '3', '1', '3', '');
INSERT INTO `think_node` VALUES ('112', 'roleList', '角色管理', '11', '3', '3', '1', '2', '');
INSERT INTO `think_node` VALUES ('111', 'addRole', '添加角色', '11', '3', '3', '1', '1', '');
INSERT INTO `think_node` VALUES ('11', 'Rbac', '权限管理', '1', '2', '2', '1', '1', '');
INSERT INTO `think_node` VALUES ('1', 'Admin', 'Rbac后台管理', '0', '1', '1', '1', null, '');
INSERT INTO `think_node` VALUES ('124', 'articleList', '文章列表', '12', '3', '3', '1', '0', '');
INSERT INTO `think_node` VALUES ('128', 'addUserHandler', '添加用户', '11', '4', '3', '1', '7', '');
INSERT INTO `think_node` VALUES ('129', 'resumeUserHandler', '开启/锁定用户', '11', '4', '3', '1', '8', '');
INSERT INTO `think_node` VALUES ('130', 'deleteUserHandler', '删除用户', '11', '4', '3', '1', '9', '');
INSERT INTO `think_node` VALUES ('131', 'addNodeHandler', '添加节点', '11', '4', '3', '1', '10', '');
INSERT INTO `think_node` VALUES ('132', 'deleteNodeHandler', '删除节点', '11', '4', '3', '1', '11', '');
INSERT INTO `think_node` VALUES ('133', 'addRoleHandler', '添加角色', '11', '4', '3', '1', '12', '');
INSERT INTO `think_node` VALUES ('134', 'accessList', '配置权限', '11', '4', '3', '1', '14', '');
INSERT INTO `think_node` VALUES ('135', 'accessHandler', '分配权限', '11', '4', '3', '1', '13', '');
INSERT INTO `think_node` VALUES ('140', 'look', '文章查看', '12', '4', '3', '1', '4', '');

-- ----------------------------
-- Table structure for `think_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_role
-- ----------------------------
INSERT INTO `think_role` VALUES ('1', '超级管理员', '0', '1', '', '0000-00-00 00:00:00');
INSERT INTO `think_role` VALUES ('2', '普通管理员', '0', '1', '', '2016-06-05 11:01:22');
INSERT INTO `think_role` VALUES ('3', '客户', '0', '1', '', '2016-06-05 11:01:16');
INSERT INTO `think_role` VALUES ('8', '测试', null, '1', '和好的角色', '2016-06-05 12:23:13');
INSERT INTO `think_role` VALUES ('9', '特使', null, '1', '行驶一起权利', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `think_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_user`;
CREATE TABLE `think_role_user` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_role_user
-- ----------------------------
INSERT INTO `think_role_user` VALUES ('1', '1', '1');
INSERT INTO `think_role_user` VALUES ('2', '2', '2');
INSERT INTO `think_role_user` VALUES ('12', '2', '3');
INSERT INTO `think_role_user` VALUES ('10', '0', '35');
INSERT INTO `think_role_user` VALUES ('11', '2', '36');
INSERT INTO `think_role_user` VALUES ('13', '9', '37');

-- ----------------------------
-- Table structure for `think_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) NOT NULL,
  `login_ip` varchar(40) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_user
-- ----------------------------
INSERT INTO `think_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'liu21st@gmail.com', '1', '备注信息', '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `think_user` VALUES ('2', 'test', 'e10adc3949ba59abbe56e057f20f883e', '', '1', '', '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `think_user` VALUES ('3', 'user', 'e10adc3949ba59abbe56e057f20f883e', '', '1', '', '0.0.0.0', '0000-00-00 00:00:00', '2016-06-06 16:49:21');
INSERT INTO `think_user` VALUES ('37', '我是特使', 'e10adc3949ba59abbe56e057f20f883e', '', '1', '', '0.0.0.0', '0000-00-00 00:00:00', '2016-06-06 17:12:44');
