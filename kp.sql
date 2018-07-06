/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : kp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-06 18:53:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kp_category
-- ----------------------------
DROP TABLE IF EXISTS `kp_category`;
CREATE TABLE `kp_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '栏目类型',
  `name` varchar(30) NOT NULL DEFAULT '',
  `nickname` varchar(50) NOT NULL DEFAULT '',
  `flag` set('hot','index','recommend') NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `diyname` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义名称',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `weigh` (`weigh`,`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='分类表';

-- ----------------------------
-- Records of kp_category
-- ----------------------------
INSERT INTO `kp_category` VALUES ('14', '0', 'default', '医疗功能房间', '医疗功能房间', '', '', '', '', '', '1527478254', '1529388873', '150', 'normal');
INSERT INTO `kp_category` VALUES ('16', '14', 'default', '门诊', '门诊', '', '', '', '', '', '1527478648', '1528202962', '16', 'normal');
INSERT INTO `kp_category` VALUES ('17', '0', 'default', '医院系统', '医院系统', '', '', '', '', '', '1527597699', '1528980720', '117', 'normal');
INSERT INTO `kp_category` VALUES ('18', '17', 'default', '给排水系统', '给排水系统', '', '', '', '', '', '1527597713', '1527597713', '18', 'normal');
INSERT INTO `kp_category` VALUES ('20', '0', 'page', '设计阶段', '设计阶段', '', '', '', '', '', '1528202097', '1528701420', '99', 'normal');
INSERT INTO `kp_category` VALUES ('21', '0', 'page', '施工阶段', '施工阶段', '', '', '', '', '', '1528202106', '1528701430', '98', 'normal');
INSERT INTO `kp_category` VALUES ('22', '0', 'page', '运维阶段', '运维阶段', '', '', '', '', '', '1528202120', '1528701440', '97', 'normal');
INSERT INTO `kp_category` VALUES ('23', '20', 'page', '建筑', '建筑', '', '', '', '', '', '1528202146', '1528701451', '96', 'normal');
INSERT INTO `kp_category` VALUES ('25', '20', 'page', '给排水', '给排水', '', '', '', '', '', '1528202181', '1528701535', '94', 'normal');
INSERT INTO `kp_category` VALUES ('26', '20', 'page', '电气', '电气', '', '', '', '', '', '1528202191', '1528701563', '93', 'normal');
INSERT INTO `kp_category` VALUES ('29', '14', 'default', '医技', '医技', '', '', '', '', '', '1528202420', '1528202420', '29', 'normal');
INSERT INTO `kp_category` VALUES ('30', '14', 'default', '住院', '住院', '', '', '', '', '', '1528202435', '1528202435', '30', 'normal');
INSERT INTO `kp_category` VALUES ('31', '17', 'default', '暖通系统', '暖通系统', '', '', '', '', '', '1528202451', '1528202451', '31', 'normal');
INSERT INTO `kp_category` VALUES ('32', '17', 'default', '电气系统', '电气系统', '', '', '', '', '', '1528202473', '1528202473', '32', 'normal');
INSERT INTO `kp_category` VALUES ('33', '17', 'default', '医疗专项系统', '医疗专项系统', '', '', '', '', '', '1528202488', '1528202488', '33', 'normal');
INSERT INTO `kp_category` VALUES ('34', '0', 'default', '医疗功能分区', '医疗功能分区', '', '', '', '', '', '1528202499', '1529388801', '40', 'normal');
INSERT INTO `kp_category` VALUES ('39', '24', 'page', '设计要求', '设计要求', '', '', '', '', '', '1528202831', '1528202831', '39', 'normal');
INSERT INTO `kp_category` VALUES ('40', '24', 'page', '设计要点', '设计要点', '', '', '', '', '', '1528202840', '1528202840', '40', 'normal');
INSERT INTO `kp_category` VALUES ('47', '29', 'default', '放射科', '放射科', '', '', '', '', '', '1528428473', '1528428473', '47', 'normal');
INSERT INTO `kp_category` VALUES ('48', '47', 'default', 'CT机房', 'CT机房', '', '', '', '', '', '1528428486', '1528428486', '48', 'normal');
INSERT INTO `kp_category` VALUES ('53', '20', 'page', '结构', '结构', '', '', '', '', '', '1528683920', '1528701487', '95', 'normal');
INSERT INTO `kp_category` VALUES ('56', '22', 'page', '建筑', '建筑', '', '', '', '', '', '1528683983', '1528701884', '99', 'normal');
INSERT INTO `kp_category` VALUES ('57', '21', 'page', '结构', '结构', '', '', '', '', '', '1528684007', '1528701733', '98', 'normal');
INSERT INTO `kp_category` VALUES ('58', '21', 'page', '给排水', '给排水', '', '', '', '', '', '1528684029', '1528701739', '97', 'normal');
INSERT INTO `kp_category` VALUES ('59', '21', 'page', '电气', '电气', '', '', '', '', '', '1528684068', '1528701749', '96', 'normal');
INSERT INTO `kp_category` VALUES ('60', '21', 'page', '暖通', '暖通', '', '', '', '', '', '1528684087', '1528685995', '60', 'normal');
INSERT INTO `kp_category` VALUES ('61', '21', 'page', '建筑', '建筑', '', '', '', '', '', '1528684109', '1528701727', '99', 'normal');
INSERT INTO `kp_category` VALUES ('62', '22', 'page', '结构', '结构', '', '', '', '', '', '1528684126', '1528701889', '98', 'normal');
INSERT INTO `kp_category` VALUES ('63', '22', 'page', '给排水', '暖通', '', '', '', '', '', '1528684144', '1528701903', '97', 'normal');
INSERT INTO `kp_category` VALUES ('64', '22', 'page', '电气', '电气', '', '', '', '', '', '1528684160', '1528701909', '96', 'normal');
INSERT INTO `kp_category` VALUES ('65', '22', 'page', '暖通', '暖通', '', '', '', '', '', '1528684174', '1528701916', '95', 'normal');
INSERT INTO `kp_category` VALUES ('66', '22', 'page', '管理', '管理', '', '', '', '', '', '1528684207', '1528686732', '66', 'normal');
INSERT INTO `kp_category` VALUES ('81', '20', 'page', '暖通', '暖通', '', '', '', '', '', '1528701595', '1528701619', '81', 'normal');
INSERT INTO `kp_category` VALUES ('95', '47', 'default', '钼靶检查室', '钼靶检查室', '', '', '', '', '', '1528714685', '1528714685', '95', 'normal');
INSERT INTO `kp_category` VALUES ('96', '29', 'default', '手术室', '手术室', '', '', '', '', '', '1528791764', '1528791764', '96', 'normal');
INSERT INTO `kp_category` VALUES ('97', '96', 'default', '妇科手术室', '妇科手术室', '', '', '', '', '', '1528791791', '1528791791', '97', 'normal');
INSERT INTO `kp_category` VALUES ('98', '34', 'default', '测试分区1', '测试分区1', '', '', '', '', '', '1529388776', '1529388776', '98', 'normal');
INSERT INTO `kp_category` VALUES ('99', '34', 'default', '测试分区2', '测试分区2', '', '', '', '', '', '1529388788', '1529388788', '99', 'normal');
INSERT INTO `kp_category` VALUES ('100', '29', 'default', 'DR', 'DR', '', '', '', '', '', '1529546145', '1529546145', '100', 'normal');
INSERT INTO `kp_category` VALUES ('101', '30', 'default', '病房值班室', '病房值班室', '', '', '', '', '', '1529573176', '1529573176', '101', 'normal');
INSERT INTO `kp_category` VALUES ('102', '30', 'default', '医生办公室', '医生办公室', '', '', '', '', '', '1529573202', '1529573202', '102', 'normal');
INSERT INTO `kp_category` VALUES ('103', '30', 'default', '病房治疗室', '病房治疗室', '', '', '', '', '', '1529573221', '1529573221', '103', 'normal');
INSERT INTO `kp_category` VALUES ('130', '32', 'default', '123', '', '', '', '', '', '', '1530695051', '1530695051', '0', 'normal');
INSERT INTO `kp_category` VALUES ('136', '18', 'default', '是', '', '', '', '', '', '', '1530695434', '1530695434', '0', 'normal');
INSERT INTO `kp_category` VALUES ('137', '136', 'default', '是 的', '', '', '', '', '', '', '1530695438', '1530695438', '0', 'normal');
INSERT INTO `kp_category` VALUES ('138', '31', 'default', '123', '', '', '', '', '', '', '1530695488', '1530695488', '0', 'normal');
INSERT INTO `kp_category` VALUES ('139', '33', 'default', '123', '', '', '', '', '', '', '1530695516', '1530695516', '0', 'normal');
INSERT INTO `kp_category` VALUES ('140', '139', 'default', '1231', '', '', '', '', '', '', '1530695521', '1530695521', '0', 'normal');
INSERT INTO `kp_category` VALUES ('155', '98', 'default', 's', '', '', '', '', '', '', '1530755239', '1530755239', '0', 'normal');
INSERT INTO `kp_category` VALUES ('156', '99', 'default', 'd', '', '', '', '', '', '', '1530755259', '1530755259', '0', 'normal');

