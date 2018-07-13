/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : kp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-07-13 19:14:23
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
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='分类表';

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
INSERT INTO `kp_category` VALUES ('32', '17', 'default', '电气系统', '电气系统', '', '', '', '', '', '1528202473', '1528202473', '32', 'normal');
INSERT INTO `kp_category` VALUES ('33', '17', 'default', '医疗专项系统', '医疗专项系统', '', '', '', '', '', '1528202488', '1528202488', '33', 'normal');
INSERT INTO `kp_category` VALUES ('34', '0', 'default', '医疗功能分区', '医疗功能分区', '', '', '', '', '', '1528202499', '1529388801', '40', 'normal');
INSERT INTO `kp_category` VALUES ('39', '24', 'page', '设计要求', '设计要求', '', '', '', '', '', '1528202831', '1528202831', '39', 'normal');
INSERT INTO `kp_category` VALUES ('40', '24', 'page', '设计要点', '设计要点', '', '', '', '', '', '1528202840', '1528202840', '40', 'normal');
INSERT INTO `kp_category` VALUES ('47', '29', 'default', '放射科', '放射科', '', '', '', '', '', '1528428473', '1528428473', '47', 'normal');
INSERT INTO `kp_category` VALUES ('48', '47', 'default', 'CT机房', 'CT机房', '', '', '', '', '', '1528428486', '1528428486', '48', 'normal');
INSERT INTO `kp_category` VALUES ('53', '20', 'page', '结构', '结构', '', '', '', '', '', '1528683920', '1528701487', '95', 'normal');
INSERT INTO `kp_category` VALUES ('56', '22', 'page', '建筑', '建筑', '', '', '', '', '', '1528683983', '1528701884', '99', 'normal');
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
INSERT INTO `kp_category` VALUES ('136', '18', 'default', '是', '', '', '', '', '', '', '1530695434', '1530695434', '0', 'normal');
INSERT INTO `kp_category` VALUES ('137', '136', 'default', '是 的', '', '', '', '', '', '', '1530695438', '1530695438', '0', 'normal');
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
  `content` text NOT NULL,
  `category_id` int(10) NOT NULL DEFAULT '0',
  `title_id` int(10) NOT NULL DEFAULT '0',
  `user` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `title_id` (`title_id`),
  KEY `user_id` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='内容表';

-- ----------------------------
-- Records of kp_content
-- ----------------------------
INSERT INTO `kp_content` VALUES ('1', 'Laravel 提供了许多有用的验证规则，同时也支持自定义规则。注册自定义验证规则的方法之一，就是使用规则对象。可以使用 Artisan 命令 make:rule 来生成新的规则对象。接下来，让我们用这个命令生成一个验证字符串是大写的规则。Laravel 会将新的规则存放在 app/Rules 目录中', '1', '1', '1');
INSERT INTO `kp_content` VALUES ('3', '有人认为发射次数多就是“金牌火箭”，有人认为可靠性高就是“金牌火箭”。按照国际惯例，一枚火箭发射成功率超过95%以上，就可以称之为“金牌火箭”，这就意味着20次发射中只允许有1次失利。而长二丙火箭在1998年，就已经达到了这个成功率，被当时中国航天工业总公司授予“优质长征二号丙运载火箭金牌”。\n据长二丙火箭副总指挥郭武介绍，长二丙火箭是目前唯一一个发射低轨道、中轨道的火箭，也是第一个“征战”过太原、酒泉、西昌3 个发射场的火箭，它以质量可靠、适应能力强著称。它的个头是众多火箭兄弟中偏小的，但却是“ 金牌火箭”中的“老大哥”。从2003年12月到2004年11月不到1年的时间里，长二丙火箭以两种技术状态，分赴3个卫星发射场，成功进行5次发射，将6颗不同卫星送入太空。', '1', '5', '1');
INSERT INTO `kp_content` VALUES ('4', '描述的对象结构（使用prototype.prop = undefined）不仅仅是任意的：Swagger.io JS生成器实际上创建了这样的对象模型，以表示缺少但可能的属性。由于我们不能在Vue中使用缺少的对象属性进行数据绑定，因此必须扩展此类对象，将缺少的属性明确地设置为某个值（例如，未定义的oder空字符串等）', '1', '23', '');
INSERT INTO `kp_content` VALUES ('5', '连尚网络旗下产品WiFi万能钥匙是全球网络共享平台,基于共享经济的模式,通过云计算和大数据技术,利用热点主人分享的闲置WiFi资源,为用户提供免费、稳定、安全的上网服务。', '1', '31', '');
INSERT INTO `kp_content` VALUES ('6', '前端开发的入门门槛其实很低，前端与服务器端语言先慢后快的学习曲线相比，前端开发的学习曲线是先快后慢。HTML 甚至不是一门语言，他仅仅是简单的标记语言！CSS 只是无类型的样式修饰语言。当然可以勉强算作弱类型语言。Javascript 的基础部分相对来说不难，入手还算快。也正因为如此，前端开发领域有很多自学成“才”的同行，但大多数人都停留在会用的阶段，因为后面的学习曲线越来越陡峭，每前进一步都很难。', '1', '33', '');
INSERT INTO `kp_content` VALUES ('7', '地方的咖啡机浪费进到房间里街坊邻居；零三分 富婆的肌肤蓝色', '1', '46', '');
INSERT INTO `kp_content` VALUES ('8', '主体建筑的平面布置、结构形式和家电设计，应为今后发展、改造和灵活分隔创造条件。', '1', '70', '');
INSERT INTO `kp_content` VALUES ('9', '见风使舵缉私局覅方法来得及愤怒的发', '1', '47', '');
INSERT INTO `kp_content` VALUES ('10', '很爽快的哈萨克哈萨克 很多刷卡', '1', '71', '');

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
-- Table structure for kp_sentence
-- ----------------------------
DROP TABLE IF EXISTS `kp_sentence`;
CREATE TABLE `kp_sentence` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sentence` varchar(255) NOT NULL DEFAULT '',
  `page_id` varchar(255) NOT NULL DEFAULT '' COMMENT '知识点id',
  `model_id` varchar(255) NOT NULL DEFAULT '' COMMENT '标准id',
  `content_id` int(10) NOT NULL DEFAULT '0' COMMENT '内容id',
  `title_id` int(10) DEFAULT NULL,
  `user` varchar(50) NOT NULL DEFAULT '0',
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`model_id`),
  KEY `title_id` (`content_id`),
  KEY `user_id` (`user`),
  KEY `page_id` (`page_id`) USING BTREE,
  KEY `model_id` (`model_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='简述表';

