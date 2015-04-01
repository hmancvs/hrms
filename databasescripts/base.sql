/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : 127.0.0.1:3306
Source Database       : hrms

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-02-02 17:27:57
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclgroup
-- ----------------------------
INSERT INTO `aclgroup` VALUES ('1', 'Super Admin', 'Has rights to entire system configuration', '2015-01-15 12:00:00', '1', '2015-01-28 11:44:49', null);
INSERT INTO `aclgroup` VALUES ('2', 'Customer Care User', 'Company Employees ', '2015-01-15 12:00:00', '1', '2015-01-28 11:45:54', null);
INSERT INTO `aclgroup` VALUES ('3', 'Human Resource User', 'Generates payroll and approves Timesheets and Leave requests', '2015-01-15 12:00:00', '1', '2015-01-25 12:22:49', null);
INSERT INTO `aclgroup` VALUES ('4', 'Management User', 'Report level user', '2015-01-15 12:00:00', '1', null, null);

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
  `flag` enum('1','0') DEFAULT '0',
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
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclpermission
-- ----------------------------
INSERT INTO `aclpermission` VALUES ('2', '1', '1', '0', '0', '1', '1', '0', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('3', '1', '2', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('4', '1', '3', '1', '1', '1', '1', '1', '0', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('5', '1', '4', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('6', '1', '5', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('7', '1', '6', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('8', '1', '7', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('14', '1', '8', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('20', '1', '9', '1', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('21', '1', '10', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('22', '1', '11', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('23', '1', '12', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('24', '1', '13', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('27', '2', '4', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('29', '2', '6', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('32', '2', '1', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('34', '2', '8', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('39', '2', '11', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('40', '2', '12', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('41', '2', '13', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('43', '2', '10', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('44', '2', '5', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('45', '2', '9', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('46', '2', '7', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('47', '2', '2', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('48', '2', '3', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('50', '4', '4', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('52', '4', '6', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('55', '4', '1', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('57', '4', '8', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('62', '4', '11', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('63', '4', '12', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('64', '4', '13', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('66', '4', '10', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('67', '4', '5', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('68', '4', '9', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('69', '4', '7', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('70', '4', '2', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('71', '4', '3', '0', '1', '1', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('119', '3', '4', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('121', '3', '6', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('124', '3', '1', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('126', '3', '8', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('131', '3', '11', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('132', '3', '12', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('133', '3', '13', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('135', '3', '10', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('136', '3', '5', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('137', '3', '9', '1', '0', '1', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('138', '3', '7', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('139', '3', '2', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('140', '3', '3', '1', '1', '1', '1', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', '2015-01-25 12:22:49', '1');
INSERT INTO `aclpermission` VALUES ('190', '1', '21', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('191', '1', '18', '0', '0', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('193', '1', '23', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('194', '1', '22', '1', '1', '1', '1', '1', '1', '0', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('195', '1', '20', '1', '1', '1', '1', '1', '1', '1', '0', '2015-01-28 11:44:49', '1', '2015-01-28 11:44:49', '1');
INSERT INTO `aclpermission` VALUES ('196', '2', '21', '0', '0', '1', '1', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('197', '2', '18', '1', '0', '1', '1', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('199', '2', '23', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('200', '2', '22', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('201', '2', '20', '1', '1', '1', '1', '0', '0', '0', '0', '2015-01-28 11:45:55', '1', '2015-01-28 11:45:55', '1');
INSERT INTO `aclpermission` VALUES ('202', '3', '21', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-25 12:22:49', '1', null, null);
INSERT INTO `aclpermission` VALUES ('203', '3', '18', '0', '0', '0', '0', '0', '0', '0', '0', '2015-01-25 12:22:49', '1', null, null);
INSERT INTO `aclpermission` VALUES ('205', '3', '23', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-25 12:22:49', '1', null, null);
INSERT INTO `aclpermission` VALUES ('206', '3', '22', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-25 12:22:49', '1', null, null);
INSERT INTO `aclpermission` VALUES ('207', '3', '20', '1', '1', '1', '1', '1', '1', '1', '0', '2015-01-25 12:22:49', '1', null, null);

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
  `flag` enum('1','0') DEFAULT '0',
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_resource_createdby` (`createdby`),
  KEY `fk_resource_lastupdatedby` (`lastupdatedby`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclresource
-- ----------------------------
INSERT INTO `aclresource` VALUES ('1', 'Lookup Type', 'Look up types', '0', '0', '1', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('2', 'System Variables', 'Values for the lookup type', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('3', 'User Account', 'A user who has activated their member account', '1', '1', '1', '1', '1', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('4', 'Audit Trail Report', 'Audit Trail Report', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('5', 'Role', 'Actions a member can execute on resources', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('6', 'Dashboard', 'user dashboard', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('7', 'System Config', 'Global system configuration parameters', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('8', 'Message', 'Direct Messaging module', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('9', 'SMS', 'SMS Communication', '1', '0', '1', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('10', 'Report Dashboard', 'Report Dashboard', '0', '0', '1', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('11', 'Report 1', 'Report 1', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('12', 'Report 2', 'Report 2', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('13', 'Report 3', 'Report 3', '0', '0', '1', '0', '0', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('18', 'Attendance', 'Enables employees to check in and out', '1', '0', '1', '1', '1', '0', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('20', 'Timesheets', 'Allows Employees to submit time spent on duty for approval.', '1', '1', '1', '1', '1', '1', '1', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('21', 'Benefits', 'Benefits', '1', '1', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('22', 'Time off', 'Request Time off', '1', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('23', 'Payroll', 'Payroll Processing', '1', '0', '1', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclusergroup
-- ----------------------------
INSERT INTO `aclusergroup` VALUES ('1', '1', '1');
INSERT INTO `aclusergroup` VALUES ('2', '2', '15');

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
INSERT INTO `appconfig` VALUES ('13', 'dateandtime', 'Date and Time Settings', 'mediumformat', 'Long date display format', '', 'M j, Y', 'text', 'Y', '1', '2012-03-01 12:00:00', '1', '2014-02-12 14:08:46', null);
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
INSERT INTO `appconfig` VALUES ('47', 'sms', 'SMS Settings', 'serverurl', 'The server url', '', null, 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('48', 'sms', 'SMS Settings', 'serverusername', 'The server username', '', null, 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('49', 'sms', 'SMS Settings', 'serverpassword', 'The server password', '', null, 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('50', 'sms', 'SMS Settings', 'serverport', 'The sms server port', '', null, 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('51', 'sms', 'SMS Settings', 'sendername', 'The default sender of sms notifications', '', 'HRMS', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('52', 'sms', 'SMS Settings', 'testnumber', 'The test number for sms notifications', '', '256701595279', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);
INSERT INTO `appconfig` VALUES ('53', 'country', 'Country Settings', 'timezone', 'Country timezone', '', 'UTC+03:00', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 15:45:42', null);
INSERT INTO `appconfig` VALUES ('54', 'notification', 'Notification and Email Options', 'errorlogemail', 'Errors and downtime email', '', 'admin@devmail.infomacorp.com', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('59', 'notification', 'Notification and Email Options', 'defaultadminemail', 'Default Admin Email', '', 'admin@devmail.infomacorp.com', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('60', 'notification', 'Notification and Email Options', 'defaultadminname', 'Default Admin Name', '', 'HRMS', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 16:28:00', null);
INSERT INTO `appconfig` VALUES ('61', 'system', 'System and UI Settings', 'appname', 'Application name', '', 'HR Portal', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('62', 'system', 'System and UI Settings', 'companyname', 'Company name', '', 'QED', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('63', 'system', 'System and UI Settings', 'companysignoff', 'Company signoff', '', 'QED Solutions', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('64', 'system', 'System and UI Settings', 'logotype', 'Logo Type', '', '1', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-12-04 17:15:38', null);
INSERT INTO `appconfig` VALUES ('65', 'system', 'System and UI Settings', 'copyrightinfo', 'Company Copyright', '', ' Copyright Ã¢â€Å“ÃƒÂ©Ã¢â€Â¬Ã‚Â® 2014  |  NFBPC  |  All Rights Reserved', 'text', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-02-13 16:54:06', null);
INSERT INTO `appconfig` VALUES ('76', 'sms', 'SMS Settings', 'smsdelivery', 'Turn on/off sms sending feature', '', 'off', 'Boolean', 'Y', '1', '2012-02-28 15:59:27', '1', '2014-03-28 12:40:33', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of audittrail
-- ----------------------------
INSERT INTO `audittrail` VALUES ('1', '1', 'user.logout', '1', '1.2', 'Logout for user with id \'admin\' successful', '2015-01-27 21:12:59', 'Y', 'Chrome, 39.0.2171.95, Mozilla/5.0 (Windows NT 6.2;', 'Chrome', '39.0.2171.95', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);
INSERT INTO `audittrail` VALUES ('2', '1', 'system.updaterole', '0', '0.5', 'Role <a href=\'http://127.0.0.1/hrms/role/view/id/MQ==\' class=\'blockanchor\'>Super Admin</a> updated', '2015-01-28 11:44:50', 'Y', 'Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '35.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 'Windows', '0', '127.0.0.1', 'http://127.0.0.1/hrms/role/view/id/MQ==', '1', 0x5B7B227265736F757263656964223A223138222C226964223A22313931222C2267726F75706964223A2231222C22637265617465223A2230222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2234222C226964223A2235222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223231222C226964223A22313930222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2236222C226964223A2237222C2267726F75706964223A2231222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2231222C226964223A2232222C2267726F75706964223A2231222C2276696577223A2231222C226C697374223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2238222C226964223A223134222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223233222C226964223A22313933222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223131222C226964223A223232222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223132222C226964223A223233222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223133222C226964223A223234222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223130222C226964223A223231222C2267726F75706964223A2231222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2235222C226964223A2236222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2239222C226964223A223230222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C22666C6167223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2237222C226964223A2238222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2232222C226964223A2233222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223232222C226964223A22313934222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2231222C22666C6167223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223230222C226964223A22313935222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2233222C226964223A2234222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C226578706F7274223A2231222C22666C6167223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D5D, 0x7B22636F6E74726F6C6C6572223A22726F6C65222C22616374696F6E223A2270726F63657373726F6C6573222C226D6F64756C65223A2264656661756C74222C22656E746974796E616D65223A2241636C47726F7570222C226964223A2231222C22737563636573736D657373616765223A225375636365737366756C6C792075706461746564222C226E616D65223A2253757065722041646D696E222C226465736372697074696F6E223A224861732072696768747320746F20656E746972652073797374656D20636F6E66696775726174696F6E222C2263686B76696577223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B6C697374223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B64656C657465223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B6578706F7274223A5B2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B637265617465223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B65646974223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B617070726F7665223A5B2231222C2231225D2C227065726D697373696F6E73223A5B7B227265736F757263656964223A223138222C226964223A22313931222C2267726F75706964223A2231222C22637265617465223A2230222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2234222C226964223A2235222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223231222C226964223A22313930222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2236222C226964223A2237222C2267726F75706964223A2231222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2231222C226964223A2232222C2267726F75706964223A2231222C2276696577223A2231222C226C697374223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2238222C226964223A223134222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223233222C226964223A22313933222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223131222C226964223A223232222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223132222C226964223A223233222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223133222C226964223A223234222C2267726F75706964223A2231222C2276696577223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223130222C226964223A223231222C2267726F75706964223A2231222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2235222C226964223A2236222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2239222C226964223A223230222C2267726F75706964223A2231222C22637265617465223A2231222C2276696577223A2231222C22666C6167223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2237222C226964223A2238222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2232222C226964223A2233222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223232222C226964223A22313934222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2231222C22666C6167223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A223230222C226964223A22313935222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2231222C226578706F7274223A2231222C22666C6167223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D2C7B227265736F757263656964223A2233222C226964223A2234222C2267726F75706964223A2231222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C226578706F7274223A2231222C22666C6167223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34343A3439222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34343A3439227D5D7D, '');
INSERT INTO `audittrail` VALUES ('3', '1', 'system.updaterole', '0', '0.5', 'Role <a href=\'http://127.0.0.1/hrms/role/view/id/Mg==\' class=\'blockanchor\'>Customer Care User</a> updated', '2015-01-28 11:45:55', 'Y', 'Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '35.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 'Windows', '0', '127.0.0.1', 'http://127.0.0.1/hrms/role/view/id/Mg==', '1', 0x5B7B227265736F757263656964223A223138222C226964223A22313937222C2267726F75706964223A2232222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2234222C226964223A223237222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223231222C226964223A22313936222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2236222C226964223A223239222C2267726F75706964223A2232222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2231222C226964223A223332222C2267726F75706964223A2232222C2276696577223A2230222C226C697374223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2238222C226964223A223334222C2267726F75706964223A2232222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223233222C226964223A22313939222C2267726F75706964223A2232222C22637265617465223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223131222C226964223A223339222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223132222C226964223A223430222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223133222C226964223A223431222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223130222C226964223A223433222C2267726F75706964223A2232222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2235222C226964223A223434222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2239222C226964223A223435222C2267726F75706964223A2232222C22637265617465223A2230222C2276696577223A2230222C22666C6167223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2237222C226964223A223436222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2232222C226964223A223437222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223232222C226964223A22323030222C2267726F75706964223A2232222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2230222C22666C6167223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223230222C226964223A22323031222C2267726F75706964223A2232222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22617070726F7665223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2233222C226964223A223438222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2231222C226C697374223A2230222C2264656C657465223A2230222C226578706F7274223A2230222C22666C6167223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D5D, 0x7B22636F6E74726F6C6C6572223A22726F6C65222C22616374696F6E223A2270726F63657373726F6C6573222C226D6F64756C65223A2264656661756C74222C22656E746974796E616D65223A2241636C47726F7570222C226964223A2232222C22737563636573736D657373616765223A225375636365737366756C6C792075706461746564222C226E616D65223A22437573746F6D657220436172652055736572222C226465736372697074696F6E223A22436F6D70616E7920456D706C6F7965657320222C2263686B637265617465223A5B2231222C2231222C2231222C2231225D2C2263686B76696577223A5B2231222C2231222C2231222C2231222C2231222C2231222C2231222C2231225D2C2263686B6C697374223A5B2231222C2231222C2231222C2231222C2231225D2C2263686B64656C657465223A5B2231222C2231225D2C2263686B65646974223A5B2231222C2231225D2C227065726D697373696F6E73223A5B7B227265736F757263656964223A223138222C226964223A22313937222C2267726F75706964223A2232222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2234222C226964223A223237222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223231222C226964223A22313936222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2236222C226964223A223239222C2267726F75706964223A2232222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2231222C226964223A223332222C2267726F75706964223A2232222C2276696577223A2230222C226C697374223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2238222C226964223A223334222C2267726F75706964223A2232222C22637265617465223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223233222C226964223A22313939222C2267726F75706964223A2232222C22637265617465223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C2265646974223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223131222C226964223A223339222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223132222C226964223A223430222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223133222C226964223A223431222C2267726F75706964223A2232222C2276696577223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223130222C226964223A223433222C2267726F75706964223A2232222C2276696577223A2231222C22666C6167223A302C22637265617465223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2235222C226964223A223434222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2239222C226964223A223435222C2267726F75706964223A2232222C22637265617465223A2230222C2276696577223A2230222C22666C6167223A302C2265646974223A302C226C697374223A302C2264656C657465223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2237222C226964223A223436222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2232222C226964223A223437222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2230222C226C697374223A2230222C2264656C657465223A2230222C22666C6167223A302C22617070726F7665223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223232222C226964223A22323030222C2267726F75706964223A2232222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2231222C22617070726F7665223A2230222C22666C6167223A302C226578706F7274223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A223230222C226964223A22323031222C2267726F75706964223A2232222C22637265617465223A2231222C2265646974223A2231222C2276696577223A2231222C226C697374223A2231222C2264656C657465223A2230222C22617070726F7665223A2230222C226578706F7274223A2230222C22666C6167223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D2C7B227265736F757263656964223A2233222C226964223A223438222C2267726F75706964223A2232222C22637265617465223A2230222C2265646974223A2230222C2276696577223A2231222C226C697374223A2230222C2264656C657465223A2230222C226578706F7274223A2230222C22666C6167223A302C22617070726F7665223A302C22637265617465646279223A2231222C226461746563726561746564223A22323031352D30312D32382031313A34353A3535222C226C617374757064617465646279223A2231222C226C61737475706461746564617465223A22323031352D30312D32382031313A34353A3535227D5D7D, '');
INSERT INTO `audittrail` VALUES ('4', '1', 'user.logout', '1', '1.2', 'Logout for user with id \'admin\' successful', '2015-01-28 21:45:52', 'Y', 'Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '35.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `refno` varchar(15) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `addressline1` varchar(255) DEFAULT '',
  `addressline2` varchar(255) DEFAULT '',
  `city` varchar(75) DEFAULT '',
  `phonenumber` varchar(15) DEFAULT '',
  `state` char(2) DEFAULT '',
  `zipcode` varchar(10) DEFAULT '',
  `email` varchar(75) DEFAULT '',
  `industrycode` varchar(5) DEFAULT '',
  `createdby` int(11) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `status` enum('0','1') DEFAULT '1',
  `defaultdepartmentid` int(11) unsigned DEFAULT NULL,
  `defaultuserid` int(11) unsigned DEFAULT NULL,
  `numberofemployeesoffperday` tinyint(3) unsigned DEFAULT '1',
  `regularleavehrs` decimal(10,0) unsigned DEFAULT NULL,
  `regularleavedays` decimal(10,0) unsigned DEFAULT NULL,
  `regularleavetype` decimal(10,0) DEFAULT NULL,
  `sickleavehrs` decimal(10,0) unsigned DEFAULT NULL,
  `sickleavedays` decimal(10,0) unsigned DEFAULT NULL,
  `sickleavetype` tinyint(4) unsigned DEFAULT NULL,
  `accrualtype` tinyint(4) unsigned DEFAULT NULL,
  `accrualfrequency` tinyint(4) unsigned DEFAULT NULL,
  `maxhoursperday` varchar(50) DEFAULT NULL,
  `maxhoursperweek` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `fk_company_createdby` (`createdby`),
  KEY `fk_company_lastupdatedby` (`lastupdatedby`),
  KEY `fk_company_defaultdepartmentid` (`defaultdepartmentid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', null, 'QED Solutions', null, '', '', '', '', '', '', '', '', null, null, null, null, '1', '2', '1', '3', '160', '21', '1', '320', '4', '1', '1', '4', '8', '40');

-- ----------------------------
-- Table structure for department
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `headid` int(11) unsigned DEFAULT NULL,
  `companyid` int(11) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_head` (`headid`),
  KEY `fk_department_company` (`companyid`),
  CONSTRAINT `fk_department_company` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_department_head` FOREIGN KEY (`headid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('1', 'Human Resource', null, '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `department` VALUES ('2', 'Customer Care', null, '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `department` VALUES ('3', 'Operations', null, '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `department` VALUES ('4', 'Finance', null, '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `department` VALUES ('5', 'Administration', null, '1', '2015-01-15 12:00:00', '1', null, null);

-- ----------------------------
-- Table structure for leave
-- ----------------------------
DROP TABLE IF EXISTS `leave`;
CREATE TABLE `leave` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `companyid` int(11) unsigned DEFAULT NULL,
  `userid` int(11) unsigned DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `hours` decimal(10,2) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remarks` varchar(255) DEFAULT '',
  `createdby` int(11) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `approvedbyid` int(10) unsigned DEFAULT NULL,
  `reason` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_leave_companyid` (`companyid`),
  KEY `fk_leave_userid` (`userid`),
  KEY `fk_leave_approvedbyid` (`approvedbyid`),
  CONSTRAINT `fk_leave_approvedbyid` FOREIGN KEY (`approvedbyid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_leave_companyid` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_leave_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17942 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leave
-- ----------------------------

-- ----------------------------
-- Table structure for ledger
-- ----------------------------
DROP TABLE IF EXISTS `ledger`;
CREATE TABLE `ledger` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `companyid` int(11) unsigned NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `codeid` int(11) unsigned DEFAULT NULL,
  `timesheetid` int(11) unsigned DEFAULT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `hours` decimal(10,1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(4) unsigned DEFAULT NULL,
  `remarks` varchar(255) NOT NULL DEFAULT '',
  `createdby` int(11) unsigned NOT NULL,
  `datecreated` datetime NOT NULL,
  `lastupdatedby` int(11) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ledger_userid` (`userid`),
  KEY `fk_ledger_companyid` (`companyid`),
  KEY `fk_ledger_timesheetid` (`timesheetid`),
  CONSTRAINT `fk_ledger_companyid` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ledger_timesheetid` FOREIGN KEY (`timesheetid`) REFERENCES `timesheet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_ledger_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17942 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ledger
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lookuptype
-- ----------------------------
INSERT INTO `lookuptype` VALUES ('1', 'LIST_ITEM_COUNT_OPTIONS', 'Listing Items Per Page', '1', '0', '0', 'The number of items per page', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('2', 'SALUTATION', 'Salutations Variables', '1', '1', '0', 'The different salutations Mr, Mrs, Dr, etc', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('3', 'MARITAL_STATUS_VALUES', 'Marital Status Values', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('5', 'CONTACT_RELATIONSHIPS', 'Next of Kin Relationships', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('6', 'EMPLOYEE_STATUS', 'Employee Contract Status', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('7', 'EMPLOYEE_POSITIONS', 'Employee Job Positions', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('8', 'EMPLOYEE_RATE_TYPES', 'Employee Rate Types', '1', '0', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('9', 'BENEFIT_TYPES', 'Employee Benefit Types', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lookuptypevalue
-- ----------------------------
INSERT INTO `lookuptypevalue` VALUES ('1', '1', '10', '10', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('2', '1', '25', '25', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('3', '1', '50', '50', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('4', '1', '250', '250', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('5', '1', '500', '500', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('6', '1', 'All', 'All', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('7', '2', '1', 'Dr.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('8', '2', '2', 'Ms.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('9', '2', '3', 'Mr.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('10', '2', '4', 'Mrs.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('11', '2', '5', 'Eng.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('12', '2', '6', 'Prof.', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('13', '3', '1', 'Married', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('14', '3', '2', 'Single', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('15', '3', '3', 'Divorced', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('16', '3', '4', 'Widowed', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('17', '3', '5', 'Partnered', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('18', '3', '6', 'Separated', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('43', '5', '1', 'Father', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('44', '5', '2', 'Mother', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('45', '5', '3', 'Sibling', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('46', '5', '4', 'Child', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('47', '5', '5', 'Grand Child', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('48', '5', '6', 'Grand Parent', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('49', '5', '7', 'In-law', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('50', '5', '8', 'Aunt', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('51', '5', '9', 'Uncle', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('52', '5', '0', 'Business Partner', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('53', '5', '11', 'Spouse', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('54', '5', '12', 'Guardian', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('55', '5', '13', 'Friend', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('56', '5', '14', 'Employer', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('57', '5', '15', 'Workmate', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('58', '5', '17', 'Other Relative', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('59', '5', '16', 'Collegue', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('66', '6', '1', 'Permanent ', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('67', '6', '2', 'Temporally', '1', '2015-01-15 12:00:00', '2015-01-24 12:05:00', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('68', '6', '3', 'Intern', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('69', '6', '4', 'Contractor', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('70', '7', '1', 'Office Admin', '1', '2015-01-15 12:00:00', '2015-01-25 13:56:17', null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('71', '7', '2', 'Human Resource Manager', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('72', '7', '3', 'Customer Care Supervisor', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('73', '7', '4', 'Customer Care Advisor', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('74', '7', '5', 'Human Resource Supervisor', '1', '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('75', '8', '1', 'Per Hour', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('76', '8', '2', 'Per Day', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('77', '8', '3', 'Per Week', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('78', '8', '4', 'Per Month', null, null, null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('79', '8', '5', 'Per Year', null, null, null, null, null, null, null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of outbox
-- ----------------------------

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
INSERT INTO `session` VALUES ('lp7bv39p64197604gri1dtjck1', '1422540701', '21104000', 'Default|a:17:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"35.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:5:\"style\";s:1:\"2\";s:7:\"toggled\";s:0:\"\";}');
INSERT INTO `session` VALUES ('m4qbo7vhboi7tkjr7v6tr9er93', '1422887206', '21104000', 'Default|a:17:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"35.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:5:\"style\";i:2;s:7:\"toggled\";s:0:\"\";}');
INSERT INTO `session` VALUES ('ofhun2kv7hlc6mkdb66q7b40o3', '1422470582', '21104000', 'Default|a:16:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:2:\"15\";s:8:\"username\";s:5:\"test1\";s:4:\"type\";s:1:\"2\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:139:\"Chrome, 39.0.2171.95, Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36, Windows\";s:7:\"browser\";s:6:\"Chrome\";s:7:\"version\";s:12:\"39.0.2171.95\";s:9:\"useragent\";s:108:\"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:5:\"style\";s:1:\"2\";}');
INSERT INTO `session` VALUES ('r5bs6kka4fjc7fht1fj5qluss7', '1422887178', '21104000', 'Default|a:17:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:2:\"15\";s:8:\"username\";s:5:\"test1\";s:4:\"type\";s:1:\"2\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:139:\"Chrome, 39.0.2171.95, Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36, Windows\";s:7:\"browser\";s:6:\"Chrome\";s:7:\"version\";s:12:\"39.0.2171.95\";s:9:\"useragent\";s:108:\"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:5:\"style\";s:1:\"2\";s:7:\"toggled\";s:0:\"\";}');
INSERT INTO `session` VALUES ('sah314j98mb5j8dtu2c5h25is0', '1422470753', '21104000', 'Default|a:11:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";}');

-- ----------------------------
-- Table structure for shift
-- ----------------------------
DROP TABLE IF EXISTS `shift`;
CREATE TABLE `shift` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `hours` decimal(10,2) unsigned DEFAULT NULL,
  `companyid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shift_companyid` (`companyid`),
  CONSTRAINT `fk_shift_companyid` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shift
-- ----------------------------
INSERT INTO `shift` VALUES ('1', 'Fulltime', '08:00:00', '17:00:00', '8.00', null);
INSERT INTO `shift` VALUES ('2', 'Morning', '08:00:00', '14:00:00', '6.00', null);
INSERT INTO `shift` VALUES ('3', 'Afternoon', '12:00:00', '18:00:00', '6.00', null);
INSERT INTO `shift` VALUES ('4', 'Night', '22:00:00', '06:00:00', '8.00', null);

-- ----------------------------
-- Table structure for timesheet
-- ----------------------------
DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE `timesheet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `companyid` int(11) unsigned DEFAULT NULL,
  `userid` int(11) unsigned DEFAULT NULL,
  `datein` date DEFAULT NULL,
  `timein` time DEFAULT NULL,
  `dateout` date DEFAULT NULL,
  `timeout` time DEFAULT NULL,
  `inremarks` varchar(1000) DEFAULT '',
  `outremarks` varchar(1000) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `notes` blob,
  `hours` decimal(10,2) unsigned DEFAULT NULL,
  `status` tinyint(3) unsigned DEFAULT NULL,
  `timesheetdate` date DEFAULT NULL,
  `datesubmitted` datetime DEFAULT NULL,
  `dateapproved` datetime DEFAULT NULL,
  `approvedbyid` int(20) unsigned DEFAULT NULL,
  `datecreated` datetime DEFAULT NULL,
  `createdby` int(20) unsigned DEFAULT NULL,
  `lastupdatedate` datetime DEFAULT NULL,
  `lastupdatedby` int(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_timesheet_createdy` (`createdby`),
  KEY `fk_timesheet_lastupdatedby` (`lastupdatedby`),
  KEY `fk_timesheet_companyid` (`companyid`),
  KEY `fk_timesheet_userid` (`userid`),
  KEY `fk_timesheet_approvedbyid` (`approvedbyid`),
  CONSTRAINT `fk_timesheet_approvedbyid` FOREIGN KEY (`approvedbyid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_timesheet_companyid` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_timesheet_userid` FOREIGN KEY (`userid`) REFERENCES `useraccount` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of timesheet
-- ----------------------------
INSERT INTO `timesheet` VALUES ('1', null, '15', '2015-01-28', '08:00:00', '2015-01-28', '17:12:55', 'sefadas asda adhbadada', 'sdfsfdfs sf fdadsdad asdad', null, null, '9.22', '1', '2015-01-28', '2015-02-02 05:06:28', '2015-02-02 05:04:22', '1', '2015-01-28 10:04:21', '15', '2015-02-02 08:06:29', null);
INSERT INTO `timesheet` VALUES ('2', null, '15', '2015-01-27', '09:00:00', '2015-01-27', '17:00:00', '', '', null, null, '8.00', '1', '2015-01-27', '2015-02-02 05:06:28', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 08:06:29', null);
INSERT INTO `timesheet` VALUES ('3', null, '15', '2015-01-26', '10:10:00', '2015-01-26', '16:10:00', '', '', null, null, '6.80', '1', '2015-01-26', '2015-02-02 14:19:15', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 17:19:16', null);
INSERT INTO `timesheet` VALUES ('4', null, '15', '2015-01-23', '11:25:00', '2015-01-23', '15:40:00', '', '', null, null, '4.25', '2', '2015-01-23', '2015-02-02 06:33:38', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 09:33:38', null);
INSERT INTO `timesheet` VALUES ('5', null, '15', '2015-01-22', '08:00:00', '2015-01-22', '17:00:00', '', '', null, null, '9.00', '2', '2015-01-22', '2015-02-02 06:33:38', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 09:33:38', null);
INSERT INTO `timesheet` VALUES ('6', null, '15', '2015-01-21', '09:00:00', '2015-01-21', '17:30:00', '', '', null, null, '8.50', '2', '2015-01-21', '2015-02-02 06:33:38', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 09:33:38', null);
INSERT INTO `timesheet` VALUES ('7', null, '15', '2015-01-20', '08:00:00', '2015-01-20', '17:00:00', '', '', null, null, '9.00', '2', '2015-01-20', '2015-02-02 06:33:38', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 09:33:38', null);
INSERT INTO `timesheet` VALUES ('8', null, '15', '2015-01-19', '09:00:00', '2015-01-19', '17:30:00', '', '', null, null, '8.50', '2', '2015-01-19', '2015-02-02 06:33:38', null, null, '2015-01-29 15:25:41', '15', '2015-02-02 09:33:39', null);
INSERT INTO `timesheet` VALUES ('9', null, '15', '2015-01-16', '08:00:00', '2015-01-16', '17:00:00', '', '', null, null, '9.00', '3', '2015-01-16', '2015-02-02 06:32:19', '2015-02-02 06:33:09', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:33:10', null);
INSERT INTO `timesheet` VALUES ('10', null, '15', '2015-01-15', '09:00:00', '2015-01-15', '17:30:00', '', '', null, null, '8.50', '3', '2015-01-15', '2015-02-02 06:32:19', '2015-02-02 06:33:09', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:33:10', null);
INSERT INTO `timesheet` VALUES ('11', null, '15', '2015-01-14', '08:00:00', '2015-01-14', '17:00:00', '', '', null, null, '9.00', '3', '2015-01-14', '2015-02-02 06:32:19', '2015-02-02 06:33:09', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:33:10', null);
INSERT INTO `timesheet` VALUES ('12', null, '15', '2015-01-13', '09:00:00', '2015-01-13', '17:30:00', '', '', null, null, '8.50', '3', '2015-01-13', '2015-02-02 06:32:19', '2015-02-02 06:33:09', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:33:10', null);
INSERT INTO `timesheet` VALUES ('13', null, '15', '2015-01-12', '08:00:00', '2015-01-12', '17:00:00', '', '', null, null, '9.00', '3', '2015-01-12', '2015-02-02 06:32:19', '2015-02-02 06:33:09', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:33:10', null);
INSERT INTO `timesheet` VALUES ('14', null, '15', '2015-01-09', '09:00:00', '2015-01-09', '17:30:00', '', '', null, null, '8.50', '3', '2015-01-09', '2015-02-02 04:46:12', '2015-02-02 06:30:54', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:30:55', null);
INSERT INTO `timesheet` VALUES ('15', null, '15', '2015-01-08', '08:00:00', '2015-01-08', '17:00:00', '', '', null, null, '9.00', '3', '2015-01-08', '2015-02-01 20:25:54', '2015-02-02 06:30:54', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:30:55', null);
INSERT INTO `timesheet` VALUES ('16', null, '15', '2015-01-07', '09:00:00', '2015-01-07', '17:30:00', '', '', null, null, '8.50', '3', '2015-01-07', '2015-02-01 20:25:54', '2015-02-02 06:30:54', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:30:55', null);
INSERT INTO `timesheet` VALUES ('17', null, '15', '2015-01-06', '08:00:00', '2015-01-06', '17:00:00', '', '', null, null, '9.00', '3', '2015-01-06', '2015-02-01 18:40:47', '2015-02-02 06:30:54', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:30:55', null);
INSERT INTO `timesheet` VALUES ('18', null, '15', '2015-01-05', '09:00:00', '2015-01-05', '17:30:00', '', '', null, null, '8.50', '3', '2015-01-05', '2015-02-01 18:40:37', '2015-02-02 06:30:54', '1', '2015-01-29 15:25:41', '15', '2015-02-02 09:30:55', null);
INSERT INTO `timesheet` VALUES ('19', null, '15', '2015-01-30', '10:05:00', null, null, '', '', null, null, null, '0', '2015-01-30', null, null, null, '2015-01-31 15:05:51', '15', '2015-02-02 10:08:34', '1');
INSERT INTO `timesheet` VALUES ('22', null, '15', '2015-01-29', '10:30:00', '2015-01-29', '17:00:00', '', '', '', '', null, '1', '2015-01-29', '2015-01-29 05:06:28', null, null, null, '15', '2015-02-02 10:08:34', null);

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
  `contactname` varchar(255) DEFAULT NULL,
  `contactrshp` varchar(50) DEFAULT NULL,
  `contactphone` varchar(15) DEFAULT NULL,
  `contactemail` varchar(255) DEFAULT NULL,
  `contactaddress` varchar(255) DEFAULT NULL,
  `notes` blob,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `probationend` date DEFAULT NULL,
  `idno` varchar(50) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `maritalstatus` varchar(255) DEFAULT NULL,
  `salutation` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `qualifications` varchar(1000) DEFAULT NULL,
  `education` blob,
  `skills` blob,
  `experience` blob,
  `jobdescription` bigint(20) DEFAULT NULL,
  `empstatus` varchar(15) DEFAULT NULL,
  `departmentid` int(11) unsigned DEFAULT NULL,
  `managerid` int(10) unsigned DEFAULT NULL,
  `workingdays` varchar(50) DEFAULT NULL,
  `maxhoursperday` varchar(50) DEFAULT NULL,
  `maxhoursperweek` varchar(50) DEFAULT NULL,
  `shift` varchar(50) DEFAULT NULL,
  `rate` decimal(10,0) unsigned DEFAULT NULL,
  `ratetype` varchar(15) DEFAULT NULL,
  `ratecurrency` varchar(50) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accname` varchar(255) DEFAULT NULL,
  `accno` varchar(255) DEFAULT NULL,
  `swiftcode` varchar(255) DEFAULT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  `regularleavehrs` decimal(10,0) unsigned DEFAULT NULL,
  `regularleavedays` decimal(10,0) unsigned DEFAULT NULL,
  `regularleavetype` decimal(10,0) DEFAULT NULL,
  `sickleavehrs` decimal(10,0) unsigned DEFAULT NULL,
  `sickleavedays` decimal(10,0) unsigned DEFAULT NULL,
  `sickleavetype` tinyint(4) unsigned DEFAULT NULL,
  `accrualtype` tinyint(4) unsigned DEFAULT NULL,
  `accrualfrequency` tinyint(4) unsigned DEFAULT NULL,
  `companyid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_departmentid` (`departmentid`),
  KEY `index_user_isactive` (`status`) USING BTREE,
  KEY `fk_user_invitedbyid` (`invitedbyid`) USING BTREE,
  KEY `index_user_email` (`email`) USING BTREE,
  KEY `index_user_phonenumber` (`phone`) USING BTREE,
  KEY `index_user_username` (`username`) USING BTREE,
  KEY `index_user_createdby` (`createdby`) USING BTREE,
  KEY `index_user_lastupdatedby` (`lastupdatedby`) USING BTREE,
  KEY `fk_user_managerid` (`managerid`),
  KEY `fk_user_companyid` (`companyid`),
  CONSTRAINT `fk_user_companyid` FOREIGN KEY (`companyid`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_departmentid` FOREIGN KEY (`departmentid`) REFERENCES `department` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_invitedbyid` FOREIGN KEY (`invitedbyid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_user_managerid` FOREIGN KEY (`managerid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useraccount
-- ----------------------------
INSERT INTO `useraccount` VALUES ('1', '1', 'HRMS', 'Portal', 'Admin', 'HRMS Admin', 'admin@devmail.infomacorp.com', 'admin2@devmail.infomacorp.com', '256752762378', '', null, null, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, null, '', '1', null, null, '2015-01-20 12:00:00', '1', '2015-01-25 13:42:11', '1', 'UG', null, null, null, null, null, '0', null, null, '', '1', null, '1422182531.jpg', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null, '1', '5', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('2', '5', 'Edward', 'Lawrence', '', 'Edward Lawrence', 'test2@devmail.infomacorp.com', '', '256712466456', '', null, null, 'elawrence', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, null, null, '1', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '2', null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('3', '2', 'Davina', 'Rives', '', 'Davina Rives', 'test3@devmail.infomacorp.com', '', '256717440245', '', null, null, 'test3', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '3', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('4', '2', 'Corland', 'Forrester', '', 'Corland Forrester', 'test4@devmail.infomacorp.com', '', '256701595279', '', null, null, 'test4', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('5', '2', 'Lule', 'Male', '', 'Lule Male', 'test5@devmail.infomacorp.com', '', '256776595279', '', null, null, 'test5', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('6', '2', 'Guy', 'Sade', '', 'Guy Sade', 'test6@devmail.infomacorp.com', '', '256755145507', '', null, null, 'test6', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('7', '2', 'Veron', 'Moran', '', 'Veron Moran', 'test7@devmail.infomacorp.com', '', '256773128700', '', null, null, 'test7', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '3', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('8', '2', 'Jessica', 'Kay', '', 'Jessica Kay', 'test8@devmail.infomacorp.com', '', '256702740174', '', null, null, 'test8', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('9', '2', 'Charlie', 'Theron', '', 'Charlie Theron', 'test9@devmail.infomacorp.com', '', '256752850921', '', null, null, 'test9', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('10', '2', 'Carlos', 'Frances', '', 'Carlos Frances', 'test10@devmail.infomacorp.com', '', '256702841314', '', null, null, 'test10', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('11', '2', 'Patrick', 'Swayze', '', 'Patrick Swayze', 'test11@devmail.infomacorp.com', '', '256782592120', '', null, null, 'test11', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('12', '2', 'David', 'Rochester', '', 'David Rochester', 'test12@devmail.infomacorp.com', '', '256753451297', '', null, null, 'test12', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '1', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('13', '2', 'Jcques', 'Pierre', '', 'Jcques Pierre', 'test13@devmail.infomacorp.com', '', '256752033229', '', null, null, 'test13', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('14', '2', 'Rolf', 'Tragbar', '', 'Rolf Tragbar', 'test14@devmail.infomacorp.com', '', '256702767861', '', null, null, 'test14', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('15', '2', 'Betty', 'Brano', '', 'Betty Brano', 'test15@devmail.infomacorp.com', '', '256790474073', '', null, null, 'test1', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, '2015-01-23 11:23:49', '6303f2', '1', null, null, '2015-01-20 12:00:00', '1', '2015-01-25 13:40:05', '1', 'UG', 'Kampala', '2041', 'Plot 102, Kalema Road', 'Lunguja, Kampala', null, '0', '2015-01-23', '1', '', '2', '1990-01-02', '1422182405.jpg', 'Solomon Bosa', '3', '25678451236', 'test@domain.com', null, null, '2014-08-01', '2015-12-31', '2014-10-01', '1046', 'ug.linkedin.com/bettybrano', 'bettybrano', '2', 'Muganda', '4', '', '', '', '', null, '2', '2', '2', '1,2,3,4,5', '8', '40', '1', '1500', '1', 'UGX', 'Barclays Bank', 'Betty Olive Brano', '100451025', '', 'Wandegeya', null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('16', '2', 'Amy', 'Thompson', '', 'Amy Thompson', 'test16@devmail.infomacorp.com', '', '256776786077', '', null, null, 'test16', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '2', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('17', '2', 'William', 'Cole', '', 'William Cole', 'test17@devmail.infomacorp.com', '', '256772401409', '', null, null, 'test17', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '4', null, null, null, null, null, '3', '2', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `useraccount` VALUES ('18', '5', 'Michael', 'Kenefick', '', 'Michael Kenefick', 'test18@devmail.infomacorp.com', '', '256772378468', '', null, null, 'test18', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, '', null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, '5', null, null, null, null, null, '1', '1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1');
