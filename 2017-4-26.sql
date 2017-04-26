/*
Navicat MySQL Data Transfer

Source Server         : Pi
Source Server Version : 50554
Source Host           : 222.222.222.200:3306
Source Database       : system

Target Server Type    : MYSQL
Target Server Version : 50554
File Encoding         : 65001

Date: 2017-04-26 13:26:36
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_class
-- ----------------------------
INSERT INTO `sys_class` VALUES ('6', '2013', '英语', '1', '2013-01-18', '3');
INSERT INTO `sys_class` VALUES ('5', '2016', '数据科学与大数据技术', '2', '2016-01-22', '0');
INSERT INTO `sys_class` VALUES ('4', '2017', '数据科学与大数据技术', '2', '2017-04-05', '0');
INSERT INTO `sys_class` VALUES ('7', '2017', '数据科学与大数据技术', '1', '2017-04-01', '0');
INSERT INTO `sys_class` VALUES ('8', '2017', '财务管理', '1', '2017-04-14', '1');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `uid` int(18) DEFAULT NULL,
  `type` int(1) NOT NULL,
  `cid` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(24) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '2a35ce608907b948df81fe3b6259ab39', '0', '0', null, '2017-03-01', '1');
INSERT INTO `sys_user` VALUES ('12', 'm', '1b3ce29a0d5e2a8865f592b0ef2f60db', '123115120', '2', null, '2017-04-04', '2');
INSERT INTO `sys_user` VALUES ('2', '2', '', null, '1', null, null, '3');
INSERT INTO `sys_user` VALUES ('3', '3', '', null, '2', null, null, '-1');
INSERT INTO `sys_user` VALUES ('4', '4', '', null, '1', null, null, '1');
INSERT INTO `sys_user` VALUES ('5', '5', '', null, '1', null, null, '1');
INSERT INTO `sys_user` VALUES ('6', '6', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('7', '7', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('8', '8', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('9', '9', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('10', '10', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('11', '11', '', null, '2', null, null, '2');
INSERT INTO `sys_user` VALUES ('13', 'm', '1b3ce29a0d5e2a8865f592b0ef2f60db', '0', '2', null, '0000-00-00', '2');
INSERT INTO `sys_user` VALUES ('14', 'a阿道夫', '1b3ce29a0d5e2a8865f592b0ef2f60db', '1', '0', null, '2017-04-05', '1');
