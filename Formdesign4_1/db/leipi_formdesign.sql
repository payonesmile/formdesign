/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : leipi_formdesign

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-08-09 23:03:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `leipi_foreign_test`
-- ----------------------------
DROP TABLE IF EXISTS `leipi_foreign_test`;
CREATE TABLE `leipi_foreign_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leipi_foreign_test
-- ----------------------------
INSERT INTO `leipi_foreign_test` VALUES ('13', '52', '32333', '0', '1407556818', '1407338095');
INSERT INTO `leipi_foreign_test` VALUES ('14', '52', '55555', '0', '1407557049', '1407556896');

-- ----------------------------
-- Table structure for `leipi_form`
-- ----------------------------
DROP TABLE IF EXISTS `leipi_form`;
CREATE TABLE `leipi_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL DEFAULT '' COMMENT '表单名称',
  `form_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '表单描述',
  `content` text NOT NULL COMMENT '表单原html模板未经处理的',
  `content_parse` text NOT NULL COMMENT '表单替换的模板 经过处理',
  `content_data` text NOT NULL COMMENT '表单中的字段数据',
  `fields` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '字段总数',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'is_del',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leipi_form
-- ----------------------------
INSERT INTO `leipi_form` VALUES ('52', '示例表', '示例', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><span style=\"font-size: 24px;\">示例表</span></p><table class=\"table table-bordered\"><tbody><tr class=\"firstRow\"><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">文本框</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"227\"><input style=\"text-align: left; width: 150px;\" title=\"文本框\" value=\"雷劈网\" name=\"data_12\" orgheight=\"\" orgwidth=\"150\" orgalign=\"left\" orgfontsize=\"\" orghide=\"0\" leipiplugins=\"text\" orgtype=\"text\"/></td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">下拉菜单</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"312\">{|-<span leipiplugins=\"select\"><select name=\"data_13\" title=\"下拉菜单\" leipiplugins=\"select\" size=\"1\" orgwidth=\"150\" style=\"width: 150px;\"><option value=\"下拉\">下拉</option><option value=\"菜单\">菜单</option></select>&nbsp;&nbsp;</span>-|}</td></tr><tr><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">单选</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"41\">{|-<span leipiplugins=\"radios\" name=\"data_14\" title=\"单选\"><input type=\"radio\" name=\"data_14\" value=\"单选2\"  checked/>单选2&nbsp;<input type=\"radio\" name=\"data_14\" value=\"单选1\"  />单选1&nbsp;</span>-|}</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">复选</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"312\">{|-<span leipiplugins=\"checkboxs\" title=\"复选\"><input type=\"checkbox\" name=\"data_16\" value=\"复选2\" />复选2&nbsp;<input type=\"checkbox\" name=\"data_15\" value=\"复选1\" checked/>复选1&nbsp;<input type=\"checkbox\" name=\"data_17\" value=\"复选3\" />复选3&nbsp;</span>-|}</td></tr><tr><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">宏控件</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"41\"><input name=\"data_18\" type=\"text\" value=\"{macros}\" title=\"宏控件\" leipiplugins=\"macros\" orgtype=\"sys_date_cn\" orghide=\"0\" orgfontsize=\"12\" orgwidth=\"150\" style=\"font-size: 12px; width: 150px;\"/></td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">二维码</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"312\"><img name=\"data_19\" title=\"雷劈网\" value=\"http://www.leipi.org\" orgtype=\"url\" leipiplugins=\"qrcode\" src=\"/Public/js/ueditor/formdesign/images/qrcode.gif\" orgwidth=\"40\" orgheight=\"40\" style=\"width: 40px; height: 40px;\"/></td></tr></tbody></table><p><textarea title=\"多行文本\" name=\"data_20\" leipiplugins=\"textarea\" value=\"\" orgrich=\"0\" orgfontsize=\"12\" orgwidth=\"600\" orgheight=\"80\" style=\"font-size:12px;width:600px;height:80px;\"></textarea></p><p><img name=\"data_21\" title=\"进度条\" leipiplugins=\"progressbar\" orgvalue=\"20\" orgsigntype=\"progress-info\" src=\"/Public/js/ueditor/formdesign/images/progressbar.gif\"/></p>', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><span style=\"font-size: 24px;\">示例表</span></p><table class=\"table table-bordered\"><tbody><tr class=\"firstRow\"><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">文本框</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"227\">{data_12}</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">下拉菜单</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"312\"><span leipiplugins=\"select\">{data_13}&nbsp;&nbsp;</span></td></tr><tr><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">单选</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"41\">{data_14}</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">复选</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"312\">{checkboxs_0}</td></tr><tr><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\">宏控件</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"41\">{data_18}</td><td valign=\"top\" style=\"word-break: break-all; border-color: rgb(221, 221, 221);\" width=\"85\">二维码</td><td valign=\"top\" style=\"border-color: rgb(221, 221, 221);\" width=\"312\">{data_19}</td></tr></tbody></table><p>{data_20}</p><p>{data_21}</p>', 'a:8:{i:0;a:12:{s:5:\"style\";s:31:\"text-align: left; width: 150px;\";s:5:\"title\";s:9:\"文本框\";s:5:\"value\";s:9:\"雷劈网\";s:4:\"name\";s:7:\"data_12\";s:9:\"orgheight\";s:0:\"\";s:8:\"orgwidth\";s:3:\"150\";s:8:\"orgalign\";s:4:\"left\";s:11:\"orgfontsize\";s:0:\"\";s:7:\"orghide\";s:1:\"0\";s:12:\"leipiplugins\";s:4:\"text\";s:7:\"orgtype\";s:4:\"text\";s:7:\"content\";s:205:\"<input style=\"text-align: left; width: 150px;\" title=\"文本框\" value=\"雷劈网\" name=\"data_12\" orgheight=\"\" orgwidth=\"150\" orgalign=\"left\" orgfontsize=\"\" orghide=\"0\" leipiplugins=\"text\" orgtype=\"text\"/>\";}i:1;a:8:{s:4:\"name\";s:7:\"data_13\";s:5:\"title\";s:12:\"下拉菜单\";s:12:\"leipiplugins\";s:6:\"select\";s:4:\"size\";s:1:\"1\";s:8:\"orgwidth\";s:3:\"150\";s:5:\"style\";s:13:\"width: 150px;\";s:5:\"value\";s:13:\"下拉,菜单\";s:7:\"content\";s:197:\"<select name=\"data_13\" title=\"下拉菜单\" leipiplugins=\"select\" size=\"1\" orgwidth=\"150\" style=\"width: 150px;\"><option value=\"下拉\">下拉</option><option value=\"菜单\">菜单</option></select>\";}i:2;a:7:{s:12:\"leipiplugins\";s:6:\"radios\";s:4:\"name\";s:7:\"data_14\";s:5:\"title\";s:6:\"单选\";s:10:\"orgchecked\";s:11:\"orgchecked0\";s:5:\"value\";s:15:\"单选2,单选1\";s:7:\"content\";s:206:\"<span leipiplugins=\"radios\" name=\"data_14\" title=\"单选\"><input type=\"radio\" name=\"data_14\" value=\"单选2\"  checked/>单选2&nbsp;<input type=\"radio\" name=\"data_14\" value=\"单选1\"  />单选1&nbsp;</span>\";s:7:\"options\";a:2:{i:0;a:4:{s:4:\"name\";s:7:\"data_14\";s:5:\"value\";s:7:\"单选2\";s:7:\"checked\";s:7:\"checked\";s:4:\"type\";s:5:\"radio\";}i:1;a:3:{s:4:\"name\";s:7:\"data_14\";s:5:\"value\";s:7:\"单选1\";s:4:\"type\";s:5:\"radio\";}}}i:3;a:8:{s:12:\"leipiplugins\";s:9:\"checkboxs\";s:5:\"title\";s:6:\"复选\";s:10:\"orgchecked\";s:11:\"orgchecked0\";s:10:\"parse_name\";s:11:\"checkboxs_0\";s:4:\"name\";s:23:\"data_16,data_15,data_17\";s:5:\"value\";s:23:\"复选2,复选1,复选3\";s:7:\"content\";s:267:\"<span leipiplugins=\"checkboxs\" title=\"复选\"><input type=\"checkbox\" name=\"data_16\" value=\"复选2\" />复选2&nbsp;<input type=\"checkbox\" name=\"data_15\" value=\"复选1\" checked/>复选1&nbsp;<input type=\"checkbox\" name=\"data_17\" value=\"复选3\" />复选3&nbsp;</span>\";s:7:\"options\";a:3:{i:0;a:3:{s:4:\"name\";s:7:\"data_16\";s:5:\"value\";s:7:\"复选2\";s:4:\"type\";s:8:\"checkbox\";}i:1;a:4:{s:4:\"name\";s:7:\"data_15\";s:5:\"value\";s:7:\"复选1\";s:7:\"checked\";s:7:\"checked\";s:4:\"type\";s:8:\"checkbox\";}i:2;a:3:{s:4:\"name\";s:7:\"data_17\";s:5:\"value\";s:7:\"复选3\";s:4:\"type\";s:8:\"checkbox\";}}}i:4;a:11:{s:4:\"name\";s:7:\"data_18\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:8:\"{macros}\";s:5:\"title\";s:9:\"宏控件\";s:12:\"leipiplugins\";s:6:\"macros\";s:7:\"orgtype\";s:11:\"sys_date_cn\";s:7:\"orghide\";s:1:\"0\";s:11:\"orgfontsize\";s:2:\"12\";s:8:\"orgwidth\";s:3:\"150\";s:5:\"style\";s:30:\"font-size: 12px; width: 150px;\";s:7:\"content\";s:197:\"<input name=\"data_18\" type=\"text\" value=\"{macros}\" title=\"宏控件\" leipiplugins=\"macros\" orgtype=\"sys_date_cn\" orghide=\"0\" orgfontsize=\"12\" orgwidth=\"150\" style=\"font-size: 12px; width: 150px;\"/>\";}i:5;a:10:{s:4:\"name\";s:7:\"data_19\";s:5:\"title\";s:9:\"雷劈网\";s:5:\"value\";s:20:\"http://www.leipi.org\";s:7:\"orgtype\";s:3:\"url\";s:12:\"leipiplugins\";s:6:\"qrcode\";s:3:\"src\";s:47:\"/Public/js/ueditor/formdesign/images/qrcode.gif\";s:8:\"orgwidth\";s:2:\"40\";s:9:\"orgheight\";s:2:\"40\";s:5:\"style\";s:26:\"width: 40px; height: 40px;\";s:7:\"content\";s:222:\"<img name=\"data_19\" title=\"雷劈网\" value=\"http://www.leipi.org\" orgtype=\"url\" leipiplugins=\"qrcode\" src=\"/Public/js/ueditor/formdesign/images/qrcode.gif\" orgwidth=\"40\" orgheight=\"40\" style=\"width: 40px; height: 40px;\"/>\";}i:6;a:10:{s:5:\"title\";s:12:\"多行文本\";s:4:\"name\";s:7:\"data_20\";s:12:\"leipiplugins\";s:8:\"textarea\";s:5:\"value\";s:0:\"\";s:7:\"orgrich\";s:1:\"0\";s:11:\"orgfontsize\";s:2:\"12\";s:8:\"orgwidth\";s:3:\"600\";s:9:\"orgheight\";s:2:\"80\";s:5:\"style\";s:39:\"font-size:12px;width:600px;height:80px;\";s:7:\"content\";s:197:\"<textarea title=\"多行文本\" name=\"data_20\" leipiplugins=\"textarea\" value=\"\" orgrich=\"0\" orgfontsize=\"12\" orgwidth=\"600\" orgheight=\"80\" style=\"font-size:12px;width:600px;height:80px;\"></textarea>\";}i:7;a:7:{s:4:\"name\";s:7:\"data_21\";s:5:\"title\";s:9:\"进度条\";s:12:\"leipiplugins\";s:11:\"progressbar\";s:8:\"orgvalue\";s:2:\"20\";s:11:\"orgsigntype\";s:13:\"progress-info\";s:3:\"src\";s:52:\"/Public/js/ueditor/formdesign/images/progressbar.gif\";s:7:\"content\";s:167:\"<img name=\"data_21\" title=\"进度条\" leipiplugins=\"progressbar\" orgvalue=\"20\" orgsigntype=\"progress-info\" src=\"/Public/js/ueditor/formdesign/images/progressbar.gif\"/>\";}}', '21', '0', '1407556981', '1407338057');

-- ----------------------------
-- Table structure for `leipi_form_data_52`
-- ----------------------------
DROP TABLE IF EXISTS `leipi_form_data_52`;
CREATE TABLE `leipi_form_data_52` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `foreign_id` int(10) unsigned NOT NULL DEFAULT '0',
  `data_1` varchar(255) NOT NULL DEFAULT '',
  `data_2` varchar(255) NOT NULL DEFAULT '',
  `data_3` varchar(255) NOT NULL DEFAULT '',
  `data_5` varchar(255) NOT NULL DEFAULT '',
  `data_6` varchar(255) NOT NULL DEFAULT '',
  `data_7` varchar(255) NOT NULL DEFAULT '',
  `data_8` varchar(255) NOT NULL DEFAULT '',
  `data_9` varchar(255) NOT NULL DEFAULT '',
  `data_10` text NOT NULL,
  `data_11` varchar(255) NOT NULL DEFAULT '',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `data_12` varchar(255) NOT NULL DEFAULT '',
  `data_13` varchar(255) NOT NULL DEFAULT '',
  `data_14` varchar(255) NOT NULL DEFAULT '',
  `data_15` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `data_16` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `data_17` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `data_18` varchar(255) NOT NULL DEFAULT '',
  `data_19` varchar(255) NOT NULL DEFAULT '',
  `data_20` text NOT NULL,
  `data_21` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of leipi_form_data_52
-- ----------------------------
INSERT INTO `leipi_form_data_52` VALUES ('1', '0', '13', '雷劈网', '菜单', '单选2', '0', '1', '1', '2014年8月7日', 'a:2:{s:5:\"value\";s:28:\"http://formdesign.leipi.org/\";s:10:\"qrcode_url\";s:45:\"/Uploads/90e1157fb525881f97148e8e9740ed5e.png\";}', '夺3333', '50', '0', '1407556818', '1407338095', '2222', '下拉', '单选2', '1', '0', '1', '2014年8月9日', 'a:2:{s:5:\"value\";s:3:\"333\";s:10:\"qrcode_url\";s:45:\"/Uploads/310dcbbf4cce62f762a2aaa148d556bd.png\";}', '顶替', '20');
INSERT INTO `leipi_form_data_52` VALUES ('2', '0', '14', '', '', '', '', '', '', '', '', '', '', '0', '1407557049', '1407556896', '雷劈网5', '菜单', '单选2', '1', '0', '1', '2014年8月8日', 'a:2:{s:5:\"value\";s:20:\"http://form/index.ph\";s:10:\"qrcode_url\";s:45:\"/Uploads/1a4363a0562a619d95fa661d80c19e01.png\";}', '顶替333333', '50');