-- ----------------------------
-- Records of kp_sentence
-- ----------------------------
INSERT INTO `kp_sentence` VALUES ('27', '描述的对象结构（使用prototype.prop = undefined）不仅仅是任意的', '20,25', '34,99', '4', '23', '李阳', '1531209853');
INSERT INTO `kp_sentence` VALUES ('35', '连尚网络旗下产品WiFi万能钥匙是全球网络共享平台', '20,23', '14,29', '5', '31', '李阳', '1531271755');
INSERT INTO `kp_sentence` VALUES ('36', '有人认为发射次数多就是“金牌火箭”', '20,23', '17', '3', '5', '111', '1531275216');
INSERT INTO `kp_sentence` VALUES ('39', '前端开发的入门门槛其实很低', '20,23', '14,29,47,48', '6', '33', 'Lee', '1531359346');
INSERT INTO `kp_sentence` VALUES ('40', '前端与服务器端语言先慢后快的学习曲线相比', '20,25', '14,29,47,48', '6', '33', 'Lee', '1531359346');
INSERT INTO `kp_sentence` VALUES ('44', 'Laravel 提供了许多有用的验证规则，同时也支持自定义规则。', '21,58', '17,31,138', '1', '1', '李阳', '1531364062');
INSERT INTO `kp_sentence` VALUES ('45', '同时也支持自定义规则', '20,25', '17,32,130', '1', '1', '李阳', '1531364062');
INSERT INTO `kp_sentence` VALUES ('46', '可以使用 Artisan 命令 make:rule 来生成新的规则对象。', '20,23', '34,99', '1', '1', '你好', '1531364062');
INSERT INTO `kp_sentence` VALUES ('47', '地方的咖啡机浪费进到房间里街坊邻居', '20,25', '14,29,96,97', '7', '46', 'Lee', '1531382087');
INSERT INTO `kp_sentence` VALUES ('48', '零三分 富婆的肌肤蓝色', '20,25', '14,29,96,97', '7', '46', 'Lee', '1531382087');
INSERT INTO `kp_sentence` VALUES ('49', '主体建筑的平面布置、结构形式和家电设计', '20,23', '14,29,96,97', '8', '70', 'Lee', '1531393083');
INSERT INTO `kp_sentence` VALUES ('51', '见风使舵缉私局覅方法来得及愤怒的发', '20,23', '17,18,136', '9', '47', '零零', '1531393446');
INSERT INTO `kp_sentence` VALUES ('52', '很爽快的哈萨克哈萨克 很多刷卡', '20,25', '14,30,103', '10', '71', '看看', '1531393532');

-- ----------------------------
-- Table structure for kp_sentence_tag
-- ----------------------------
DROP TABLE IF EXISTS `kp_sentence_tag`;
CREATE TABLE `kp_sentence_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sentence_id` int(10) NOT NULL DEFAULT '0',
  `tag_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tag_id` (`tag_id`),
  KEY `title_id` (`sentence_id`)
) ENGINE=InnoDB AUTO_INCREMENT=757 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='章节和标签关联表';

