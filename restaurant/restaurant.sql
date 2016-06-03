/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : restaurant

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2016-06-03 07:38:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bs_accept_address`
-- ----------------------------
DROP TABLE IF EXISTS `bs_accept_address`;
CREATE TABLE `bs_accept_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL COMMENT '位置（省市县等）',
  `address` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT '1' COMMENT '性别1男0女',
  `contact` varchar(50) DEFAULT NULL,
  `is_default` int(2) DEFAULT '0' COMMENT '1表示默认收货地址',
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of bs_accept_address
-- ----------------------------
INSERT INTO `bs_accept_address` VALUES ('2', '1', '15053203610', '青岛市北区', '山东路130号嘉合新兴1号楼1单元2007室', '1', '刘子楠', '1', '2016-05-12 11:47:56');
INSERT INTO `bs_accept_address` VALUES ('3', '1', '15053203610', '青岛李沧区', '中海国际九水花园11号楼1单元1402室', '1', '海城', '0', '2016-05-12 14:35:48');
INSERT INTO `bs_accept_address` VALUES ('4', '1', '15053203610', '青岛崂山区', '松岭路99号青岛科技大学', '1', '刘传伟', '0', '2016-05-12 11:48:26');
INSERT INTO `bs_accept_address` VALUES ('5', '1', '13687657303', '临沂沂南', '青驼镇刘家河疃', '1', '刘传伟', '0', '2016-05-12 11:53:03');

-- ----------------------------
-- Table structure for `bs_admin`
-- ----------------------------
DROP TABLE IF EXISTS `bs_admin`;
CREATE TABLE `bs_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `reg_time` datetime DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of bs_admin
-- ----------------------------
INSERT INTO `bs_admin` VALUES ('1', 'admin', 'e80b5017098950fc58aad83c8c14978e', '2016-05-06 13:29:17', '2016-05-12 11:59:28');

-- ----------------------------
-- Table structure for `bs_food`
-- ----------------------------
DROP TABLE IF EXISTS `bs_food`;
CREATE TABLE `bs_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `is_show` int(2) DEFAULT NULL,
  `remark` text,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_food
-- ----------------------------
INSERT INTO `bs_food` VALUES ('1', '1', '烤芸豆', '2', 'Uploads/2016-05-06/572c9ee6e80f6.png', '1', 'yu', '2016-05-06 21:54:30');
INSERT INTO `bs_food` VALUES ('2', '1', '烤面筋', '12', 'Uploads/2016-05-06/572c9f1a952d0.png', '1', '', '2016-05-07 13:47:46');
INSERT INTO `bs_food` VALUES ('3', '1', '烤培根', '12', 'Uploads/2016-05-06/572ca22303fac.png', '1', '', '2016-05-07 13:47:55');
INSERT INTO `bs_food` VALUES ('4', '1', '烤五花肉', '10', 'Uploads/2016-05-06/572ca23912058.png', '1', '', '2016-05-07 13:48:04');
INSERT INTO `bs_food` VALUES ('5', '1', '烤馒头片（2片）', '2', 'Uploads/2016-05-06/572ca25d22e63.png', '1', '', '2016-05-06 21:55:53');
INSERT INTO `bs_food` VALUES ('6', '2', '开胃海带', '10', 'Uploads/2016-05-07/572d80096b79c.png', '1', '', '2016-05-07 13:41:41');
INSERT INTO `bs_food` VALUES ('7', '2', '川味口水鸡', '26', 'Uploads/2016-05-07/572d804fd2e24.png', '1', '', '2016-05-07 13:42:57');
INSERT INTO `bs_food` VALUES ('8', '2', '川味凉皮', '16', 'Uploads/2016-05-07/572d806cb062e.png', '1', '', '2016-05-07 13:43:28');
INSERT INTO `bs_food` VALUES ('9', '2', '海豆黄瓜', '14', 'Uploads/2016-05-07/572d808af0bd3.png', '1', '', '2016-05-07 13:44:07');
INSERT INTO `bs_food` VALUES ('10', '2', '蓝莓山药', '18', 'Uploads/2016-05-07/572d80b57487b.png', '1', '', '2016-05-07 13:44:44');
INSERT INTO `bs_food` VALUES ('11', '2', '老醋花生', '14', 'Uploads/2016-05-07/572d80d331e8a.png', '1', '', '2016-05-07 13:45:09');
INSERT INTO `bs_food` VALUES ('12', '3', '香椿炒鸡蛋', '28', 'Uploads/2016-05-07/572d8245af739.png', '1', '', '2016-05-07 13:51:34');
INSERT INTO `bs_food` VALUES ('13', '3', '糖醋里脊', '36', 'Uploads/2016-05-07/572d827dad3ae.png', '1', '', '2016-05-07 13:52:45');
INSERT INTO `bs_food` VALUES ('14', '3', '红烧茄子', '18', 'Uploads/2016-05-07/572d828de98d2.png', '1', '', '2016-05-07 13:52:36');
INSERT INTO `bs_food` VALUES ('15', '3', '地三鲜', '22', 'Uploads/2016-05-07/572d82c6d5805.png', '1', '', '2016-05-07 13:53:28');
INSERT INTO `bs_food` VALUES ('16', '3', '炸黄花鱼', '38', 'Uploads/2016-05-07/572d82de7fd4f.png', '1', '', '2016-05-07 13:53:54');
INSERT INTO `bs_food` VALUES ('17', '3', '梅菜扣肉', '48', 'Uploads/2016-05-07/572d82f92edef.png', '1', '', '2016-05-07 13:54:51');
INSERT INTO `bs_food` VALUES ('18', '3', '酸辣土豆丝', '16', 'Uploads/2016-05-07/572d8312110d1.png', '1', '', '2016-05-07 13:54:45');

