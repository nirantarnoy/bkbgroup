/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acc_member

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-11-22 21:11:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `backup_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `backup_schedule`;
CREATE TABLE `backup_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_type` int(11) DEFAULT NULL,
  `target_date` datetime DEFAULT NULL,
  `command_text` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of backup_schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `bank`
-- ----------------------------
DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of bank
-- ----------------------------
INSERT INTO `bank` VALUES ('2', 'KBB', 'Bank of chaina', null, null, null, null, null);

-- ----------------------------
-- Table structure for `bank_account`
-- ----------------------------
DROP TABLE IF EXISTS `bank_account`;
CREATE TABLE `bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account` varchar(20) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `balance` float(11,0) DEFAULT NULL,
  `created_at` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bank_account
-- ----------------------------

-- ----------------------------
-- Table structure for `bank_account_company`
-- ----------------------------
DROP TABLE IF EXISTS `bank_account_company`;
CREATE TABLE `bank_account_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `bank_account` varchar(20) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `balance` float(11,0) DEFAULT '0',
  `created_at` int(20) DEFAULT NULL,
  `created_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bank_account_company
-- ----------------------------
INSERT INTO `bank_account_company` VALUES ('1', 'XXX', '77895412545', '2', '881', null, null);

-- ----------------------------
-- Table structure for `bank_trans`
-- ----------------------------
DROP TABLE IF EXISTS `bank_trans`;
CREATE TABLE `bank_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `trans_type` int(11) DEFAULT NULL,
  `amount` float(11,0) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bank_trans
-- ----------------------------
INSERT INTO `bank_trans` VALUES ('13', '2020-11-06 09:11:35', '1', 'Adjustment out', '2', '-50', '1', null);
INSERT INTO `bank_trans` VALUES ('14', '2020-11-06 09:11:39', '1', 'Adjustment in', '1', '90', '1', null);
INSERT INTO `bank_trans` VALUES ('15', '2020-11-06 09:11:39', '1', 'Adjustment out', '2', '-90', '1', null);
INSERT INTO `bank_trans` VALUES ('16', '2020-11-06 09:11:39', '1', 'Adjustment out', '2', '-240', '1', null);
INSERT INTO `bank_trans` VALUES ('17', '2020-11-06 09:11:40', '1', 'Adjustment out', '2', '-240', '1', null);
INSERT INTO `bank_trans` VALUES ('18', '2020-11-06 09:11:41', '1', 'Adjustment out', '2', '-480', '1', null);
INSERT INTO `bank_trans` VALUES ('19', '2020-11-06 16:11:00', '1', 'Member deposit', '1', '0', '1', null);
INSERT INTO `bank_trans` VALUES ('20', '2020-11-06 16:11:06', '1', 'Member deposit', '1', '0', '1', null);
INSERT INTO `bank_trans` VALUES ('21', '2020-11-06 16:11:09', '1', 'Member deposit', '1', '0', '1', null);
INSERT INTO `bank_trans` VALUES ('22', '2020-11-06 16:11:11', '1', 'Member deposit', '1', '50', '1', null);
INSERT INTO `bank_trans` VALUES ('23', '2020-11-06 16:11:11', '1', 'Member withdraw', '2', '-50', '1', null);
INSERT INTO `bank_trans` VALUES ('24', '2020-11-06 16:11:12', '1', 'Member withdraw', '2', '-50', '1', null);
INSERT INTO `bank_trans` VALUES ('25', '2020-11-06 16:11:13', '1', 'capital', '1', '-240', '1', null);
INSERT INTO `bank_trans` VALUES ('26', '2020-11-06 16:11:14', '1', 'capital', '2', '-90', '1', null);
INSERT INTO `bank_trans` VALUES ('27', '2020-11-06 10:11:16', '2', 'Delete withdraw member account', '1', '50', '1', null);
INSERT INTO `bank_trans` VALUES ('28', '2020-11-06 10:11:18', '1', 'Delete withdraw member account', '1', '50', '1', null);
INSERT INTO `bank_trans` VALUES ('29', '2020-11-06 16:11:18', '1', 'Member deposit', '1', '90', '1', null);
INSERT INTO `bank_trans` VALUES ('30', '2020-11-06 10:11:19', '1', 'Delete capital', '2', '-90', '1', null);
INSERT INTO `bank_trans` VALUES ('31', '2020-11-06 10:11:20', '1', 'Delete capital', '1', '-240', '1', null);
INSERT INTO `bank_trans` VALUES ('32', '2020-11-06 16:11:21', '1', 'capital', '2', '-10', '1', null);
INSERT INTO `bank_trans` VALUES ('33', '2020-11-06 10:11:21', '1', 'Delete capital', '1', '10', '1', null);
INSERT INTO `bank_trans` VALUES ('34', '2020-11-10 21:11:19', '1', 'Member deposit', '1', '40', '1', null);
INSERT INTO `bank_trans` VALUES ('35', '2020-11-21 12:48:30', '1', 'capital', '2', '-69', '1', null);
INSERT INTO `bank_trans` VALUES ('36', '2020-11-21 12:57:30', '1', 'Member deposit', '1', '9', '1', null);
INSERT INTO `bank_trans` VALUES ('37', '2020-11-21 12:58:34', '1', 'Member withdraw', '2', '-9', '1', null);

