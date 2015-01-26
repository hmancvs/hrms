/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : 127.0.0.1:3306
Source Database       : hrms

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-01-21 08:35:48
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclgroup
-- ----------------------------
INSERT INTO `aclgroup` VALUES ('1', 'Super Admin', 'Has rights to entire system configuration', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclgroup` VALUES ('2', 'Employee', 'Company Employees ', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclgroup` VALUES ('3', 'HR Supervisor', 'Generates payroll and approves Timesheets and Leave requests', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclgroup` VALUES ('4', 'Management', 'Report level user', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclgroup` VALUES ('5', 'Data Admin', 'Data Administrator', '2015-01-15 12:00:00', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclpermission
-- ----------------------------
INSERT INTO `aclpermission` VALUES ('2', '1', '1', '0', '0', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('3', '1', '2', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('4', '1', '3', '1', '1', '1', '1', '1', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('5', '1', '4', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('6', '1', '5', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('7', '1', '6', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('8', '1', '7', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('14', '1', '8', '1', '0', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('20', '1', '9', '1', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('21', '1', '10', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('22', '1', '11', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('23', '1', '12', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('24', '1', '13', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('25', '1', '14', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('27', '2', '4', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('29', '2', '6', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('32', '2', '1', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('34', '2', '8', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('39', '2', '11', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('40', '2', '12', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('41', '2', '13', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('42', '2', '14', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('43', '2', '10', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('44', '2', '5', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('45', '2', '9', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('46', '2', '7', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('47', '2', '2', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('48', '2', '3', '0', '1', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('50', '4', '4', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('52', '4', '6', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('55', '4', '1', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('57', '4', '8', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('62', '4', '11', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('63', '4', '12', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('64', '4', '13', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('65', '4', '14', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('66', '4', '10', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('67', '4', '5', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('68', '4', '9', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('69', '4', '7', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('70', '4', '2', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('71', '4', '3', '0', '1', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('119', '3', '4', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('121', '3', '6', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('124', '3', '1', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('126', '3', '8', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('131', '3', '11', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('132', '3', '12', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('133', '3', '13', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('134', '3', '14', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('135', '3', '10', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('136', '3', '5', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('137', '3', '9', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('138', '3', '7', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('139', '3', '2', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('140', '3', '3', '0', '1', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('142', '5', '4', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('144', '5', '6', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('147', '5', '1', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('149', '5', '8', '1', '0', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('154', '5', '11', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('155', '5', '12', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('156', '5', '13', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('157', '5', '14', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('158', '5', '10', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('159', '5', '5', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('160', '5', '9', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('161', '5', '7', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('162', '5', '2', '0', '0', '0', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('163', '5', '3', '0', '1', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('187', '1', '15', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('188', '1', '16', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclpermission` VALUES ('189', '1', '17', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclresource
-- ----------------------------
INSERT INTO `aclresource` VALUES ('1', 'Lookup Type', 'Look up types', '0', '0', '1', '1', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('2', 'System Variables', 'Values for the lookup type', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('3', 'User Account', 'A user who has activated their member account', '1', '1', '1', '1', '1', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('4', 'Audit Trail Report', 'Audit Trail Report', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('5', 'Role', 'Actions a member can execute on resources', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('6', 'Dashboard', 'user dashboard', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('7', 'System Config', 'Global system configuration parameters', '1', '1', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `aclresource` VALUES ('8', 'Message', 'Direct Messaging module', '1', '0', '1', '1', '1', '0', '0', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('9', 'SMS', 'SMS Communication', '1', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('10', 'Report Dashboard', 'Report Dashboard', '0', '0', '1', '0', '0', '0', '0', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('11', 'Report 1', 'Report 1', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('12', 'Report 2', 'Report 2', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('13', 'Report 3', 'Report 3', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('14', 'Report 4', 'Report 4', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('15', 'Report 5', 'Report 5', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('16', 'Report 6', 'Report 6', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('17', 'Report 7', 'Report 7', '0', '0', '1', '0', '0', '0', '1', '2015-01-15 12:00:00', null, null, null);
INSERT INTO `aclresource` VALUES ('18', 'Check In', 'Enables employees to check in', '1', '0', '0', '0', '0', '0', '0', null, null, null, null);
INSERT INTO `aclresource` VALUES ('19', 'Check Out', 'Enables employees to check out', '1', '0', '0', '0', '0', '0', '0', null, null, null, null);
INSERT INTO `aclresource` VALUES ('20', 'Timesheets', 'Time spent on duty', '1', '1', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `aclresource` VALUES ('21', 'Benefits', 'Benefits', '1', '1', '1', '1', '1', '0', '0', null, null, null, null);
INSERT INTO `aclresource` VALUES ('22', 'Time off', 'Request Time off', '1', '1', '1', '1', '1', '0', '0', null, null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of aclusergroup
-- ----------------------------
INSERT INTO `aclusergroup` VALUES ('1', '1', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of audittrail
-- ----------------------------
INSERT INTO `audittrail` VALUES ('1', '1', 'user.login', '1', '1.1', 'Login for user with id \'admin\' successful', '2015-01-15 20:48:48', 'Y', 'Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '34.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);
INSERT INTO `audittrail` VALUES ('2', '1', 'user.login', '1', '1.1', 'Login for user with id \'admin\' successful', '2015-01-15 21:36:10', 'Y', 'Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '34.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);
INSERT INTO `audittrail` VALUES ('3', '1', 'user.logout', '1', '1.2', 'Logout for user with id \'admin\' successful', '2015-01-20 10:39:56', 'Y', 'Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64;', 'Firefox', '35.0', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0', 'Windows', '0', '127.0.0.1', null, '0', null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lookuptype
-- ----------------------------
INSERT INTO `lookuptype` VALUES ('1', 'LIST_ITEM_COUNT_OPTIONS', 'Listing Items Per Page', '1', '0', '0', 'The number of items per page', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('2', 'SALUTATION', 'Salutations Variables', '1', '1', '0', 'The different salutations Mr, Mrs, Dr, etc', '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('3', 'MARITAL_STATUS_VALUES', 'Marital Status Values', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('4', 'PROFESSIONS', 'Member Professions', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);
INSERT INTO `lookuptype` VALUES ('5', 'CONTACT_RELATIONSHIPS', 'Next of Kin Relationships', '1', '1', '0', null, '2015-01-15 12:00:00', '1', null, null);

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
INSERT INTO `lookuptypevalue` VALUES ('13', '3', '1', 'Married', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('14', '3', '2', 'Single', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('15', '3', '3', 'Divorced', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('16', '3', '4', 'Widowed', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('17', '3', '5', 'Partnered', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('18', '3', '6', 'Separated', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('19', '2', '7', 'Honourable', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('20', '2', '8', 'Rt Hon', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('21', '2', '9', 'Bishop', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('22', '2', '10', 'General Overseer', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('23', '2', '11', 'Pastor', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('24', '2', '12', 'Apostle', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('25', '4', '1', 'Teacher', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('26', '4', '2', 'Engineer', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('27', '4', '3', 'General Business', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('28', '4', '4', 'Accountant', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('29', '4', '5', 'Doctor', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('30', '4', '6', 'Farmer', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('32', '4', '8', 'Banking', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('33', '4', '9', 'IT and Computers', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('34', '4', '10', 'Architect', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('35', '4', '11', 'Manufacturing', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('36', '4', '12', 'Housewife', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('37', '4', '13', 'Student', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('38', '4', '14', 'Medical', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('39', '4', '15', 'Clergy', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('40', '4', '15', 'Media and Journalism', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('41', '4', '15', 'Sports', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('42', '4', '15', 'Music, Dance and Drama', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('43', '5', '1', 'Father', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('44', '5', '2', 'Mother', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('45', '5', '3', 'Sibling', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('46', '5', '4', 'Child', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('47', '5', '5', 'Grand Child', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('48', '5', '6', 'Grand Parent', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('49', '5', '7', 'In-law', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('50', '5', '8', 'Aunt', '1060', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('51', '5', '9', 'Uncle', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('52', '5', '0', 'Business Partner', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('53', '5', '11', 'Spouse', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('54', '5', '12', 'Guardian', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('55', '5', '13', 'Friend', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('56', '5', '14', 'Employer', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('57', '5', '15', 'Workmate', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('58', '5', '17', 'Other Relative', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('59', '5', '16', 'Collegue', null, '2015-01-15 12:00:00', null, null, null, null, null);
INSERT INTO `lookuptypevalue` VALUES ('60', '4', '16', 'Lecturer', '279', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('61', '2', '13', 'Hon.', '279', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('62', '4', '17', 'Pastor', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('63', '4', '18', 'Bishop', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('64', '4', '19', 'Gospel Minister', '1', '2015-01-15 12:00:00', null, null, '', null, null);
INSERT INTO `lookuptypevalue` VALUES ('65', '4', '20', 'Theologian', '1', '2015-01-15 12:00:00', null, null, '', null, null);

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
INSERT INTO `session` VALUES ('15c95cdsr4ib1llp978ok5tto0', '1421656382', '21104000', 'Default|a:1:{s:11:\"initialized\";b:1;}');
INSERT INTO `session` VALUES ('6sin68hakmsc010crbgjt0lh57', '1421740149', '21104000', 'Default|a:15:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"35.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}}');
INSERT INTO `session` VALUES ('c81s6m60b7rmd05pk09pi7mn54', '1421425452', '21104000', 'Default|a:16:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 34.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"34.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:7:\"toggled\";s:0:\"\";}');
INSERT INTO `session` VALUES ('dlvir21e1mkq8i91pp9kv9tmf3', '1421778822', '21104000', 'Default|a:18:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";s:6:\"userid\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:4:\"type\";s:1:\"1\";s:12:\"browseraudit\";a:7:{s:14:\"browserdetails\";s:96:\"Firefox, 35.0, Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0, Windows\";s:7:\"browser\";s:7:\"Firefox\";s:7:\"version\";s:4:\"35.0\";s:9:\"useragent\";s:72:\"Mozilla/5.0 (Windows NT 6.2; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0\";s:2:\"os\";s:7:\"Windows\";s:8:\"ismobile\";i:0;s:9:\"ipaddress\";s:9:\"127.0.0.1\";}s:7:\"toggled\";s:0:\"\";s:16:\"itemcountperpage\";s:2:\"50\";s:5:\"style\";s:1:\"1\";}');
INSERT INTO `session` VALUES ('nh010d4vu7t7o9026702l0chp2', '1421693652', '21104000', 'Default|a:11:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";}');
INSERT INTO `session` VALUES ('vsnidh98kko6cq89ibmtfnroi6', '1421738643', '21104000', 'Default|a:11:{s:11:\"initialized\";b:1;s:6:\"errors\";s:0:\"\";s:14:\"successmessage\";s:0:\"\";s:10:\"formvalues\";a:0:{}s:13:\"invitesuccess\";s:0:\"\";s:13:\"custommessage\";s:0:\"\";s:14:\"custommessage1\";s:0:\"\";s:14:\"custommessage2\";s:0:\"\";s:14:\"custommessage3\";s:0:\"\";s:14:\"custommessage4\";s:0:\"\";s:14:\"custommessage5\";s:0:\"\";}');

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
  `ethnicity` varchar(255) DEFAULT NULL,
  `salutation` varchar(15) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `qualifications` varchar(1000) DEFAULT NULL,
  `education` blob,
  `skills` blob,
  `experience` blob,
  `empstatus` varchar(15) DEFAULT NULL,
  `departmentid` int(11) unsigned DEFAULT NULL,
  `managerid` int(10) unsigned DEFAULT NULL,
  `workingdays` varchar(50) DEFAULT NULL,
  `maxhoursperday` varchar(50) DEFAULT NULL,
  `maxhoursperweek` varchar(50) DEFAULT NULL,
  `starttime` varchar(50) DEFAULT NULL,
  `endtime` varchar(50) DEFAULT NULL,
  `rate` decimal(10,0) unsigned DEFAULT NULL,
  `ratetype` varchar(15) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accname` varchar(255) DEFAULT NULL,
  `accno` varchar(255) DEFAULT NULL,
  `swiftcode` varchar(255) DEFAULT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_member_isactive` (`status`),
  KEY `fk_member_invitedbyid` (`invitedbyid`),
  KEY `index_member_email` (`email`),
  KEY `index_member_phonenumber` (`phone`),
  KEY `index_member_username` (`username`),
  KEY `index_member_createdby` (`createdby`),
  KEY `index_member_lastupdatedby` (`lastupdatedby`),
  CONSTRAINT `fk_member_invitedbyid` FOREIGN KEY (`invitedbyid`) REFERENCES `useraccount` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of useraccount
-- ----------------------------
INSERT INTO `useraccount` VALUES ('1', '1', 'HRMS', 'Portal', 'Admin', 'HRMS Admin', 'admin@devmail.infomacorp.com', '', '256752762378', '', null, null, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, null, null, '1', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('2', '5', 'Edward', 'Lawrence', '', 'Edward Lawrence', 'test2@devmail.infomacorp.com', '', '256712466456', '', null, null, 'test2', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '1', null, null, null, '1', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('3', '2', 'Davina', 'Rives', '', 'Davina Rives', 'test3@devmail.infomacorp.com', '', '256717440245', '', null, null, 'test3', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('4', '3', 'Corland', 'Forrester', '', 'Corland Forrester', 'test4@devmail.infomacorp.com', '', '256701595279', '', null, null, 'test4', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('5', '4', 'Lule', 'Male', '', 'Lule Male', 'test5@devmail.infomacorp.com', '', '256776595279', '', null, null, 'test5', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('6', '3', 'Guy', 'Sade', '', 'Guy Sade', 'test6@devmail.infomacorp.com', '', '256755145507', '', null, null, 'test6', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('7', '2', 'Veron', 'Moran', '', 'Veron Moran', 'test7@devmail.infomacorp.com', '', '256773128700', '', null, null, 'test7', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('8', '2', 'Jessica', 'Kay', '', 'Jessica Kay', 'test8@devmail.infomacorp.com', '', '256702740174', '', null, null, 'test8', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('9', '2', 'Charlie', 'Theron', '', 'Charlie Theron', 'test9@devmail.infomacorp.com', '', '256752850921', '', null, null, 'test9', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('10', '3', 'Carlos', 'Frances', '', 'Carlos Frances', 'test10@devmail.infomacorp.com', '', '256702841314', '', null, null, 'test10', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('11', '4', 'Patrick', 'Swayze', '', 'Patrick Swayze', 'test11@devmail.infomacorp.com', '', '256782592120', '', null, null, 'test11', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('12', '4', 'David', 'Rochester', '', 'David Rochester', 'test12@devmail.infomacorp.com', '', '256753451297', '', null, null, 'test12', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('13', '4', 'Jcques', 'Pierre', '', 'Jcques Pierre', 'test13@devmail.infomacorp.com', '', '256752033229', '', null, null, 'test13', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('14', '3', 'Rolf', 'Tragbar', '', 'Rolf Tragbar', 'test14@devmail.infomacorp.com', '', '256702767861', '', null, null, 'test14', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('15', '2', 'Betty', 'Brano', '', 'Betty Brano', 'test15@devmail.infomacorp.com', '', '256790474073', '', null, null, 'test15', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '2', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('16', '3', 'Amy', 'Thompson', '', 'Amy Thompson', 'test16@devmail.infomacorp.com', '', '256776786077', '', null, null, 'test16', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('17', '2', 'William', 'Cole', '', 'William Cole', 'test17@devmail.infomacorp.com', '', '256772401409', '', null, null, 'test17', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, null, null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `useraccount` VALUES ('18', '5', 'Michael', 'Kenefick', '', 'Michael Kenefick', 'test18@devmail.infomacorp.com', '', '256772378468', '', null, null, 'test18', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '0', null, null, null, '0', null, null, '2015-01-20 12:00:00', '1', null, null, 'UG', null, null, '', null, null, null, null, null, '', '1', null, '', '', null, '', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

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