-- ----------------------------
-- Table structure for kp_content
-- ----------------------------
DROP TABLE IF EXISTS `kp_content`;
CREATE TABLE `kp_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `category_id` int(10) NOT NULL DEFAULT '0',
  `title_id` int(10) NOT NULL DEFAULT '0',
  `user_id` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `title_id` (`title_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='内容表';

-- ----------------------------
-- Records of kp_content
-- ----------------------------
INSERT INTO `kp_content` VALUES ('1', '测试内容', '14', '1', '');

-- ----------------------------
-- Table structure for kp_kptype
-- ----------------------------
DROP TABLE IF EXISTS `kp_kptype`;
CREATE TABLE `kp_kptype` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '知识点类型ID',
  `name` varchar(60) NOT NULL COMMENT '知识点类型名称',
  `weigh` int(11) NOT NULL COMMENT '权重',
  `status` enum('0','1','2') NOT NULL COMMENT '状态:0=隐藏,1=免费,2=收费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of kp_kptype
-- ----------------------------
INSERT INTO `kp_kptype` VALUES ('1', '强制规范', '10', '1');
INSERT INTO `kp_kptype` VALUES ('2', '国家规范', '6', '1');
INSERT INTO `kp_kptype` VALUES ('3', '地方规范', '5', '1');
INSERT INTO `kp_kptype` VALUES ('4', '行业规范', '4', '1');
INSERT INTO `kp_kptype` VALUES ('5', '厂商设备资料', '3', '1');
INSERT INTO `kp_kptype` VALUES ('6', '建设心得体会', '2', '1');

