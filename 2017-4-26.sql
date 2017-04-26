/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : system

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-04-26 16:51:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sys_class
-- ----------------------------
DROP TABLE IF EXISTS `sys_class`;
CREATE TABLE `sys_class` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `grade` varchar(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `no` varchar(2) NOT NULL,
  `date` date NOT NULL,
  `type` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_class
-- ----------------------------
INSERT INTO `sys_class` VALUES ('6', '2013', '英语', '1', '2013-01-18', '3', '0');
INSERT INTO `sys_class` VALUES ('5', '2016', '数据科学与大数据技术', '2', '2016-01-22', '0', '1');
INSERT INTO `sys_class` VALUES ('4', '2017', '数据科学与大数据技术', '2', '2017-04-05', '0', '1');
INSERT INTO `sys_class` VALUES ('7', '2017', '数据科学与大数据技术', '1', '2017-04-01', '0', '1');
INSERT INTO `sys_class` VALUES ('8', '2017', '财务管理', '1', '2017-04-14', '1', '1');
INSERT INTO `sys_class` VALUES ('9', '2017', '日语', '1', '2017-04-07', '3', '1');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `uid` int(18) NOT NULL,
  `type` int(1) NOT NULL,
  `cid` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(24) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '2a35ce608907b948df81fe3b6259ab39', '0', '0', null, '2017-03-01', '1');
INSERT INTO `sys_user` VALUES ('12', 'm', '1b3ce29a0d5e2a8865f592b0ef2f60db', '123115120', '2', null, '2017-04-04', '2');
INSERT INTO `sys_user` VALUES ('2', '2', '', '2', '1', null, null, '3');
INSERT INTO `sys_user` VALUES ('3', '3', '', '4', '2', null, null, '-1');
INSERT INTO `sys_user` VALUES ('4', '4', '', '3', '1', null, null, '1');
INSERT INTO `sys_user` VALUES ('5', '5', '', '5', '1', null, null, '1');
INSERT INTO `sys_user` VALUES ('6', '6', '', '6', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('7', '7', '', '7', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('8', '8', '', '8', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('9', '9', '', '9', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('10', '10', '', '10', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('11', '11', '', '11', '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('13', 'm', '1b3ce29a0d5e2a8865f592b0ef2f60db', '12', '2', null, '0000-00-00', '2');
INSERT INTO `sys_user` VALUES ('14', 'a阿道夫', '1b3ce29a0d5e2a8865f592b0ef2f60db', '1', '0', null, '2017-04-05', '1');
INSERT INTO `sys_user` VALUES ('15', '123123', '2be6441ec5832b824d2ba1031dca01af', '123123123', '2', '9', '2017-04-07', '2');