-- ----------------------------
-- Table structure for `capital`
-- ----------------------------
DROP TABLE IF EXISTS `capital`;
CREATE TABLE `capital` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime DEFAULT NULL,
  `list` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` float(11,0) DEFAULT NULL,
  `total` float(11,0) DEFAULT NULL,
  `expend_date` datetime DEFAULT NULL,
  `cashier_name` varchar(255) DEFAULT NULL,
  `company_bank_account_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of capital
-- ----------------------------
INSERT INTO `capital` VALUES ('11', '2020-11-21 12:48:30', 'ไก่ทอด', '1', '69', '-69', '2020-11-21 00:00:00', 'ทดสอบ นะครับ', '1', '1', '1');

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL,
  `is_level2` int(1) DEFAULT NULL,
  `id_card_photo` varchar(255) DEFAULT NULL,
  `bank_photo` varchar(255) DEFAULT NULL,
  `member_type` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `active_date` datetime DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', 'Forex01', 'fdfdxx', '2020-05-01 00:00:00', '09877636727', '2', '66666666660', '066669', '1', '1603295734.jpg', '', null, '1', '2020-10-11 13:49:03', null, null, null, null);
INSERT INTO `member` VALUES ('2', 'Forex001', 'นิรันดร์ วังญาติ', '2020-10-22 00:00:00', '0860063601', '2', '3455555', '323232', '1', '1603346979.jpg', '', null, '1', '2020-10-21 13:49:06', null, null, null, null);
INSERT INTO `member` VALUES ('4', 'Forex002', 'Ax2010', '1970-01-01 00:00:00', '0888898765', '2', '7789541254', '100100', '1', '', 'aHR0cHM6Ly9zLmlzYW5vb2suY29tL3RyLzAvdWQvMjgzLzE0MTkwMDkvMTQxOTAwOS0yMDIwMDExNDA5NDk0MC04YjMwMmU0LmpwZw==.jpg', null, '1', '2020-10-13 13:49:09', null, null, null, null);
INSERT INTO `member` VALUES ('5', 'TEST02', 'TEST02', '1970-01-01 00:00:00', '+66.8600636', '2', '3434343434343', '6666', '0', '', '', null, '1', '2020-10-13 21:10:35', null, null, null, null);
INSERT INTO `member` VALUES ('7', 'fdfd', 'santi99', '2020-12-19 00:00:00', 'fdfd', '2', 'fdfdfffdfd', '0', '0', '', '', 'SKM', '1', '2020-10-14 09:02:48', null, null, null, null);
INSERT INTO `member` VALUES ('9', 'ZXX', 'dfdfd', '2020-10-02 00:00:00', '4555555', '2', '3233333', '323232323', '1', '', '', null, '1', '2020-10-26 09:22:52', null, '1', null, null);
INSERT INTO `member` VALUES ('10', 'ccc', 'cccxx', '2020-10-26 00:00:00', '5', '2', '5', '45454', '1', '', '', null, '1', '2020-10-26 15:22:47', null, '1', null, null);
INSERT INTO `member` VALUES ('11', 'zaaa', 'aaa', '2020-10-12 00:00:00', '6777', '2', '33333', '34343', '0', '', '', null, '1', '2020-10-26 15:44:25', null, '1', null, null);
INSERT INTO `member` VALUES ('14', 'santi99', 'aaaadsd', '2020-11-24 00:00:00', '5656565', '2', '55555', '66564', '0', '', '', 'SKM', '1', '2020-11-17 20:40:33', null, '1', null, null);

