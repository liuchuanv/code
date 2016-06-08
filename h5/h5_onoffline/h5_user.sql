/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-06-08 15:17:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `h5_user`
-- ----------------------------
DROP TABLE IF EXISTS `h5_user`;
CREATE TABLE `h5_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h5_user
-- ----------------------------
INSERT INTO `h5_user` VALUES ('1', '张三', 'zhangsan@sina.com');
INSERT INTO `h5_user` VALUES ('2', '李四', 'lisi@sina.com');
INSERT INTO `h5_user` VALUES ('3', '王五', 'wangwu@sina.com');
INSERT INTO `h5_user` VALUES ('4', '赵六', 'zhaoliu@sina.com');
INSERT INTO `h5_user` VALUES ('5', '刘七', 'liuqi@sina.com');
INSERT INTO `h5_user` VALUES ('6', '江阳', 'jiangyang@sina.com');
INSERT INTO `h5_user` VALUES ('7', '燕小六', 'yanputou@sina.com');
INSERT INTO `h5_user` VALUES ('8', '邢宝森', 'xingbaosen@sina.com');
INSERT INTO `h5_user` VALUES ('9', '李大嘴', 'lidazui@sina.com');
INSERT INTO `h5_user` VALUES ('10', 'test', 'test');