-- ----------------------------
-- Table structure for kp_standard
-- ----------------------------
DROP TABLE IF EXISTS `kp_standard`;
CREATE TABLE `kp_standard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章表';

-- ----------------------------
-- Records of kp_standard
-- ----------------------------
INSERT INTO `kp_standard` VALUES ('2', '2', '中华现代临床护理学杂志');
INSERT INTO `kp_standard` VALUES ('13', '6', '《医疗功能房间详图详解》');
INSERT INTO `kp_standard` VALUES ('14', '6', '《医用电气设备》GB9706.19-2000');
INSERT INTO `kp_standard` VALUES ('15', '6', '《绿色医院建筑评价标准》');
INSERT INTO `kp_standard` VALUES ('16', '6', '《医用内窥镜及附件通用要求》GB11244-2005');
INSERT INTO `kp_standard` VALUES ('17', '1', '《综合医院建筑设计规范》GB51039-2014');

-- ----------------------------
-- Table structure for kp_tag
-- ----------------------------
DROP TABLE IF EXISTS `kp_tag`;
CREATE TABLE `kp_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='标签表';

-- ----------------------------
-- Records of kp_tag
-- ----------------------------

-- ----------------------------
-- Table structure for kp_title
-- ----------------------------
DROP TABLE IF EXISTS `kp_title`;
CREATE TABLE `kp_title` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL DEFAULT '0',
  `standard_id` int(10) NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `level` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `standard_id` (`standard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='目录表';

-- ----------------------------
-- Records of kp_title
-- ----------------------------
INSERT INTO `kp_title` VALUES ('1', '0', '2', '中华现代临床护理学杂志', '0');
INSERT INTO `kp_title` VALUES ('5', '1', '2', '序', '1');
INSERT INTO `kp_title` VALUES ('6', '1', '2', '23423432', '1');
INSERT INTO `kp_title` VALUES ('7', '1', '2', '123', '1');
INSERT INTO `kp_title` VALUES ('8', '1', '2', '14124', '1');
INSERT INTO `kp_title` VALUES ('9', '1', '2', '1231111', '1');
INSERT INTO `kp_title` VALUES ('10', '1', '2', '34444', '1');

-- ----------------------------
-- Table structure for kp_title_tag
-- ----------------------------
DROP TABLE IF EXISTS `kp_title_tag`;
CREATE TABLE `kp_title_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title_id` int(10) NOT NULL DEFAULT '0',
  `tag_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='章节和标签关联表';

-- ----------------------------
-- Records of kp_title_tag
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;
