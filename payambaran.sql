/*
Navicat MariaDB Data Transfer

Source Server         : mariadb
Source Server Version : 100208
Source Host           : localhost:3307
Source Database       : payambaran

Target Server Type    : MariaDB
Target Server Version : 100208
File Encoding         : 65001

Date: 2019-02-21 21:54:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for attachment
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'User uploaded the file.\r\nNULL is system files.',
  `dyna` blob DEFAULT NULL COMMENT 'ItemID\r\nPath\r\nFilename\r\nType',
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Deleted\r\n0: Suspended\r\n1: Active',
  PRIMARY KEY (`id`),
  KEY `Created` (`created`),
  KEY `Status` (`status`),
  KEY `UserID` (`userID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='All files uploaded to system are logged here';

-- ----------------------------
-- Records of attachment
-- ----------------------------

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('superAdmin', '1', '1508416990');

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('admin', '1', 'مدیر', null, null, '1507555215', '1515502636');
INSERT INTO `auth_item` VALUES ('superAdmin', '1', 'مدیر کل', null, null, '1507643138', '1507643138');

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentID` int(10) DEFAULT NULL,
  `type` enum('cat','tag','lst','mnu') COLLATE utf8_unicode_ci NOT NULL COMMENT 'ENUM:\r\n''cat'': Category\r\n''tag'': Tag/Taxonomy\r\n''lst'': List ''mnu'': Menu',
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `dyna` blob DEFAULT NULL,
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1: Suspended\r\n0: Unpublished\r\n1: Published',
  `left` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `tree` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `ParentID` (`parentID`),
  KEY `Type` (`type`),
  KEY `Name` (`name`(255)),
  KEY `Created` (`created`),
  KEY `Status` (`status`),
  KEY `lft` (`left`,`right`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nested records to store tree structures.\r\nIt includes categories, tags, persons.\r\n! This table is based on what Yii has designed.\r\nIf nothing exists, we will use "Nested sets" structure.';

-- ----------------------------
-- Records of category
-- ----------------------------

-- ----------------------------
-- Table structure for clinic_program
-- ----------------------------
DROP TABLE IF EXISTS `clinic_program`;
CREATE TABLE `clinic_program` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `personID` int(10) NOT NULL,
  `begin_time` time NOT NULL,
  `end_time` time NOT NULL,
  `dyna` blob DEFAULT NULL,
  `created` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` decimal(1,0) DEFAULT NULL COMMENT '0: Disabled 1: Enabled',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of clinic_program
-- ----------------------------

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'Book creator',
  `modelID` int(11) NOT NULL,
  `type` decimal(1,0) DEFAULT NULL,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL COMMENT 'عنوان',
  `dyna` blob DEFAULT NULL COMMENT 'All fields',
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array keeps all other options',
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Deleted\r\n0: Disabled\r\n1: Published\r\n5: Suggestion',
  PRIMARY KEY (`id`),
  KEY `UserID` (`userID`),
  KEY `Created` (`created`),
  KEY `Status` (`status`),
  KEY `Name` (`name`(255)),
  KEY `modelID` (`modelID`),
  FULLTEXT KEY `name_2` (`name`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `item_ibfk_2` FOREIGN KEY (`modelID`) REFERENCES `model` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores list of items.';

-- ----------------------------
-- Records of item
-- ----------------------------

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'User who did the action.\r\nNull is system actions',
  `code` smallint(5) NOT NULL COMMENT 'Action code.\r\nCodes are defined in excel file',
  `action` tinyint(1) NOT NULL COMMENT '\n1: Insert\r\n2: Update\r\n3: Delete',
  `model` char(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Table of item.\r\nNULL is reserved.',
  `modelID` int(10) DEFAULT NULL COMMENT 'Item ID\r\nNULL is reserved for system activities.',
  `values` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON decoded values of old and new values.\r\n{''old'':[], ''new'':[]}',
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserID` (`userID`),
  KEY `Code` (`code`),
  KEY `Action` (`action`),
  KEY `Model` (`model`),
  KEY `ModelID` (`modelID`),
  KEY `Date` (`date`),
  KEY `Time` (`time`),
  KEY `FKLog440613` (`userID`),
  CONSTRAINT `log_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Audit table.\r\n! This is only about actions are done by operators or auto-system, it is not the search log.';

-- ----------------------------
-- Records of log
-- ----------------------------

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL COMMENT 'نام و نام خانوادگی',
  `type` enum('cnt','sgn','cmp') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'cnt' COMMENT 'Enum: cnt: contact us, sgn: suggestions, cmp: complaints',
  `tel` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'شماره تماس',
  `body` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'متن',
  `dyna` blob DEFAULT NULL COMMENT 'All fields',
  `created` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of message
-- ----------------------------

-- ----------------------------
-- Table structure for model
-- ----------------------------
DROP TABLE IF EXISTS `model`;
CREATE TABLE `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array to store fields, order of fields and aliases\r\n\r\nStores fields options as JSON:\r\n{\r\n  [\r\n    fieldID: 5,\r\n    name: //Field name in language (ISO 639-1). Overrides default value in "Field" table\r\n      [\r\n        ''ar'':''myField'',\r\n        ''fa'':''yourField''\r\n      ],\r\n    width:15\r\n  ],\r\n  [\r\n    fieldID: 7,\r\n    name:\r\n      [\r\n        ''ar'':''...'',...\r\n      ]\r\n  ]\r\n}',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Alias` (`alias`),
  KEY `Name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of model
-- ----------------------------
INSERT INTO `model` VALUES ('1', 'slide', 'اسلاید', null);
INSERT INTO `model` VALUES ('2', 'news', 'خبر', null);
INSERT INTO `model` VALUES ('3', 'article', 'مقاله', null);
INSERT INTO `model` VALUES ('4', 'doctor', 'پزشک', null);
INSERT INTO `model` VALUES ('5', 'insurance', 'بیمه', null);
INSERT INTO `model` VALUES ('6', 'image-gallery', 'تصویر', null);
INSERT INTO `model` VALUES ('7', 'video-gallery', 'ویدئو', null);

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cat_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `page_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of page
-- ----------------------------

-- ----------------------------
-- Table structure for ugroup
-- ----------------------------
DROP TABLE IF EXISTS `ugroup`;
CREATE TABLE `ugroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `members` blob DEFAULT NULL COMMENT 'JSON array:\r\nU[userID] => [Status:0,1]',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `created` (`created`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User groups';

-- ----------------------------
-- Records of ugroup
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Hashed\r\nIt maybe 512',
  `roleID` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dyna` blob DEFAULT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Suspended\r\n0: Inactive\r\n1: Active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`),
  KEY `Name` (`name`),
  KEY `Status` (`status`),
  KEY `ruleID` (`roleID`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleID`) REFERENCES `auth_item` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table of users';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Admin', 'admin', '$2y$13$ZwQcrIXEr35pMAGmMZ00KueGQOxbyTG6NDs3i6WY1JUv1zsdZ5iUG', 'superAdmin', null, '2018-02-13 21:46:22', '1');

-- ----------------------------
-- Table structure for userugroup
-- ----------------------------
DROP TABLE IF EXISTS `userugroup`;
CREATE TABLE `userugroup` (
  `userID` int(11) NOT NULL,
  `ugroupID` int(11) NOT NULL,
  PRIMARY KEY (`userID`,`ugroupID`),
  KEY `ugroupID` (`ugroupID`) USING BTREE,
  CONSTRAINT `userugroup_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `userugroup_ibfk_2` FOREIGN KEY (`ugroupID`) REFERENCES `ugroup` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of userugroup
-- ----------------------------

-- ----------------------------
-- Table structure for user_request
-- ----------------------------
DROP TABLE IF EXISTS `user_request`;
CREATE TABLE `user_request` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `type` decimal(2,0) unsigned NOT NULL COMMENT 'all user request types',
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `dyna` blob DEFAULT NULL COMMENT 'All fields',
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array keeps all other options',
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'Request Status',
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  CONSTRAINT `user_request_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_request
-- ----------------------------