-- ----------------------------
-- Records of kp_sentence_tag
-- ----------------------------
INSERT INTO `kp_sentence_tag` VALUES ('441', '5', '521');
INSERT INTO `kp_sentence_tag` VALUES ('442', '5', '522');
INSERT INTO `kp_sentence_tag` VALUES ('443', '5', '523');
INSERT INTO `kp_sentence_tag` VALUES ('444', '5', '524');
INSERT INTO `kp_sentence_tag` VALUES ('445', '5', '525');
INSERT INTO `kp_sentence_tag` VALUES ('446', '5', '526');
INSERT INTO `kp_sentence_tag` VALUES ('447', '5', '527');
INSERT INTO `kp_sentence_tag` VALUES ('448', '5', '528');
INSERT INTO `kp_sentence_tag` VALUES ('449', '5', '529');
INSERT INTO `kp_sentence_tag` VALUES ('450', '5', '530');
INSERT INTO `kp_sentence_tag` VALUES ('451', '5', '531');
INSERT INTO `kp_sentence_tag` VALUES ('452', '5', '532');
INSERT INTO `kp_sentence_tag` VALUES ('453', '5', '533');
INSERT INTO `kp_sentence_tag` VALUES ('454', '5', '534');
INSERT INTO `kp_sentence_tag` VALUES ('455', '5', '535');
INSERT INTO `kp_sentence_tag` VALUES ('456', '5', '536');
INSERT INTO `kp_sentence_tag` VALUES ('457', '5', '537');
INSERT INTO `kp_sentence_tag` VALUES ('458', '5', '538');
INSERT INTO `kp_sentence_tag` VALUES ('459', '5', '539');
INSERT INTO `kp_sentence_tag` VALUES ('460', '5', '540');
INSERT INTO `kp_sentence_tag` VALUES ('461', '5', '541');
INSERT INTO `kp_sentence_tag` VALUES ('462', '5', '542');
INSERT INTO `kp_sentence_tag` VALUES ('463', '5', '543');
INSERT INTO `kp_sentence_tag` VALUES ('464', '5', '544');
INSERT INTO `kp_sentence_tag` VALUES ('465', '5', '545');
INSERT INTO `kp_sentence_tag` VALUES ('466', '5', '546');
INSERT INTO `kp_sentence_tag` VALUES ('467', '5', '547');
INSERT INTO `kp_sentence_tag` VALUES ('468', '5', '548');
INSERT INTO `kp_sentence_tag` VALUES ('469', '5', '549');
INSERT INTO `kp_sentence_tag` VALUES ('470', '5', '550');
INSERT INTO `kp_sentence_tag` VALUES ('471', '5', '551');
INSERT INTO `kp_sentence_tag` VALUES ('472', '5', '552');
INSERT INTO `kp_sentence_tag` VALUES ('473', '5', '553');
INSERT INTO `kp_sentence_tag` VALUES ('474', '5', '554');
INSERT INTO `kp_sentence_tag` VALUES ('475', '5', '555');
INSERT INTO `kp_sentence_tag` VALUES ('476', '5', '556');
INSERT INTO `kp_sentence_tag` VALUES ('546', '1', '626');
INSERT INTO `kp_sentence_tag` VALUES ('547', '1', '627');
INSERT INTO `kp_sentence_tag` VALUES ('548', '1', '628');
INSERT INTO `kp_sentence_tag` VALUES ('549', '1', '629');
INSERT INTO `kp_sentence_tag` VALUES ('550', '1', '630');
INSERT INTO `kp_sentence_tag` VALUES ('551', '1', '631');
INSERT INTO `kp_sentence_tag` VALUES ('552', '1', '632');
INSERT INTO `kp_sentence_tag` VALUES ('553', '1', '633');
INSERT INTO `kp_sentence_tag` VALUES ('554', '1', '634');
INSERT INTO `kp_sentence_tag` VALUES ('555', '1', '635');
INSERT INTO `kp_sentence_tag` VALUES ('556', '1', '636');
INSERT INTO `kp_sentence_tag` VALUES ('557', '1', '637');
INSERT INTO `kp_sentence_tag` VALUES ('558', '1', '638');
INSERT INTO `kp_sentence_tag` VALUES ('559', '1', '639');
INSERT INTO `kp_sentence_tag` VALUES ('560', '1', '640');
INSERT INTO `kp_sentence_tag` VALUES ('561', '1', '641');
INSERT INTO `kp_sentence_tag` VALUES ('562', '1', '642');
INSERT INTO `kp_sentence_tag` VALUES ('563', '1', '643');
INSERT INTO `kp_sentence_tag` VALUES ('564', '1', '644');
INSERT INTO `kp_sentence_tag` VALUES ('565', '1', '645');
INSERT INTO `kp_sentence_tag` VALUES ('566', '1', '646');
INSERT INTO `kp_sentence_tag` VALUES ('567', '1', '647');
INSERT INTO `kp_sentence_tag` VALUES ('568', '1', '648');
INSERT INTO `kp_sentence_tag` VALUES ('569', '1', '649');
INSERT INTO `kp_sentence_tag` VALUES ('570', '1', '650');
INSERT INTO `kp_sentence_tag` VALUES ('571', '1', '651');
INSERT INTO `kp_sentence_tag` VALUES ('572', '1', '652');
INSERT INTO `kp_sentence_tag` VALUES ('573', '1', '653');
INSERT INTO `kp_sentence_tag` VALUES ('574', '1', '654');
INSERT INTO `kp_sentence_tag` VALUES ('575', '1', '655');
INSERT INTO `kp_sentence_tag` VALUES ('576', '1', '656');
INSERT INTO `kp_sentence_tag` VALUES ('577', '1', '657');
INSERT INTO `kp_sentence_tag` VALUES ('578', '1', '658');
INSERT INTO `kp_sentence_tag` VALUES ('579', '1', '659');
INSERT INTO `kp_sentence_tag` VALUES ('580', '19', '660');
INSERT INTO `kp_sentence_tag` VALUES ('581', '19', '661');
INSERT INTO `kp_sentence_tag` VALUES ('582', '19', '662');
INSERT INTO `kp_sentence_tag` VALUES ('583', '19', '663');
INSERT INTO `kp_sentence_tag` VALUES ('584', '19', '664');
INSERT INTO `kp_sentence_tag` VALUES ('585', '19', '665');
INSERT INTO `kp_sentence_tag` VALUES ('586', '20', '660');
INSERT INTO `kp_sentence_tag` VALUES ('587', '20', '661');
INSERT INTO `kp_sentence_tag` VALUES ('588', '20', '662');
INSERT INTO `kp_sentence_tag` VALUES ('589', '20', '663');
INSERT INTO `kp_sentence_tag` VALUES ('590', '20', '664');
INSERT INTO `kp_sentence_tag` VALUES ('591', '20', '665');
INSERT INTO `kp_sentence_tag` VALUES ('592', '21', '660');
INSERT INTO `kp_sentence_tag` VALUES ('593', '21', '661');
INSERT INTO `kp_sentence_tag` VALUES ('594', '21', '662');
INSERT INTO `kp_sentence_tag` VALUES ('595', '21', '663');
INSERT INTO `kp_sentence_tag` VALUES ('596', '21', '664');
INSERT INTO `kp_sentence_tag` VALUES ('597', '21', '665');
INSERT INTO `kp_sentence_tag` VALUES ('598', '22', '660');
INSERT INTO `kp_sentence_tag` VALUES ('599', '22', '661');
INSERT INTO `kp_sentence_tag` VALUES ('600', '22', '662');
INSERT INTO `kp_sentence_tag` VALUES ('601', '22', '663');
INSERT INTO `kp_sentence_tag` VALUES ('602', '22', '664');
INSERT INTO `kp_sentence_tag` VALUES ('603', '22', '665');
INSERT INTO `kp_sentence_tag` VALUES ('604', '23', '666');
INSERT INTO `kp_sentence_tag` VALUES ('605', '23', '663');
INSERT INTO `kp_sentence_tag` VALUES ('606', '23', '667');
INSERT INTO `kp_sentence_tag` VALUES ('607', '23', '668');
INSERT INTO `kp_sentence_tag` VALUES ('608', '24', '660');
INSERT INTO `kp_sentence_tag` VALUES ('609', '24', '661');
INSERT INTO `kp_sentence_tag` VALUES ('610', '24', '662');
INSERT INTO `kp_sentence_tag` VALUES ('611', '25', '666');
INSERT INTO `kp_sentence_tag` VALUES ('612', '25', '663');
INSERT INTO `kp_sentence_tag` VALUES ('613', '25', '667');
INSERT INTO `kp_sentence_tag` VALUES ('614', '25', '668');
INSERT INTO `kp_sentence_tag` VALUES ('615', '26', '669');
INSERT INTO `kp_sentence_tag` VALUES ('616', '26', '670');
INSERT INTO `kp_sentence_tag` VALUES ('617', '26', '671');
INSERT INTO `kp_sentence_tag` VALUES ('618', '26', '672');
INSERT INTO `kp_sentence_tag` VALUES ('619', '27', '669');
INSERT INTO `kp_sentence_tag` VALUES ('620', '27', '670');
INSERT INTO `kp_sentence_tag` VALUES ('621', '27', '671');
INSERT INTO `kp_sentence_tag` VALUES ('622', '27', '672');
INSERT INTO `kp_sentence_tag` VALUES ('623', '28', '673');
INSERT INTO `kp_sentence_tag` VALUES ('624', '28', '674');
INSERT INTO `kp_sentence_tag` VALUES ('625', '28', '675');
INSERT INTO `kp_sentence_tag` VALUES ('626', '28', '676');
INSERT INTO `kp_sentence_tag` VALUES ('627', '28', '677');
INSERT INTO `kp_sentence_tag` VALUES ('628', '28', '678');
INSERT INTO `kp_sentence_tag` VALUES ('629', '29', '666');
INSERT INTO `kp_sentence_tag` VALUES ('630', '29', '676');
INSERT INTO `kp_sentence_tag` VALUES ('631', '29', '667');
INSERT INTO `kp_sentence_tag` VALUES ('632', '29', '668');
INSERT INTO `kp_sentence_tag` VALUES ('633', '30', '673');
INSERT INTO `kp_sentence_tag` VALUES ('634', '30', '674');
INSERT INTO `kp_sentence_tag` VALUES ('635', '30', '675');
INSERT INTO `kp_sentence_tag` VALUES ('636', '30', '676');
INSERT INTO `kp_sentence_tag` VALUES ('637', '30', '677');
INSERT INTO `kp_sentence_tag` VALUES ('638', '30', '678');
INSERT INTO `kp_sentence_tag` VALUES ('639', '31', '666');
INSERT INTO `kp_sentence_tag` VALUES ('640', '31', '676');
INSERT INTO `kp_sentence_tag` VALUES ('641', '31', '667');
INSERT INTO `kp_sentence_tag` VALUES ('642', '31', '668');
INSERT INTO `kp_sentence_tag` VALUES ('643', '32', '676');
INSERT INTO `kp_sentence_tag` VALUES ('644', '32', '666');
INSERT INTO `kp_sentence_tag` VALUES ('645', '32', '673');
INSERT INTO `kp_sentence_tag` VALUES ('646', '32', '674');
INSERT INTO `kp_sentence_tag` VALUES ('647', '32', '675');
INSERT INTO `kp_sentence_tag` VALUES ('648', '32', '667');
INSERT INTO `kp_sentence_tag` VALUES ('649', '32', '677');
INSERT INTO `kp_sentence_tag` VALUES ('650', '32', '678');
INSERT INTO `kp_sentence_tag` VALUES ('651', '33', '666');
INSERT INTO `kp_sentence_tag` VALUES ('652', '33', '676');
INSERT INTO `kp_sentence_tag` VALUES ('653', '33', '667');
INSERT INTO `kp_sentence_tag` VALUES ('654', '33', '668');
INSERT INTO `kp_sentence_tag` VALUES ('655', '34', '679');
INSERT INTO `kp_sentence_tag` VALUES ('656', '34', '680');
INSERT INTO `kp_sentence_tag` VALUES ('657', '34', '681');
INSERT INTO `kp_sentence_tag` VALUES ('658', '34', '682');
INSERT INTO `kp_sentence_tag` VALUES ('659', '34', '676');
INSERT INTO `kp_sentence_tag` VALUES ('660', '34', '683');
INSERT INTO `kp_sentence_tag` VALUES ('661', '34', '671');
INSERT INTO `kp_sentence_tag` VALUES ('662', '34', '684');
INSERT INTO `kp_sentence_tag` VALUES ('663', '34', '685');
INSERT INTO `kp_sentence_tag` VALUES ('664', '35', '686');
INSERT INTO `kp_sentence_tag` VALUES ('665', '35', '687');
INSERT INTO `kp_sentence_tag` VALUES ('666', '35', '688');
INSERT INTO `kp_sentence_tag` VALUES ('667', '35', '689');
INSERT INTO `kp_sentence_tag` VALUES ('668', '35', '690');
INSERT INTO `kp_sentence_tag` VALUES ('669', '35', '691');
INSERT INTO `kp_sentence_tag` VALUES ('670', '35', '692');
INSERT INTO `kp_sentence_tag` VALUES ('671', '35', '693');
INSERT INTO `kp_sentence_tag` VALUES ('672', '35', '694');
INSERT INTO `kp_sentence_tag` VALUES ('673', '36', '695');
INSERT INTO `kp_sentence_tag` VALUES ('674', '36', '696');
INSERT INTO `kp_sentence_tag` VALUES ('675', '36', '697');
INSERT INTO `kp_sentence_tag` VALUES ('676', '36', '698');
INSERT INTO `kp_sentence_tag` VALUES ('677', '36', '699');
INSERT INTO `kp_sentence_tag` VALUES ('678', '36', '700');
INSERT INTO `kp_sentence_tag` VALUES ('679', '36', '701');
INSERT INTO `kp_sentence_tag` VALUES ('680', '37', '702');
INSERT INTO `kp_sentence_tag` VALUES ('681', '38', '703');
INSERT INTO `kp_sentence_tag` VALUES ('682', '38', '704');
INSERT INTO `kp_sentence_tag` VALUES ('683', '38', '705');
INSERT INTO `kp_sentence_tag` VALUES ('684', '38', '706');
INSERT INTO `kp_sentence_tag` VALUES ('685', '38', '707');
INSERT INTO `kp_sentence_tag` VALUES ('686', '39', '702');
INSERT INTO `kp_sentence_tag` VALUES ('687', '39', '708');
INSERT INTO `kp_sentence_tag` VALUES ('688', '40', '709');
INSERT INTO `kp_sentence_tag` VALUES ('689', '40', '706');
INSERT INTO `kp_sentence_tag` VALUES ('690', '40', '707');
INSERT INTO `kp_sentence_tag` VALUES ('691', '41', '676');
INSERT INTO `kp_sentence_tag` VALUES ('692', '41', '666');
INSERT INTO `kp_sentence_tag` VALUES ('693', '41', '673');
INSERT INTO `kp_sentence_tag` VALUES ('694', '41', '674');
INSERT INTO `kp_sentence_tag` VALUES ('695', '41', '675');
INSERT INTO `kp_sentence_tag` VALUES ('696', '41', '667');
INSERT INTO `kp_sentence_tag` VALUES ('697', '41', '677');
INSERT INTO `kp_sentence_tag` VALUES ('698', '41', '678');
INSERT INTO `kp_sentence_tag` VALUES ('699', '42', '666');
INSERT INTO `kp_sentence_tag` VALUES ('700', '42', '676');
INSERT INTO `kp_sentence_tag` VALUES ('701', '42', '667');
INSERT INTO `kp_sentence_tag` VALUES ('702', '42', '668');
INSERT INTO `kp_sentence_tag` VALUES ('703', '43', '679');
INSERT INTO `kp_sentence_tag` VALUES ('704', '43', '680');
INSERT INTO `kp_sentence_tag` VALUES ('705', '43', '681');
INSERT INTO `kp_sentence_tag` VALUES ('706', '43', '682');
INSERT INTO `kp_sentence_tag` VALUES ('707', '43', '676');
INSERT INTO `kp_sentence_tag` VALUES ('708', '43', '683');
INSERT INTO `kp_sentence_tag` VALUES ('709', '43', '671');
INSERT INTO `kp_sentence_tag` VALUES ('710', '43', '684');
INSERT INTO `kp_sentence_tag` VALUES ('711', '43', '685');
INSERT INTO `kp_sentence_tag` VALUES ('712', '44', '676');
INSERT INTO `kp_sentence_tag` VALUES ('713', '44', '666');
INSERT INTO `kp_sentence_tag` VALUES ('714', '44', '673');
INSERT INTO `kp_sentence_tag` VALUES ('715', '44', '674');
INSERT INTO `kp_sentence_tag` VALUES ('716', '44', '675');
INSERT INTO `kp_sentence_tag` VALUES ('717', '44', '667');
INSERT INTO `kp_sentence_tag` VALUES ('718', '44', '677');
INSERT INTO `kp_sentence_tag` VALUES ('719', '44', '678');
INSERT INTO `kp_sentence_tag` VALUES ('720', '45', '666');
INSERT INTO `kp_sentence_tag` VALUES ('721', '45', '676');
INSERT INTO `kp_sentence_tag` VALUES ('722', '45', '667');
INSERT INTO `kp_sentence_tag` VALUES ('723', '45', '668');
INSERT INTO `kp_sentence_tag` VALUES ('724', '46', '679');
INSERT INTO `kp_sentence_tag` VALUES ('725', '46', '680');
INSERT INTO `kp_sentence_tag` VALUES ('726', '46', '681');
INSERT INTO `kp_sentence_tag` VALUES ('727', '46', '682');
INSERT INTO `kp_sentence_tag` VALUES ('728', '46', '676');
INSERT INTO `kp_sentence_tag` VALUES ('729', '46', '683');
INSERT INTO `kp_sentence_tag` VALUES ('730', '46', '671');
INSERT INTO `kp_sentence_tag` VALUES ('731', '46', '684');
INSERT INTO `kp_sentence_tag` VALUES ('732', '46', '685');
INSERT INTO `kp_sentence_tag` VALUES ('733', '47', '710');
INSERT INTO `kp_sentence_tag` VALUES ('734', '47', '711');
INSERT INTO `kp_sentence_tag` VALUES ('735', '47', '712');
INSERT INTO `kp_sentence_tag` VALUES ('736', '47', '713');
INSERT INTO `kp_sentence_tag` VALUES ('737', '47', '714');
INSERT INTO `kp_sentence_tag` VALUES ('738', '48', '715');
INSERT INTO `kp_sentence_tag` VALUES ('739', '48', '716');
INSERT INTO `kp_sentence_tag` VALUES ('740', '48', '717');
INSERT INTO `kp_sentence_tag` VALUES ('741', '48', '718');
INSERT INTO `kp_sentence_tag` VALUES ('742', '49', '719');
INSERT INTO `kp_sentence_tag` VALUES ('743', '50', '720');
INSERT INTO `kp_sentence_tag` VALUES ('744', '50', '721');
INSERT INTO `kp_sentence_tag` VALUES ('745', '50', '722');
INSERT INTO `kp_sentence_tag` VALUES ('746', '50', '723');
INSERT INTO `kp_sentence_tag` VALUES ('747', '50', '724');
INSERT INTO `kp_sentence_tag` VALUES ('748', '51', '720');
INSERT INTO `kp_sentence_tag` VALUES ('749', '51', '721');
INSERT INTO `kp_sentence_tag` VALUES ('750', '51', '722');
INSERT INTO `kp_sentence_tag` VALUES ('751', '51', '723');
INSERT INTO `kp_sentence_tag` VALUES ('752', '51', '724');
INSERT INTO `kp_sentence_tag` VALUES ('753', '52', '725');
INSERT INTO `kp_sentence_tag` VALUES ('754', '52', '726');
INSERT INTO `kp_sentence_tag` VALUES ('755', '52', '727');
INSERT INTO `kp_sentence_tag` VALUES ('756', '52', '728');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='文章表';