-- ----------------------------
-- Table structure for `bs_food_cat`
-- ----------------------------
DROP TABLE IF EXISTS `bs_food_cat`;
CREATE TABLE `bs_food_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `is_show` int(2) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_food_cat
-- ----------------------------
INSERT INTO `bs_food_cat` VALUES ('1', '特色烧烤大串', '1', '');
INSERT INTO `bs_food_cat` VALUES ('2', '爽口凉菜', '1', '');
INSERT INTO `bs_food_cat` VALUES ('3', '精品家常菜', '1', '好吃不腻');
INSERT INTO `bs_food_cat` VALUES ('4', '烤芸豆', '1', '');

-- ----------------------------
-- Table structure for `bs_order`
-- ----------------------------
DROP TABLE IF EXISTS `bs_order`;
CREATE TABLE `bs_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `accept_address_id` int(11) DEFAULT NULL COMMENT '收货地址',
  `order_type` int(2) DEFAULT NULL COMMENT '订单类型1外卖2自提3在这儿吃',
  `book_time` datetime DEFAULT NULL COMMENT '预约时间',
  `status` int(2) DEFAULT NULL COMMENT '0待付款1待发货2待收货3已收货',
  `extra` varchar(255) DEFAULT NULL COMMENT '额外费用id[x,x,x]',
  `extra_money` float DEFAULT NULL,
  `favor` varchar(255) DEFAULT NULL COMMENT '优惠[{id:key}]',
  `favor_money` float DEFAULT NULL,
  `remark` text COMMENT '备注',
  `old_money` float DEFAULT NULL COMMENT '不算额外费用和优惠的总计',
  `total_money` float DEFAULT NULL COMMENT '总价 = old_money + extra - favor',
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='订单';