-- ----------------------------
-- Table structure for `member_account`
-- ----------------------------
DROP TABLE IF EXISTS `member_account`;
CREATE TABLE `member_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `active_status` int(1) DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `cash_in` float(11,0) DEFAULT NULL,
  `cash_out` float(11,0) DEFAULT NULL,
  `net_win` float(11,0) DEFAULT NULL,
  `turnover` float(11,0) DEFAULT NULL,
  `bank_account_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(2) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member_account
-- ----------------------------
INSERT INTO `member_account` VALUES ('3', null, '2020-10-09 15:10:54', '1', null, '1', '500', '0', '500', '0', null, '1602232854', null, null, null);
INSERT INTO `member_account` VALUES ('4', null, '2020-10-09 15:10:55', '2', null, '1', '700', '0', '700', '0', null, '1602232855', null, null, null);
INSERT INTO `member_account` VALUES ('5', null, '2020-10-09 16:10:00', '2', null, '0', '0', '0', '0', '0', null, '1602236400', null, null, null);
INSERT INTO `member_account` VALUES ('10', null, '2020-10-12 10:10:15', '4', null, '1', '1000', '0', '1000', '0', null, '1602474015', null, null, null);
INSERT INTO `member_account` VALUES ('12', null, '2020-10-12 10:10:16', '4', null, '1', '0', '0', '0', '5000', null, '1602474016', null, null, null);
INSERT INTO `member_account` VALUES ('13', null, '2020-10-12 10:10:16', '4', null, '1', '0', '0', '0', '890', null, '1602474016', null, null, null);
INSERT INTO `member_account` VALUES ('16', null, '2020-10-12 13:10:00', '4', null, '0', '0', '0', '0', '1000', null, '1602484800', null, null, null);
INSERT INTO `member_account` VALUES ('17', null, '2020-10-12 13:10:05', '4', null, '0', '0', '0', '0', '500', null, '1602484805', null, null, null);
INSERT INTO `member_account` VALUES ('19', null, '2020-10-14 10:22:27', '7', null, '1', '100', '0', '100', '0', null, '1602645747', null, null, null);
INSERT INTO `member_account` VALUES ('21', null, '2020-10-14 11:45:09', '7', null, '1', '900', '0', '900', '0', null, '1602650709', null, null, null);
INSERT INTO `member_account` VALUES ('22', null, '2020-10-14 11:52:05', '7', null, '1', '500', '0', '500', '0', null, '1602651125', null, null, null);
INSERT INTO `member_account` VALUES ('23', null, '2020-10-14 11:53:42', '7', null, '1', '700', '0', '700', '0', null, '1602651222', null, null, null);
INSERT INTO `member_account` VALUES ('24', null, '2020-10-14 11:54:48', '7', null, '1', '900', '0', '900', '0', null, '1602651288', null, null, null);
INSERT INTO `member_account` VALUES ('25', null, '2020-10-14 11:55:55', '7', null, '1', '600', '0', '600', '0', null, '1602651355', null, null, null);
INSERT INTO `member_account` VALUES ('26', null, '2020-10-14 11:56:30', '7', null, '1', '190', '0', '190', '0', null, '1602651390', null, null, null);
INSERT INTO `member_account` VALUES ('28', null, '2020-10-14 13:47:44', '1', null, '1', '200', '0', '200', '0', null, '1602658064', null, null, null);
INSERT INTO `member_account` VALUES ('29', null, '2020-10-14 13:57:55', '7', null, '1', '100', '0', '100', '0', null, '1602658675', null, null, null);
INSERT INTO `member_account` VALUES ('30', null, '2020-10-26 09:23:42', '9', null, '0', '0', '0', '0', '0', null, '1603679022', '1', null, null);
INSERT INTO `member_account` VALUES ('31', null, '2020-10-26 09:28:17', '9', null, '0', '0', '0', '0', '0', null, '1603679297', '1', null, null);
INSERT INTO `member_account` VALUES ('32', null, '2020-10-26 15:34:15', '10', null, '0', '0', '0', '0', '500', null, '1603701255', '1', null, null);
INSERT INTO `member_account` VALUES ('33', null, '2020-10-26 15:34:27', '10', null, '1', '200', '0', '200', '0', null, '1603701267', '1', null, null);
INSERT INTO `member_account` VALUES ('34', null, '2020-10-26 15:41:21', '10', null, '0', '0', '600', '-600', '0', null, '1603701681', '1', null, null);
INSERT INTO `member_account` VALUES ('35', null, '2020-10-26 15:41:53', '10', null, '1', '90', '0', '90', '0', null, '1603701713', '1', null, null);
INSERT INTO `member_account` VALUES ('36', null, '2020-10-26 15:42:35', '10', null, '1', '800', '0', '800', '0', null, '1603701755', '1', null, null);
INSERT INTO `member_account` VALUES ('39', null, '2020-11-06 16:00:37', '4', null, '0', '500', '0', '500', '0', '1', '1604653237', '1', null, null);
INSERT INTO `member_account` VALUES ('40', null, '2020-11-06 16:06:50', '11', null, '0', '200', '0', '200', '0', '1', '1604653610', '1', null, null);
INSERT INTO `member_account` VALUES ('41', null, '2020-11-06 16:09:47', '9', null, '0', '2800', '0', '2800', '0', '1', '1604653787', '1', null, null);
INSERT INTO `member_account` VALUES ('42', null, '2020-11-06 16:11:21', '11', null, '0', '50', '0', '50', '0', '1', '1604653881', '1', null, null);
INSERT INTO `member_account` VALUES ('43', null, '2020-11-06 16:11:56', '11', null, '0', '0', '50', '-50', '0', '1', '1604653916', '1', null, null);
INSERT INTO `member_account` VALUES ('44', null, '2020-11-06 16:12:51', '11', null, '0', '0', '50', '-50', '0', '1', '1604653971', '1', null, null);
INSERT INTO `member_account` VALUES ('45', null, '2020-11-06 16:18:30', '11', null, '0', '90', '0', '90', '0', '1', '1604654310', '1', null, null);
INSERT INTO `member_account` VALUES ('46', null, '2020-11-10 21:19:52', '11', null, '0', '40', '0', '40', '0', '1', '1605017992', '1', null, null);
INSERT INTO `member_account` VALUES ('47', null, '2020-11-21 12:57:30', '14', null, '1', '9', '0', '9', '0', '1', '1605938250', '1', null, null);
INSERT INTO `member_account` VALUES ('48', null, '2020-11-21 12:58:34', '14', null, '0', '0', '9', '-9', '0', '1', '1605938314', '1', null, null);