-- ----------------------------
-- Records of kp_standard
-- ----------------------------
INSERT INTO `kp_standard` VALUES ('2', '2', '中华现代临床护理学杂志');
INSERT INTO `kp_standard` VALUES ('13', '6', '《医疗功能房间详图详解》');
INSERT INTO `kp_standard` VALUES ('14', '6', '《医用电气设备》GB9706.19-2000');
INSERT INTO `kp_standard` VALUES ('15', '6', '《绿色医院建筑评价标准》');
INSERT INTO `kp_standard` VALUES ('16', '6', '《医用内窥镜及附件通用要求》GB11244-2005');
INSERT INTO `kp_standard` VALUES ('17', '1', '《综合医院建筑设计规范》GB51039-2014');
INSERT INTO `kp_standard` VALUES ('18', '1', '你好啊');
INSERT INTO `kp_standard` VALUES ('19', '2', '知识点');
INSERT INTO `kp_standard` VALUES ('20', '2', 'hello  Bm');
INSERT INTO `kp_standard` VALUES ('21', '2', '综合医院建筑设计规范');

-- ----------------------------
-- Table structure for kp_tag
-- ----------------------------
DROP TABLE IF EXISTS `kp_tag`;
CREATE TABLE `kp_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(30) NOT NULL DEFAULT '',
  `createtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `createtime` (`createtime`)
) ENGINE=InnoDB AUTO_INCREMENT=729 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='标签表';