-- ----------------------------
-- Records of bs_order
-- ----------------------------
INSERT INTO `bs_order` VALUES ('21', '1463023152', '1', '2', '1', '2016-04-12 06:00:00', '1', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"25\"}]', '5', '', '36', '36', '2016-05-12 11:19:12');
INSERT INTO `bs_order` VALUES ('22', '1463035354', '1', '2', '1', '2016-04-12 06:00:00', '-1', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"25\"}]', '5', '', '28', '28', '2016-05-12 14:42:34');
INSERT INTO `bs_order` VALUES ('23', '1463038487', '1', '2', '1', '2016-04-12 06:00:00', '-1', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"20\"}]', '4', '', '20', '21', '2016-05-12 15:34:47');
INSERT INTO `bs_order` VALUES ('24', '1463107318', '1', '2', '1', '2016-04-13 06:00:00', '-1', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"0\"}]', '0', '', '2', '7', '2016-05-13 10:41:58');
INSERT INTO `bs_order` VALUES ('25', '1463151342', '1', '2', '1', '2016-04-13 06:00:00', '0', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"25\"}]', '5', '', '82', '82', '2016-05-13 22:55:42');
INSERT INTO `bs_order` VALUES ('26', '1463151343', '1', '2', '1', '2016-04-13 06:00:00', '0', '[{\"foodBoxFee\" : \"2.0\"},{\"deliverFee\":\"3.0\"}]', '5', '[{\"fillFavor\":\"25\"}]', '5', '', '82', '82', '2016-05-13 22:55:43');

-- ----------------------------
-- Table structure for `bs_order_food`
-- ----------------------------
DROP TABLE IF EXISTS `bs_order_food`;
CREATE TABLE `bs_order_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `amount` int(5) DEFAULT NULL COMMENT '数量',
  `price` float DEFAULT NULL COMMENT '单价',
  `sum_money` float DEFAULT NULL COMMENT '总价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='订单商品';

-- ----------------------------
-- Records of bs_order_food
-- ----------------------------
INSERT INTO `bs_order_food` VALUES ('21', '21', '2', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('22', '21', '4', '1', '10', '10');
INSERT INTO `bs_order_food` VALUES ('23', '21', '1', '1', '2', '2');
INSERT INTO `bs_order_food` VALUES ('24', '21', '3', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('25', '22', '12', '1', '28', '28');
INSERT INTO `bs_order_food` VALUES ('26', '23', '1', '1', '2', '2');
INSERT INTO `bs_order_food` VALUES ('27', '23', '3', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('28', '23', '5', '3', '2', '6');
INSERT INTO `bs_order_food` VALUES ('29', '24', '5', '1', '2', '2');
INSERT INTO `bs_order_food` VALUES ('30', '25', '3', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('31', '25', '1', '1', '2', '2');
INSERT INTO `bs_order_food` VALUES ('32', '25', '4', '1', '10', '10');
INSERT INTO `bs_order_food` VALUES ('33', '25', '2', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('34', '25', '10', '1', '18', '18');
INSERT INTO `bs_order_food` VALUES ('35', '25', '12', '1', '28', '28');
INSERT INTO `bs_order_food` VALUES ('36', '26', '3', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('37', '26', '1', '1', '2', '2');
INSERT INTO `bs_order_food` VALUES ('38', '26', '4', '1', '10', '10');
INSERT INTO `bs_order_food` VALUES ('39', '26', '2', '1', '12', '12');
INSERT INTO `bs_order_food` VALUES ('40', '26', '10', '1', '18', '18');
INSERT INTO `bs_order_food` VALUES ('41', '26', '12', '1', '28', '28');

-- ----------------------------
-- Table structure for `bs_receive_address`
-- ----------------------------
DROP TABLE IF EXISTS `bs_receive_address`;
CREATE TABLE `bs_receive_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `real_name` varchar(50) DEFAULT NULL,
  `is_default` int(2) DEFAULT '0' COMMENT '1表示默认收货地址',
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of bs_receive_address
-- ----------------------------

-- ----------------------------
-- Table structure for `bs_shopping_cart`
-- ----------------------------
DROP TABLE IF EXISTS `bs_shopping_cart`;
CREATE TABLE `bs_shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `amount` int(5) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of bs_shopping_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `bs_smscode`
-- ----------------------------
DROP TABLE IF EXISTS `bs_smscode`;
CREATE TABLE `bs_smscode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `phone` varchar(11) DEFAULT NULL COMMENT '用户手机号',
  `content` varchar(255) DEFAULT '' COMMENT '内容',
  `check_code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `status` int(2) DEFAULT '0' COMMENT '0 未使用 1 使用',
  `code_type` int(2) DEFAULT '0' COMMENT '1 注册 2 找回密码',
  `add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='短信验证码表';

-- ----------------------------
-- Records of bs_smscode
-- ----------------------------
INSERT INTO `bs_smscode` VALUES ('1', null, '13687657303', '', '477859', '1', '1', '2016-05-06 00:06:00');

-- ----------------------------
-- Table structure for `bs_syscfg`
-- ----------------------------
DROP TABLE IF EXISTS `bs_syscfg`;
CREATE TABLE `bs_syscfg` (
  `id` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL COMMENT '餐盒费、配送费、满优惠',
  `content` varchar(255) DEFAULT NULL,
  `cfg_type` int(2) DEFAULT NULL COMMENT '-1优惠1附加费用',
  `remark` varchar(255) DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- ----------------------------
-- Records of bs_syscfg
-- ----------------------------
INSERT INTO `bs_syscfg` VALUES ('deliverFee', '配送费', '3.0', '1', '配送费统一3.0元', '2016-05-07 13:29:05');
INSERT INTO `bs_syscfg` VALUES ('fillFavor', '满优惠', '{\"20\":\"4\", \"25\":\"5\"}', '-1', '满20元优惠4元，满25元优惠5元，满30元优惠6元', '2016-05-07 13:34:32');
INSERT INTO `bs_syscfg` VALUES ('foodBoxFee', '餐盒费', '2.0', '1', '餐盒费统一2.0元', '2016-05-07 13:28:53');
INSERT INTO `bs_syscfg` VALUES ('notice', '店铺公告', '本店终于上线了给您带来的不便请谅解，谢谢大家的支持。米饭自带的请大家不要看错了！1.本店使用饿了么网上订餐，优先配送！ 2.提前40分钟预定，用餐更及时！ 3.意见反馈、开店申请全国客服电话：10105757。', '0', '', '2016-05-07 18:03:07');

-- ----------------------------
-- Table structure for `bs_user`
-- ----------------------------
DROP TABLE IF EXISTS `bs_user`;
CREATE TABLE `bs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `head_img` varchar(255) DEFAULT NULL COMMENT '头像',
  `password` varchar(100) DEFAULT NULL,
  `sex` int(2) DEFAULT '1' COMMENT '0女1男',
  `age` int(4) DEFAULT NULL,
  `reg_time` datetime DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of bs_user
-- ----------------------------
INSERT INTO `bs_user` VALUES ('1', 'test', '15053203610', '1730060902@qq.com', 'Uploads/2016-05-13/yIxgJzmLCy.jpg', 'd41d8cd98f00b204e9800998ecf8427e', '1', '34', '2016-05-03 12:02:48', '2016-05-13 12:11:49');
INSERT INTO `bs_user` VALUES ('2', 'liuc', '13687657303', '1730060902@qq.com', null, 'e80b5017098950fc58aad83c8c14978e', '1', '34', '2016-05-05 23:00:36', '2016-05-05 23:19:49');
INSERT INTO `bs_user` VALUES ('3', '小明', '15053203618', '1254428527@qq.com', null, 'e10adc3949ba59abbe56e057f20f883e', '0', '35', '2016-05-06 13:17:11', null);