-- ----------------------------
-- Table structure for `position_user`
-- ----------------------------
DROP TABLE IF EXISTS `position_user`;
CREATE TABLE `position_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_member` int(1) DEFAULT NULL,
  `is_accounting` int(1) DEFAULT NULL,
  `is_promotion` int(1) DEFAULT NULL,
  `is_capital` int(1) DEFAULT NULL,
  `is_bank` int(1) DEFAULT NULL,
  `is_user` int(1) DEFAULT NULL,
  `is_position` int(1) DEFAULT NULL,
  `is_company_account` int(1) DEFAULT NULL,
  `is_statistics` int(1) DEFAULT NULL,
  `is_all` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of position_user
-- ----------------------------
INSERT INTO `position_user` VALUES ('1', 'Admin', 'System Administrator', null, null, null, null, null, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `position_user` VALUES ('2', 'Cashier', 'Cashier Employee', null, null, null, null, null, '0', '1', '0', '1', '0', '0', '0', null, null, '0');
INSERT INTO `position_user` VALUES ('3', 'Service', 'Service Employee', null, null, null, null, null, '1', '0', '0', '0', '1', '0', '0', '0', '1', '0');

-- ----------------------------
-- Table structure for `promotion`
-- ----------------------------
DROP TABLE IF EXISTS `promotion`;
CREATE TABLE `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promotion
-- ----------------------------
INSERT INTO `promotion` VALUES ('1', 'ปีใหม่', 'โปรรับปีใหม่ 2021', null, null, null, null, null);

-- ----------------------------
-- Table structure for `trans_logs`
-- ----------------------------
DROP TABLE IF EXISTS `trans_logs`;
CREATE TABLE `trans_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `member_name` varchar(255) DEFAULT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trans_logs
-- ----------------------------
INSERT INTO `trans_logs` VALUES ('5', 'member', '1', 'ccc', 'insert', '2020-10-26 15:22:47');
INSERT INTO `trans_logs` VALUES ('6', 'member', '1', '10', 'update', '2020-10-26 15:26:44');
INSERT INTO `trans_logs` VALUES ('7', 'accounting', '1', '10', 'insert', '2020-10-26 15:34:15');
INSERT INTO `trans_logs` VALUES ('8', 'accounting', '1', '10', 'insert', '2020-10-26 15:34:27');
INSERT INTO `trans_logs` VALUES ('9', 'accounting', '1', '10', 'insert', '2020-10-26 15:42:35');
INSERT INTO `trans_logs` VALUES ('10', 'member', '1', 'aaa', 'insert', '2020-10-26 15:44:25');
INSERT INTO `trans_logs` VALUES ('11', 'accounting', '1', 'aaa', 'insert', '2020-11-01 15:56:28');
INSERT INTO `trans_logs` VALUES ('12', 'accounting', '1', 'aaa', 'insert', '2020-11-01 16:10:13');
INSERT INTO `trans_logs` VALUES ('13', 'accounting', '1', 'Ax2010', 'insert', '2020-11-06 16:00:37');
INSERT INTO `trans_logs` VALUES ('14', 'accounting', '1', 'aaa', 'insert', '2020-11-06 16:06:50');
INSERT INTO `trans_logs` VALUES ('15', 'accounting', '1', 'dfdfd', 'insert', '2020-11-06 16:09:47');
INSERT INTO `trans_logs` VALUES ('16', 'accounting', '1', 'aaa', 'insert', '2020-11-06 16:11:21');
INSERT INTO `trans_logs` VALUES ('17', 'accounting', '1', 'aaa', 'insert', '2020-11-06 16:11:56');
INSERT INTO `trans_logs` VALUES ('18', 'accounting', '1', 'aaa', 'insert', '2020-11-06 16:12:51');
INSERT INTO `trans_logs` VALUES ('19', 'accounting', '1', 'aaa', 'insert', '2020-11-06 16:18:30');
INSERT INTO `trans_logs` VALUES ('20', 'accounting', '1', 'aaa', 'insert', '2020-11-10 21:19:52');
INSERT INTO `trans_logs` VALUES ('21', 'member', '1', 'dfdfddf', 'insert', '2020-11-17 20:05:37');
INSERT INTO `trans_logs` VALUES ('22', 'member', '1', '', 'delete', '2020-11-17 14:05:52');
INSERT INTO `trans_logs` VALUES ('23', 'member', '1', '676767', 'insert', '2020-11-17 20:08:01');
INSERT INTO `trans_logs` VALUES ('24', 'member', '1', '676767', 'update', '2020-11-17 20:08:38');
INSERT INTO `trans_logs` VALUES ('25', 'member', '1', '', 'delete', '2020-11-17 14:09:43');
INSERT INTO `trans_logs` VALUES ('26', 'member', '1', 'aaaadsd', 'insert', '2020-11-17 20:40:33');
INSERT INTO `trans_logs` VALUES ('27', 'accounting', '1', 'aaaadsd', 'insert', '2020-11-21 12:57:30');
INSERT INTO `trans_logs` VALUES ('28', 'accounting', '1', 'aaaadsd', 'insert', '2020-11-21 12:58:34');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `position_id` int(2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Administrator', 'admin', '25d55ad283aa400af464c76d713c07ad', '1', '1', null, null, null, null);
INSERT INTO `user` VALUES ('3', 'user01', 'user01', 'e10adc3949ba59abbe56e057f20f883e', '3', '1', null, null, null, null);