-- ----------------------------
-- Records of kp_tag
-- ----------------------------
INSERT INTO `kp_tag` VALUES ('666', '自定义', '1531364062');
INSERT INTO `kp_tag` VALUES ('667', '支持', '1531364062');
INSERT INTO `kp_tag` VALUES ('668', '同时', '1531364062');
INSERT INTO `kp_tag` VALUES ('669', '任意', '1531209853');
INSERT INTO `kp_tag` VALUES ('670', '描述', '1531209853');
INSERT INTO `kp_tag` VALUES ('671', '对象', '1531364062');
INSERT INTO `kp_tag` VALUES ('672', '结构', '1531209853');
INSERT INTO `kp_tag` VALUES ('674', '验证', '1531364062');
INSERT INTO `kp_tag` VALUES ('675', '有用', '1531364062');
INSERT INTO `kp_tag` VALUES ('676', '规则', '1531364062');
INSERT INTO `kp_tag` VALUES ('677', '提供', '1531364062');
INSERT INTO `kp_tag` VALUES ('678', '许多', '1531364062');
INSERT INTO `kp_tag` VALUES ('679', 'Artisan', '1531364062');
INSERT INTO `kp_tag` VALUES ('680', 'make', '1531364062');
INSERT INTO `kp_tag` VALUES ('681', 'rule', '1531364062');
INSERT INTO `kp_tag` VALUES ('682', '生成', '1531364062');
INSERT INTO `kp_tag` VALUES ('683', '命令', '1531364062');
INSERT INTO `kp_tag` VALUES ('684', '使用', '1531364062');
INSERT INTO `kp_tag` VALUES ('685', '可以', '1531364062');
INSERT INTO `kp_tag` VALUES ('686', '网络共享', '1531271755');
INSERT INTO `kp_tag` VALUES ('687', '连尚', '1531271755');
INSERT INTO `kp_tag` VALUES ('688', 'WiFi', '1531271755');
INSERT INTO `kp_tag` VALUES ('689', '万能钥匙', '1531271755');
INSERT INTO `kp_tag` VALUES ('690', '平台', '1531271755');
INSERT INTO `kp_tag` VALUES ('691', '网络', '1531271755');
INSERT INTO `kp_tag` VALUES ('692', '旗下', '1531271755');
INSERT INTO `kp_tag` VALUES ('693', '全球', '1531271755');
INSERT INTO `kp_tag` VALUES ('694', '产品', '1531271755');
INSERT INTO `kp_tag` VALUES ('695', '金牌', '1531275216');
INSERT INTO `kp_tag` VALUES ('696', '次数', '1531275216');
INSERT INTO `kp_tag` VALUES ('697', '火箭', '1531275216');
INSERT INTO `kp_tag` VALUES ('698', '发射', '1531275216');
INSERT INTO `kp_tag` VALUES ('699', '有人', '1531275216');
INSERT INTO `kp_tag` VALUES ('700', '认为', '1531275216');
INSERT INTO `kp_tag` VALUES ('701', '就是', '1531275216');
INSERT INTO `kp_tag` VALUES ('702', '前端开发', '1531359346');
INSERT INTO `kp_tag` VALUES ('703', '服务器端', '1531358763');
INSERT INTO `kp_tag` VALUES ('704', '学习曲线', '1531358763');
INSERT INTO `kp_tag` VALUES ('705', '先慢', '1531358763');
INSERT INTO `kp_tag` VALUES ('706', '语言', '1531359346');
INSERT INTO `kp_tag` VALUES ('707', '相比', '1531359346');
INSERT INTO `kp_tag` VALUES ('708', '入门', '1531359346');
INSERT INTO `kp_tag` VALUES ('709', '前端', '1531359346');
INSERT INTO `kp_tag` VALUES ('710', '咖啡机', '1531382087');
INSERT INTO `kp_tag` VALUES ('711', '街坊邻居', '1531382087');
INSERT INTO `kp_tag` VALUES ('712', '浪费', '1531382087');
INSERT INTO `kp_tag` VALUES ('713', '房间', '1531382087');
INSERT INTO `kp_tag` VALUES ('714', '地方', '1531382087');
INSERT INTO `kp_tag` VALUES ('715', '富婆', '1531382087');
INSERT INTO `kp_tag` VALUES ('716', '肌肤', '1531382087');
INSERT INTO `kp_tag` VALUES ('717', '三分', '1531382087');
INSERT INTO `kp_tag` VALUES ('718', '蓝色', '1531382087');
INSERT INTO `kp_tag` VALUES ('719', '平面布置', '1531393083');
INSERT INTO `kp_tag` VALUES ('720', '缉私局', '1531393446');
INSERT INTO `kp_tag` VALUES ('721', '见风使舵', '1531393446');
INSERT INTO `kp_tag` VALUES ('722', '来得及', '1531393446');
INSERT INTO `kp_tag` VALUES ('723', '愤怒', '1531393446');
INSERT INTO `kp_tag` VALUES ('724', '方法', '1531393446');
INSERT INTO `kp_tag` VALUES ('725', '哈萨克', '1531393532');
INSERT INTO `kp_tag` VALUES ('726', '刷卡', '1531393532');
INSERT INTO `kp_tag` VALUES ('727', '爽快', '1531393532');
INSERT INTO `kp_tag` VALUES ('728', '很多', '1531393532');

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
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='目录表';

