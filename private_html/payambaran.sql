/*
Navicat MariaDB Data Transfer

Source Server         : localhost
Source Server Version : 100312
Source Host           : localhost:3307
Source Database       : payambaran

Target Server Type    : MariaDB
Target Server Version : 100312
File Encoding         : 65001

Date: 2019-03-14 15:08:54
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
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '-1: Deleted\r\n0: Suspended\r\n1: Active',
  PRIMARY KEY (`id`),
  KEY `Created` (`created`),
  KEY `Status` (`status`),
  KEY `UserID` (`userID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='All files uploaded to system are logged here';

-- ----------------------------
-- Records of attachment
-- ----------------------------
INSERT INTO `attachment` VALUES ('43', '1', 0x040500160000000300040053020800D0020C0003031000400366696C657061746873697A65747970656974656D49442163653531653233633464333966613465333134313237653335363837653133372E706E6721323031392F303374060121706E672E, '1551624747', '1');
INSERT INTO `attachment` VALUES ('44', '1', 0x040500160000000300040053020800D0020C00F3021000300366696C657061746873697A65747970656974656D49442133393961643539623032316234643130363666623732323736306134333466392E706E6721323031392F303388FE21706E672E, '1551624747', '1');
INSERT INTO `attachment` VALUES ('45', '1', 0x040500160000000300040053020800D0020C0003031000400366696C657061746873697A65747970656974656D49442165653633326532356562346336333638356335306234656235336666323237632E706E6721323031392F30336A410121706E672E, '1551624748', '1');
INSERT INTO `attachment` VALUES ('46', '1', 0x040500160000000300040053020800D0020C0003031000400366696C657061746873697A65747970656974656D49442163333534306462373630346134323166653364366431383039636364363235362E706E6721323031392F303370C80121706E672E, '1551624748', '1');
INSERT INTO `attachment` VALUES ('47', '1', 0x040500160000000300040053020800D0020C0003031000400366696C657061746873697A65747970656974656D49442131616365666162613031613361633331613634363165656265303938346566372E706E6721323031392F3033040C1521706E672E, '1551624748', '1');
INSERT INTO `attachment` VALUES ('53', '1', 0x040500160000000300040053020800D0020C0003031000400366696C657061746873697A65747970656974656D49442131373162363632353134386339343666323736346238343736303134646539332E706E6721323031392F30337E081321706E6732, '1551626375', '1');

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
  `type` enum('cat','tag','lst','mnu','dep') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `dyna` blob DEFAULT NULL,
  `extra` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Nested records to store tree structures.\r\nIt includes categories, tags, persons.\r\n! This table is based on what Yii has designed.\r\nIf nothing exists, we will use "Nested sets" structure.';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('79', null, 'mnu', 'درباره ما', 0x04080045000000030004003000080043000F006300160093001F00A3002A006301370073016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B73686F775F696E5F666F6F7465722166610221302132352121706572736F6E406C697374212131, null, '1551625618', '1', '1', '8', '0', '79');
INSERT INTO `category` VALUES ('80', '79', 'mnu', 'تاریخچه', 0x04070037000000030004003000080043000F006300160093001F00B3002A0073016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B216661042131213235213121706572736F6E406C69737421, null, '1551626399', '1', '6', '7', '1', '79');
INSERT INTO `category` VALUES ('81', '79', 'mnu', 'رياست', 0x04070037000000030004003000080043000F006300160093001F00B3002A0073016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B216661082131213236213121706572736F6E406C69737421, null, '1551626860', '1', '4', '5', '1', '79');
INSERT INTO `category` VALUES ('82', '79', 'mnu', 'افتخارات و گواهي نامه ها', 0x04070037000000030004003000080043000F006300160093001F00B3002A0073016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B216661062131213237213121706572736F6E406C69737421, null, '1551628057', '1', '2', '3', '1', '79');
INSERT INTO `category` VALUES ('83', null, 'mnu', 'معرفي بيمارستان', 0x04070037000000030004003000080043000F006300160093001F00A3002A0063016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B2166610A21302132352121706572736F6E406C69737421, null, '1551628273', '1', '1', '6', '0', '83');
INSERT INTO `category` VALUES ('84', '83', 'mnu', 'خدمات مراقبتی', 0x04070037000000030004003000080043000F006300160093001F00A3002A0063016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B2166610C21302132352121706572736F6E406C69737421, null, '1551630119', '1', '2', '5', '1', '83');
INSERT INTO `category` VALUES ('85', '84', 'mnu', 'اورژانس', 0x04070037000000030004003000080043000F006300160093001F00B3002A0073016C616E67736F7274636F6E74656E74706167655F69646D656E755F74797065616374696F6E5F6E616D6565787465726E616C5F6C696E6B2166610E2131213238213121706572736F6E406C69737421, null, '1551630172', '1', '3', '4', '2', '83');
INSERT INTO `category` VALUES ('86', null, 'cat', 'قلب و عروق', 0x04030015000000030004003000080043006C616E67736F727463617465676F72795F747970652166611021657870657274697365, null, '1551632901', '1', '1', '2', '0', '86');
INSERT INTO `category` VALUES ('87', null, 'cat', 'ورزشی', 0x04030015000000030004003000080043006C616E67736F727463617465676F72795F7479706521666112216E657773, null, '1551633153', '1', '1', '2', '0', '87');
INSERT INTO `category` VALUES ('89', null, 'dep', 'مدیریت', 0x040200080000000300040030006C616E67736F727421666114, null, '1552558872', '1', '1', '2', '0', '89');
INSERT INTO `category` VALUES ('90', null, 'dep', 'پشتیبانی', 0x040200080000000300040030006C616E67736F727421666116, null, '1552561992', '1', '1', '2', '0', '90');

-- ----------------------------
-- Table structure for catitem
-- ----------------------------
DROP TABLE IF EXISTS `catitem`;
CREATE TABLE `catitem` (
  `itemID` int(10) NOT NULL,
  `catID` int(10) NOT NULL,
  `type` enum('cat','tax') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Some types are defined in list like: ''cat'', ''tax''',
  `status` tinyint(1) NOT NULL COMMENT '-1: Suspended\r\n0: Unpublished\r\n1: Published',
  PRIMARY KEY (`itemID`,`catID`,`type`),
  KEY `CatID` (`catID`),
  KEY `Type` (`type`),
  KEY `Status` (`status`),
  KEY `ItemID` (`itemID`) USING BTREE,
  CONSTRAINT `catitem_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `catitem_ibfk_2` FOREIGN KEY (`catID`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of catitem
-- ----------------------------
INSERT INTO `catitem` VALUES ('12', '87', 'cat', '1');

-- ----------------------------
-- Table structure for clinic_program
-- ----------------------------
DROP TABLE IF EXISTS `clinic_program`;
CREATE TABLE `clinic_program` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dyna` blob DEFAULT NULL,
  `created` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of clinic_program
-- ----------------------------
INSERT INTO `clinic_program` VALUES ('6', '1551830400', 0x0401000A000000030069735F686F6C696461792130, '1551895458', '1');
INSERT INTO `clinic_program` VALUES ('7', '1551916800', 0x0401000A000000030069735F686F6C696461792130, '1551895458', '1');
INSERT INTO `clinic_program` VALUES ('8', '1552521600', 0x0401000A000000030069735F686F6C696461792130, '1552457592', '1');
INSERT INTO `clinic_program` VALUES ('9', '1552608000', 0x0401000A000000030069735F686F6C696461792131, '1552457604', '1');
INSERT INTO `clinic_program` VALUES ('10', '1552694400', 0x0401000A000000030069735F686F6C696461792130, '1552457639', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores list of items.';

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('4', '1', '5', null, 'تست', 0x0403000D00000003000400630208009302626F64796C616E67696D616765213C70207374796C653D22646972656374696F6E3A2072746C3B223ED8AAD8B3D8AA3C2F703E2161722164656261393931333031303636626238353638383036663931623734383863632E6A7067, null, '1551026353', '1');
INSERT INTO `item` VALUES ('7', '1', '1', null, 'اسلاید فارسی 1', 0x040200090000000300040033006C616E67696D6167652166612165333465356236663630316563396665383232646532363864373733346430322E6A7067, null, '1551029948', '1');
INSERT INTO `item` VALUES ('8', '1', '1', null, 'اسلاید انگلیسی 1', 0x040200090000000300040033006C616E67696D61676521656E2131636334343134346164653933303836326239333363666637666363653064382E706E67, null, '1551030290', '0');
INSERT INTO `item` VALUES ('9', '1', '3', '1', 'یوسف مبشری', 0x040700340000000300040033000A0083021000B34F18006350210093502A0023516C616E67617661746172726573756D65737572656E616D6565787065727469736566697273746E616D65657870657269656E63652166612164376137313836613739643962313265613338313238393732333436366538342E6A706721D984D988D8B1D98520D8A7DB8CD9BED8B3D988D98520D985D8AAD98620D8B3D8A7D8AED8AADAAFDB8C20D8A8D8A720D8AAD988D984DB8CD8AF20D8B3D8A7D8AFDAAFDB8C20D986D8A7D985D981D987D988D98520D8A7D8B220D8B5D986D8B9D8AA20DA86D8A7D9BE20D98820D8A8D8A720D8A7D8B3D8AAD981D8A7D8AFD98720D8A7D8B220D8B7D8B1D8A7D8ADD8A7D98620DAAFD8B1D8A7D981DB8CDAA920D8A7D8B3D8AA2E20DA86D8A7D9BEDAAFD8B1D987D8A720D98820D985D8AAD988D98620D8A8D984DAA9D98720D8B1D988D8B2D986D8A7D985D98720D98820D985D8ACD984D98720D8AFD8B120D8B3D8AAD988D98620D98820D8B3D8B7D8B1D8A2D986DA86D986D8A7D98620DAA9D98720D984D8A7D8B2D98520D8A7D8B3D8AA20D98820D8A8D8B1D8A7DB8C20D8B4D8B1D8A7DB8CD8B720D981D8B9D984DB8C20D8AADAA9D986D988D984D988DA98DB8C20D985D988D8B1D8AF20D986DB8CD8A7D8B220D98820DAA9D8A7D8B1D8A8D8B1D8AFD987D8A7DB8C20D985D8AAD986D988D8B920D8A8D8A720D987D8AFD98120D8A8D987D8A8D988D8AF20D8A7D8A8D8B2D8A7D8B1D987D8A7DB8C20DAA9D8A7D8B1D8A8D8B1D8AFDB8C20D985DB8C20D8A8D8A7D8B4D8AF2E20DAA9D8AAD8A7D8A8D987D8A7DB8C20D8B2DB8CD8A7D8AFDB8C20D8AFD8B120D8B4D8B5D8AA20D98820D8B3D98720D8AFD8B1D8B5D8AF20DAAFD8B0D8B4D8AAD987D88C20D8ADD8A7D98420D98820D8A2DB8CD986D8AFD98720D8B4D986D8A7D8AED8AA20D981D8B1D8A7D988D8A7D98620D8ACD8A7D985D8B9D98720D98820D985D8AAD8AED8B5D8B5D8A7D98620D8B1D8A720D985DB8C20D8B7D984D8A8D8AF20D8AAD8A720D8A8D8A720D986D8B1D98520D8A7D981D8B2D8A7D8B1D987D8A720D8B4D986D8A7D8AED8AA20D8A8DB8CD8B4D8AAD8B1DB8C20D8B1D8A720D8A8D8B1D8A7DB8C20D8B7D8B1D8A7D8ADD8A7D98620D8B1D8A7DB8CD8A7D986D98720D8A7DB8C20D8B9D984DB8C20D8A7D984D8AED8B5D988D8B520D8B7D8B1D8A7D8ADD8A7D98620D8AED984D8A7D982DB8C20D98820D981D8B1D987D986DAAF20D9BEDB8CD8B4D8B1D98820D8AFD8B120D8B2D8A8D8A7D98620D981D8A7D8B1D8B3DB8C20D8A7DB8CD8ACD8A7D8AF20DAA9D8B1D8AF2E20D8AFD8B120D8A7DB8CD98620D8B5D988D8B1D8AA20D985DB8C20D8AAD988D8A7D98620D8A7D985DB8CD8AF20D8AFD8A7D8B4D8AA20DAA9D98720D8AAD985D8A7D98520D98820D8AFD8B4D988D8A7D8B1DB8C20D985D988D8ACD988D8AF20D8AFD8B120D8A7D8B1D8A7D8A6D98720D8B1D8A7D987DAA9D8A7D8B1D987D8A720D98820D8B4D8B1D8A7DB8CD8B720D8B3D8AED8AA20D8AAD8A7DB8CD9BE20D8A8D98720D9BED8A7DB8CD8A7D98620D8B1D8B3D8AF20D988D8B2D985D8A7D98620D985D988D8B1D8AF20D986DB8CD8A7D8B220D8B4D8A7D985D98420D8ADD8B1D988D981DA86DB8CD986DB8C20D8AFD8B3D8AAD8A7D988D8B1D8AFD987D8A7DB8C20D8A7D8B5D984DB8C20D98820D8ACD988D8A7D8A8DAAFD988DB8C20D8B3D988D8A7D984D8A7D8AA20D9BEDB8CD988D8B3D8AAD98720D8A7D987D98420D8AFD986DB8CD8A7DB8C20D985D988D8ACD988D8AF20D8B7D8B1D8A7D8ADDB8C20D8A7D8B3D8A7D8B3D8A720D985D988D8B1D8AF20D8A7D8B3D8AAD981D8A7D8AFD98720D982D8B1D8A7D8B120DAAFDB8CD8B1D8AF2E21D985D8A8D8B4D8B1DB8C21383621DB8CD988D8B3D9812131, null, '1551104360', '1');
INSERT INTO `item` VALUES ('10', '1', '4', '1', 'بیمه ایران', 0x040200090000000300040033006C616E67696D6167652166612136343561656432646561323236336232363261326461386639666438373336622E706E67, null, '1551111028', '1');
INSERT INTO `item` VALUES ('12', '1', '2', '1', 'خبر تست', 0x0405002000000003000400E300080013010D0063031400D303626F64796C616E67696D61676573756D6D6172797075626C6973685F64617465213C703ED8AAD8B3D8AA3C2F703E2166612132663465343465623461386166373065653061303531383963316637346238632E706E6721D8B4D8B3DB8C21DBB2DBB0DBB1DBB92FDBB0DBB32FDBB0DBB9, null, '1551118437', '1');
INSERT INTO `item` VALUES ('14', '1', '1', null, 'اسلاید عربی 1', 0x040200090000000300040033006C616E67696D6167652161722137366436616535363936353431333939346263393338623839396437633739302E706E67, null, '1551290933', '1');
INSERT INTO `item` VALUES ('25', '1', '5', null, 'تاریخچه', 0x0404001100000003000400E300080010010C002301626F64796C616E677365656E696D616765213C703ED985D8AAD9863C2F703E216661022133666132336539333034313330636462313639313237363365616538613533662E706E67, null, '1551626375', '1');
INSERT INTO `item` VALUES ('26', '1', '5', null, 'رياست', 0x0403000D00000003000400E30008001301626F64796C616E67696D616765213C703ED985D8AAD9863C2F703E2166612132626132386337653861326230636237376236613232653665333931653237622E706E67, null, '1551626835', '1');
INSERT INTO `item` VALUES ('27', '1', '5', null, 'افتخارات و گواهي نامه ها', 0x0403000D00000003000400430308007303626F64796C616E67696D616765213C703ED8A7D981D8AAD8AED8A7D8B1D8A7D8AA20D98820DAAFD988D8A7D987D98A20D986D8A7D985D98720D987D8A73C2F703E2166612139353031646262393762323031353235326363663737666133633839333266322E706E67, null, '1551628024', '1');
INSERT INTO `item` VALUES ('28', '1', '5', null, 'اورژانس', 0x0403000D00000003000400630108009301626F64796C616E67696D616765213C703ED8A7D988D8B1DA98D8A7D986D8B33C2F703E2166612137346162393937323337323835633261373635373362633735393535643237352E706E67, null, '1551630154', '1');
INSERT INTO `item` VALUES ('29', '1', '3', '1', 'دکتر فرهاد مرادی', 0x0406002E0000000300040033000A0043001200F3001B0023012400D3016C616E67726573756D65737572656E616D6565787065727469736566697273746E616D65657870657269656E63652166612121D985D8B1D8A7D8AFDB8C21383621D981D8B1D987D8A7D8AF213135, null, '1551891002', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of model
-- ----------------------------
INSERT INTO `model` VALUES ('1', 'slide', 'اسلاید', null);
INSERT INTO `model` VALUES ('2', 'post', 'مطلب', null);
INSERT INTO `model` VALUES ('3', 'person', 'شخص', null);
INSERT INTO `model` VALUES ('4', 'insurance', 'بیمه', null);
INSERT INTO `model` VALUES ('5', 'page', 'صفحات', null);
INSERT INTO `model` VALUES ('9', 'gallery', 'گالری', null);

-- ----------------------------
-- Table structure for person_program_rel
-- ----------------------------
DROP TABLE IF EXISTS `person_program_rel`;
CREATE TABLE `person_program_rel` (
  `dayID` int(11) NOT NULL,
  `personID` int(11) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`dayID`,`personID`),
  KEY `person_program_rel_ibfk_2` (`personID`),
  CONSTRAINT `person_program_rel_ibfk_1` FOREIGN KEY (`dayID`) REFERENCES `clinic_program` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `person_program_rel_ibfk_2` FOREIGN KEY (`personID`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of person_program_rel
-- ----------------------------
INSERT INTO `person_program_rel` VALUES ('6', '9', '10:00:00', '11:00:00', '');
INSERT INTO `person_program_rel` VALUES ('6', '29', '16:00:00', '18:00:00', '');
INSERT INTO `person_program_rel` VALUES ('7', '9', '10:00:00', '11:00:00', '');
INSERT INTO `person_program_rel` VALUES ('7', '29', '16:00:00', '18:00:00', '');
INSERT INTO `person_program_rel` VALUES ('8', '9', '10:00:00', '11:00:00', '');
INSERT INTO `person_program_rel` VALUES ('10', '9', '10:00:00', '11:00:00', '');
INSERT INTO `person_program_rel` VALUES ('10', '29', '16:00:00', '18:00:00', 'asf');

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
INSERT INTO `user` VALUES ('1', 'Admin', 'admin', '$2y$13$LzbDws024iCbvece6kIsSOuoiVQj.6cETL7bgrRuKgZpa.Dul/dqW', 'superAdmin', 0x0401000700000003007570646174656421323031392D30332D30362031353A30353A3432, '2018-02-13 21:46:22', '1');

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

-- ----------------------------
-- View structure for clinic_program_view
-- ----------------------------
DROP VIEW IF EXISTS `clinic_program_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `clinic_program_view` AS select (select `c`.`name` from `category` `c` where `c`.`id` = column_get(`i`.`dyna`,'expertise' as signed)) AS `exp`,`i`.`name` AS `name`,`cp`.`date` AS `date`,`ppr`.`start_time` AS `start_time`,`ppr`.`end_time` AS `end_time`,`ppr`.`description` AS `description` from ((`clinic_program` `cp` join `person_program_rel` `ppr` on(`cp`.`id` = `ppr`.`dayID`)) join `item` `i` on(`i`.`modelID` = (select `model`.`id` from `model` where `model`.`name` = 'person') and `i`.`id` = `ppr`.`personID`)) ;
