/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : 127.0.0.1:3306
Source Database       : hrms

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-01-16 10:45:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for aclgroup
-- ----------------------------
DROP TABLE IF EXISTS `aclgroup`;
CREATE TABLE `aclgroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `datecreated` datetime NOT NULL,
  `createdby` int(11) unsigned NOT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `fk_group_createdby` (`createdby`),
  KEY `fk_group_lastupdatedby` (`lastupdatedby`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclgroup
-- ----------------------------
INSERT INTO `aclgroup` VALUES ('1', 'Super Admin', 'Has rights to entire system configuration', '2014-09-15 12:00:00', '1', '2011-11-28 15:35:40', '2');
INSERT INTO `aclgroup` VALUES ('2', 'National Data Clerk', 'Data access level stricted to National Level', '2014-09-15 12:00:00', '1', '2012-02-17 12:31:39', '27');
INSERT INTO `aclgroup` VALUES ('3', 'Regional Data Clerk', 'Data access level stricted to Region Level', '2014-09-15 12:00:00', '1', '2014-10-06 11:13:07', '2');
INSERT INTO `aclgroup` VALUES ('4', 'Province Data Clerk', 'Data access level stricted to Province Level', '2014-09-15 12:00:00', '1', '2014-10-06 11:13:17', '2');
INSERT INTO `aclgroup` VALUES ('5', 'District Data Clerk', 'Data access level stricted to District Level', '2014-09-15 12:00:00', '1', '2014-10-06 11:14:45', null);
INSERT INTO `aclgroup` VALUES ('6', 'Subcounty Data Clerk', 'Data access level stricted to Subcounty Level', '2014-09-15 12:00:00', '1', '2014-10-06 11:12:59', null);
INSERT INTO `aclgroup` VALUES ('7', 'Data Admin', 'Overall data admin', '2014-09-15 12:00:00', '1', '2014-10-06 11:17:29', null);
INSERT INTO `aclgroup` VALUES ('8', 'Management', 'Access to management specific roles and reports', '2014-09-15 12:00:00', '1', '2014-10-06 11:19:16', null);
INSERT INTO `aclgroup` VALUES ('9', 'superman', 'Testing', '2014-10-24 05:20:30', '1', '2014-10-24 05:38:08', null);
INSERT INTO `aclgroup` VALUES ('10', 'District Leader', 'District Leaders on Leadership Teams', '2014-11-03 12:13:08', '279', null, null);

-- ----------------------------
-- Table structure for aclpermission
-- ----------------------------
DROP TABLE IF EXISTS `aclpermission`;
CREATE TABLE `aclpermission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(11) unsigned DEFAULT NULL,
  `resourceid` int(11) unsigned NOT NULL,
  `create` enum('1','0') DEFAULT '0',
  `edit` enum('1','0') DEFAULT '0',
  `view` enum('1','0') DEFAULT '0',
  `list` enum('1','0') DEFAULT '0',
  `delete` enum('1','0') DEFAULT '0',
  `approve` enum('1','0') DEFAULT '0',
  `export` enum('1','0') DEFAULT '0',
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_groupid_resourceid` (`groupid`,`resourceid`),
  KEY `fk_aclpermission_groupid` (`groupid`),
  KEY `fk_aclpermission_resourceid` (`resourceid`),
  KEY `fk_permission_createdby` (`createdby`),
  KEY `fk_permission_lastupdatedby` (`lastupdatedby`),
  CONSTRAINT `fk_aclpermission_groupid` FOREIGN KEY (`groupid`) REFERENCES `aclgroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_aclpermission_resourceid` FOREIGN KEY (`resourceid`) REFERENCES `aclresource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclpermission
-- ----------------------------
INSERT INTO `aclpermission` VALUES ('2', '1', '1', '0', '0', '1', '1', '0', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('3', '1', '2', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('4', '1', '3', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('5', '1', '4', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('6', '1', '5', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('7', '1', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('8', '1', '7', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('9', '1', '8', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('11', '1', '10', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('12', '1', '11', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('13', '1', '12', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('14', '1', '13', '1', '0', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('15', '1', '14', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('16', '1', '15', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('17', '1', '16', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('18', '1', '17', '1', '1', '1', '1', '1', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('19', '1', '18', '1', '1', '1', '1', '1', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('20', '1', '19', '1', '0', '1', '0', '0', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('21', '1', '20', '0', '0', '1', '0', '0', '0', '0', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('22', '1', '21', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('23', '1', '22', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('24', '1', '23', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('25', '1', '24', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', '2014-10-30 12:50:16', '1');
INSERT INTO `aclpermission` VALUES ('26', '2', '11', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('27', '2', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('28', '2', '12', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('29', '2', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('30', '2', '18', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('31', '2', '8', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('32', '2', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('33', '2', '10', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('34', '2', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('35', '2', '17', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('36', '2', '16', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('37', '2', '14', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('38', '2', '15', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('39', '2', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('40', '2', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('41', '2', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('42', '2', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('43', '2', '20', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('44', '2', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('45', '2', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('46', '2', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('47', '2', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('48', '2', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-06 10:47:52', '1', null, null);
INSERT INTO `aclpermission` VALUES ('49', '6', '11', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('50', '6', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('51', '6', '12', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('52', '6', '6', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('53', '6', '18', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('54', '6', '8', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('55', '6', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('56', '6', '10', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('57', '6', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('58', '6', '17', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('59', '6', '16', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('60', '6', '14', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('61', '6', '15', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('62', '6', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('63', '6', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('64', '6', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('65', '6', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('66', '6', '20', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('67', '6', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('68', '6', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('69', '6', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('70', '6', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('71', '6', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-06 11:12:59', '1', null, null);
INSERT INTO `aclpermission` VALUES ('72', '3', '11', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('73', '3', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('74', '3', '12', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('75', '3', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('76', '3', '18', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('77', '3', '8', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('78', '3', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('79', '3', '10', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('80', '3', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('81', '3', '17', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('82', '3', '16', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('83', '3', '14', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('84', '3', '15', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('85', '3', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('86', '3', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('87', '3', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('88', '3', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('89', '3', '20', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('90', '3', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('91', '3', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('92', '3', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('93', '3', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('94', '3', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-06 11:13:07', '1', null, null);
INSERT INTO `aclpermission` VALUES ('95', '4', '11', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('96', '4', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('97', '4', '12', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('98', '4', '6', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('99', '4', '18', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('100', '4', '8', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('101', '4', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('102', '4', '10', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('103', '4', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('104', '4', '17', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('105', '4', '16', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('106', '4', '14', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('107', '4', '15', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('108', '4', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('109', '4', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('110', '4', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('111', '4', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('112', '4', '20', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('113', '4', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('114', '4', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('115', '4', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('116', '4', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('117', '4', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-06 11:13:17', '1', null, null);
INSERT INTO `aclpermission` VALUES ('118', '5', '11', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('119', '5', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('120', '5', '12', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('121', '5', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('122', '5', '18', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('123', '5', '8', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('124', '5', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('125', '5', '10', '1', '1', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('126', '5', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('127', '5', '17', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('128', '5', '16', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('129', '5', '14', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('130', '5', '15', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('131', '5', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('132', '5', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('133', '5', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('134', '5', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('135', '5', '20', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('136', '5', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('137', '5', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('138', '5', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('139', '5', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('140', '5', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-06 11:14:45', '1', '2014-10-06 11:14:45', '1');
INSERT INTO `aclpermission` VALUES ('141', '7', '11', '1', '1', '1', '1', '1', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('142', '7', '4', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('143', '7', '12', '1', '1', '1', '1', '1', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('144', '7', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('145', '7', '18', '1', '1', '1', '1', '1', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('146', '7', '8', '1', '1', '1', '1', '1', '0', '1', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('147', '7', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('148', '7', '10', '1', '1', '1', '1', '0', '0', '1', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('149', '7', '13', '1', '0', '1', '1', '1', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('150', '7', '17', '1', '1', '1', '1', '1', '0', '1', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('151', '7', '16', '1', '1', '1', '1', '1', '0', '1', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('152', '7', '14', '1', '1', '1', '1', '1', '0', '1', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('153', '7', '15', '1', '1', '1', '1', '1', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('154', '7', '21', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('155', '7', '22', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('156', '7', '23', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('157', '7', '24', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('158', '7', '20', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('159', '7', '5', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('160', '7', '19', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('161', '7', '7', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('162', '7', '2', '0', '0', '0', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('163', '7', '3', '0', '1', '1', '0', '0', '0', '0', '2014-10-24 16:47:22', '1', '2014-10-24 16:47:22', '1');
INSERT INTO `aclpermission` VALUES ('164', '8', '11', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('165', '8', '4', '0', '0', '1', '1', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('166', '8', '12', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('167', '8', '6', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('168', '8', '18', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('169', '8', '8', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('170', '8', '1', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('171', '8', '10', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('172', '8', '13', '0', '0', '0', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('173', '8', '17', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('174', '8', '16', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('175', '8', '14', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('176', '8', '15', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('177', '8', '21', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('178', '8', '22', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('179', '8', '23', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('180', '8', '24', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('181', '8', '20', '0', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('182', '8', '5', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('183', '8', '19', '1', '0', '1', '0', '0', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('184', '8', '7', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('185', '8', '2', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('186', '8', '3', '1', '1', '1', '1', '1', '0', '0', '2014-10-06 11:19:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('187', '1', '25', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('188', '1', '26', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('189', '1', '27', '0', '0', '1', '0', '0', '0', '1', '2014-10-30 12:50:16', '1', null, null);
INSERT INTO `aclpermission` VALUES ('190', '10', '11', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('191', '10', '4', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('192', '10', '25', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('193', '10', '24', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('194', '10', '12', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('195', '10', '6', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('196', '10', '18', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('197', '10', '26', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('198', '10', '8', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('199', '10', '1', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('200', '10', '10', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('201', '10', '22', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('202', '10', '21', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('203', '10', '23', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('204', '10', '13', '1', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('205', '10', '17', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('206', '10', '16', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('207', '10', '14', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('208', '10', '15', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('209', '10', '20', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('210', '10', '5', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('211', '10', '19', '1', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('212', '10', '27', '0', '0', '1', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('213', '10', '7', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('214', '10', '2', '0', '0', '0', '0', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);
INSERT INTO `aclpermission` VALUES ('215', '10', '3', '0', '0', '1', '1', '0', '0', '0', '2014-11-03 12:13:08', '279', null, null);

-- ----------------------------
-- Table structure for aclresource
-- ----------------------------
DROP TABLE IF EXISTS `aclresource`;
CREATE TABLE `aclresource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `create` enum('1','0') DEFAULT '0',
  `edit` enum('1','0') DEFAULT '0',
  `view` enum('1','0') DEFAULT '0',
  `list` enum('1','0') DEFAULT '0',
  `delete` enum('1','0') DEFAULT '0',
  `approve` enum('1','0') DEFAULT '0',
  `export` enum('1','0') DEFAULT '0',
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_resource_createdby` (`createdby`),
  KEY `fk_resource_lastupdatedby` (`lastupdatedby`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclresource
-- ----------------------------
INSERT INTO `aclresource` VALUES ('1', 'Lookup Type', 'Look up types', '0', '0', '1', '1', '0', '0', '0', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('2', 'System Variables', 'Values for the lookup type', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('3', 'User Account', 'A user who has activated their member account', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('4', 'Audit Trail Report', 'Audit Trail Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('5', 'Role', 'Actions a member can execute on resources', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('6', 'Dashboard', 'user dashboard', '0', '0', '1', '0', '0', '0', '0', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('7', 'System Config', 'Global system configuration parameters', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('8', 'Location', 'Country demographic locations', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('10', 'Member', 'Registered member of NFBPC', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('11', 'Appointment', 'Leadership transaction resource', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('12', 'Committee', 'NFBPC Committee ', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('13', 'Message', 'Direct Messaging module', '1', '0', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('14', 'Organisation', 'Registered churches and ministries', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('15', 'Position', 'Leadership roles assigned to a member', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('16', 'NFBPC Region', 'NFBPC Region Location', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('17', 'NFBPC Province', 'NFBPC Region Location', '1', '1', '1', '1', '1', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('18', 'Department', 'Department details', '1', '1', '1', '1', '1', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('19', 'SMS', 'SMS Communication', '1', '0', '1', '0', '0', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('20', 'Report Dashboard', 'Report Dashboard', '0', '0', '1', '0', '0', '0', '0', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('21', 'Member Statistics Report', 'Member Statistics Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('22', 'Member Registration Trends Report', 'Member Registration Trends Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('23', 'Members by Location Report', 'Members by Location Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('24', 'Church Statistics Report', 'Church Statistics Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('25', 'Church Registration Trends Report', 'Church Registration Trends Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('26', 'Leadership and Committee Structures Report', 'Leadership and Committee Structures Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('27', 'SMS Outbound Report', 'SMS Outbound Report', '0', '0', '1', '0', '0', '0', '1', '2014-09-15 12:00:00', null, null, null);

-- ----------------------------
-- Table structure for aclusergroup
-- ----------------------------
DROP TABLE IF EXISTS `aclusergroup`;
CREATE TABLE `aclusergroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(11) unsigned NOT NULL,
  `userid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_group_user` (`groupid`,`userid`),
  KEY `fk_aclusergroup_userid` (`userid`),
  CONSTRAINT `fk_aclusergroup_groupid` FOREIGN KEY (`groupid`) REFERENCES `aclgroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_aclusergroup_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclusergroup
-- ----------------------------
INSERT INTO `aclusergroup` VALUES ('1', '1', '1');
INSERT INTO `aclusergroup` VALUES ('7', '1', '279');
INSERT INTO `aclusergroup` VALUES ('6', '1', '1060');
INSERT INTO `aclusergroup` VALUES ('21', '1', '1074');
INSERT INTO `aclusergroup` VALUES ('31', '1', '1081');
INSERT INTO `aclusergroup` VALUES ('10', '2', '1063');
INSERT INTO `aclusergroup` VALUES ('8', '7', '1061');
INSERT INTO `aclusergroup` VALUES ('9', '7', '1062');
INSERT INTO `aclusergroup` VALUES ('11', '7', '1064');
INSERT INTO `aclusergroup` VALUES ('12', '7', '1065');
INSERT INTO `aclusergroup` VALUES ('13', '7', '1066');
INSERT INTO `aclusergroup` VALUES ('14', '7', '1067');
INSERT INTO `aclusergroup` VALUES ('15', '7', '1068');
INSERT INTO `aclusergroup` VALUES ('16', '7', '1069');
INSERT INTO `aclusergroup` VALUES ('17', '7', '1070');
INSERT INTO `aclusergroup` VALUES ('18', '7', '1071');
INSERT INTO `aclusergroup` VALUES ('19', '7', '1072');
INSERT INTO `aclusergroup` VALUES ('20', '7', '1073');
INSERT INTO `aclusergroup` VALUES ('22', '7', '1075');
INSERT INTO `aclusergroup` VALUES ('23', '7', '1076');
INSERT INTO `aclusergroup` VALUES ('25', '7', '1080');
INSERT INTO `aclusergroup` VALUES ('27', '7', '1082');
INSERT INTO `aclusergroup` VALUES ('28', '7', '1083');
INSERT INTO `aclusergroup` VALUES ('26', '8', '304');
INSERT INTO `aclusergroup` VALUES ('32', '8', '305');
INSERT INTO `aclusergroup` VALUES ('38', '8', '448');
INSERT INTO `aclusergroup` VALUES ('36', '8', '741');
INSERT INTO `aclusergroup` VALUES ('24', '8', '1079');
INSERT INTO `aclusergroup` VALUES ('29', '8', '1086');
INSERT INTO `aclusergroup` VALUES ('30', '8', '1087');
INSERT INTO `aclusergroup` VALUES ('33', '8', '2638');
INSERT INTO `aclusergroup` VALUES ('34', '8', '2639');
INSERT INTO `aclusergroup` VALUES ('35', '8', '2640');
INSERT INTO `aclusergroup` VALUES ('37', '8', '2641');
INSERT INTO `aclusergroup` VALUES ('39', '8', '2642');
INSERT INTO `aclusergroup` VALUES ('40', '8', '2643');

-- ----------------------------
-- Table structure for appconfig
-- ----------------------------
DROP TABLE IF EXISTS `appconfig`;
CREATE TABLE `appconfig` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(50) DEFAULT '',
  `sectiondisplay` varchar(50) DEFAULT NULL,
  `optionname` varchar(50) DEFAULT NULL,
  `displayname` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `optionvalue` varchar(255) DEFAULT '',
  `optiontype` varchar(15) DEFAULT '',
  `active` enum('N','Y') DEFAULT 'Y',
  `editable` tinyint(4) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_appconfig_createdby` (`createdby`),
  KEY `index_appconfig_lastupdatedby` (`lastupdatedby`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of appconfig
-- ----------------------------
INSERT INTO `appconfig` VALUES ('1', 'backup', 'Backup Settings', 'retentionperiod', 'Backup Rentention Perid', 'Duration for which backups are kept', '7', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-21 19:01:16', null);
INSERT INTO `appconfig` VALUES ('2', 'backup', 'Backup Settings', 'scriptfolder', 'Folder for Backup Scripts', 'The path relative to the APPLICATION_PATH variable, use a starting / since the variable is a folder name', 'backup', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-21 19:01:16', null);
INSERT INTO `appconfig` VALUES ('3', 'backup', 'Backup Settings', 'usegzip', 'Gzip Backups', 'Whether to use gzip compression or not, options are yes and no', 'yes', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-21 19:01:16', null);
INSERT INTO `appconfig` VALUES ('4', 'backup', 'Backup Settings', 'removesqlfile', 'Sql Backups', 'Remove SQL file after processing, options are yes and no', 'yes', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-21 19:01:16', null);
INSERT INTO `appconfig` VALUES ('5', 'backup', 'Backup Settings', 'sendemail', 'Send Backups to Admin Email', 'Send backup via email, options are yes and no', 'no', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-21 19:01:16', null);
INSERT INTO `appconfig` VALUES ('6', 'country', 'Country Settings', 'currencysymbol', 'Currency Symbol', '', 'Shs', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('7', 'country', 'Country Settings', 'currencycode', 'Currency Code', '', 'UGX', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('8', 'country', 'Country Settings', 'currencydecimalplaces', 'Currreny decimal places', '', '0', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('9', 'country', 'Country Settings', 'mincurrencyvalue', 'Minimum currency amount', '', '50', 'decimal', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('10', 'country', 'Country Settings', 'maxcurrencyvalue', 'Maximum currency amount', '', '50000', 'decimal', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('12', 'dateandtime', 'Date and Time Settings', 'shortformat', 'Short date display format', '', 'm/d/Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('13', 'dateandtime', 'Date and Time Settings', 'mediumformat', 'Long date display format', '', 'j M, Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('14', 'dateandtime', 'Date and Time Settings', 'longformat', 'Long date with week day', '', 'l, j F Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('15', 'dateandtime', 'Date and Time Settings', 'mysqlformat', 'Short date database format', '', '%m/%d/%Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('16', 'dateandtime', 'Date and Time Settings', 'mysqlmediumformat', 'Long date database format', '', '%d %b, %Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('17', 'dateandtime', 'Date and Time Settings', 'mysqldateandtimeformat', 'Long date with timestamp', '', '%m/%d/%Y - %H:%i:%s', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('19', 'profile', 'User Profile Settings', 'passwordminlength', 'Minimum password length', 'The minimum length of a password', '6', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-03-17 00:05:02', null);
INSERT INTO `appconfig` VALUES ('20', 'dateandtime', 'Date and Time Settings', 'mindate', 'Date picker number of days ahead of current date', 'The minimum date for the date picker', '2', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('21', 'dateandtime', 'Date and Time Settings', 'maxdate', 'Date picker number of days before current date', 'The maximum date for the date picker', '2', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('22', 'dateandtime', 'Date and Time Settings', 'datepickerformat', 'Javascript long date', 'The format for Javascript dates', 'M dd, yy', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('23', 'dateandtime', 'Date and Time Settings', 'javascriptshortformat', 'Javascript short date', 'Short date for Javascript dates', 'm/dd/yy', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('24', 'uploads', 'File upload Options', 'docallowedformats', 'Allowed formats for document upload', 'Allowed document file formats', 'doc, docx, pdf, txt, jpg, jpeg, png, bmp', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:09:02', null);
INSERT INTO `appconfig` VALUES ('25', 'uploads', 'File upload Options', 'docmaximumfilesize', 'Maximum allowed size (bytes) for document uploads', 'Maximum size of a document in bytes', '8000000', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:09:02', null);
INSERT INTO `appconfig` VALUES ('26', 'profile', 'User Profile Settings', 'passwordmaxlength', 'Maximum password length', 'The maximum length of a password', '20', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-03-17 00:05:02', null);
INSERT INTO `appconfig` VALUES ('30', 'notification', 'Notification and Email Options', 'emailmessagesender', 'Sender of email notifications', 'The email address the application uses to send out notifications', 'notifications@devmail.infomacorp.com', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-12-04 16:27:59', null);
INSERT INTO `appconfig` VALUES ('31', 'uploads', 'File upload Settings', 'photoallowedformats', 'Profile photo allowed formats', 'Allowed photo file formats', 'jpg, jpeg, png', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:09:02', null);
INSERT INTO `appconfig` VALUES ('32', 'uploads', 'File upload Settings', 'photomaximumfilesize', 'Maximum allowed size (bytes) for profile photo', 'Maximum size of a profile photo in bytes', '5000000', 'integer', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:09:02', null);
INSERT INTO `appconfig` VALUES ('35', 'notification', 'Notification and Email Options', 'supportemailaddress', 'Contact us and Support email address ', 'The address to which support emails are sent', 'support@devmail.infomacorp.com', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:27:59', null);
INSERT INTO `appconfig` VALUES ('36', 'dateandtime', 'Date and Time Settings', 'mindateofbirth', 'Date of birth number of years before today', 'The number of years before today for allowable date for the hire date', '100', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-02-12 14:08:46', null);
INSERT INTO `appconfig` VALUES ('37', 'profile', 'User Profile Settings', 'usernamemaxlength', 'Minimum username length', '', '20', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-03-17 00:05:02', null);
INSERT INTO `appconfig` VALUES ('38', 'profile', 'User Profile Settings', 'usernameminlength', 'Maximum username length', '', '4', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-03-17 00:05:02', null);
INSERT INTO `appconfig` VALUES ('39', 'country', 'Country Settings', 'countryisocode', 'Country standard iso code', '', 'UG', 'text', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-12-04 15:45:41', null);
INSERT INTO `appconfig` VALUES ('40', 'country', 'Country Settings', 'phonemaxlength', 'Maximum digits allowed for phone number', '', '12', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('41', 'country', 'Country Settings', 'phoneminlength', 'Minimum digits allowed for phone number', '', '12', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('42', 'country', 'Country Settings', 'nationalidminlength', 'Minimum digits allowed for National ID', '', '6', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('43', 'country', 'Country Settings', 'nationalidmaxlength', 'Maximum digits allowed for National ID', '', '10', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('44', 'profile', 'User Profile Settings', 'activationkeylength', 'The length of random account activation key', '', '6', 'integer', 'Y', '1', '2011-05-18 09:55:32', '1', '2014-03-17 00:05:02', null);
INSERT INTO `appconfig` VALUES ('45', 'notification', 'Notification and Email Options', 'notificationsendername', 'Name of sender for email notifications', '', 'HRMS', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:27:59', null);
INSERT INTO `appconfig` VALUES ('46', 'country', 'Country Settings', 'countrycode', 'Phone number code prefix', '', '256', 'integer', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('47', 'sms', 'SMS Settings', 'serverurl', 'The server url', '', 'http://sms.shreeweb.com/sendsms/sendsms.php', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('48', 'sms', 'SMS Settings', 'serverusername', 'The server username', '', 'nfbpc', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('49', 'sms', 'SMS Settings', 'serverpassword', 'The server password', '', '9UhDHU9V', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('50', 'sms', 'SMS Settings', 'serverport', 'The sms server port', '', null, 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('51', 'sms', 'SMS Settings', 'sendername', 'The default sender of sms notifications', '', 'HRMS', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('52', 'sms', 'SMS Settings', 'testnumber', 'The test number for sms notifications', '', '256701595279', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('53', 'country', 'Country Settings', 'timezone', 'Country timezone', '', 'UTC+03:00', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('54', 'notification', 'Notification and Email Options', 'errorlogemail', 'Errors and downtime email', '', 'admin@devmail.infomacorp.com', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('59', 'notification', 'Notification and Email Options', 'defaultadminemail', 'Default Admin Email', '', 'admin@devmail.infomacorp.com', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('60', 'notification', 'Notification and Email Options', 'defaultadminname', 'Default Admin Name', '', 'HRMS', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('61', 'system', 'System and UI Settings', 'appname', 'Application name', '', 'HRMS Portal', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('62', 'system', 'System and UI Settings', 'companyname', 'Company name', '', 'QED', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('63', 'system', 'System and UI Settings', 'companysignoff', 'Company signoff', '', 'QED Solutions', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('64', 'system', 'System and UI Settings', 'logotype', 'Logo Type', '', '1', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('65', 'system', 'System and UI Settings', 'copyrightinfo', 'Company Copyright', '', ' Copyright Ã¢â€Å“ÃƒÂ©Ã¢â€Â¬Ã‚Â® 2014  |  NFBPC  |  All Rights Reserved', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-02-13 16:54:06', null);
INSERT INTO `appconfig` VALUES ('71', 'api', 'APIs and Services', 'google_mapsapikey', 'API Key for google maps', '', 'AIzaSyAjkTHnLzEkyF1ntVoUkZthaZWV4VN5DJE', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 15:42:27', null);
INSERT INTO `appconfig` VALUES ('75', 'api', 'APIs and Services', 'google_disablemaps', 'Turn on/off maps for debugging', '', 'on', 'Boolean', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 15:42:27', null);
INSERT INTO `appconfig` VALUES ('76', 'sms', 'SMS Settings', 'smsdelivery', 'Turn on/off sms sending feature', '', 'on', 'Boolean', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);

-- ----------------------------
-- Table structure for audittrail
-- ----------------------------
DROP TABLE IF EXISTS `audittrail`;
CREATE TABLE `audittrail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned DEFAULT NULL,
  `transactiontype` varchar(50) DEFAULT NULL,
  `module` tinyint(4) unsigned DEFAULT NULL,
  `usecase` varchar(50) DEFAULT NULL,
  `transactiondetails` mediumtext,
  `transactiondate` datetime DEFAULT NULL,
  `status` enum('N','Y') DEFAULT 'N',
  `browserdetails` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `useragent` varchar(255) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `ismobile` varchar(50) DEFAULT NULL,
  `ipaddress` varchar(50) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `isupdate` tinyint(4) unsigned DEFAULT NULL,
  `prejson` blob,
  `postjson` blob,
  `jsondiff` blob,
  PRIMARY KEY (`id`),
  KEY `fk_audittrail_userid` (`userid`),
  KEY `fk_audittrail_transactiontype` (`transactiontype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of audittrail
-- ----------------------------
INSERT INTO `audittrail` VALUES ('1', '1', 'user.login', '1', '1.1', 'Login for user with id \'admin\' successful', '2015-01-15 20:48:48', 'Y', 'Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '34.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);
INSERT INTO `audittrail` VALUES ('2', '1', 'user.login', '1', '1.1', 'Login for user with id \'admin\' successful', '2015-01-15 21:36:10', 'Y', 'Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '34.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);

-- ----------------------------
-- Table structure for lookuptype
-- ----------------------------
DROP TABLE IF EXISTS `lookuptype`;
CREATE TABLE `lookuptype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `displayname` varchar(50) DEFAULT NULL,
  `listable` tinyint(4) unsigned DEFAULT '1',
  `updatable` tinyint(4) unsigned DEFAULT NULL,
  `addbutnodelete` tinyint(4) unsigned DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lookuptype
-- ----------------------------
INSERT INTO `lookuptype` VALUES ('1', 'LIST_ITEM_COUNT_OPTIONS', 'Listing Items Per Page', '1', '0', '0', 'The number of items per page', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('2', 'SALUTATION', 'Salutations Variables', '1', '1', '0', 'The different salutations Mr, Mrs, Dr, etc', '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('3', 'MARITAL_STATUS_VALUES', 'Marital Status Values', '1', '1', '0', null, '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('4', 'PROFESSIONS', 'Member Professions', '1', '1', '0', null, '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('5', 'CONTACT_RELATIONSHIPS', 'Next of Kin Relationships', '1', '1', '0', null, '2014-09-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('6', 'CHURCH FLATERNITY', 'Church Fraternities', '1', '1', '0', null, '2014-09-15 12:00:00', '1', null, null);

-- ----------------------------
-- Table structure for lookuptypevalue
-- ----------------------------
DROP TABLE IF EXISTS `lookuptypevalue`;
CREATE TABLE `lookuptypevalue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lookuptypeid` int(11) unsigned DEFAULT NULL,
  `lookuptypevalue` varchar(50) DEFAULT NULL,
  `lookupvaluedescription` varchar(255) DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  `alias` varchar(500) DEFAULT NULL,
  `code` varchar(500) DEFAULT NULL,
  `info` mediumtext,
  PRIMARY KEY (`id`),
  KEY `fk_lookuptypevalue_lookuptypeid` (`lookuptypeid`),
  CONSTRAINT `fk_lookuptypevalue_lookuptypeid` FOREIGN KEY (`lookuptypeid`) REFERENCES `lookuptype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lookuptypevalue
-- ----------------------------
INSERT INTO `lookuptypevalue` VALUES ('1', '1', '10', '10', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('2', '1', '25', '25', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('3', '1', '50', '50', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('4', '1', '250', '250', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('5', '1', '500', '500', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('6', '1', 'All', 'All', '1', '2014-09-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('7', '2', '1', 'Dr.', '1', '2014-09-15 12:00:00', '2014-10-04 11:54:31', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('8', '2', '2', 'Ms.', '1', '2014-09-15 12:00:00', '2014-10-04 11:55:08', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('9', '2', '3', 'Mr.', '1', '2014-09-15 12:00:00', '2014-10-04 11:54:52', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('10', '2', '4', 'Mrs.', '1', '2014-09-15 12:00:00', '2014-10-04 11:55:00', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('11', '2', '5', 'Eng.', '1', '2014-09-15 12:00:00', '2014-10-04 11:54:39', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('12', '2', '6', 'Prof.', '1', '2014-09-15 12:00:00', '2014-10-04 11:55:17', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('13', '3', '1', 'Married', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('14', '3', '2', 'Single', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('15', '3', '3', 'Divorced', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('16', '3', '4', 'Widowed', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('17', '3', '5', 'Partnered', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('18', '3', '6', 'Separated', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('19', '2', '7', 'Honourable', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('20', '2', '8', 'Rt Hon', '1', null, '2014-11-26 23:42:01', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('21', '2', '9', 'Bishop', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('22', '2', '10', 'General Overseer', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('23', '2', '11', 'Pastor', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('24', '2', '12', 'Apostle', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('25', '4', '1', 'Teacher', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('26', '4', '2', 'Engineer', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('27', '4', '3', 'General Business', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('28', '4', '4', 'Accountant', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('29', '4', '5', 'Doctor', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('30', '4', '6', 'Farmer', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('32', '4', '8', 'Banking', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('33', '4', '9', 'IT and Computers', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('34', '4', '10', 'Architect', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('35', '4', '11', 'Manufacturing', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('36', '4', '12', 'Housewife', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('37', '4', '13', 'Student', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('38', '4', '14', 'Medical', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('39', '4', '15', 'Clergy', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('40', '4', '15', 'Media and Journalism', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('41', '4', '15', 'Sports', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('42', '4', '15', 'Music, Dance and Drama', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('43', '5', '1', 'Father', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('44', '5', '2', 'Mother', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('45', '5', '3', 'Sibling', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('46', '5', '4', 'Child', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('47', '5', '5', 'Grand Child', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('48', '5', '6', 'Grand Parent', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('49', '5', '7', 'In-law', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('50', '5', '8', 'Aunt', '1060', null, '2014-10-07 08:53:25', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('51', '5', '9', 'Uncle', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('52', '5', '0', 'Business Partner', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('53', '5', '11', 'Spouse', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('54', '5', '12', 'Guardian', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('55', '5', '13', 'Friend', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('56', '5', '14', 'Employer', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('57', '5', '15', 'Workmate', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('58', '5', '17', 'Other Relative', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('59', '5', '16', 'Collegue', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('60', '4', '16', 'Lecturer', '279', '2014-11-03 11:30:49', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('61', '2', '13', 'Hon.', '279', '2014-11-03 16:17:24', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('62', '4', '17', 'Pastor', '1', '2014-11-26 23:38:14', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('63', '4', '18', 'Bishop', '1', '2014-11-26 23:38:46', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('64', '4', '19', 'Gospel Minister', '1', '2014-11-26 23:39:32', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('65', '4', '20', 'Theologian', '1', '2014-11-26 23:41:16', null, null, '', null, null);

-- ----------------------------
-- Table structure for useraccount
-- ----------------------------
DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE `useraccount` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) unsigned DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `othername` varchar(255) DEFAULT NULL,
  `displayname` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `salutation` varchar(10) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `email2` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `phone_actkey` varchar(10) DEFAULT NULL,
  `phone_isactivated` tinyint(4) unsigned DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT '',
  `status` varchar(4) DEFAULT '0',
  `trx` varchar(50) DEFAULT NULL,
  `activationdate` datetime DEFAULT NULL,
  `activationkey` varchar(50) DEFAULT NULL,
  `agreedtoterms` tinyint(4) DEFAULT '1',
  `securityquestion` tinyint(4) unsigned DEFAULT NULL,
  `securityanswer` tinyint(4) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  `nationality` int(11) unsigned DEFAULT NULL,
  `country` varchar(2) DEFAULT 'UG',
  `town` varchar(255) DEFAULT NULL,
  `postalcode` varchar(15) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `isinvited` tinyint(4) unsigned DEFAULT NULL,
  `hasacceptedinvite` tinyint(4) unsigned DEFAULT NULL,
  `dateinvited` date DEFAULT NULL,
  `invitedbyid` int(11) unsigned DEFAULT NULL,
  `bio` blob,
  `gender` tinyint(4) unsigned DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `profilephoto` varchar(255) DEFAULT '',
  `maritalstatus` tinyint(4) DEFAULT NULL,
  `contactid` int(11) unsigned DEFAULT NULL,
  `contactname` varchar(255) DEFAULT NULL,
  `contactphone` varchar(15) DEFAULT NULL,
  `contactrshp` varchar(50) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_member_isactive` (`status`),
  KEY `fk_member_invitedbyid` (`invitedbyid`),
  KEY `index_member_email` (`email`),
  KEY `index_member_phonenumber` (`phone`),
  KEY `index_member_username` (`username`),
  KEY `index_member_createdby` (`createdby`),
  KEY `index_member_lastupdatedby` (`lastupdatedby`),
  CONSTRAINT `fk_member_invitedbyid` FOREIGN KEY (`invitedbyid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2644 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useraccount
-- ----------------------------
INSERT INTO `useraccount` VALUES ('1', '1', 'HRMS', 'Portal', 'Admin', 'HRMS Admin', null, null, 'admin@devmail.infomacorp.com', '', '256752762378', '', null, null, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-09-15 00:00:00', null, '1', null, null, '2014-09-15 00:00:00', '1', '2014-12-04 16:59:47', '1', null, 'UG', null, null, '', null, null, '0', null, null, null, '1', null, '1417701587.jpg', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('279', '1', 'Robert', 'Mutyaba', '', 'Robert Mutyaba', null, '13', 'rbm@devmail.infomacorp.com', '', '256712466456', '', null, null, 'rmutyaba', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-07 13:49:10', '', '1', null, null, '2014-10-01 12:00:00', '1', '2014-11-03 16:18:50', '279', null, 'UG', null, null, '', null, null, '0', '2014-10-07', '1', 0x526F6265727420422E204D75747961626120697320746865204D696E697374657220666F72204943542E2048652070726F7669646573206C65616465727368697020746F20746865204E46425043204D696E6973747279206F66204943543B20616E6420737472656E677468656E73206F75722070726F6A6563747320776974682068697320657863657074696F6E616C206162696C697469657320616E6420657870657269656E636520696E206E6565647320616E616C797369732C2070726F6A656374206D616E6167656D656E742C207175616C69747920636F6E74726F6C2C2064657369676E20616E642073706563696669636174696F6E2C206D6F64696669636174696F6E206F66207374616E6461726420736F6674776172652C20646576656C6F706D656E74206F6620737570706C656D656E74617279206170706C69636174696F6E732C20696E7374616C6C6174696F6E20616E6420696D706C656D656E746174696F6E2C20656475636174696F6E2C20737570706F72742C20616E64206D61696E74656E616E63652E20526F62657274206973206120737472617465676963207468696E6B657220616E642061206D656D626572206F6620496E7374697475746520666F72204E6174696F6E616C205472616E73666F726D6174696F6E20416C756D6E692E0D0A0D0A4D6F72657665722C20526F62657274206861732070617373696F6E20666F72206D696E69737472793A20686520686173207370656E74206F766572203130207965617273206173206120796F757468206D656E746F722C206C656164696E6720746865206469736369706C6573686970206465706172746D656E74206174207468652052656465656D6564206F6620746865204C6F7264204576616E67656C6973746963204368757263682E2048652069732070617373696F6E6174652061626F7574206E6174696F6E616C207472616E73666F726D6174696F6E2C20616E6420657370656369616C6C7920746865204269626C6963616C20617070726F61636820746F207472616E73666F726D696E67206C697665732E20486520726561647320776964656C7920616E642067697665732068696D73656C662066756C6C7920666F722074686520776F726B206F6620436872697374210D0A0D0A526F626572742068617320776F726B656420617320616E20696D706C656D656E746572206F662066696E616E6369616C2073797374656D732073696E6365203139393920616E64206265656E20696E766F6C76656420696E206F76657220343025206F6620746865204D6963726F736F66742044796E616D696373204E415620696D706C656D656E746174696F6E7320696E205567616E64612C20616E64207365766572616C20696E20456173742041667269636120616E64206174206C6561737420313025206F662074686520456E746572707269736520496E7475697420517569636B426F6F6B7320496D706C656D656E746174696F6E732E20526F626572742070726F7669646573206D616E6167656D656E7420746F2052424D2053797374656D7320436F6E73756C74204C74642C2074686520636F6D70616E7920617574686F726973656420746F2073656C6C20496E7475697420517569636B426F6F6B732070726F647563747320696E205567616E64612E0D0A0D0A526F6265727420686F6C64732061204D6173746572206F6620536369656E636520696E20436F6D707574657220536369656E63652C20612042616368656C6F72732064656772656520696E20536369656E636520284D617468656D6174696373292C206120706F7374206772616475617465206469706C6F6D6120696E20436F6D707574657220536369656E63652C20616E64204143434120492063657274696669636174652066726F6D204143434120476C6F62616C2028554B292E20486520697320616C736F206120436572746966696564204E61766973696F6E2050726F64756374205370656369616C6973742C20436572746966696564204E61766973696F6E20536F6C7574696F6E7320446576656C6F7065722C20616E6420686F6C647320496E7475697420517569636B426F6F6B732063657274696669636174696F6E7320696E20506F696E74206F662053616C6520616E6420456E746572707269736520536F6C7574696F6E732E0D0A0D0A526F626572742068617320616C736F2061747461696E65642068696768206C6576656C204F616B73656564204C65616465727368697020547261696E696E6720776974682074686520496E7374697475746520666F72204E6174696F6E616C205472616E73666F726D6174696F6E20696E205567616E64612C20616E642073697473206F6E2074686520626F617264206F66206469726563746F727320666F72204368696C6420616E642046616D696C7920466F756E646174696F6E205567616E64612C204C61626F7572657273205465726D73206F6620436F76656E616E7420616E6420736572766573206F6E206C656164657273686970207465616D73206174205468652052656465656D6564206F6620746865204C6F7264204576616E67656C697374696320436875726368204D616B65726572652E20486520616C736F206C6561647320746865204469736369706C6573686970206465706172746D656E742074686572652E, '1', null, '1415002218.jpg', '1', null, null, null, '', '3');
INSERT INTO `useraccount` VALUES ('304', '8', 'James', 'Kisaale', '', 'James Kisaale', null, '8', 'Pm@devmail.infomdevmail.infomacorp.com', '', '256717440245', '256772479992', null, null, 'prime minister', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-11-01 07:49:07', '', '1', null, null, '2014-10-01 12:00:00', '1', '2014-11-01 08:27:34', '304', null, 'UG', null, null, 'P.o.box 27803, Kampala', null, null, '0', '2014-11-01', '279', null, '1', '1973-09-17', '', '1', '279', null, null, '', '7');
INSERT INTO `useraccount` VALUES ('305', '8', 'Aggrey', 'Soyekwo', '', 'Aggrey Soyekwo', null, null, 'soyekwo10@devmail.infomacorp.com', '', '256717440280', '', null, null, null, '', '0', null, null, '9490dc', '1', null, null, '2014-10-01 12:00:00', '1', '2014-12-05 00:23:01', null, null, 'UG', null, null, '', null, '1', null, '2014-12-05', '279', null, null, null, '', null, null, null, '', null, null);
INSERT INTO `useraccount` VALUES ('448', '8', 'Deo', 'Musoke', '', 'Deo Musoke', null, null, 'dmkk777@devmail.infomacorp.com', '', '256772457239', '', null, null, null, '', '0', null, null, '5f53c8', '1', null, null, '2014-10-01 12:00:00', '1', '2014-12-05 01:00:25', null, null, 'UG', null, null, '', null, '1', null, '2014-12-05', '279', null, null, null, '', null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('741', '8', 'Godfrey', 'Wavamuno', '', 'Godfrey Wavamuno', null, null, 'godfreywavah@devmail.infomacorp.com', '', '256779777777', '', null, null, null, '', '0', null, null, '9abf2f', '1', null, null, '2014-10-01 12:00:00', '1', '2014-12-05 00:48:21', null, null, 'UG', null, null, '', null, '1', null, '2014-12-05', '279', null, null, null, '', null, null, null, '', null, null);
INSERT INTO `useraccount` VALUES ('1060', '2', 'Herman', 'Musiitwa', '', 'Herman Musiitwa', null, '3', 'hmanmstw@devmail.infomacorp.com', '', '256701595279', '', null, '0', 'herman', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-06 09:07:26', '', '1', null, null, '2014-10-06 09:06:36', '1', '2014-11-10 16:15:53', '1', null, 'UG', null, null, '', null, null, '0', '2014-10-06', '1', 0x4C6F72656D20697073756D20646F6C6F722073697420616D65742C20636F6E73656374657475722061646970697363696E6720656C69742E2050726F696E20706C6163657261742C207175616D20757420706F73756572652061646970697363696E672C2075726E6120656E696D2067726176696461206E756C6C612C20696420696E74657264756D206E69736C206E756E632065676574206F7263692E2041656E65616E2076617269757320736564206C6967756C6120617420736F6C6C696369747564696E2E0D0A0D0A20446F6E65632064696374756D20636F6E64696D656E74756D2073617069656E207365642061646970697363696E672E20446F6E656320657420756C74726963696573206C6F72656D2C20757420766F6C75747061742065726F732E204E616D206C616F726565742070656C6C656E746573717565206C6163696E69612E2050726F696E207669766572726120697073756D20717569732073617069656E2074656D706F722066617563696275732E20557420666575676961742075726E612073656420656E696D20616C69717565742C207361676974746973207375736369706974206E756C6C6120736F64616C65732E20496E746567657220626962656E64756D207175697320656C6974206E6F6E20696E74657264756D2E200D0A0D0A51756973717565206C6F72656D2066656C69732C206C616F7265657420636F6E73657175617420736F64616C657320612C20706F727461206E6F6E206C6967756C612E204D6F726269206C6F626F727469732066657567696174206F726369206575206C616F726565742E2050686173656C6C757320656C656D656E74756D2076656C6974206E6F6E206D6574757320656C656D656E74756D2C20617420646170696275732065726174206D6F6C6C69732E20446F6E6563206E6F6E2065726F732071756973206F7263692076756C707574617465207665686963756C6120757420717569732061756775652E200D0A0D0A50686173656C6C7573206120766573746962756C756D207475727069732C206575206D6F6C6C6973206E6962682E204D616563656E617320626C616E64697420636F6E76616C6C69732073617069656E2071756973206C75637475732E20446F6E6563206C6F72656D206D617373612C2072686F6E637573207574206C6F72656D20612C20636F6E76616C6C697320626962656E64756D206E6962682E204E756C6C616D206174206C6163696E69612076656C69742E, '1', '1985-12-29', '1414845168.jpg', '5', '1', null, '', '', '3');
INSERT INTO `useraccount` VALUES ('1061', '7', 'Bishop Joshua', 'Lwere', '', 'Bishop Joshua Lwere', null, '10', 'jlwere@devmail.infomacorp.comorp.com', '', '256772414390', '256712414390', null, '0', null, '', '0', null, null, 'e3c76f', '0', null, null, '2014-10-07 13:53:11', '279', '2014-11-26 23:16:31', '1', null, 'UG', null, null, 'Apollo Kaggwa Road, opp.Shell Petrol Station', null, null, '0', '2014-10-07', '279', 0x426973686F70204A6F73687561204C77657265206973207468652047656E6572616C204F76657273656572206F6620746865204E6174696F6E616C2046656C6C6F7773686970206F6620426F726E20616761696E2050656E7465636F7374616C204368757263686573206F66205567616E646120284E46425043292E20486520697320746865200D0A4469726563746F72206F662047726163652043687269737469616E2043656E7465722043686172697461626C6520547275737420616E64204469726563746F7220477261636520436F6D6D756E69747920537570706F72742050726F6772616D2E20486520697320616C736F2074686520466F756E64657220616E642053656E696F7220506173746F72206F6620477261636520417373656D626C792E2042702E204A6F7368756120697320616C736F2061206C6F63616C20436F756E63696C204368696566206F66206869732076696C6C6167652E0D0A0D0A42702E204A6F7368756120697320766572792070617373696F6E6174652061626F7574204E6174696F6E616C205472616E73666F726D6174696F6E20616E6420706172746963756C61726C79206F7065726174657320696E20746865206172656173206F6620427573696E6573732C20436976696C20536F63696574792C20436F6E666C696374205265736F6C7574696F6E2C20446576656C6F706D656E742C20496E7465726E616C6C7920446973706C616365642C2048756D616E6974617269616E2052656C6965662C20536F6369616C20456E7472657072656E657572736869702E204865206973206D61727269656420746F204D61726761726574204C7765726520616E6420476F642068617320626C6573736564207468656D207769746820666F7572206368696C6472656E2C20696E636C7564696E67207477696E732E0D0A0D0A4E4154494F4E414C2046454C4C4F575348495020494E564F4C56454D454E540D0A0D0A48617665206265656E2070617274206F6620746869732046656C6C6F77736869702073696E63652074686520646179206F662069747320696E63657074696F6E2EE280A85769746E6573736564207468652065737461626C6973686D656E74206F6620746869732046656C6C6F7773686970206F6E2031397468204665627275617279203139393020696E2054696D6F74687920436C6173732C206174205761746F746F2043687572636820287468656E204B50432920627920746865204C61746520486F6E2042616C616B204B697279612E0D0A0D0A436C65726B206F66204E4642504320666F722031393938202D20323030370D0A4C6567616C2041647669736F7220666F72207468652046656C6C6F77736869700D0A447261667465642074686520436F6E737469747574696F6E206F66207468652046656C6C6F77736869700D0A4472616674656420616E64205365742075702074686520537472756374757265206F66207468652046656C6C6F7773686970200D0A52656769737465726564207468652046656C6C6F77736869702077697468204D696E6973747279206F6620496E7465726E616C20416666616972730D0A447261667465642074686520436F6465206F6620436F6E64756374207769746820696E7075742066726F6D2044722E204D6974616C612026205072204D69636861656C204B79617A7A65200D0A0D0A536574207570207468652046656C6C6F77736869702053656372657461726961740D0A41646D696E697374726174696F6E20262046696C696E672053797374656D0D0A4D656D6265727368697020526567697374726174696F6E2073797374656D200D0A4920736574207570207468652046656C6C6F777368697020446174612062617365206F66206D656D62657220436875726368657320636F756E74727920776964652E0D0A4D616465207468652046656C6C6F77736869702044696172790D0A0D0A54726176656C6C656420636F756E7472792D77696465200D0A5465616368696E672026206578706C61696E696E67207768617420746869732046656C6C6F77736869702069730D0A52656372756974696E6720706173746F727320746F206A6F696E20746869732046656C6C6F77736869700D0A45737461626C697368696E672046656C6C6F777368697020737472756374757265730D0A576974682044722E204D6974616C6120646973747269627574696E6720776865656C204368616972732026206D656574696E672064697374726963742F6369766963206C6561646572730D0A576F726B696E6720776974682044722E204D6974616C612C20492068617665206265656E20696E766F6C76656420696E20746865206964656E74696669636174696F6E2C206170706F696E746D656E742C20696E64756374696F6E2026206F7269656E746174696F6E206F66207468652063757272656E74206D656D62657273206F662074686520456C6465727320436F756E63696C2E0D0A0D0A5370656369616C20536572766963657320746F2074686520506173746F72730D0A547261696E696E6720506173746F727320696E20436875726368204C6561646572736869700D0A547261696E696E6720506173746F727320696E2046696E616E63652026204368757263682041646D696E697374726174696F6E2E0D0A48617665207772697474656E20626F6F6B73206F6E206C6561646572736869702C2066696E616E636520262061646D696E697374726174696F6E20746F2068656C7020706173746F72732073706972697475616C6C7920616E642070726163746963616C6C792E0D0A48656C70696E6720706173746F727320746F20726567697374657220746865697220436875726368657320696E204E474F20262043424FE28099730D0A50726F76696465642061204C6177796572206174206D7920436875726368205072656D6973657320746F206F666665722073756273696469736564206C6567616C20736572766963657320746F207468652046656C6C6F7773686970206D656D62657220706173746F72730D0A0D0A47656E6572616C20536563726574617279206F66207468652046656C6C6F7773686970202832303037202D2032303133290D0A0D0A, '1', null, '1417031436.jpg', '1', null, 'Mrs Christine Margaret Lwere', '256772493807', '11', '9');
INSERT INTO `useraccount` VALUES ('1062', '7', 'Lule', 'Male', 'Testuser', 'Lule Male', null, null, 'hmusiitwa@devmail.infomacorp.com', '', '256776595279', '', null, '0', 'lulemale', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-13 13:32:07', '816a46', '1', null, null, '2014-10-13 13:18:40', '1', '2014-11-10 15:55:14', null, null, 'UG', null, null, '', null, null, '0', '2014-10-13', '1', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1063', '2', 'Hilda', 'Naisiko', '', 'Hilda Naisiko', null, '2', 'hildanai@devmail.infomacorp.com', '', '256714123323', '', null, '0', null, '', '0', null, null, '3735fb', '0', null, null, '2014-10-15 17:47:46', '279', null, null, null, 'UG', null, null, 'Kyekyo', null, '1', '0', '2014-10-15', '279', null, '2', null, '', '2', '279', null, null, '13', '14');
INSERT INTO `useraccount` VALUES ('1064', '7', 'Denis', 'Ezokare', '', 'Denis Ezokare', null, null, 'denis@devmail.infomacorp.com', '', '256755145507', '', null, '0', 'denis', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-16 06:33:38', '', '1', null, null, '2014-10-15 17:51:24', '279', '2014-10-16 06:33:38', null, null, 'UG', null, null, '', null, null, '0', '2014-10-15', '279', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1065', '7', 'Jonah', 'Elubu', '', 'Jonah NFBPC', null, null, 'jonahelub@devmail.infomacorp.com', '', '256773128700', '', null, '0', 'jonah', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-25 15:46:18', '', '1', null, null, '2014-10-15 17:57:24', '279', '2014-10-25 16:23:29', null, null, 'UG', null, null, '', null, null, '0', '2014-10-15', '279', null, '1', null, '1414268609.jpg', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1066', '7', 'Samuel', 'Alioni', '', 'Samuel Alioni', null, '3', 'samatech7@devmail.infomacorp.com', '', '256702740174', '', null, '0', 'samatech', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-16 00:43:41', '', '1', null, null, '2014-10-15 17:59:29', '279', '2014-10-24 02:04:15', '1066', null, 'UG', null, null, '', null, null, '0', '2014-10-15', '279', null, '1', null, '', '1', null, null, null, '', '9');
INSERT INTO `useraccount` VALUES ('1067', '7', 'Gordon', 'Kisaakye', '', 'Gordon Kisaakye', null, null, 'gordon56692@devmail.infomacorp.com', '', '256777359301', '', null, '0', null, '', '0', null, null, 'f197d5', '0', null, null, '2014-10-15 18:02:21', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1068', '7', 'Fred', 'Kasule', '', 'Fred Kasule', null, null, 'fredkasulen@devmail.infomacorp.com', '', '256776666245', '', null, '0', null, '', '0', null, null, 'ebf539', '0', null, null, '2014-10-15 18:04:35', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1069', '7', 'Fredrick', 'Ssemazzi', '', 'Fredrick Ssemazzi', null, null, 'fredericksemazzi@devmail.infomacorp.com', '', '256782396438', '', null, '0', null, '', '0', null, null, 'a9b7aa', '0', null, null, '2014-10-15 18:07:51', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1070', '7', 'Africano', 'Magyezi', '', 'Africano Magyezi', null, '11', 'africanomagezi@devmaildevmail.infomacorp.com', '', '256752850921', '256776850921', null, '0', 'clerk@nfbpc.org', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-17 07:19:08', '', '1', null, null, '2014-10-15 18:11:00', '279', '2014-11-28 16:53:45', '1070', null, 'UG', null, null, 'P. O. Box 21267, Kampala - Uganda', null, null, '0', '2014-10-15', '279', null, '1', '1964-07-07', '1413439093.jpg', '1', '18', null, '', '11', '16');
INSERT INTO `useraccount` VALUES ('1071', '7', 'Stephen', 'Kasumba', '', 'Stephen Kasumba', null, null, 'stevenkast123@devmail.infomacorp.com', '', '256705424037', '', null, '0', null, '', '0', null, null, 'add477', '0', null, null, '2014-10-15 18:14:03', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1072', '7', 'Welike', 'Amos', '', 'Amos Werike', null, null, 'amoswelike@devmail.infomacorp.com', '', '256702841314', '', null, '0', 'amos welike', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-11-07 01:56:06', '', '1', null, null, '2014-10-15 18:16:31', '279', '2014-11-07 01:56:06', null, null, 'UG', null, null, '', null, null, '0', '2014-10-15', '279', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1073', '7', 'David', 'Matovu', '', 'David Matovu', null, null, 'davimato@devmail.infomacorp.com', '', '256772588193', '', null, '0', null, '', '0', null, null, '9033d1', '0', null, null, '2014-10-15 18:29:59', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1074', '1', 'Fredrick', 'Kanobe', '', 'Fredrick Kanobe', null, null, 'fredrick.kanobe@devmail.infomacorp.com', '', '256782592120', '', null, '0', 'fkanobe', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-11-03 10:23:33', '', '1', null, null, '2014-10-15 18:32:03', '1', '2014-11-03 10:23:33', null, null, 'UG', null, null, '', null, null, '0', '2014-11-03', '1', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1075', '7', 'Peter', 'Igibolu', '', 'Peter Igiibolu', null, null, 'mpigibolu@devmail.infomacorp.com', '', '256753451297', '', null, '0', 'pigibolu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-10-28 02:15:05', '', '1', null, null, '2014-10-15 18:34:16', '279', '2014-10-28 02:15:05', null, null, 'UG', null, null, '', null, null, '0', '2014-10-15', '279', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1076', '7', 'Andrew', 'Mwesige', '', 'Andrew Mwesige', null, null, 'mwesigea@devmail.infomacorp.com', '', '256712493893', '', null, '0', null, '', '0', null, null, 'c56ac1', '0', null, null, '2014-10-15 18:36:22', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-15', '279', null, '1', null, '', null, null, null, null, '', null);
INSERT INTO `useraccount` VALUES ('1079', '8', 'Joan', 'Mugenzi', '', 'Joan Mugenzi', null, '2', 'joanmugenzi@devmail.infomacorp.com', '', '256772460976', '', null, '0', null, '', '0', null, null, 'ed2276', '0', null, null, '2014-10-25 08:58:05', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-10-25', '279', null, '2', null, '', '2', null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1080', '7', 'Racheal', 'Bategeka', '', 'Racheal Bategeka', null, '2', 'rbategeka@devmail.infomacorp.com', '', '256772466456', '', null, '0', null, '', '0', null, null, 'd9ab50', '0', null, null, '2014-10-27 05:54:09', '279', '2014-11-01 02:14:48', '1', null, 'UG', null, null, '', null, null, '0', '2014-10-27', '279', null, '2', null, '', '2', null, null, null, '', '2');
INSERT INTO `useraccount` VALUES ('1081', '1', 'Simon Pavia', 'Odeke', '', 'Simon Pavia Odeke', null, '3', 'espadevmail.infomacorp.comomacorp.com', '', '256752033229', '256774033229', null, '0', 'espadek', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-11-13 19:05:53', '', '1', null, null, '2014-11-01 05:37:55', '1', '2014-11-13 19:05:53', '1', null, 'UG', null, null, 'P .O. Box 12715 Kampala', null, null, '0', '2014-11-11', '279', null, '1', '1986-08-20', '1414835393.jpg', '2', null, null, '', '2', '9');
INSERT INTO `useraccount` VALUES ('1082', '7', 'Nata', 'Anthony', '', 'Nata Anthony', null, '3', 'nataanthoni@devmail.infomacorp.com', '', '256702767861', '', null, '0', 'enata', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-11-01 19:11:12', '', '1', null, null, '2014-11-01 10:11:41', '279', '2014-11-20 11:10:24', '1082', null, 'UG', null, null, 'Nakawa, Kamp[ala', null, null, '0', '2014-11-01', '279', 0x4920616D204E61746120416E74686F6E792C206120626F726E20616761696E2043687269737469616E2066726F6D20746865204E6F72746865726E2070617274206F662074686520636F756E7472792C20616E204170707320446576656C6F7065722C20626173696E67206F6E2057656220417070732E204865206973206120616E206576616E67656C697374202C2063757272656E746C792066656C6C6F7773686970696E672066726F6D204E616B6177612050656E7465636F7374616C204368757263682C20486520646F6573206C6F766520746865204C6F72642077686F6C65206865617465646C7920616E64206861732061206D696E6420736574206F6620E2809C4E6F7468696E6720697320496D706F737369626C6520696620796F7520676976652069742074696D6521E2809D0D0A42757420476F642066697273742E, '1', '1991-12-26', '1416470651.jpg', '2', '1084', null, '', '17', '9');
INSERT INTO `useraccount` VALUES ('1083', '7', 'Nick', 'Dekoning', '', 'Nick Dekoning', null, null, 'nick.dekoning@devmail.infomacorp.com', '', '256790474073', '', null, '0', 'nickdekoning', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-12-03 16:21:06', '', '1', null, null, '2014-11-01 10:59:37', '279', '2014-12-03 16:21:06', '1', null, 'UG', null, null, '', null, null, '0', '2014-12-03', '1', null, '1', null, '1417579593.jpg', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('1086', '8', 'Anthony', 'Mugisha', '', 'Anthony Mugisha', null, '6', 'amugisha@devmail.infomacorp.com', '', '256772502887', '', null, '0', null, '', '0', null, null, '1dcd7a', '0', null, null, '2014-11-03 11:37:32', '279', '2014-11-03 14:34:22', '279', null, 'UG', null, null, '', null, '1', '0', '2014-11-03', '279', null, '1', null, '', '1', null, null, null, '', '6');
INSERT INTO `useraccount` VALUES ('1087', '8', 'Enock', 'Ssebuyungo', '', 'Enock Ssebuyungo', null, '6', 'esebuyungo@devmail.infomacorp.com', '', '256772424428', '', null, '0', null, '', '0', null, null, '51ef29', '0', null, null, '2014-11-03 11:40:41', '279', '2014-11-26 17:06:23', '1', null, 'UG', null, null, '', null, '1', '0', '2014-11-26', '1', null, '1', null, '', '1', null, null, '', '', '16');
INSERT INTO `useraccount` VALUES ('2638', '8', 'Juliet', 'Namukasa', '', 'Juliet Namukasa', null, '2', 'juliet.namukasa@devmail.infomacorp.com', '', '256772308383', '', null, '0', null, '', '0', null, null, '4e4cd7', '0', null, null, '2014-12-05 00:31:56', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-12-05', '279', null, '2', '1973-11-05', '', '2', null, null, '', '', '4');
INSERT INTO `useraccount` VALUES ('2639', '8', 'Julius', 'Bitamazire', '', 'Julius Bitamazire', null, '3', 'julius.bitamazire@devmail.infomacorp.com', '', '256752561077', '', null, '0', null, '', '0', null, null, 'b49154', '0', null, null, '2014-12-05 00:37:48', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-12-05', '279', null, '1', '1963-11-05', '', '1', null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('2640', '8', 'Humphery', 'Rwabugahya', '', 'Humphery Rwabugahya', null, '3', 'hrwabugahya@devmail.infomacorp.com', '', '256776786077', '', null, '0', 'hrwabugahya', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-12-07 20:33:04', '', '1', null, null, '2014-12-05 00:44:11', '279', '2014-12-07 20:33:04', null, null, 'UG', null, null, '', null, null, '0', '2014-12-05', '279', null, '1', '1972-12-01', '', '1', null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('2641', '8', 'David', 'Semugooma', 'Rogers', 'David Rogers Semugooma', null, '5', 'drs@devmail.devmail.infomacorp.com', '', '256772401409', '256704401409', null, '0', 'drsemugooma', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-12-05 14:35:13', '', '1', null, null, '2014-12-05 00:51:50', '279', '2014-12-05 14:58:12', '2641', null, 'UG', null, null, 'P.O. Box 30457\r\nKampala', null, null, '0', '2014-12-05', '279', null, '1', '1971-07-05', '1417780490.jpg', '1', null, 'Daisy Semugooma', '256701401409', '11', '2');
INSERT INTO `useraccount` VALUES ('2642', '8', 'Michael', 'Kansiime', '', 'Michael Kansiime', null, null, 'drkanmich@devmail.infomacorp.com', '', '256776763330', '', null, '0', null, '', '0', null, null, 'd7fcbc', '0', null, null, '2014-12-05 01:18:30', '279', null, null, null, 'UG', null, null, '', null, '1', '0', '2014-12-05', '279', null, '1', null, '', null, null, null, '', '', null);
INSERT INTO `useraccount` VALUES ('2643', '8', 'Godfrey', 'Mawa', '', 'Godfrey Mawa', null, null, 'mawa_mog@devmail.infomacorp.com', '', '256772378468', '', null, '0', 'mawa_mog', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2014-12-22 13:31:19', '', '1', null, null, '2014-12-22 09:36:00', '279', '2014-12-22 13:31:19', null, null, 'UG', null, null, '', null, null, '0', '2014-12-22', '279', null, '1', null, '', null, null, null, '', '', null);

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `senderid` int(11) unsigned DEFAULT NULL,
  `parentid` int(11) unsigned DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `contents` blob NOT NULL,
  `html` blob,
  `datecreated` datetime NOT NULL,
  `type` tinyint(4) unsigned DEFAULT '0',
  `sendername` varchar(255) DEFAULT NULL,
  `senderemail` varchar(255) DEFAULT NULL,
  `membertotal` varchar(50) DEFAULT NULL,
  `usertotal` varchar(50) DEFAULT NULL,
  `smsid` varchar(50) DEFAULT NULL,
  `resultcode` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_senderid` (`senderid`),
  KEY `fk_message_parentid` (`parentid`),
  CONSTRAINT `fk_message_parentid` FOREIGN KEY (`parentid`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_message_senderid` FOREIGN KEY (`senderid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', '1', null, '', 0x486579206865726D616E2E20746869732069732061206C69766520746573742066726F6D206E6662706320706F7274616C2070726F646E2E, null, '2014-11-01 02:10:21', '2', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('2', '279', null, '', 0x7472792074686973, null, '2014-11-01 04:50:59', '2', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('3', '1', null, 'testing kano', 0x776F772069742069732061206772656174206461790D0A, null, '2014-11-03 09:59:20', '1', null, null, '8', '6', null, null, null);
INSERT INTO `message` VALUES ('4', '279', null, 'Testing Platform', 0x5468697320656D61696C2077696C6C20646566696E6974656C7920726561636820526F626572742E0D0A0D0A46616E74617374696321, null, '2014-11-03 10:27:14', '1', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('5', '279', null, 'Testing Platform', 0x486921205468697320656D61696C2069732073656E742073747261696768742066726F6D206F7572206C61756E6368696E6720706F7274616C206173206120746573742E0D0A0D0A506C6561736520636F6E6669726D20726563656970742E0D0A0D0A526567617264732C0D0A0D0A526F62657274, null, '2014-11-03 10:35:29', '1', null, null, '2', '2', null, null, null);
INSERT INTO `message` VALUES ('6', '279', null, 'Minister Prayer Meeting for December 2014', 0x5468697320697320746F2072656D696E6420796F752074686174207765207368616C6C2068617665206F757220707261796572206D656574696E6720696E20446563656D626572206F6E2036746820446563656D62657220323031342E0D0A0D0A526567617264732C0D0A0D0A506F7274616C2041646D696E, null, '2014-11-03 14:06:55', '1', null, null, '2', '2', null, null, null);
INSERT INTO `message` VALUES ('7', '279', null, '', 0x536565626F20636F6E6669726D2072656365697074, null, '2014-11-04 12:37:23', '2', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('8', '279', null, '', 0x6E64632074657374, null, '2014-11-07 12:21:32', '2', null, null, '3', '3', null, null, null);
INSERT INTO `message` VALUES ('9', '1070', null, 'Reply to the TEsting', 0x4920686176652072656365697665642074686520546573740D0A0D0A4166726963616E6F, null, '2014-11-28 16:26:25', '1', null, null, '0', '0', null, null, null);
INSERT INTO `message` VALUES ('10', '1070', null, 'Reply to the TEst', 0x5265636569766564207468652054657374204D6573736167650D0A0D0A4166726963616E6F0D0A, null, '2014-11-28 16:27:53', '1', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('11', null, null, 'we would like to join with you', 0x204465617220467269656E640D0A4772656574696E677320746F20796F752066726F6D20454E48414B4B4F5245202C65737461626C69736865642020494E20323030206A757374206120686F70652C206275742061207265616C6973746963206578706563746174696F6E20666F7220616C6C2E205768696C652077652068617665206D616465207369676E69666963616E742070726F677265737320746F7761726420616368696576696E67207468697320676F616C2C207468657265206973206D7563682072656D61696E696E6720746F20626520646F6E652E0D0A57652061726520626C65737365642077697468206120706C6174666F726D2074686174206166666F72647320757320746865206F70706F7274756E69747920746F2067697665206120766F69636520746F2074686F73652077686F20646F6EE28099742068617665206120766F6963652C20746F2068656C702070656F706C65206265636F6D65206D6F72652070617373696F6E61746520616E642066756C66696C6C656420696E2074686569722020204C4946452C2072656C6174696F6E73686970732C2073706972697475616C206C69666520616E64206361726565722E0D0A0D0A4B61696C61792052616A752C6D792077696665204C45454C41202061726520636F6D6D697474656420746F20696D70726F76696E6720746865206C69766573206F6620646973616476616E746167656420616E64204F525048414E20206368696C6472656E2E20496E20636F6C6C61626F726174696F6E2077697468206F74686572732C2077652073747269766520746F2070726F7669646520796F7574687320776974682061636365737320746F20637269746963616C6C79206E65656465642073657276696365732C20696E636C7564696E67207361666520616E6420646563656E7420686F7573696E672C206D65646963616C20616E64206D656E74616C206865616C74682073657276696365732C20656475636174696F6E20616E64206A6F6220747261696E696E672E20496E20612073656375726520616E64206C6F76696E6720656E7669726F6E6D656E742C206974206973206F75722062656C696566207468657365206368696C6472656E2077696C6C20646576656C6F702061206E65772073656E7365206F6620726573706F6E736962696C69747920616E6420636F6D6D69746D656E7420746F207468656D73656C7665732C2074686569722066656C6C6F772068756D616E206265696E67732C20746865697220636F6D6D756E697469657320616E64206E6174696F6E2E0D0A0D0A4279206A6F696E696E6720746F6765746865722C2077652077696C6C2062652061626C6520746F206272696E6720746F67657468657220616C6C206F66206F757220636F6D62696E65642074616C656E747320616E6420626C657373696E677320746F2068656C702070656F706C6520646576656C6F7020612073656E7365206F6620707572706F736520616E64206D697373696F6E20696E207468656972206C697665732E205765206561726E6573746C79207365656B20796F757220737570706F7274206F662074686973206566666F727420746F2068656C7020637265617465206120646566696E696E67206D6F6D656E7420696E20746865206C69766573206F66206368696C6472656E20616E642066616D696C6965732E0D0A0D0A200D0A0D0A53696E636572656C790D0A0D0A4B61696C61792052616A750D0A0D0A2F2F7777772E66616365626F6F6B2E636F6D2F61706F73746C65636875726368696E696E6469610D0A0D0A7777772E6661697468696E646565642E636F6D0D0A200D0A7777772E66616365626F6F6B2E636F6D2F70616765732F4368696C6472656E2D666F722D474F442F3134303730333430353937323931300D0A0D0A4B61696C61792052616A750D0A48204E6F23390D0A41594F44485941204E4147415220434F4C4F4E590D0A4C4F54484B554E54412C20534543554E44455241424144202D20353030302031350D0A414E4448524120505241444553482C20494E4449410D0A43454C4C204E4F202D20303039312D393631383535393936350D0A456D61696C204944202D2072616A756B61696C617940676D61696C2E636F6D200D0A57656273697465202D207777772E206661697468696E646565642E636F6D200D0A200D0A687474703A2F2F7777772E796F75747562652E636F6D2F757365722F6B61696C617933370D0A, null, '2014-12-03 08:17:10', '1', 'Kailay Raju', 'rajukailay@gmail.com', '1', '1', null, null, null);
INSERT INTO `message` VALUES ('12', '1', null, 'Test email', 0x746869732069732061207465737420656D61696C2E20706C656173652069676E6F7265, null, '2014-12-05 09:23:52', '1', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('13', '1', null, 'Prayer Meeting - 06/12/2014', 0x5468697320697320746F206C657420796F75206B6E6F772074686174207765206172652070726570696E6720616E6F746865722070726179657220627265616B666173740D0A0D0A54696D692047726579, null, '2014-12-05 09:44:30', '1', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('14', '1', null, 'Hey hasadadda', 0x7A632078637A6A627820637A6B63627A6B2063630D0A0D0A6173646B6A2061646A6B6164616473736464, null, '2014-12-05 09:48:33', '1', null, null, '1', '1', null, null, null);
INSERT INTO `message` VALUES ('15', '1070', null, 'THE MINISTERS\' MEETING', 0x4465617220436F6C6C6561677565733B0D0A0D0A596F75206172652068756D626C792072656D696E6465642061626F7574206F757220337264204D696E69737465727327206D656574696E672064756520746F2074616B6520706C61636520746F6D6F72726F7720617420746865204E46425043204865616471756172746572732C20617420353A3030202D20393A303020702E6D2E0D0A0D0A506C6561736520656E646561766F7220746F20617474656E640D0A0D0A4166726963616E6F204D616779657A690D0A4E43202D204E46425043, null, '2014-12-09 19:17:11', '1', null, null, '35', '35', null, null, null);
INSERT INTO `message` VALUES ('16', '1070', null, 'THE MINISTERS\' MEETING', 0x446561722053657276616E7473206F6620746865204C6F72642C200D0A0D0A492068657265627920696E7669746520796F7520746F20746F6D6F72726F77277320337264204E50425043204D696E69737465722773204D656574696E672064756520746F2074616B6520706C61636520617420746865204E46425043206F6666696365733B20746F6D6F72726F772031302D31322D323031342C2066726F6D20353A303020702E6D2E0D0A0D0A546865204167656E646120696E636C756465733B20446576656C6F70696E6720612073797374656D206F66204D6F62696C697A696E67207468652043687572636865732077697468696E2047726561746572204B616D70616C6120526567696F6E2E0D0A0D0A506C6561736520656E646561766F7220746F20617474656E640D0A0D0A4166726963616E6F204D616779657A690D0A4E6174696F6E616C20436C65726B, null, '2014-12-09 19:24:06', '1', null, null, '5', '5', null, null, null);
INSERT INTO `message` VALUES ('17', null, null, 'Kathy', 0x492063616D6520746F20796F7572204265747479204F646F6E676F20207C204E464250432057656220506F7274616C207061676520616E64206E6F746963656420796F7520636F756C6420686176652061206C6F74206D6F726520686974732E2049206861766520666F756E64207468617420746865206B657920746F2072756E6E696E6720612077656273697465206973206D616B696E672073757265207468652076697369746F727320796F75206172652067657474696E672061726520696E746572657374656420696E20796F7572206E696368652E205468657265206973206120636F6D70616E79207468617420796F752063616E206765742076697369746F72732066726F6D20616E642074686579206C657420796F7520747279207468656972207365727669636520666F7220667265652E2049206D616E6167656420746F20676574206F766572203330302074617267657465642076697369746F727320746F2064617920746F206D7920776562736974652E20436865636B206974206F757420686572653A20687474703A2F2F686F6D652E70756B652E73652F752F3271647A, null, '2014-12-13 20:46:43', '1', 'Kathy', 'ubgskqsc@aol.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('18', null, null, 'Mindy', 0x48692C206D79206E616D65206973204D696E647920616E64204920616D207468652073616C6573206D616E61676572206174205374617253454F204D61726B6574696E672E204920776173206A757374206C6F6F6B696E6720617420796F7572207369746520616E6420736565207468617420796F75722077656273697465206861732074686520706F74656E7469616C20746F206765742061206C6F74206F662076697369746F72732E2049206A7573742077616E7420746F2074656C6C20796F752C20496E206361736520796F7520646F6E277420616C7265616479206B6E6F772E2E2E20546865726520697320612077656273697465207365727669636520776869636820616C726561647920686173206D6F7265207468616E203136206D696C6C696F6E2075736572732C20616E6420746865206D616A6F72697479206F66207468652075736572732061726520696E746572657374656420696E20746F70696373206C696B6520796F7572732E2042792067657474696E6720796F75722077656273697465206F6E2074686973207365727669636520796F7520686176652061206368616E636520746F2067657420796F75722073697465206D6F726520706F70756C6172207468616E20796F752063616E20696D6167696E652E204974206973206672656520746F207369676E20757020616E6420796F752063616E2066696E64206F7574206D6F72652061626F757420697420686572653A20687474703A2F2F747230322E636F6D2F37202D204E6F772C206C6574206D652061736B20796F752E2E2E20446F20796F75206E65656420796F7572207369746520746F206265207375636365737366756C20746F206D61696E7461696E20796F757220776179206F66206C6966653F20446F20796F75206E6565642074617267657465642076697369746F72732077686F2061726520696E746572657374656420696E2074686520736572766963657320616E642070726F647563747320796F75206F666665723F20417265206C6F6F6B696E6720666F72206578706F737572652C20746F20696E6372656173652073616C65732C20616E6420746F20717569636B6C7920646576656C6F702061776172656E65737320666F7220796F757220736974653F20496620796F757220616E73776572206973205945532C20796F752063616E2061636869657665207468657365207468696E6773206F6E6C7920696620796F752067657420796F75722077656273697465206F6E207468652073657276696365204920616D2064657363726962696E672E205468697320747261666669632073657276696365206164766572746973657320796F7520746F2074686F7573616E64732C207768696C6520616C736F20676976696E6720796F752061206368616E636520746F2074657374207468652073657276696365206265666F726520706179696E6720616E797468696E672E20416C6C2074686520706F70756C617220736974657320617265207573696E672074686973206E6574776F726B20746F20626F6F7374207468656972207472616666696320616E6420616420726576656E75652120576879206172656EE280997420796F753F20416E64207768617420697320626574746572207468616E20747261666669633F204974E280997320726563757272696E672074726166666963212054686174277320686F772072756E6E696E672061207375636365737366756C207369746520776F726B732E2E2E2048657265277320746F20796F75722073756363657373212046696E64206F7574206D6F726520686572653A20687474703A2F2F696E6E6F7661642E77732F706F356B71, null, '2014-12-15 13:16:12', '1', 'Mindy', 'ramxonbmi@gmail.com', '1', '1', null, null, null);
INSERT INTO `message` VALUES ('19', null, null, 'Mindy', 0x48692C206D79206E616D65206973204D696E647920616E64204920616D207468652073616C6573206D616E61676572206174205374617253454F204D61726B6574696E672E204920776173206A757374206C6F6F6B696E6720617420796F7572207369746520616E6420736565207468617420796F75722073697465206861732074686520706F74656E7469616C20746F206265636F6D65207665727920706F70756C61722E2049206A7573742077616E7420746F2074656C6C20796F752C20496E206361736520796F7520646F6E277420616C7265616479206B6E6F772E2E2E20546865726520697320612077656273697465207365727669636520776869636820616C726561647920686173206D6F7265207468616E203136206D696C6C696F6E2075736572732C20616E6420746865206D616A6F72697479206F662074686520757365727320617265206C6F6F6B696E6720666F7220746F70696373206C696B6520796F7572732E2042792067657474696E6720796F75722077656273697465206F6E2074686973206E6574776F726B20796F7520686176652061206368616E636520746F2067657420796F75722073697465206D6F726520706F70756C6172207468616E20796F752063616E20696D6167696E652E204974206973206672656520746F207369676E20757020616E6420796F752063616E2072656164206D6F72652061626F757420697420686572653A20687474703A2F2F747230322E636F6D2F37202D204E6F772C206C6574206D652061736B20796F752E2E2E20446F20796F75206E65656420796F7572207369746520746F206265207375636365737366756C20746F206D61696E7461696E20796F757220627573696E6573733F20446F20796F75206E65656420746172676574656420747261666669632077686F2061726520696E746572657374656420696E2074686520736572766963657320616E642070726F647563747320796F75206F666665723F20417265206C6F6F6B696E6720666F72206578706F737572652C20746F20696E6372656173652073616C65732C20616E6420746F20717569636B6C7920646576656C6F702061776172656E65737320666F7220796F757220776562736974653F20496620796F757220616E73776572206973205945532C20796F752063616E2061636869657665207468657365207468696E6773206F6E6C7920696620796F752067657420796F75722073697465206F6E207468652073657276696365204920616D2074616C6B696E672061626F75742E205468697320747261666669632073657276696365206164766572746973657320796F7520746F2074686F7573616E64732C207768696C6520616C736F20676976696E6720796F752061206368616E636520746F207465737420746865206E6574776F726B206265666F726520706179696E6720616E797468696E6720617420616C6C2E20416C6C2074686520706F70756C617220736974657320617265207573696E672074686973207365727669636520746F20626F6F7374207468656972207472616666696320616E6420616420726576656E75652120576879206172656EE280997420796F753F20416E64207768617420697320626574746572207468616E20747261666669633F204974E280997320726563757272696E672074726166666963212054686174277320686F772072756E6E696E672061207375636365737366756C207369746520776F726B732E2E2E2048657265277320746F20796F75722073756363657373212046696E64206F7574206D6F726520686572653A20687474703A2F2F746C696E6B2E706C2F36663030, null, '2014-12-17 18:55:10', '1', 'Mindy', 'mxpuoizrm@gmail.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('20', '1070', null, '4TH MINISTERS\' MEETING', 0x0D0A4465617220436F6C6C6561677565733B0D0A0D0A596F75206172652068756D626C792072656D696E6465642061626F7574206F757220347468204D696E69737465727327206D656574696E672064756520746F2074616B6520706C61636520746F6D6F72726F7720617420746865204E4642504320486561647175617274657273206F6E203139746820446563656D6265722C20617420353A3030202D20393A303020702E6D2E0D0A0D0A506C6561736520656E646561766F7220746F20617474656E640D0A0D0A4166726963616E6F204D616779657A690D0A4E43202D204E46425043, null, '2014-12-18 09:17:10', '1', null, null, '12', '12', null, null, null);
INSERT INTO `message` VALUES ('21', '1070', null, '4TH MINISTERS\' MEETING', 0x0D0A4465617220436F6C6C6561677565733B0D0A0D0A596F75206172652068756D626C792072656D696E6465642061626F7574206F757220347468204D696E69737465727327206D656574696E672064756520746F2074616B6520706C61636520746F6D6F72726F7720617420746865204E46425043204865616471756172746572732C206F6E2031392D31322D3230313420617420353A3030202D20393A303020702E6D2E0D0A506C6561736520656E646561766F7220746F20617474656E640D0A0D0A4166726963616E6F204D616779657A690D0A4E43202D204E46425043, null, '2014-12-18 09:18:31', '1', null, null, '35', '35', null, null, null);
INSERT INTO `message` VALUES ('22', null, null, 'Wendy', 0x48692C206D79206E616D65206973204D696E647920616E64204920616D207468652073616C6573206D616E61676572206174205374617253454F204D61726B6574696E672E204920776173206A757374206C6F6F6B696E6720617420796F7572207765627369746520616E6420736565207468617420796F75722073697465206861732074686520706F74656E7469616C20746F206265636F6D65207665727920706F70756C61722E2049206A7573742077616E7420746F2074656C6C20796F752C20496E206361736520796F7520646F6E277420616C7265616479206B6E6F772E2E2E20546865726520697320612077656273697465207365727669636520776869636820616C726561647920686173206D6F7265207468616E203136206D696C6C696F6E2075736572732C20616E64206D6F7374206F662074686520757365727320617265206C6F6F6B696E6720666F72206E6963686573206C696B6520796F7572732E2042792067657474696E6720796F75722073697465206F6E2074686973207365727669636520796F7520686176652061206368616E636520746F2067657420796F75722073697465206D6F72652076697369746F7273207468616E20796F752063616E20696D6167696E652E204974206973206672656520746F207369676E20757020616E6420796F752063616E2066696E64206F7574206D6F72652061626F757420697420686572653A20687474703A2F2F636D7961642E636F2F692F35693177202D204E6F772C206C6574206D652061736B20796F752E2E2E20446F20796F75206E65656420796F7572207369746520746F206265207375636365737366756C20746F206D61696E7461696E20796F757220776179206F66206C6966653F20446F20796F75206E65656420746172676574656420747261666669632077686F2061726520696E746572657374656420696E2074686520736572766963657320616E642070726F647563747320796F75206F666665723F20417265206C6F6F6B696E6720666F72206578706F737572652C20746F20696E6372656173652073616C65732C20616E6420746F20717569636B6C7920646576656C6F702061776172656E65737320666F7220796F757220776562736974653F20496620796F757220616E73776572206973205945532C20796F752063616E2061636869657665207468657365207468696E6773206F6E6C7920696620796F752067657420796F75722073697465206F6E207468652073657276696365204920616D2074616C6B696E672061626F75742E20546869732074726166666963206E6574776F726B206164766572746973657320796F7520746F2074686F7573616E64732C207768696C6520616C736F20676976696E6720796F752061206368616E636520746F207465737420746865206E6574776F726B206265666F726520706179696E6720616E797468696E6720617420616C6C2E20416C6C2074686520706F70756C617220626C6F677320617265207573696E672074686973206E6574776F726B20746F20626F6F7374207468656972207472616666696320616E6420616420726576656E75652120576879206172656EE280997420796F753F20416E64207768617420697320626574746572207468616E20747261666669633F204974E280997320726563757272696E672074726166666963212054686174277320686F772072756E6E696E672061207375636365737366756C207369746520776F726B732E2E2E2048657265277320746F20796F75722073756363657373212046696E64206F7574206D6F726520686572653A20687474703A2F2F71612E6A757374737469636B792E636F6D2F796F75726C732F32373567, null, '2014-12-20 08:26:31', '1', 'Wendy', 'akblpigxdf@gmail.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('23', null, null, 'Anne', 0x492063616D6520746F20796F7572204166726963616E6F204D616779657A69207C204E464250432057656220506F7274616C207061676520616E64206E6F746963656420796F7520636F756C6420686176652061206C6F74206D6F72652076697369746F72732E2049206861766520666F756E64207468617420746865206B657920746F2072756E6E696E6720612077656273697465206973206D616B696E672073757265207468652076697369746F727320796F75206172652067657474696E672061726520696E746572657374656420696E20796F7572207375626A656374206D61747465722E205468657265206973206120636F6D70616E79207468617420796F752063616E206765742076697369746F72732066726F6D20616E642074686579206C657420796F752074727920746865207365727669636520666F7220667265652E2049206D616E6167656420746F20676574206F766572203330302074617267657465642076697369746F727320746F2064617920746F206D7920736974652E205669736974207468656D20686572653A20687474703A2F2F71612E6A757374737469636B792E636F6D2F796F75726C732F32373566, null, '2014-12-21 10:13:57', '1', 'Anne', 'cmhifu@aol.com', '1', '1', null, null, null);
INSERT INTO `message` VALUES ('24', null, null, 'Anne', 0x492063616D6520746F20796F75722057696C736F6E204F70696F207C204E464250432057656220506F7274616C207061676520616E64206E6F746963656420796F7520636F756C6420686176652061206C6F74206D6F72652076697369746F72732E2049206861766520666F756E64207468617420746865206B657920746F2072756E6E696E67206120706F70756C61722077656273697465206973206D616B696E672073757265207468652076697369746F727320796F75206172652067657474696E672061726520696E746572657374656420696E20796F7572207375626A656374206D61747465722E205468657265206973206120636F6D70616E79207468617420796F752063616E206765742076697369746F72732066726F6D20616E642074686579206C657420796F752074727920746865207365727669636520666F7220667265652E2049206D616E6167656420746F20676574206F766572203330302074617267657465642076697369746F727320746F2064617920746F206D7920776562736974652E205669736974207468656D20686572653A20687474703A2F2F71612E6A757374737469636B792E636F6D2F796F75726C732F32373566, null, '2014-12-23 07:02:46', '1', 'Anne', 'jsmocldfya@aol.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('25', null, null, 'Anne', 0x596F75206E656564207461726765746564207472616666696320746F20796F75722053656D75656C204E656C736F6E204B616B65746520207C204E464250432057656220506F7274616C207765627369746520736F20776879206E6F742074727920736F6D6520666F7220667265653F2054686572652069732061205645525920504F57455246554C20616E6420504F50554C415220636F6D70616E79206F75742074686572652077686F206E6F77206C65747320796F752074727920746865697220776562736974652074726166666963207365727669636520666F72203720646179732066726565206F66206368617267652E204920616D20736F20676C61642074686579206F70656E656420746865697220747261666669632073797374656D206261636B20757020746F20746865207075626C69632120436865636B206974206F757420686572653A20687474703A2F2F636C61696D796F7572657863656C6C656E63652E696E666F2F31676B, null, '2014-12-27 22:08:27', '1', 'Anne', 'soejjcgry@aol.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('26', null, null, 'Anne', 0x492063616D6520746F20796F75722053656D75656C204E656C736F6E204B616B65746520207C204E464250432057656220506F7274616C207061676520616E64206E6F746963656420796F7520636F756C6420686176652061206C6F74206D6F726520686974732E2049206861766520666F756E64207468617420746865206B657920746F2072756E6E696E6720612077656273697465206973206D616B696E672073757265207468652076697369746F727320796F75206172652067657474696E672061726520696E746572657374656420696E20796F7572207375626A656374206D61747465722E205468657265206973206120636F6D70616E79207468617420796F752063616E206765742076697369746F72732066726F6D20616E642074686579206C657420796F7520747279207468656972207365727669636520666F7220667265652E2049206D616E6167656420746F20676574206F766572203330302074617267657465642076697369746F727320746F2064617920746F206D7920776562736974652E20436865636B206974206F757420686572653A20687474703A2F2F7377747574732E636F6D2F732F39, null, '2014-12-30 08:19:43', '1', 'Anne', 'fbdasv@aol.com', '1', '0', null, null, null);
INSERT INTO `message` VALUES ('27', '1070', null, 'PUTTING IN FIELDS', 0x4465617220526F626572743B0D0A0D0A49206861766520747269656420746F206C6F616420696E20736F6D65206F662074686520636F6D6974746565733B20627574206861766520666F756E64206F7574207468617420736F6D65206E616D6573206F66207468657365206C6561646572732063616E6E6F7420626520696E7365727465642062656361757365207468657920415245204E4F5420494E2054484520444154414241534520414C52454144592E2020414E44204649454C44532E0D0A0D0A4144564953450D0A0D0A4146524943414E4F, null, '2015-01-03 18:28:21', '1', null, null, '2', '2', null, null, null);

-- ----------------------------
-- Table structure for messagerecipient
-- ----------------------------
DROP TABLE IF EXISTS `messagerecipient`;
CREATE TABLE `messagerecipient` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `messageid` int(11) unsigned NOT NULL,
  `recipientid` int(11) unsigned NOT NULL,
  `isread` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_messagerecipient` (`recipientid`,`messageid`),
  KEY `fk_recipient_messageid` (`messageid`),
  KEY `fk_recipient_recipientid` (`recipientid`),
  CONSTRAINT `fk_messagerecipienet_messageid` FOREIGN KEY (`messageid`) REFERENCES `message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_messagerecipienet_senderid` FOREIGN KEY (`recipientid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messagerecipient
-- ----------------------------

-- ----------------------------
-- Table structure for outbox
-- ----------------------------
DROP TABLE IF EXISTS `outbox`;
CREATE TABLE `outbox` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `phone` mediumtext,
  `msg` varchar(1000) DEFAULT NULL,
  `source` varchar(15) DEFAULT NULL,
  `resultcode` varchar(255) DEFAULT NULL,
  `smsid` varchar(255) DEFAULT NULL,
  `deliverstatus` varchar(255) DEFAULT NULL,
  `deliverdetails` varchar(255) DEFAULT NULL,
  `messageid` int(11) unsigned DEFAULT NULL,
  `msgcount` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of outbox
-- ----------------------------
INSERT INTO `outbox` VALUES ('1', '2014-11-01 02:10:22', '1', '256701595279', 'Hey herman. this is a live test from nfbpc portal prodn.', 'NFBPC', 'SUBMIT_SUCCESS', '7d2c7866-fd1c-e58b-715c-d9d0f067754e', null, null, '1', '1');
INSERT INTO `outbox` VALUES ('2', '2014-11-01 04:51:00', '279', '256712466456', 'try this', 'NFBPC', 'SUBMIT_SUCCESS', 'd7546c1b-4129-d4ee-599d-f5c0a6270648', null, null, '2', '1');
INSERT INTO `outbox` VALUES ('3', '2014-11-04 12:37:24', '279', '256782396438', 'Seebo confirm receipt', 'NFBPC', 'SUBMIT_SUCCESS', 'df31a2ac-92ef-0213-8cda-ff56aad5d38a', null, null, '7', '1');
INSERT INTO `outbox` VALUES ('4', '2014-11-07 12:21:39', '279', '256752850921,256782396438,256772414390', 'ndc test', 'NFBPC', 'SUBMIT_SUCCESS', '1a38eeb2-bfd1-95d0-20fa-cd89b8da9e17', null, null, '8', '3');

-- ----------------------------
-- Table structure for session
-- ----------------------------
DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `id` char(32) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `data` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of session
-- ----------------------------
INSERT INTO `session` VALUES ('c81s6m60b7rmd05pk09pi7mn54', '1421346984', '21104000', 'Default|a:15:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"34.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}}');

-- ----------------------------
-- Function structure for CAP_FIRST
-- ----------------------------
DROP FUNCTION IF EXISTS `CAP_FIRST`;
DELIMITER ;;
CREATE DEFINER=`dev`@`127.0.0.1` FUNCTION `CAP_FIRST`(input VARCHAR(255)) RETURNS varchar(255) CHARSET utf8
    DETERMINISTIC
BEGIN
	DECLARE len INT;
	DECLARE i INT;
	SET len   = CHAR_LENGTH(input);
	SET input = LOWER(input);
	SET i = 0;
	WHILE (i < len) DO

		IF (MID(input,i,1) = ' ' OR i = 0) THEN
			IF (i < len) THEN
				SET input = CONCAT(
					LEFT(input,i),
					UPPER(MID(input,i + 1,1)),
					RIGHT(input,len - i - 1)
				);
			END IF;
		END IF;
		SET i = i + 1;
	END WHILE;
	RETURN input;
END
;;
DELIMITER ;