-- ----------------------------
-- Records of kp_title
-- ----------------------------
INSERT INTO `kp_title` VALUES ('1', '0', '2', '中华现代临床护理学杂志', '0');
INSERT INTO `kp_title` VALUES ('5', '1', '2', '序', '1');
INSERT INTO `kp_title` VALUES ('8', '1', '2', '14124', '1');
INSERT INTO `kp_title` VALUES ('23', '0', '14', '13213', '0');
INSERT INTO `kp_title` VALUES ('28', '1', '2', '123', '1');
INSERT INTO `kp_title` VALUES ('29', '1', '2', '1', '1');
INSERT INTO `kp_title` VALUES ('31', '0', '18', '123123', '0');
INSERT INTO `kp_title` VALUES ('38', '0', '20', 'BIM', '0');
INSERT INTO `kp_title` VALUES ('39', '38', '20', '第一章', '1');
INSERT INTO `kp_title` VALUES ('40', '38', '20', '第二张', '1');
INSERT INTO `kp_title` VALUES ('41', '39', '20', '第一节', '2');
INSERT INTO `kp_title` VALUES ('42', '40', '20', '章节1', '2');
INSERT INTO `kp_title` VALUES ('43', '40', '20', '章节2', '2');
INSERT INTO `kp_title` VALUES ('44', '38', '20', '第三张', '1');
INSERT INTO `kp_title` VALUES ('47', '0', '21', '综合医院建筑设计规范', '0');
INSERT INTO `kp_title` VALUES ('48', '47', '21', '第一张', '1');
INSERT INTO `kp_title` VALUES ('49', '47', '21', '第二张', '1');
INSERT INTO `kp_title` VALUES ('51', '48', '21', 'a', '2');
INSERT INTO `kp_title` VALUES ('52', '47', '21', '第三张', '1');
INSERT INTO `kp_title` VALUES ('53', '47', '21', '你说啊', '1');
INSERT INTO `kp_title` VALUES ('54', '47', '21', '你好的', '1');
INSERT INTO `kp_title` VALUES ('55', '47', '21', '是啊', '1');
INSERT INTO `kp_title` VALUES ('56', '55', '21', '你', '2');
INSERT INTO `kp_title` VALUES ('57', '56', '21', '没到', '3');
INSERT INTO `kp_title` VALUES ('58', '57', '21', '真的', '4');
INSERT INTO `kp_title` VALUES ('59', '38', '20', '第三章', '1');
INSERT INTO `kp_title` VALUES ('68', '47', '21', '建筑设计', '1');
INSERT INTO `kp_title` VALUES ('69', '68', '21', '一般规定', '2');
INSERT INTO `kp_title` VALUES ('70', '69', '21', '5.1.1', '3');
INSERT INTO `kp_title` VALUES ('71', '47', '21', '一级', '1');
INSERT INTO `kp_title` VALUES ('72', '0', '15', '《绿色医院建筑评价标准》', '0');
INSERT INTO `kp_title` VALUES ('73', '0', '17', '《综合医院建筑设计规范》GB51039-2014', '0');
INSERT INTO `kp_title` VALUES ('74', '47', '21', '山大', '1');
SET FOREIGN_KEY_CHECKS=1;
