-- MySQL dump 10.13  Distrib 5.6.44, for Linux (x86_64)
--
-- Host: localhost    Database: lanrenzhijia
-- ------------------------------------------------------
-- Server version	5.6.44-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `uid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '密码',
  `icon` varchar(255) DEFAULT NULL COMMENT '头像',
  `group` int(11) DEFAULT '1' COMMENT '所属分组  1普通用户（小程序管理员【分配，未分配】）    2总管理员',
  `lastloginip` varchar(20) DEFAULT NULL,
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(2:无效,1:有效)',
  `updatetime` int(10) NOT NULL DEFAULT '0',
  `num` int(11) DEFAULT '0' COMMENT '0不做限制',
  `jxs` int(11) DEFAULT '0',
  `overtime` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '1' COMMENT '0不允许1允许',
  `type` varchar(100) NOT NULL DEFAULT '' COMMENT '代理商可以使用的业务类型',
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '代理商余额',
  `is_del` int(1) NOT NULL DEFAULT '0' COMMENT '是否被删除  0  没有   1  已被删除',
  PRIMARY KEY (`uid`) USING BTREE,
  KEY `username` (`username`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','7fef6171469e80d32c0559f88b377245','http://2.cnhjdy.net/upimages/20200227/b63fbc72e3ba38e2940ae8080298be2c901.jpg',2,'1996554452',1582803305,'8139306@qq.com','15524110595','站码之家源码','',1,0,0,0,NULL,1,'',0.00,0),(2,'wangshoujian','e10adc3949ba59abbe56e057f20f883e',NULL,1,'1006805110',1575534413,'865342423@qq.com','18632565590','王守建','',1,1575432349,0,1,NULL,1,'',0.00,0),(3,'zhanglichao','e10adc3949ba59abbe56e057f20f883e',NULL,3,'1877177717',1575713618,'','13230162576','张立超','',1,1575436489,0,1,1796313600,1,'a:1:{i:0;s:1:\"0\";}',12000.00,0),(4,'wangli','e10adc3949ba59abbe56e057f20f883e',NULL,1,NULL,0,'865342423@qq.com','15232627159','王磊','',1,1575509044,0,NULL,NULL,1,'',0.00,0),(5,'yuejichuan','e10adc3949ba59abbe56e057f20f883e',NULL,1,NULL,0,'2829837915@qq.com','13230162576','岳冀川','',1,1575537230,0,3,NULL,1,'',0.00,0);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group`
--

DROP TABLE IF EXISTS `admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `listorder` (`listorder`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group`
--

LOCK TABLES `admin_group` WRITE;
/*!40000 ALTER TABLE `admin_group` DISABLE KEYS */;
INSERT INTO `admin_group` VALUES (1,'普通管理员','管理本用户的小程序','',0,1477622552),(2,'总管理员','管理所有用户及小程序','',0,1476067479),(3,'代理商','管理旗下生成的小程序','',0,1476067479);
/*!40000 ALTER TABLE `admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applet`
--

DROP TABLE IF EXISTS `applet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '小程序名称',
  `thumb` varchar(255) DEFAULT NULL COMMENT '小程序LOGO',
  `comment` varchar(255) DEFAULT NULL COMMENT '小程序描述',
  `appID` varchar(255) DEFAULT NULL,
  `appSecret` varchar(255) DEFAULT NULL COMMENT '秘钥',
  `mchid` varchar(255) DEFAULT NULL COMMENT '微信支付商户号',
  `signkey` varchar(255) DEFAULT NULL COMMENT '支付秘钥',
  `adminid` int(11) DEFAULT NULL,
  `jxs` int(11) DEFAULT '0',
  `dateline` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '0' COMMENT '0开发中   1正常使用',
  `xcxId` varchar(255) DEFAULT NULL,
  `sub_mchid` varchar(255) DEFAULT NULL,
  `identity` int(1) NOT NULL DEFAULT '1' COMMENT '1普通用户 2子商户',
  `baidu_appID` varchar(255) DEFAULT NULL COMMENT '百度小程序appid',
  `baidu_appSecret` varchar(255) DEFAULT NULL COMMENT '百度小程序appSecret',
  `baidu_xcxId` varchar(255) DEFAULT NULL COMMENT '百度小程序原始ID',
  `ali_appID` varchar(255) DEFAULT NULL COMMENT '支付宝小程序appid',
  `ali_appSecret` varchar(255) DEFAULT NULL COMMENT '支付宝小程序appSecret',
  `ali_xcxId` varchar(255) DEFAULT NULL COMMENT '支付宝小程序原始ID',
  `pay_time` int(10) DEFAULT '0' COMMENT '开通时长,时长套餐id',
  `end_time` int(11) DEFAULT '0' COMMENT '到期时间',
  `price` decimal(15,2) DEFAULT '0.00' COMMENT '订单价格',
  `type` varchar(100) DEFAULT '' COMMENT '业务类型',
  `overdue_date` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `combo_id` int(11) NOT NULL DEFAULT '0' COMMENT '套餐id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applet`
--

LOCK TABLES `applet` WRITE;
/*!40000 ALTER TABLE `applet` DISABLE KEYS */;
INSERT INTO `applet` VALUES (1,'站码之家官网小程序','/upimages/20200227/14002d40e6cfd1ab5d825e9630a4ef2929.jpg','小程序描述*小程序描述*小程序描述*小程序描述*小程序描述*小程序描述*','wxff10fc451972c04e','bd21921871598ff18d5108229e4cd605','1','D5PWQyQePnFc6aKXDh8K3XznWJCHpwWB',0,1,1538655399,0,'gh_5de863b43fd6',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,0,1729008000,0.00,'a:1:{i:0;s:1:\"0\";}',0,1),(2,'王守建的小程序','/upimages/20191204/5026dbd7fa4ecc020d90633cab05812a215.jpg','九牛网有限公司微信小程序官网',NULL,NULL,NULL,NULL,2,1,1575435783,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,0,1670083200,0.00,'a:1:{i:0;s:1:\"0\";}',0,1),(3,'王磊的小程序','/upimages/20191205/a2f4f45c8ceee9528ade4e5b19a48bc0341.jpg','王磊',NULL,NULL,NULL,NULL,4,3,1575509253,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,3,1654392453,2400.00,'a:1:{i:0;s:1:\"0\";}',0,6),(4,'全功能小程序',NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,1575625193,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,-2,1576229993,0.00,'a:1:{i:0;s:1:\"0\";}',0,7);
/*!40000 ALTER TABLE `applet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combo`
--

DROP TABLE IF EXISTS `combo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '套餐名称',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `combo_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '套餐简介',
  `node_id` text COMMENT '套餐权限ID',
  `icon` varchar(255) DEFAULT NULL COMMENT '套餐图标',
  `wx_price` int(10) NOT NULL DEFAULT '0' COMMENT '套餐微信价格',
  `baidu_price` int(10) NOT NULL DEFAULT '0' COMMENT '套餐百度价格',
  `ali_price` int(10) NOT NULL DEFAULT '0' COMMENT '套餐支付宝价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combo`
--

LOCK TABLES `combo` WRITE;
/*!40000 ALTER TABLE `combo` DISABLE KEYS */;
INSERT INTO `combo` VALUES (1,'多功能全行业小程序套餐',1538228844,0,'','a:147:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:1:\"9\";i:9;s:2:\"10\";i:10;s:2:\"11\";i:11;s:2:\"12\";i:12;s:2:\"13\";i:13;s:2:\"14\";i:14;s:2:\"15\";i:15;s:2:\"17\";i:16;s:2:\"18\";i:17;s:2:\"19\";i:18;s:2:\"20\";i:19;s:2:\"21\";i:20;s:2:\"22\";i:21;s:2:\"23\";i:22;s:2:\"24\";i:23;s:2:\"25\";i:24;s:3:\"144\";i:25;s:2:\"26\";i:26;s:2:\"27\";i:27;s:2:\"28\";i:28;s:2:\"29\";i:29;s:2:\"30\";i:30;s:2:\"31\";i:31;s:2:\"32\";i:32;s:2:\"33\";i:33;s:2:\"34\";i:34;s:2:\"35\";i:35;s:2:\"36\";i:36;s:2:\"37\";i:37;s:2:\"38\";i:38;s:2:\"39\";i:39;s:2:\"40\";i:40;s:2:\"41\";i:41;s:3:\"149\";i:42;s:2:\"42\";i:43;s:2:\"43\";i:44;s:2:\"45\";i:45;s:2:\"46\";i:46;s:2:\"47\";i:47;s:2:\"48\";i:48;s:2:\"49\";i:49;s:2:\"50\";i:50;s:2:\"51\";i:51;s:2:\"52\";i:52;s:2:\"53\";i:53;s:2:\"54\";i:54;s:2:\"55\";i:55;s:2:\"56\";i:56;s:2:\"57\";i:57;s:2:\"58\";i:58;s:2:\"59\";i:59;s:2:\"60\";i:60;s:2:\"61\";i:61;s:3:\"138\";i:62;s:3:\"147\";i:63;s:3:\"148\";i:64;s:2:\"62\";i:65;s:2:\"63\";i:66;s:2:\"64\";i:67;s:2:\"65\";i:68;s:2:\"66\";i:69;s:2:\"67\";i:70;s:2:\"68\";i:71;s:2:\"69\";i:72;s:2:\"70\";i:73;s:2:\"71\";i:74;s:2:\"72\";i:75;s:2:\"73\";i:76;s:2:\"74\";i:77;s:2:\"75\";i:78;s:2:\"76\";i:79;s:2:\"77\";i:80;s:2:\"78\";i:81;s:2:\"79\";i:82;s:2:\"80\";i:83;s:2:\"81\";i:84;s:2:\"82\";i:85;s:2:\"83\";i:86;s:2:\"84\";i:87;s:2:\"85\";i:88;s:2:\"86\";i:89;s:2:\"87\";i:90;s:2:\"88\";i:91;s:2:\"89\";i:92;s:2:\"90\";i:93;s:2:\"91\";i:94;s:2:\"92\";i:95;s:2:\"93\";i:96;s:2:\"94\";i:97;s:2:\"95\";i:98;s:2:\"96\";i:99;s:2:\"97\";i:100;s:2:\"98\";i:101;s:2:\"99\";i:102;s:3:\"100\";i:103;s:3:\"101\";i:104;s:3:\"102\";i:105;s:3:\"103\";i:106;s:3:\"104\";i:107;s:3:\"105\";i:108;s:3:\"106\";i:109;s:3:\"107\";i:110;s:3:\"108\";i:111;s:3:\"109\";i:112;s:3:\"110\";i:113;s:3:\"111\";i:114;s:3:\"112\";i:115;s:3:\"113\";i:116;s:3:\"114\";i:117;s:3:\"115\";i:118;s:3:\"116\";i:119;s:3:\"117\";i:120;s:3:\"118\";i:121;s:3:\"119\";i:122;s:3:\"120\";i:123;s:3:\"121\";i:124;s:3:\"122\";i:125;s:3:\"123\";i:126;s:3:\"124\";i:127;s:3:\"125\";i:128;s:3:\"126\";i:129;s:3:\"127\";i:130;s:3:\"128\";i:131;s:3:\"129\";i:132;s:3:\"130\";i:133;s:3:\"131\";i:134;s:3:\"132\";i:135;s:3:\"133\";i:136;s:3:\"134\";i:137;s:3:\"135\";i:138;s:3:\"136\";i:139;s:3:\"139\";i:140;s:3:\"140\";i:141;s:3:\"141\";i:142;s:3:\"142\";i:143;s:3:\"143\";i:144;s:3:\"145\";i:145;s:3:\"146\";i:146;s:3:\"137\";}',NULL,1200,0,0),(6,'商城功能套餐',1575534121,0,'','a:75:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"6\";i:5;s:1:\"7\";i:6;s:1:\"8\";i:7;s:2:\"11\";i:8;s:2:\"19\";i:9;s:2:\"20\";i:10;s:2:\"21\";i:11;s:2:\"22\";i:12;s:2:\"23\";i:13;s:2:\"24\";i:14;s:2:\"25\";i:15;s:3:\"144\";i:16;s:2:\"26\";i:17;s:2:\"27\";i:18;s:2:\"28\";i:19;s:2:\"29\";i:20;s:2:\"30\";i:21;s:2:\"31\";i:22;s:2:\"32\";i:23;s:2:\"33\";i:24;s:2:\"34\";i:25;s:2:\"35\";i:26;s:2:\"36\";i:27;s:2:\"37\";i:28;s:2:\"38\";i:29;s:3:\"148\";i:30;s:2:\"42\";i:31;s:2:\"43\";i:32;s:2:\"45\";i:33;s:2:\"46\";i:34;s:2:\"47\";i:35;s:2:\"54\";i:36;s:3:\"138\";i:37;s:2:\"62\";i:38;s:2:\"63\";i:39;s:2:\"64\";i:40;s:2:\"65\";i:41;s:2:\"66\";i:42;s:2:\"67\";i:43;s:2:\"68\";i:44;s:2:\"69\";i:45;s:2:\"70\";i:46;s:2:\"71\";i:47;s:2:\"72\";i:48;s:2:\"73\";i:49;s:2:\"75\";i:50;s:2:\"76\";i:51;s:2:\"77\";i:52;s:2:\"78\";i:53;s:2:\"79\";i:54;s:2:\"80\";i:55;s:2:\"81\";i:56;s:2:\"82\";i:57;s:2:\"83\";i:58;s:2:\"85\";i:59;s:2:\"86\";i:60;s:2:\"87\";i:61;s:2:\"88\";i:62;s:2:\"93\";i:63;s:2:\"94\";i:64;s:3:\"103\";i:65;s:3:\"104\";i:66;s:3:\"105\";i:67;s:3:\"106\";i:68;s:3:\"107\";i:69;s:3:\"108\";i:70;s:3:\"109\";i:71;s:3:\"110\";i:72;s:3:\"111\";i:73;s:3:\"112\";i:74;s:3:\"137\";}',NULL,3888,0,0),(7,'全功能小程序',1575625042,0,'','a:147:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:1:\"9\";i:9;s:2:\"10\";i:10;s:2:\"11\";i:11;s:2:\"12\";i:12;s:2:\"13\";i:13;s:2:\"14\";i:14;s:2:\"15\";i:15;s:2:\"17\";i:16;s:2:\"18\";i:17;s:2:\"19\";i:18;s:2:\"20\";i:19;s:2:\"21\";i:20;s:2:\"22\";i:21;s:2:\"23\";i:22;s:2:\"24\";i:23;s:2:\"25\";i:24;s:3:\"144\";i:25;s:2:\"26\";i:26;s:2:\"27\";i:27;s:2:\"28\";i:28;s:2:\"29\";i:29;s:2:\"30\";i:30;s:2:\"31\";i:31;s:2:\"32\";i:32;s:2:\"33\";i:33;s:2:\"34\";i:34;s:2:\"35\";i:35;s:2:\"36\";i:36;s:2:\"37\";i:37;s:2:\"38\";i:38;s:3:\"148\";i:39;s:2:\"39\";i:40;s:2:\"40\";i:41;s:2:\"41\";i:42;s:3:\"149\";i:43;s:2:\"42\";i:44;s:2:\"43\";i:45;s:2:\"45\";i:46;s:2:\"46\";i:47;s:2:\"47\";i:48;s:2:\"48\";i:49;s:2:\"49\";i:50;s:2:\"50\";i:51;s:2:\"51\";i:52;s:2:\"52\";i:53;s:2:\"53\";i:54;s:2:\"54\";i:55;s:2:\"55\";i:56;s:2:\"56\";i:57;s:2:\"57\";i:58;s:2:\"58\";i:59;s:2:\"59\";i:60;s:2:\"60\";i:61;s:2:\"61\";i:62;s:3:\"138\";i:63;s:3:\"147\";i:64;s:2:\"62\";i:65;s:2:\"63\";i:66;s:2:\"64\";i:67;s:2:\"65\";i:68;s:2:\"66\";i:69;s:2:\"67\";i:70;s:2:\"68\";i:71;s:2:\"69\";i:72;s:2:\"70\";i:73;s:2:\"71\";i:74;s:2:\"72\";i:75;s:2:\"73\";i:76;s:2:\"74\";i:77;s:2:\"75\";i:78;s:2:\"76\";i:79;s:2:\"77\";i:80;s:2:\"78\";i:81;s:2:\"79\";i:82;s:2:\"80\";i:83;s:2:\"81\";i:84;s:2:\"82\";i:85;s:2:\"83\";i:86;s:2:\"84\";i:87;s:2:\"85\";i:88;s:2:\"86\";i:89;s:2:\"87\";i:90;s:2:\"88\";i:91;s:2:\"89\";i:92;s:2:\"90\";i:93;s:2:\"91\";i:94;s:2:\"92\";i:95;s:2:\"93\";i:96;s:2:\"94\";i:97;s:2:\"95\";i:98;s:2:\"96\";i:99;s:2:\"97\";i:100;s:2:\"98\";i:101;s:2:\"99\";i:102;s:3:\"100\";i:103;s:3:\"101\";i:104;s:3:\"102\";i:105;s:3:\"103\";i:106;s:3:\"104\";i:107;s:3:\"105\";i:108;s:3:\"106\";i:109;s:3:\"107\";i:110;s:3:\"108\";i:111;s:3:\"109\";i:112;s:3:\"110\";i:113;s:3:\"111\";i:114;s:3:\"112\";i:115;s:3:\"113\";i:116;s:3:\"114\";i:117;s:3:\"115\";i:118;s:3:\"116\";i:119;s:3:\"117\";i:120;s:3:\"118\";i:121;s:3:\"119\";i:122;s:3:\"120\";i:123;s:3:\"121\";i:124;s:3:\"122\";i:125;s:3:\"123\";i:126;s:3:\"124\";i:127;s:3:\"125\";i:128;s:3:\"126\";i:129;s:3:\"127\";i:130;s:3:\"128\";i:131;s:3:\"129\";i:132;s:3:\"130\";i:133;s:3:\"131\";i:134;s:3:\"132\";i:135;s:3:\"133\";i:136;s:3:\"134\";i:137;s:3:\"135\";i:138;s:3:\"136\";i:139;s:3:\"139\";i:140;s:3:\"140\";i:141;s:3:\"141\";i:142;s:3:\"142\";i:143;s:3:\"143\";i:144;s:3:\"145\";i:145;s:3:\"146\";i:146;s:3:\"137\";}',NULL,12000,0,0);
/*!40000 ALTER TABLE `combo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_url`
--

DROP TABLE IF EXISTS `image_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appletid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_url`
--

LOCK TABLES `image_url` WRITE;
/*!40000 ALTER TABLE `image_url` DISABLE KEYS */;
INSERT INTO `image_url` VALUES (1,26,'http://cs.riyuanma.com/assetsj/pigefanxin/slide.jpg',1538652735,0);
/*!40000 ALTER TABLE `image_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_model`
--

DROP TABLE IF EXISTS `ims_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_model`
--

LOCK TABLES `ims_model` WRITE;
/*!40000 ALTER TABLE `ims_model` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_model_type`
--

DROP TABLE IF EXISTS `ims_model_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_model_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) DEFAULT NULL,
  `datas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_model_type`
--

LOCK TABLES `ims_model_type` WRITE;
/*!40000 ALTER TABLE `ims_model_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_model_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_about`
--

DROP TABLE IF EXISTS `ims_sudu8_page_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_about` (
  `content` mediumtext,
  `uniacid` int(11) NOT NULL,
  `header` int(11) DEFAULT '0',
  `tel_box` int(11) DEFAULT '0',
  `serv_box` int(11) DEFAULT '0',
  PRIMARY KEY (`uniacid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_about`
--

LOCK TABLES `ims_sudu8_page_about` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_about` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_about` VALUES ('<p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p><p><br/></p><p>这里是介绍内容</p>',1,1,1,1);
/*!40000 ALTER TABLE `ims_sudu8_page_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_art_nav`
--

DROP TABLE IF EXISTS `ims_sudu8_page_art_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_art_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_art_nav`
--

LOCK TABLES `ims_sudu8_page_art_nav` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_art_nav` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_art_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_art_navlist`
--

DROP TABLE IF EXISTS `ims_sudu8_page_art_navlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_art_navlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `bgcolor` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL COMMENT '1启用 2不启用',
  `num` int(11) NOT NULL,
  `textcolor` varchar(32) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_art_navlist`
--

LOCK TABLES `ims_sudu8_page_art_navlist` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_art_navlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_art_navlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_banner`
--

DROP TABLE IF EXISTS `ims_sudu8_page_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_banner` (
  `uniacid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL,
  `num` int(10) NOT NULL,
  `descp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_banner`
--

LOCK TABLES `ims_sudu8_page_banner` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_banner` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_banner` VALUES (1,8,'banner','/upimages/20191204/2e2990eb8dead8200910ca7b08355210642.jpg','',1,1,''),(1,7,'miniad','http://cs.riyuanma.com/assetsj/jiaju/tanchuang.jpg','/sudu8_page/listPro/listPro?cid=1646',1,99,'全部产品'),(1,9,'bigad','/upimages/20191207/197b6eb7938bf140cf1b6b8d28ea0dfa503.jpg','',1,0,''),(1,10,'banner','/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png','',1,0,'');
/*!40000 ALTER TABLE `ims_sudu8_page_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_base`
--

DROP TABLE IF EXISTS `ims_sudu8_page_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_base` (
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `index_style` varchar(255) DEFAULT NULL,
  `about_style` varchar(255) DEFAULT NULL,
  `prolist_style` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `about` text,
  `aboutCN` varchar(255) DEFAULT '门店介绍',
  `aboutCNen` varchar(255) DEFAULT 'About Store',
  `index_about_title` varchar(255) DEFAULT NULL,
  `catename` varchar(255) DEFAULT '产品 & 服务',
  `catenameen` varchar(255) DEFAULT 'Products and Services',
  `copyright` varchar(255) DEFAULT '技术支持：小程序科技',
  `copyimg` varchar(255) NOT NULL,
  `tel_b` varchar(255) DEFAULT NULL,
  `footer_style` varchar(255) DEFAULT NULL,
  `base_color` varchar(255) DEFAULT NULL,
  `base_color2` varchar(255) DEFAULT NULL,
  `index_pro_btn` varchar(255) DEFAULT NULL,
  `index_pro_lstyle` varchar(255) DEFAULT NULL,
  `index_pro_tstyle` varchar(255) DEFAULT NULL,
  `index_pro_ts_al` varchar(255) DEFAULT NULL,
  `base_color_t` text NOT NULL,
  `c_title` int(2) NOT NULL,
  `video` varchar(255) NOT NULL,
  `v_img` varchar(255) NOT NULL,
  `i_b_x_ts` int(2) NOT NULL,
  `i_b_y_ts` int(2) NOT NULL,
  `catename_x` varchar(255) NOT NULL,
  `catenameen_x` varchar(255) NOT NULL,
  `tel_box` int(1) NOT NULL,
  `tabbar_bg` char(10) NOT NULL,
  `tabbar_tc` char(10) NOT NULL,
  `tabbar` text NOT NULL,
  `tabnum` int(1) NOT NULL,
  `copy_do` int(1) NOT NULL,
  `copy_id` int(5) NOT NULL,
  `base_tcolor` varchar(10) NOT NULL,
  `color_bar` char(8) DEFAULT NULL,
  `c_b_bg` varchar(255) DEFAULT NULL,
  `c_b_btn` varchar(255) DEFAULT NULL,
  `i_b_x_iw` varchar(255) DEFAULT NULL,
  `form_index` int(1) DEFAULT NULL,
  `tabbar_tca` char(10) DEFAULT NULL,
  `tabbar_time` int(11) DEFAULT NULL,
  `config` varchar(1000) DEFAULT NULL,
  `tabbar_t` int(11) NOT NULL DEFAULT '1',
  `slide` varchar(2000) DEFAULT NULL,
  `hxmm` varchar(255) DEFAULT NULL,
  `logo2` varchar(255) DEFAULT NULL,
  `sharejf` varchar(255) DEFAULT NULL,
  `sharetype` int(1) DEFAULT NULL,
  `sharexz` int(11) DEFAULT NULL,
  `score_shoppay` int(11) DEFAULT NULL COMMENT '店内最大抵用积分',
  `spcatename` varchar(255) DEFAULT NULL,
  `spcatenameen` varchar(255) DEFAULT NULL,
  `sp_i_b_y_ts` int(1) NOT NULL DEFAULT '0',
  `sptj_max` int(11) NOT NULL DEFAULT '10',
  `sptj_max_sp` int(11) NOT NULL DEFAULT '10',
  `gonggao` varchar(255) NOT NULL,
  `gonggaoUrl` varchar(255) NOT NULL,
  `tabbar_new` text NOT NULL,
  `tabnum_new` int(1) NOT NULL,
  `homepage` int(1) NOT NULL DEFAULT '1',
  `duomerchants` int(1) NOT NULL DEFAULT '2',
  `remote` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uniacid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_base`
--

LOCK TABLES `ims_sudu8_page_base` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_base` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_base` VALUES (26,'slide',NULL,NULL,'http://cs.riyuanma.com/assetsj/pigefanxin/logo_bg.jpg','招商代理','http://cs.riyuanma.com/assetsj/pigefanxin/logo.jpg','招商代理','南通世纪大道8888号','8:30 - 18:00','15111111111','120.946330','31.983310','皮新彩，从事沙发家具维修翻新上门服务，维修材料的研发和销售，沙发家具维修技术培训！经过多年的发展，目前在上海、北京、长沙、成都、合肥等等国内80%的大城市有分部。是国内国际品牌家具售后维修的首选提供商.本公司一贯坚持专业、专心、细致、真诚的经营理念，全心全意为客户提供优质的家具维修美容服务让家具座椅日久长新完美无缺。','公司介绍','About Company','9','服务项目','Services','技术支持：小程序科技','',NULL,NULL,'#d40f33','#d40f33',NULL,'1',NULL,'t1','#ffcf3d',1,'','',9,9,'最新客照','New Photos',1,'#d40f33','#ffffff','a:5:{i:0;s:219:\"a:4:{s:8:\"tabbar_l\";s:5:\"index\";s:8:\"tabbar_t\";s:6:\"首页\";s:9:\"tabbar_p1\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar1.png\";s:9:\"tabbar_p2\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar1.png\";}\";i:1;s:234:\"a:5:{s:8:\"tabbar_l\";s:1:\"7\";s:8:\"tabbar_t\";s:6:\"项目\";s:9:\"tabbar_p1\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar2.png\";s:9:\"tabbar_p2\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar2.png\";s:4:\"type\";s:1:\"7\";}\";i:2;s:234:\"a:5:{s:8:\"tabbar_l\";s:1:\"7\";s:8:\"tabbar_t\";s:6:\"材料\";s:9:\"tabbar_p1\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar3.png\";s:9:\"tabbar_p2\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar3.png\";s:4:\"type\";s:1:\"7\";}\";i:3;s:218:\"a:4:{s:8:\"tabbar_l\";s:4:\"book\";s:8:\"tabbar_t\";s:6:\"预约\";s:9:\"tabbar_p1\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar4.png\";s:9:\"tabbar_p2\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar4.png\";}\";i:4;s:225:\"a:4:{s:8:\"tabbar_l\";s:10:\"usercenter\";s:8:\"tabbar_t\";s:6:\"我的\";s:9:\"tabbar_p1\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar5.png\";s:9:\"tabbar_p2\";s:55:\"http://cs.riyuanma.com/assetsj/pigefanxin/tabbar5.png\";}\";}',0,0,0,'#ffffff','','','0','560',0,'',NULL,'a:12:{s:7:\"newhead\";s:1:\"0\";s:6:\"search\";s:1:\"0\";s:6:\"bigadT\";s:1:\"0\";s:6:\"bigadC\";s:1:\"1\";s:8:\"bigadCTC\";s:1:\"8\";s:8:\"bigadCNN\";s:18:\"点击进入首页\";s:7:\"miniadT\";s:1:\"0\";s:7:\"miniadC\";s:1:\"0\";s:7:\"miniadN\";s:12:\"优惠活动\";s:7:\"miniadB\";s:12:\"查看详情\";s:4:\"copT\";s:1:\"9\";s:8:\"userFood\";s:1:\"0\";}',1,'a:1:{i:0;s:53:\"http://cs.riyuanma.com/assetsj/pigefanxin/slide.jpg\";}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,10,10,'','','',0,1,2,1),(1,'newslide',NULL,NULL,'http://cs.riyuanma.com/assetsj/hunsha/bg.jpg','家居馆','http://cs.riyuanma.com/assetsj/hunsha/logo.jpg','家居销售','南通世纪大道8888号','8:30 - 18:00','15111111111','120.94633','31.98331','家居销售','公司介绍','About Company','9','热销产品','','技术支持：九牛网科技有限公司','','18533015976','none','#ad9f98','#ad9f98',NULL,'2',NULL,'','#ffcf3d',0,'','',2,2,'推荐专区','',1,'FFFFFF','000000','a:4:{i:0;s:209:\"a:4:{s:8:\"tabbar_l\";s:5:\"index\";s:8:\"tabbar_t\";s:6:\"首页\";s:9:\"tabbar_p1\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar1.png\";s:9:\"tabbar_p2\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar1.png\";}\";i:1;s:207:\"a:4:{s:8:\"tabbar_l\";s:3:\"tel\";s:8:\"tabbar_t\";s:6:\"电话\";s:9:\"tabbar_p1\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar2.png\";s:9:\"tabbar_p2\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar2.png\";}\";i:2;s:207:\"a:4:{s:8:\"tabbar_l\";s:3:\"map\";s:8:\"tabbar_t\";s:6:\"导航\";s:9:\"tabbar_p1\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar3.png\";s:9:\"tabbar_p2\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar3.png\";}\";i:3;s:222:\"a:4:{s:8:\"tabbar_l\";s:10:\"usercenter\";s:8:\"tabbar_t\";s:12:\"个人中心\";s:9:\"tabbar_p1\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar4.png\";s:9:\"tabbar_p2\";s:50:\"http://cs.riyuanma.com/assetsj/jiaju/tabbar4.png\";}\";}',0,0,0,'#ffffff','FFFFFF','','0','600',0,'FF0000',NULL,'a:17:{s:7:\"newhead\";s:1:\"0\";s:6:\"search\";s:1:\"0\";s:6:\"bigadT\";s:1:\"1\";s:6:\"bigadC\";s:1:\"1\";s:8:\"bigadCTC\";s:1:\"5\";s:8:\"bigadCNN\";s:18:\"点击进入首页\";s:7:\"miniadT\";s:1:\"1\";s:7:\"miniadC\";s:1:\"0\";s:7:\"miniadN\";s:12:\"点击进入\";s:7:\"miniadB\";s:12:\"点击进入\";s:4:\"copT\";s:1:\"9\";s:8:\"userFood\";s:1:\"0\";s:5:\"commA\";s:1:\"0\";s:6:\"commAs\";s:1:\"0\";s:5:\"commP\";s:1:\"0\";s:6:\"commPs\";s:1:\"0\";s:9:\"serverBtn\";s:1:\"1\";}',1,'a:0:{}',NULL,'/upimages/20191207/b8d25f5eb556f6a3fc200263d5559c33282.png',NULL,NULL,NULL,NULL,'','',0,10,10,'','','a:5:{i:0;s:185:\"a:5:{s:11:\"tabbar_name\";s:6:\"首页\";s:10:\"tabbar_url\";s:23:\"/sudu8_page/index/index\";s:15:\"tabbar_linktype\";s:4:\"page\";s:6:\"tabbar\";s:1:\"2\";s:13:\"tabimginput_1\";s:14:\"icon-x-shouye4\";}\";i:1;s:195:\"a:5:{s:11:\"tabbar_name\";s:6:\"点餐\";s:10:\"tabbar_url\";s:33:\"/sudu8_page_plugin_food/food/food\";s:15:\"tabbar_linktype\";s:4:\"page\";s:6:\"tabbar\";s:1:\"2\";s:13:\"tabimginput_1\";s:14:\"icon-c-bijiben\";}\";i:2;s:201:\"a:5:{s:11:\"tabbar_name\";s:12:\"个人中心\";s:10:\"tabbar_url\";s:33:\"/sudu8_page/usercenter/usercenter\";s:15:\"tabbar_linktype\";s:4:\"page\";s:6:\"tabbar\";s:1:\"2\";s:13:\"tabimginput_1\";s:13:\"icon-x-geren4\";}\";i:3;s:184:\"a:5:{s:11:\"tabbar_name\";s:6:\"预约\";s:10:\"tabbar_url\";s:21:\"/sudu8_page/book/book\";s:15:\"tabbar_linktype\";s:4:\"page\";s:6:\"tabbar\";s:1:\"2\";s:13:\"tabimginput_1\";s:15:\"icon-x-bangzhu2\";}\";i:4;s:199:\"a:5:{s:11:\"tabbar_name\";s:9:\"微同城\";s:10:\"tabbar_url\";s:36:\"/sudu8_page_plugin_forum/index/index\";s:15:\"tabbar_linktype\";s:4:\"page\";s:6:\"tabbar\";s:1:\"2\";s:13:\"tabimginput_1\";s:12:\"icon-c-yixue\";}\";}',5,1,2,1);
/*!40000 ALTER TABLE `ims_sudu8_page_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_beizhu`
--

DROP TABLE IF EXISTS `ims_sudu8_page_beizhu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_beizhu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `beizhu` varchar(500) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_beizhu`
--

LOCK TABLES `ims_sudu8_page_beizhu` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_beizhu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_beizhu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cid` int(11) NOT NULL COMMENT '父栏目ID',
  `uniacid` int(11) NOT NULL COMMENT 'uniacid',
  `name` varchar(255) NOT NULL COMMENT '栏目名',
  `ename` varchar(255) NOT NULL COMMENT '栏目英文名',
  `cdesc` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT '栏目类型',
  `show_i` int(1) NOT NULL DEFAULT '0' COMMENT '首页显示',
  `statue` int(1) NOT NULL DEFAULT '1' COMMENT '栏目状态',
  `num` int(3) NOT NULL DEFAULT '50' COMMENT '栏目排序',
  `catepic` varchar(255) NOT NULL COMMENT '栏目图片',
  `list_type` int(2) NOT NULL COMMENT '列表显示类型',
  `list_style` int(2) NOT NULL COMMENT '列表样式',
  `list_stylet` char(10) NOT NULL COMMENT '列表样式里的标题样式',
  `list_tstyle` int(2) NOT NULL COMMENT '首页标题样式',
  `list_tstylel` int(2) NOT NULL,
  `content` mediumtext NOT NULL,
  `pic_page_btn` int(1) DEFAULT '0',
  `pic_page_btn_zt` int(1) NOT NULL DEFAULT '0',
  `cateconf` varchar(500) DEFAULT NULL,
  `onlyid` varchar(255) DEFAULT NULL,
  `list_style_more` int(1) NOT NULL DEFAULT '1' COMMENT '1普通2左侧',
  `slide_is` int(1) NOT NULL DEFAULT '2' COMMENT '1启用2不启用',
  `pic_page_bg` int(1) NOT NULL DEFAULT '0',
  `pagenum` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1654 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_cate`
--

LOCK TABLES `ims_sudu8_page_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_cate` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_cate` VALUES (446,0,19,'服务展示','Service display','','showPro',1,1,5,'',1,12,'none',2,0,'',0,0,NULL,NULL,1,2,0,10),(509,0,25,'积分兑换区','','','showPro',1,1,95,'',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(490,0,22,'客照欣赏','Photo Cases','','showPic',1,1,9,'',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(367,0,13,'所有产品','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/jiaju/nav1.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(368,0,13,'卧室系列','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/jiaju/nav2.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(369,0,13,'书房系列','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/jiaju/nav3.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(370,0,13,'阳台系列','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/jiaju/nav4.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(371,0,13,'客厅系列','','','showPro',0,1,95,'http://cs.riyuanma.com/assetsj/jiaju/nav5.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(372,0,13,'商务办公','','','showPro',0,1,94,'http://cs.riyuanma.com/assetsj/jiaju/nav6.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(373,0,13,'儿童系列','','','showPro',0,1,93,'http://cs.riyuanma.com/assetsj/jiaju/nav7.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(374,0,13,'储物系列','','','showPro',0,1,92,'http://cs.riyuanma.com/assetsj/jiaju/nav8.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(437,0,18,'研学线路','','','showPro',1,1,97,'http://cs.riyuanma.com/assetsj/lvxingshe/nav4.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(438,0,18,'出国签证','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/lvxingshe/nav5.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(431,427,17,'沙发维修材料','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/pigefanxin/column4.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(432,0,17,'关于我们','About','','page',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/nav1.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(460,458,15,'全球旅拍','Global tour','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav2.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(457,0,14,'储物系列','','','showPro',0,1,92,'http://cs.riyuanma.com/assetsj/jiaju/nav8.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(456,0,14,'儿童系列','','','showPro',0,1,93,'http://cs.riyuanma.com/assetsj/jiaju/nav7.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(455,0,14,'商务办公','','','showPro',0,1,94,'http://cs.riyuanma.com/assetsj/jiaju/nav6.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(454,0,14,'客厅系列','','','showPro',0,1,95,'http://cs.riyuanma.com/assetsj/jiaju/nav5.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(453,0,14,'阳台系列','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/jiaju/nav4.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(452,0,14,'书房系列','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/jiaju/nav3.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(451,0,14,'卧室系列','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/jiaju/nav2.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(450,0,14,'所有产品','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/jiaju/nav1.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(307,306,16,'照片1','','216','showPic',1,1,50,'',1,0,'',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(306,0,16,'照片','','16','page',1,1,50,'http://dulitest.nttrip.cn/upimages/20180131/ad2d74837d94d686ec126f3d7159e120797.jpg',0,3,'',1,1,'<p>1546</p>',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(305,0,16,'123测试','','123','showArt',1,1,50,'http://dulitest.nttrip.cn/upimages/20180131/2f31b91a859547aa2afb167903b9f935503.jpg',0,0,'',1,1,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(439,0,18,'积分兑换区','','','showPro',1,1,95,'',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(440,0,19,'客照欣赏','Photo Cases','','showPic',1,1,9,'',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(441,440,19,'婚纱摄影','Wedding photography','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav1.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(442,440,19,'全球旅拍','Global tour','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav2.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(443,440,19,'个人写真','Personal photo','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav3.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(430,427,17,'家具维修材料','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/column3.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(445,0,19,'优惠活动','Activities','','showArt',1,1,8,'',1,1,'tlb',2,0,'',0,0,NULL,NULL,1,2,0,10),(444,440,19,'情侣闺蜜','Lovers & girlfriends','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav4.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(458,0,15,'客照欣赏','Photo Cases','','showPic',1,1,9,'',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(459,458,15,'婚纱摄影','Wedding photography','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav1.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(433,0,17,'加盟培训','Join','','page',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/nav4.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(434,0,18,'洛阳线路','','','showPro',1,1,999,'http://cs.riyuanma.com/assetsj/lvxingshe/nav1.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(435,0,18,'国内线路','','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/lvxingshe/nav2.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(436,0,18,'出境线路','','','showPro',1,1,98,'http://cs.riyuanma.com/assetsj/lvxingshe/nav3.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(429,427,17,'维修工具','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/column2.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(426,0,17,'加盟优势','Advantage','','showArt',1,1,99,'',1,2,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(428,427,17,'维修套装','','','showPro',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/column1.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(427,0,17,'材料销售','store','','showPro',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav3.png',0,12,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(424,0,17,'服务项目','Service','','showArt',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav2.png',1,1,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(425,0,17,'客户案例','case','','showArt',1,1,8,'',1,3,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(461,458,15,'个人写真','Personal photo','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav3.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(462,458,15,'情侣闺蜜','Lovers & girlfriends','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav4.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(463,0,15,'优惠活动','Activities','','showArt',1,1,8,'',1,1,'tlb',2,0,'',0,0,NULL,NULL,1,2,0,10),(464,0,15,'服务展示','Service display','','showPro',1,1,5,'',1,12,'none',2,0,'',0,0,NULL,NULL,1,2,0,10),(491,490,22,'婚纱摄影','Wedding photography','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav1.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(507,0,25,'研学线路','','','showPro',1,1,97,'http://cs.riyuanma.com/assetsj/lvxingshe/nav4.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(508,0,25,'出国签证','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/lvxingshe/nav5.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(505,0,25,'国内线路','','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/lvxingshe/nav2.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(506,0,25,'出境线路','','','showPro',1,1,98,'http://cs.riyuanma.com/assetsj/lvxingshe/nav3.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(482,0,23,'教练预约','subscribe/trainer','','showPro',1,1,99,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(483,0,23,'会员卡办理','power','','showPro',1,1,88,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(484,0,23,'俱乐部器材','equipment','','showPic',1,1,90,'',1,5,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(492,490,22,'全球旅拍','Global tour','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav2.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(493,490,22,'个人写真','Personal photo','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav3.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(494,490,22,'情侣闺蜜','Lovers & girlfriends','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav4.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(495,0,22,'优惠活动','Activities','','showArt',1,1,8,'',1,1,'tlb',2,0,'',0,0,NULL,NULL,1,2,0,10),(496,0,22,'服务展示','Service display','','showPro',1,1,5,'',1,12,'none',2,0,'',0,0,NULL,NULL,1,2,0,10),(504,0,25,'洛阳线路','','','showPro',1,1,999,'http://cs.riyuanma.com/assetsj/lvxingshe/nav1.png',1,12,'tl',2,0,'',0,0,NULL,NULL,1,2,0,10),(755,705,27,'保健品','','','showPro',0,1,99,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(873,869,36,'防静电接地','','','showPro',0,1,49,'',1,12,'tl',0,1,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(912,0,35,'客照欣赏','Photo Cases','','showPic',1,0,9,'',1,2,'tcb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(704,0,28,'首页文章','','','showArt',1,1,50,'',1,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(913,912,35,'婚纱摄影','Wedding photography','','showPic',1,0,9,'http://cs.riyuanma.com/assetsj/hunsha/nav1.png',1,2,'tcb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(745,0,30,'案例展示','SHOWCASE','','showArt',1,1,51,'http://www.suibianxia.cn/upimages/20180325/126e0896392c3181a3933c534238fafb766.jpg',1,1,'tl',2,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(756,705,27,'化妆品','','','showPro',0,1,98,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(757,705,27,'护肤品','','','showPro',0,1,97,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(705,0,27,'商品信息','','','showPro',0,1,1,'',0,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(694,0,29,'儿童系列','','','showPro',0,1,93,'http://cs.riyuanma.com/assetsj/jiaju/nav7.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(695,0,29,'储物系列','','','showPro',0,1,92,'http://cs.riyuanma.com/assetsj/jiaju/nav8.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(693,0,29,'商务办公','','','showPro',0,1,94,'http://cs.riyuanma.com/assetsj/jiaju/nav6.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(692,0,29,'客厅系列','','','showPro',0,1,95,'http://cs.riyuanma.com/assetsj/jiaju/nav5.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(691,0,29,'阳台系列','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/jiaju/nav4.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(690,0,29,'书房系列','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/jiaju/nav3.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(689,0,29,'卧室系列','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/jiaju/nav2.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(688,0,29,'所有产品','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/jiaju/nav1.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(746,0,30,'视频分享','VIDEOS','视频分享','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180323/b3172c8d98aaa52bbd65a7b9a8415245932.jpg',1,1,'tl',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(758,705,27,'奶粉','','','showPro',0,1,96,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(759,705,27,'零食','','','showPro',0,1,95,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(760,705,27,'儿童用品','','','showPro',0,1,94,'',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1116,0,27,'在途特价预定','','','showArt',1,1,99,'',1,5,'tcb',2,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(869,0,36,'产品中心','','','showPro',1,1,3,'',1,12,'tc',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(870,0,36,'新闻中心','','','showArt',1,1,1,'',1,3,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(871,0,36,'成功案例','','','showPic',1,1,2,'',1,5,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(872,869,36,'防静电地板','','','showPro',0,1,50,'',1,12,'tl',0,1,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1119,0,33,'脱毛&激光类','Hair removal','脱毛','showPro',1,1,3,'http://www.suibianxia.cn/upimages/20180419/3276db13fc52b79f4f3bd0b5de126842931.png',1,12,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1120,0,33,'半永久','Semi permanent','半永久','showPro',1,1,4,'http://www.suibianxia.cn/upimages/20180419/cf31596d93cc51534fdbecaf075da1a3211.jpg',1,12,'tcb',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(875,869,36,'弱电工程','','','showPro',0,1,47,'',1,12,'tl',0,1,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(874,869,36,'机房装修','','','showPro',0,1,48,'',1,12,'tl',0,1,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(812,0,32,'所有项目','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/qixiu/nav1.png',1,12,'none',0,2,'',0,0,NULL,NULL,1,2,0,10),(813,0,32,'产品&服务','Products and Services','','showPro',1,0,98,'',1,12,'tl',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(808,0,32,'检车环境','','','showArt',0,1,999,'http://cs.riyuanma.com/assetsj/qixiu/nav2.png',1,1,'none',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(809,0,32,'检车准备','','','showArt',0,1,98,'http://cs.riyuanma.com/assetsj/qixiu/nav3.png',1,1,'none',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(811,0,32,'行业资讯','Industry information','','showArt',0,1,96,'',1,2,'tlb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(810,0,32,'关于我们','','','showArt',0,1,97,'http://cs.riyuanma.com/assetsj/qixiu/nav4.png',1,1,'none',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(890,0,37,'高级设计师','Designer','','showPro',1,0,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(891,0,37,'主营&服务','The main and Services','','showPic',1,0,99,'http://www.suibianxia.cn/upimages/20180408/35aa968cc7112bc5176d8bb3e3a86b0b296.jpg',0,4,'tcb',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1117,1116,27,'彩妆','','','showArt',1,1,99,'',1,2,'tcb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(892,0,37,'样板风格','style','','showPic',1,0,97,'',1,2,'tcb',1,0,'',0,2,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(877,0,34,'视频分享','VIDEOS','视频分享','showArt',0,1,50,'',1,1,'tl',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1121,0,33,'皮肤管理','Skin management','皮肤管理','showPro',1,1,6,'http://www.suibianxia.cn/upimages/20180419/351292fe6d26baf95558c16d24049c2a766.JPG',1,12,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1226,0,41,'案例展示','Case Shows','','showPro',1,0,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1471,1463,38,'ios下载','','ios','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180713/5f86ecc4eac297c989d074a7aef4d319379.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','20186132199984',1,2,0,10),(1472,1464,38,'关于我们','','菲律賓執照\r\n\r\n我們提供的所有產品和服務，是由菲律賓政府卡格揚河經濟特區 First Cagayan leisure and Resort Corporation. www.firstcagayan.com 所授權和監管。這是一家位於Cagayan特別經濟區和自由口岸 (CSEZFP)的機構，並且是互動遊戲的授權者及管理者。\r\n\r\n安全与保密\r\n\r\n我们采用了目前最好的加密技术（1024位RSA密钥交换和 448位blowfish）和防火墙系统保护你的安全、私隐，并保证你享受公平的 游戏。客户在本平台的','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180713/8cd79e07836ef35e18709c4488e7b6c0180.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','2018613211347888',1,2,0,10),(1344,1337,55,'ios','','','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180711/51be7660fe56de91327e9531c34511f0749.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','2018611222611482',1,2,0,10),(1343,1336,55,'栏目4','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat4.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1342,1336,55,'栏目3','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat3.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1341,1336,55,'栏目2','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat2.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1340,1336,55,'栏目1','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat1.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1339,0,55,'新品推荐','','','showArt',0,0,97,'',0,2,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}','2018611223733356',1,2,0,10),(1337,0,55,'产品展示','','','showArt',1,1,99,'',0,2,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";N;}','2018611222512288',1,2,0,10),(1338,0,55,'花束欣赏','','','showArt',1,0,98,'',0,2,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";N;}','2018611223720576',1,2,0,10),(1336,0,55,'花艺','Famous teachers','','showArt',1,0,999,'',0,6,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','2018611222456202',1,2,0,10),(1357,1352,56,'栏目2','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat2.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1356,1352,56,'栏目1','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat1.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1355,0,56,'新品推荐','','','showArt',0,0,97,'',0,2,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}','2018611224646359',1,2,0,10),(1354,0,56,'花束欣赏','','','showArt',0,0,98,'',0,2,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";N;}','2018611224628837',1,2,0,10),(1353,0,56,'产品展示','','','showArt',1,1,99,'http://www.suibianxia.cn/upimages/20180711/0cccfcb6abf0ab4978023a238034d6bf872.jpg',0,2,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";N;}','201861122471646',1,2,0,10),(1470,1463,38,'安卓下载','','安卓下载','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180713/26839ef96d389d3fda0f5a0a1273edd6957.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861321942323',1,2,0,10),(1352,0,56,'花艺','Famous teachers','','showArt',0,0,999,'',0,6,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861122461947',1,2,0,10),(1102,0,44,'花束','Carnation','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180418/e2883a5aa3cc1713fdec3b0ab002bcc4718.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1103,0,44,'小熊花束','Bear bouquet','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180418/b11a7ecd32aeec45604937d6203d248d406.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(904,0,39,'服务项目','service item','','showPro',1,1,55,'http://www.suibianxia.cn/upimages/20180409/19086d207f3b6f7a6bd30e53f9c3266a597.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(905,0,39,'纹绣知识','.','护理小知识','showArt',1,1,51,'http://www.suibianxia.cn/upimages/20180416/36ce984e1c0d3f1516c353075c34dd67401.png',1,4,'tcb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(906,0,39,'最新活动','latest activity','最新活动','showPic',1,1,58,'http://www.suibianxia.cn/upimages/20180409/68c166a4bac5d736a22dcb28200c83e4675.png',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(914,912,35,'全球旅拍','Global tour','','showPic',1,0,9,'http://cs.riyuanma.com/assetsj/hunsha/nav2.png',1,2,'tcb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(915,912,35,'个人写真','Personal photo','','showPic',1,0,9,'http://cs.riyuanma.com/assetsj/hunsha/nav3.png',1,2,'tcb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(916,912,35,'情侣闺蜜','Lovers & girlfriends','','showPic',1,0,9,'http://cs.riyuanma.com/assetsj/hunsha/nav4.png',1,2,'tcb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(917,0,35,'优惠活动','Activities','','showArt',1,1,8,'',1,1,'tlb',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','20186514255591',1,2,0,10),(918,0,35,'服务展示','Service display','','showPro',1,0,5,'',1,12,'none',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1243,0,33,'仪器介绍','','','showArt',0,1,50,'http://www.suibianxia.cn/upimages/20180509/9a9a4af3a34bda31682cd5fd8a4dceab986.jpg',1,2,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1032,0,42,'成功案例','','','showArt',1,1,50,'',1,2,'tl',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1118,0,33,'管理师团队','administrator','','showArt',1,1,1,'http://www.suibianxia.cn/upimages/20180419/2487a5ce217909b8c66efe35a81da604403.jpg',1,2,'tc',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1035,996,42,'全钢无边防静电地板','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1033,0,42,'新闻动态','','','showArt',1,1,49,'',1,4,'tl',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1169,0,44,'插花','Flower arrangement','','showPro',0,1,2,'http://www.suibianxia.cn/upimages/20180424/a15fa69122cdf01d30e89436be09643c264.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(996,0,42,'产品中心','FengShen','','showPro',1,1,999,'',1,12,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1036,996,42,'OA智能网络地板','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1246,1245,49,'吃','eat','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180521/73e7d7a7f631a3b68861e4946bad7973660.jpg',1,1,'tlb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018421115545648',2,2,0,10),(1060,0,33,'美甲美睫','Nail beauty and ciliary','美甲美睫','showPro',1,1,5,'http://www.suibianxia.cn/upimages/20180419/cf8a9da4c09d5174fc55aa827a29e492800.jpg',1,12,'tcb',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1245,0,49,'娱乐','play','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180521/6762994ad4a260fea26d0eaed9a3c57f350.jpg',1,3,'tcb',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018421115540355',1,2,0,10),(1127,0,33,'药妆','','','showPro',0,1,50,'http://www.suibianxia.cn/upimages/20180419/7e4760b874f2b8baa72fbbb1d013af42120.png',1,12,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1098,0,44,'店长推荐','HOT','','showPro',1,1,99,'http://www.suibianxia.cn/upimages/20180418/bebe39a7aa81c3fb5196b34b5635883a311.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1099,0,44,'玫瑰花','rose','','showPro',1,1,98,'http://www.suibianxia.cn/upimages/20180418/446aef8f7b948e65dc3a03bc174846c5920.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1100,0,44,'盆栽','Pot','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180418/601f769d591c3be132b411ca8827aace22.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1101,0,44,'花车','Float','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180418/f5f39874d09c7904617106a02a8fb4d5137.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1037,996,42,'通风地板','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1038,996,42,'陶瓷防静电地板','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1041,996,42,'PVC防静电地板','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1042,996,42,'防静电接地','','','showPro',0,1,50,'',1,12,'tl',0,2,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1168,0,44,'花瓶','vase','','showPro',0,1,1,'http://www.suibianxia.cn/upimages/20180424/0e7531e6845cdb84361bd899ff8fda1591.jpg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1167,0,27,'特价商品','','','showPro',1,1,9,'',1,14,'tcb',2,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1170,0,44,'礼盒花','Gift box flower','','showPro',0,1,22,'http://www.suibianxia.cn/upimages/20180424/3d77d385335c7ce8120c06d2b631b16d559.jpeg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1171,0,44,'花篮','Flower basket','','showPro',1,1,49,'http://www.suibianxia.cn/upimages/20180424/00210bfb6ffb9e82d87e0e4ef7fc539f343.jpeg',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1477,1465,38,'康乃馨','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat12.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1476,1465,38,'蓝玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat11.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1204,0,46,'灯具安装','Installation of lamps and lanterns','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180426/b84570777859bcad83a7696d407f920e58.png',1,12,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1205,0,46,'五金安装','Hardware installation','','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180426/153773820439ead52a3103428c672fa2443.png',1,12,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}',NULL,1,2,0,10),(1206,0,43,'推荐美食','Recommended food','','showPic',1,1,90,'http://www.suibianxia.cn/upimages/20180426/dbd0de303f95a37ebce2c991c7e91281165.png',1,2,'tc',1,1,'',0,2,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1207,0,43,'点评美食','Comment on food','','showArt',1,0,89,'',1,2,'tc',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1208,0,43,'新闻资讯','News information','','showArt',1,1,3,'',1,3,'',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"1\";}',NULL,1,2,0,10),(1227,0,41,'产品&服务','Products and Services','','showPic',1,1,100,'http://www.suibianxia.cn/upimages/20180427/92e0af1a8408b16c03ead5fcdeef6f3f351.jpg',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1228,0,41,'摄影风格','Photography Style','','showPic',1,1,97,'',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1229,0,41,'案例展示','The Case Shows','','showArt',1,1,98,'http://www.suibianxia.cn/upimages/20180427/049998af4a414b66d228f21decda4176285.jpg',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1231,0,41,'婚纱定制','Wedding Custom','婚纱定制','showArt',1,1,99,'',1,1,'tcb',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1233,0,41,'婚纱租赁','Wedding Dress Rental','婚纱租赁','showPro',1,1,98,'',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1234,0,33,'美体','','','showPro',0,1,50,'',1,12,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}',NULL,1,2,0,10),(1235,0,35,'书画活动','','','showPro',1,0,50,'',1,12,'tc',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','20186514340579',1,2,0,10),(1236,0,48,'冷菜','lengcai','冷菜','showPro',1,1,4,'http://www.suibianxia.cn/upimages/20180613/7c8c69836f2f64ea305e9aa94df3de03352.jpg',1,13,'tcb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018513153659159',1,2,0,10),(1239,0,48,'点心','','点心','showPro',1,1,1,'http://www.suibianxia.cn/upimages/20180613/ba0c191fbdf99b1eaaf39cb038920343701.jpg',1,13,'tc',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018513153420932',1,2,0,10),(1238,0,48,'热菜','recai','好吃','showPro',1,1,3,'http://www.suibianxia.cn/upimages/20180613/1d069b7aa66cabafadd86375cf4c9f28593.jpg',1,13,'tcb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018513153640136',1,2,0,10),(1240,0,48,'腊味','','腊味','showPro',1,1,2,'http://www.suibianxia.cn/upimages/20180613/3495646f55bf486f5879dcd2619ae683613.jpg',1,13,'',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018513153445424',1,2,0,10),(1247,1245,49,'玩','play','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180521/f078593ed5e6ce1a6811996368f23435622.png',1,1,'tlb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018421115612525',2,2,0,10),(1248,1245,49,'住','sleep','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180521/ed5fc42bcfbecf6e92df06859e081e5e425.png',1,1,'tcb',2,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018421115818349',2,2,0,10),(1249,0,51,'娱乐','entertainment','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180528/6004630ec8aff1fdd61ad15da9cdd5b6260.png',1,3,'tc',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','201842814556999',1,1,0,10),(1250,1249,51,'东戴河美食','eat','','showArt',1,1,51,'http://www.suibianxia.cn/upimages/20180528/81dff78d0f016e4fcf3b8ce32549f62a752.png',1,3,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','201842814739869',1,2,0,10),(1251,1249,51,'东戴河住宿','sleep','','showArt',1,1,51,'http://www.suibianxia.cn/upimages/20180528/ff48ed7d1e89e57f58c2468eecff4d4d410.png',1,3,'tc',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','201842814834295',1,2,0,10),(1252,1249,51,'东戴河美景','play','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180528/3317146abe883d2a9d8f0900428d88a0232.png',1,3,'tc',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','201842814923787',1,2,0,10),(1278,1249,51,'东戴河视频','VIDEOS','东戴河视频','showArt',0,1,50,'',1,3,'tcb',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','201842922269505',1,2,0,10),(1279,0,51,'拼团介绍','','拼团介绍','showArt',0,1,50,'http://www.suibianxia.cn/upimages/20180530/14391b52f035a3d29043e5ab89500cd2583.png',1,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018430171337749',1,2,0,10),(1275,0,50,'专业游泳教练','Professional swimming coach','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201842815494970',1,2,0,10),(1276,0,50,'游泳馆介绍','Natatorium photos','','showPic',1,1,99,'',1,5,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018428154957604',1,2,0,10),(1277,0,50,'样板风格','style','','showPic',1,0,97,'',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018428154343893',1,2,0,10),(1280,0,51,'秒杀','','','showPro',0,1,50,'http://www.suibianxia.cn/upimages/20180530/54d94d4e26e41dd75b11d94ad4b7bfaf959.jpg',1,11,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','201843017310950',1,2,0,10),(1281,0,53,'娱乐','entertainment','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180613/55381a96b4aec39f2e1c326c9c248a6c751.png',1,3,'tc',1,2,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018513121810297',1,1,0,10),(1288,0,53,'拼团介绍','','','showArt',0,1,50,'',1,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018513134746998',1,2,0,10),(1285,1281,53,'东戴河视频','VIDEOS','','showArt',0,1,50,'',1,3,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018513122535311',1,2,0,10),(1284,1281,53,'东戴河住宿','sleep','苗苗农家院设有三人间、四人间，共18个房间。\r\n房间内：空调、电视、24小时热水淋浴、电蚊香、WIFI等','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180617/0a38dc5733bb65c4b4976ef10095b59e194.jpg',1,3,'tc',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018513122352591',1,2,0,10),(1286,1281,53,'东戴河美景','beautiful','','showArt',1,1,50,'',1,3,'tc',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018513134457350',1,2,0,10),(1287,1281,53,'东戴河美食','eat','','showArt',1,1,50,'',1,3,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"2\";}','2018513134541935',1,2,0,10),(1289,0,53,'秒杀','','','showPro',0,1,50,'',1,11,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','2018513134827375',1,2,0,10),(1468,1462,38,'栏目3','','','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180713/29391ddbffedf1d8ce68231654103c1975.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861321647855',1,2,0,10),(1469,1462,38,'栏目4','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat4.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1405,0,57,'11','','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180712/e2021f09cd5aa472c1cbdcd518e82435752.png',1,1,'none',0,0,'',1,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"2\";}','2018612112935408',1,2,0,10),(1404,0,58,'哟咻','','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180712/cf3b1e3463116f4b5eb5370642e24bcb734.png',1,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201861295015137',1,2,0,10),(1345,1337,55,'安卓','','安卓下载方式','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180711/c258434eefc73aafbe94468b2a18057c771.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861122279453',1,2,0,10),(1346,1338,55,'香槟玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat7.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1347,1338,55,'玫瑰百合','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat8.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1348,1339,55,'红玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat9.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1349,1339,55,'雏菊','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat10.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1350,1339,55,'蓝玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat11.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1351,1339,55,'康乃馨','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat12.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1358,1352,56,'栏目3','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat3.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1359,1352,56,'栏目4','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat4.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1360,1353,56,'ios下载','','','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180711/e019f389139e6a5ce9a783b182395109266.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861122473446',1,2,0,10),(1361,1353,56,'安卓下载','','','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180711/2d541c5ae9ab2f312bbd0df7937ebf8f696.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861122482471',1,2,0,10),(1362,1354,56,'香槟玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat7.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1363,1354,56,'玫瑰百合','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat8.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1364,1355,56,'红玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat9.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1365,1355,56,'雏菊','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat10.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1366,1355,56,'蓝玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat11.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1367,1355,56,'康乃馨','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat12.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1473,1464,38,'新闻资讯','','','showArt',1,1,9,'http://www.suibianxia.cn/upimages/20180713/c3770debc325ec93345fea4a58af2f96635.jpg',1,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201861321225720',1,2,0,10),(1474,1465,38,'红玫瑰','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat9.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1475,1465,38,'雏菊','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat10.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1467,1462,38,'栏目2','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat2.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1460,0,59,'星级服务','Great  Services','','showPic',1,1,80,'',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201861316221555',1,2,0,10),(1461,0,59,'工程案例','Engineering case','','showPic',1,1,97,'',1,2,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018613161646884',1,2,0,10),(1459,0,59,'推荐产品','Recommended products','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018613161615205',1,2,0,10),(1466,1462,38,'栏目1','','','showArt',1,1,9,'http://cs.riyuanma.com/assetsj/huadian/cat1.jpg',0,2,'tc',0,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}',NULL,1,2,0,10),(1465,0,38,'新品推荐','','','showArt',0,0,97,'',0,2,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}','2018613212147807',1,2,0,10),(1464,0,38,'文章管理','','','showArt',1,1,98,'http://www.suibianxia.cn/upimages/20180713/f7663a93fbc57d2e223502ca69a497b2225.jpg',0,2,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";N;}','2018613211310315',1,2,0,10),(1462,0,38,'花艺','Famous teachers','','showArt',0,0,999,'',0,6,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','2018613211056332',1,2,0,10),(1463,0,38,'产品展示','','展示','showArt',1,1,99,'http://www.suibianxia.cn/upimages/20180713/3d2bbbe1f5fe1f3cabc68209df97f585486.jpg',0,2,'tc',2,0,'',0,0,'a:2:{s:5:\"pmarb\";s:2:\"10\";s:4:\"ptit\";s:1:\"0\";}','201861321755866',1,2,0,10),(1478,0,60,'- 爆系套餐 -','','方圆十里网络大电影即将进行拍摄制作，面向大众群体招投资以及广告植入。','showPro',1,1,50,'http://www.suibianxia.cn/upimages/20180724/7f7116731f70cdea1f6b14b86bd517e5961.png',0,11,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018624164033446',1,1,0,10),(1479,0,60,'- 主题案例 -','Subject case','','showPic',0,1,50,'/upimages/20180917/e888a7bfbd4474b63daad34df11ad94e742.jpg',0,2,'tc',1,1,'',0,2,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201862416435135',1,2,0,10),(1480,0,60,'- 客片欣赏 -','Guest piece','','showPic',0,1,50,'http://www.suibianxia.cn/upimages/20180724/d5ef739d760c4945f179c415ee468ddd166.png',1,1,'tc',0,0,'',0,2,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018624164624338',1,1,0,10),(1481,0,60,'预约热线','','','showArt',1,1,50,'http://www.suibianxia.cn/upimages/20180724/5e4c0137e80e5590945bc3840c8c2120735.png',0,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"0\";}','201862416491233',1,2,0,10),(1495,0,62,'样板风格','style','','showPic',1,1,97,'',1,2,'tcb',1,0,'',0,0,NULL,NULL,1,2,0,10),(1496,0,63,'教练预约','subscribe/trainer','','showPro',1,1,99,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1494,0,62,'产品&服务','Products and Services','','showPic',1,1,99,'',1,2,'tcb',1,0,'',0,0,NULL,NULL,1,2,0,10),(1493,0,62,'高级设计师','Designer','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1492,0,61,'全网VIP影视免费体验','','','showArt',1,1,50,'',0,1,'tcb',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201886195258883',1,1,0,10),(1489,0,61,'图片','pic','','page',1,1,50,'/upimages/20180906/e63b571801f056ad55eba2ff9030bf52949.jpg',1,3,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018851583667',1,1,0,10),(1490,1489,61,'图片','','','showPic',0,1,50,'',1,1,'',0,0,'',0,2,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','20188515132333',1,2,1,10),(1491,0,61,'扫码免费体验','','','showArt',1,1,50,'',1,1,'none',1,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','20188515192130',1,1,0,10),(1497,0,63,'会员卡办理','power','','showPro',1,1,88,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1498,0,63,'俱乐部器材','equipment','','showPic',1,1,90,'',1,5,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1499,0,62,'影视vip','','','showArt',0,1,50,'',0,0,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','201881592653736',1,2,0,10),(1500,0,63,'影视vip','','','showArt',0,0,50,'',0,0,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','20188159308329',1,2,0,10),(1501,0,64,'教练预约','subscribe/trainer','','showPro',1,1,99,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1502,0,64,'会员卡办理','power','','showPro',1,1,88,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1503,0,64,'俱乐部器材','equipment','','showPic',1,1,90,'',1,5,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1504,0,64,'影视','','','showArt',0,1,50,'',0,0,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','201881612104022',1,2,0,10),(1511,0,66,'高级设计师','Designer','','showPro',1,1,99,'http://cs.riyuanma.com/assetsj/zxzs/nav1.png',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1510,0,65,'盘锦大米','','','showPro',0,1,50,'/upimages/20180918/feeb676f3d05c6cb547d3476f658faeb651.jpg',0,0,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','201881817526417',1,2,0,10),(1508,0,60,'首页视频一','','','showArt',1,1,50,'',1,1,'none',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201881816644723',1,1,0,10),(1509,0,65,'盘锦河蟹','','','showPro',0,1,50,'',0,12,'',0,0,'',0,0,'a:2:{s:5:\"pmarb\";N;s:4:\"ptit\";N;}','201881817125127',1,2,0,10),(1512,0,66,'产品&服务','Products and Services','','showPic',1,1,99,'',1,2,'tcb',1,0,'',0,0,NULL,NULL,1,2,0,10),(1513,0,66,'样板风格','style','','showPic',1,1,97,'',1,2,'tcb',1,0,'',0,0,NULL,NULL,1,2,0,10),(1514,0,67,'教练预约','subscribe/trainer','','showPro',1,1,99,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1515,0,67,'会员卡办理','power','','showPro',1,1,88,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1516,0,67,'俱乐部器材','equipment','','showPic',1,1,90,'',1,5,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1524,0,68,'学校环境','','','showArt',1,1,50,'',0,2,'tcb',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"2\";}','201882211475794',1,2,0,10),(1525,0,68,'师资力量','','','showArt',1,1,50,'',0,3,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','201882211481428',1,2,0,10),(1526,0,68,'课程介绍','','','showArt',1,1,50,'',0,2,'tcb',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','2018822114827363',1,2,0,10),(1528,0,68,'成功学子','','','showArt',1,1,50,'',0,3,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','2018822114852681',1,2,0,10),(1529,0,68,'新生问答','','','showArt',1,1,50,'',0,3,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','2018822114910514',1,2,0,10),(1532,0,68,'招生简章',' student recruitment brochure','','page',1,1,50,'',0,3,'tl',1,1,'<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"line-height: 1.5; font-size: 32px;\"><span style=\"font-family: KaiTi_GB2312;\"><span style=\"color: rgb(255, 255, 255); font-size: 24px; background-color: rgb(229, 51, 51);\"><strong><span style=\"font-family: SimSun; font-size: 14px;\"><img alt=\"\" src=\"http://m.zzhuaren.com/uploads/allimg/171007/1-1G00GG1245K.jpg\"/><img alt=\"\" src=\"http://m.zzhuaren.com/uploads/allimg/170409/1-1F40911363N19.jpg\"/><br/></span></strong></span></span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"line-height: 1.5; font-size: 32px;\"><span style=\"font-family: KaiTi_GB2312;\"><span style=\"color: rgb(255, 255, 255); font-size: 24px; background-color: rgb(229, 51, 51);\"><strong><span style=\"font-family: SimSun; font-size: 14px;\">招生对象</span></strong><span style=\"font-family: SimSun; font-size: 14px;\">：</span></span></span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"line-height: 1.5; font-family: SimSun;\">&nbsp;1、目前已经从事手机维修，但维修水平有限，需要进修者 ！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"text-align: center; line-height: 1.5; font-family: SimSun;\">&nbsp;2、初中或者高中毕业想学一门实用的技术且拿个学历者！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"text-align: center; line-height: 1.5; font-family: SimSun;\">&nbsp;3、对于已经开店，但没有学过手机维修，想要开展维修业务者！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"line-height: 1.5; font-family: SimSun;\"><span style=\"color: rgb(0, 0, 0);\">&nbsp;4、对于目前收入不满意，准备通过学习迅速踏上致富之路的学习者 ！</span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"line-height: 1.5; font-family: SimSun;\">&nbsp;5、没有稳定工作，希望通过学习有份稳定工作固定收入 ！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(229, 51, 51);\"><strong>教学模式：</strong></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">我们采取<span style=\"color: rgb(229, 51, 51);\">理论+在校工作室实践+学校在科技市场的维修店面实战</span>的教学模式，学员入校后每人一个工作台，一套维修工具，以及各种类型的手机，大部分时间都是实战，只有多实战才能学到真技术， 这样系统的学完后，可解决各种手机的各种问题。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><img alt=\"\" src=\"http://m.zzhuaren.com/uploads/allimg/170409/1-1F409113RN58.jpg\"/><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">（理论教室1）</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><img alt=\"\" src=\"http://m.zzhuaren.com/uploads/allimg/171007/1-1G00GG21O51.jpg\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">（学校实践工作室1）</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><img alt=\"\" src=\"http://m.zzhuaren.com/uploads/allimg/170409/1-1F40911405K64.jpg\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">（学员在我们科技市场的维修店面为客户修手机中）</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><span style=\"font-family: KaiTi_GB2312; font-size: x-large;\"><span style=\"font-size: 24px;\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(229, 51, 51);\"><span style=\"font-family: SimSun; font-size: 14px;\"><strong>开设班级</strong>：</span></span></span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong style=\"color: rgb(229, 51, 51); line-height: 1.5;\">一. 国产智能维修高手班：</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/>&nbsp;<strong>A、维修店技术：</strong>各品牌手机拆装，刷机的几种方法、手机解锁，风枪、烙铁的使用（尾插(充电头)、元器件、飞线、芯片等焊接技术），听筒、响铃、振子、话筒拆装。手机内外屏的更换、一体屏的拆胶与贴合技术。重点培训动手能力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/><strong>B、android手机电路精解：</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">1、电源电路读图要点 2、充电电路读图要点 3、13M时钟电路读图要点 4、接收电路读图要点&nbsp;5、发射电路读图要点&nbsp;6、本振电路读图要点 7、SIM卡电路读图要点 8、送话电路读图要点&nbsp;9、受话电路读图要点10、其他电路读图要点</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/><strong>C、android手机手机故障分析：</strong>1、不开机 2、 不维持开机 3、开机困难4、自动关机 5、不能关机或关机困难 6、关机后不能开机，重装电池可开机 7、进入某一项功能关机 8、响铃状态关机 9、发射关机 10、无信号 11、无受话 12、无送话 13、无显示 14、显示黑屏/白屏 15、无振铃 16、无振动 等等。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">&nbsp;时间60天(理论+在校实操+维修店实习)&nbsp;<strong>（</strong><strong>小</strong><strong>班精讲</strong><strong>&nbsp;</strong>&nbsp;<strong>毕业发职业技能合格证书</strong>&nbsp;<strong>签订就业协议，保证就业</strong><strong>） &nbsp;<a href=\"http://p.qiao.baidu.com/im/index?siteid=10396738&ucid=19992246&cp=&cr=&cw=\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(0, 0, 0);\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(255, 153, 0);\">点击咨询详情</span></a></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong><span style=\"color: rgb(229, 51, 51);\">二.苹果三星高手班</span></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/>&nbsp;<strong>A、维修店技术：</strong>苹果手机与android各品牌手机的拆装及刷机方法、手机解锁，风枪、烙铁的使用（尾插(充电头)、元器件、飞线、芯片等焊接技术），听筒、响铃、振子、话筒拆装。手机内外屏的更换、一体屏的拆胶与贴合技术。重点培训动手能力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/><strong>B、苹果手机与android手机电路精解：</strong>1、电源电路讲解。2、充电电路讲解3、13M时钟电路讲解 。4、接收电路讲解 。5、发射电路讲解。 6、本振电路讲解。 7、SIM卡电路讲解。 8、送话电路讲解 。9、受话电路讲解。10、其他电路讲解。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/><strong>C、苹果手机与android手机故障分析</strong>：1、不开机 。2、 不维持开机 。3、开机困难。4、自动关机。 5、不能关机或关机困难 。6、关机后不能开机，重装电池可开机。 7、进入某一项功能关机。 8、响铃状态关机。 9、发射关机。 10、无信号 。11、无受话 。12、无送话 。13、无显示。 14、显示黑屏/白屏 。15、无振铃。 16、无振动 等等。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">时间:90天。（理论+在校实操+维修店实习）</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">（<strong>小班精讲</strong>&nbsp;<strong>毕业发职业技能合格证书</strong>&nbsp;<strong>签订就业协议保证就业）&nbsp;<a href=\"http://p.qiao.baidu.com/im/index?siteid=10396738&ucid=19992246&cp=&cr=&cw=\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(0, 0, 0);\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(255, 153, 0);\">点击咨询详情</span></a></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong><span style=\"color: rgb(229, 51, 51);\">&nbsp;三. 智能手机刷机救砖班</span></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/>&nbsp;课程特色：适合无基础学员，专门学习苹果，安卓手机刷机<br/>学制：3-5天&nbsp; 费用：1200<br/>手机出现系统被损坏，造成功能失效或无法开机，也通常通过刷机来解决。一般</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">1、讲解手机刷机原因（手机运行速度慢、闪退、自动关机、重启、变砖等等）。<br/>2、讲解手机刷机的几种方式及区别：线刷，卡刷，软刷和厂刷。<br/>3、学习手机线刷方法及注意事项。<br/>4、学习手机卡刷方法及注意事项。<br/>5、讲解手机软刷方法及注意事项（三星苹果专用救转软件、国产机专用救转软件）。<br/>6、各品牌手机刷机的方法及要领，手机换那些配件后不适合刷机等预备工作讲解。&nbsp;<a href=\"http://p.qiao.baidu.com/im/index?siteid=10396738&ucid=19992246&cp=&cr=&cw=\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(0, 0, 0);\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(255, 153, 0);\"><strong>点击咨询详情</strong></span></a></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/><strong><span style=\"color: rgb(229, 51, 51);\">&nbsp;四.&nbsp;手机屏幕贴合培训班</span></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/>&nbsp;课程特色：零基础学习，学成后能够让学员独立解决手机屏幕爆屏，屏幕分离技术等、<br/>学制：3-5天 费用：1200<br/>1、讲解手机屏幕的机构原理。<br/>2、讲解电容触摸屏与电阻触摸的结构原理和工作方式。<br/>3、学习手机液晶屏与触摸屏的分离技术。<br/>4、学习手机屏幕背光纸的贴合技巧。<br/>5、讲解手机屏幕（玻璃基板、背光板、彩色滤光片、液晶、偏光板、灯管、扩散板）工作的原理。<br/>6、学习手机镜面的分离更换、换中框、换背光、<br/>7、学习自主修复黑屏、白屏、红屏、花屏、触摸不灵等故障。<br/>8、学习苹果手机的外配拆装。&nbsp;<a href=\"http://p.qiao.baidu.com/im/index?siteid=10396738&ucid=19992246&cp=&cr=&cw=\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(0, 0, 0);\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(255, 153, 0);\"><strong>点击咨询详情</strong></span></a></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong><span style=\"color: rgb(229, 51, 51);\">五.学历班：</span></strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong>一年制手机高级维修班</strong>（送电脑维修班）&nbsp; 费用：8800元&nbsp;&nbsp;&nbsp; （小班精讲&nbsp; 毕业发中专证、职业技能合格证书和职业资格中级证书）<br/><strong>两年制手机高级维修班</strong>（送电脑维修班+网络工程班）<br/>（小班精讲&nbsp; 毕业发大专证、中专证、职业技能合格证书和职业资格中级证书）所有培训均可签订就业合同保证就业 &nbsp;&nbsp;<a href=\"http://p.qiao.baidu.com/im/index?siteid=10396738&ucid=19992246&cp=&cr=&cw=\" target=\"_blank\" style=\"text-decoration-line: none; color: rgb(0, 0, 0);\"><span style=\"color: rgb(255, 255, 255); background-color: rgb(255, 153, 0);\"><strong>点击咨询更多</strong></span></a></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\">如报名请提前预约名额，为了保证教学质量，每期只招15人，预约电话18838264830或QQ940463855或微信zzhuaren</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;; font-size: 14px; white-space: normal;\"><strong><span style=\"color: rgb(229, 51, 51);\">注：本校向学员免费提供手机维修工具、手机及手机配件批发渠道电话、开店经验等。同时长期为学员提供免费维修技术支持、疑难解答等相关问题。</span></strong></p><p><br/></p>',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','2018822162918742',1,2,0,10),(1531,0,68,'学校介绍','School introduction','郑州华人手机维修培训,隶属于郑州华人职业培训学校，提供智能手机维修培训,苹果IPHONE手机维修培训,IPAD平板电脑维修培训,是郑州手机维修培训领导品牌,学校常年开设手机维修培训,小班授课,包教包会，至今已培养了来自国内外上千万名学员，不少已成为维修和培训行业的佼佼者，深得同行的赞赏与认可！同时积累了丰富的手机维修培训教学的经验！\r\n报名热线：0371-63636333\r\n','page',1,1,51,'/upimages/20180925/39849a679a203329991fa22d98e7329352.jpg',0,3,'tl',1,1,'<p><span style=\"color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;, Arial, Helvetica, sans-serif; font-size: 14px;\"><img src=\"https://www.suibianxia.cn/upimages/20180922/1537592510719854.jpg\" title=\"1537592510719854.jpg\" alt=\"01.jpg\"/></span></p><p><span style=\"color: rgb(51, 51, 51); font-family: &quot;Microsoft Yahei&quot;, Arial, Helvetica, sans-serif; font-size: 14px;\">郑州华人手机维修培训,隶属于郑州华人职业培训学校，提供智能手机维修培训,苹果IPHONE手机维修培训,IPAD平板电脑维修培训,是郑州手机维修培训领导品牌,学校常年开设手机维修培训,小班授课,包教包会，至今已培养了来自国内外上千万名学员，不少已成为维修和培训行业的佼佼者，深得同行的赞赏与认可！同时积累了丰富的手机维修培训教学的经验！</span></p>',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','201882216193117',1,2,0,10),(1560,0,69,'杂项鉴定','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/jiaju/nav4.png',1,12,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018822201536625',1,2,0,10),(1559,0,69,'字画鉴定','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/jiaju/nav3.png',1,12,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','201882220152528',1,2,0,10),(1558,0,69,'玉器鉴定','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/jiaju/nav2.png',1,12,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','20188222015679',1,2,0,10),(1557,0,69,'瓷器鉴定','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/jiaju/nav1.png',1,12,'tc',0,0,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"0\";s:4:\"ptit\";s:1:\"0\";}','2018822201437400',1,2,0,10),(1621,0,26,'加盟培训','Join','','page',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/nav4.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(1620,0,26,'关于我们','About','','page',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/nav1.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(1619,1615,26,'沙发维修材料','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/pigefanxin/column4.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1618,1615,26,'家具维修材料','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/column3.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1617,1615,26,'维修工具','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/column2.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1616,1615,26,'维修套装','','','showPro',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/column1.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1615,0,26,'材料销售','store','','showPro',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav3.png',0,12,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1613,0,26,'客户案例','case','','showArt',1,1,8,'',1,3,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1614,0,26,'加盟优势','Advantage','','showArt',1,1,99,'',1,2,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1612,0,26,'服务项目','Service','','showArt',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav2.png',1,1,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1591,0,70,'服务项目','Service','','showArt',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav2.png',1,1,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1592,0,70,'客户案例','case','','showArt',1,1,8,'',1,3,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1593,0,70,'加盟优势','Advantage','','showArt',1,1,99,'',1,2,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1594,0,70,'材料销售','store','','showPro',1,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/nav3.png',0,12,'tc',1,0,'',0,0,NULL,NULL,1,2,0,10),(1595,1594,70,'维修套装','','','showPro',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/column1.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1596,1594,70,'维修工具','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/pigefanxin/column2.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1597,1594,70,'家具维修材料','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/column3.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1598,1594,70,'沙发维修材料','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/pigefanxin/column4.jpg',1,12,'tl',0,0,'',0,0,NULL,NULL,1,2,0,10),(1599,0,70,'关于我们','About','','page',0,1,99,'http://cs.riyuanma.com/assetsj/pigefanxin/nav1.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(1600,0,70,'加盟培训','Join','','page',0,1,97,'http://cs.riyuanma.com/assetsj/pigefanxin/nav4.png',1,0,'',0,2,'此处是栏目内容',0,0,NULL,NULL,1,2,0,10),(1601,0,71,'客照欣赏','Photo Cases','','showPic',1,1,9,'',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1602,1601,71,'婚纱摄影','Wedding photography','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav1.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1603,1601,71,'全球旅拍','Global tour','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav2.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1604,1601,71,'个人写真','Personal photo','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav3.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1605,1601,71,'情侣闺蜜','Lovers & girlfriends','','showPic',1,1,9,'http://cs.riyuanma.com/assetsj/hunsha/nav4.png',1,2,'tcb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1606,0,71,'优惠活动','Activities','','showArt',1,1,8,'',1,1,'tlb',2,0,'',0,0,NULL,NULL,1,2,0,10),(1607,0,71,'服务展示','Service display','','showPro',1,1,5,'',1,12,'none',2,0,'',0,0,NULL,NULL,1,2,0,10),(1608,0,72,'教练预约','subscribe/trainer','','showPro',1,1,99,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1609,0,72,'会员卡办理','power','','showPro',1,1,88,'',1,12,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1610,0,72,'俱乐部器材','equipment','','showPic',1,1,90,'',1,5,'none',1,0,'',0,0,NULL,NULL,1,2,0,10),(1611,0,63,'阅读','','','showArt',1,1,50,'',1,2,'tl',1,1,'',0,0,'a:2:{s:5:\"pmarb\";s:1:\"1\";s:4:\"ptit\";s:1:\"1\";}','20188281428948',1,2,0,10),(1653,0,1,'储物系列','','','showPro',0,1,92,'http://cs.riyuanma.com/assetsj/jiaju/nav8.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1651,0,1,'商务办公','','','showPro',0,1,94,'http://cs.riyuanma.com/assetsj/jiaju/nav6.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1652,0,1,'儿童系列','','','showPro',0,1,93,'http://cs.riyuanma.com/assetsj/jiaju/nav7.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1650,0,1,'客厅系列','','','showPro',0,1,95,'http://cs.riyuanma.com/assetsj/jiaju/nav5.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1647,0,1,'卧室系列','','','showPro',0,1,98,'http://cs.riyuanma.com/assetsj/jiaju/nav2.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1649,0,1,'阳台系列','','','showPro',0,1,96,'http://cs.riyuanma.com/assetsj/jiaju/nav4.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1648,0,1,'书房系列','','','showPro',0,1,97,'http://cs.riyuanma.com/assetsj/jiaju/nav3.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10),(1646,0,1,'所有产品','','','showPro',0,1,999,'http://cs.riyuanma.com/assetsj/jiaju/nav1.png',1,12,'tc',0,0,'',0,0,NULL,NULL,1,2,0,10);
/*!40000 ALTER TABLE `ims_sudu8_page_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_collect`
--

DROP TABLE IF EXISTS `ims_sudu8_page_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_collect`
--

LOCK TABLES `ims_sudu8_page_collect` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_collect` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_collect` VALUES (1,5,'showPro',30,1),(9,5,'showPro_lv',0,1),(10,5,'pt',1,1),(12,5,'showPro',53,1),(8,7,'showPro',30,1);
/*!40000 ALTER TABLE `ims_sudu8_page_collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_about`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_about`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotline` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `after_sale` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `letlon` varchar(255) NOT NULL,
  `descs` text NOT NULL,
  `teamdesc` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `ewm` varchar(255) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `banner` mediumtext NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_about`
--

LOCK TABLES `ims_sudu8_page_com_about` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_about` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_com_about` VALUES (1,'40000000000','8139306@qq.com','2475289346','13800000000','站码之家源码全行业小程序系统','xxxxxxxxxxxxxxxxxxxxxxx','118.204603,39.633971','','<p><img src=\"http://cs.riyuanma.com/upimages/20200114/1578972884229424.jpg\" title=\"1578972884229424.jpg\" alt=\"8.jpg\"/><img src=\"http://cs.riyuanma.com/upimages/20200114/1578972895251610.jpg\" title=\"1578972895251610.jpg\" alt=\"9.jpg\"/></p>','/upimages/20191204/fe2d6c4b3b4c1b01f64be6dd6ea6beaf643.png','/upimages/20200114/a7c0366f07be44b769567344e637ea52356.jpg','xxxxxxxxxxxxxx','a:9:{s:7:\"banner1\";s:58:\"/upimages/20200227/b22971abedb5ec2b9744dc4e6bca59a8818.jpg\";s:7:\"banner2\";N;s:7:\"banner3\";N;s:10:\"banner1_t1\";s:0:\"\";s:10:\"banner2_t1\";s:0:\"\";s:10:\"banner3_t1\";s:0:\"\";s:10:\"banner1_t2\";s:0:\"\";s:10:\"banner2_t2\";s:0:\"\";s:10:\"banner3_t2\";s:0:\"\";}','小程序代理，小程序加盟，全行业小程序代理,微信小程序','站码之家全程小程序加盟代理系统，全行业解决方案，内置强大功能模块，满足客户对小程序的所有需求');
/*!40000 ALTER TABLE `ims_sudu8_page_com_about` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_cases`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `ewm` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `casetype` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1上线  2下线',
  `hits` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `recommend` int(1) NOT NULL DEFAULT '2' COMMENT '1推荐 2不推荐',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_cases`
--

LOCK TABLES `ims_sudu8_page_com_cases` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_cases` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_com_cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_func`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_func`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_func` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `descs` varchar(255) NOT NULL,
  `listbg` varchar(7) NOT NULL,
  `text` text NOT NULL,
  `place` varchar(255) NOT NULL,
  `func` varchar(255) NOT NULL,
  `funcimg` mediumtext NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1上线 2下线',
  `num` int(11) NOT NULL COMMENT '排序',
  `createtime` int(11) NOT NULL COMMENT '添加时间',
  `hits` int(11) NOT NULL COMMENT '人气',
  `recommend` int(1) NOT NULL DEFAULT '2' COMMENT '1推荐 2不推荐',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_func`
--

LOCK TABLES `ims_sudu8_page_com_func` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_func` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_com_func` VALUES (5,'多规格商城','icon-gouwucheman','多规格商城是指在商城中能够选取规格、多规格匹配。点击购买弹出弹框，用来选择规格和选择购买数量，并和库存匹配。','#c3c3c3','<p style=\"text-align: center\"><br/></p><p style=\"text-align: center;\"><span style=\"color: rgb(255, 255, 255);\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533865047361423.jpg\" title=\"1533865047361423.jpg\" alt=\"多规格商品1.jpg\"/></span></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533865146852057.jpg\" title=\"1533865146852057.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533865147472171.jpg\" title=\"1533865147472171.jpg\"/></p><p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><br/></p>','实物售卖,服务售卖','商品规格设置,秒杀商品','a:1:{i:0;s:58:\"/upimages/20180810/8c7caee72e7937137b04c83517b8786c996.jpg\";}',1,1,1533864331,1,2),(6,'付费视频系统','icon-shipin','付费视频是为了维护视频版权，促进用户知识付费的一种手段。','#b3d246','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','商业活动,运营推广,文体创意','在线支付,评论审核','a:1:{i:0;s:58:\"/upimages/20180810/02a94f535c0a070b10aacbf0a15e4bbb985.jpg\";}',1,2,1533864465,0,2),(7,'多门店','icon-duomendian1','多门店共享数据，可切换不同城市显示，搜索门店并显示门店详情。','#4a79ee','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533864536280694.jpg\" title=\"1533864536280694.jpg\" alt=\"多门店管理.jpg\"/></p>','连锁店','切换城市页面,多门店搜索,门店列表展示','a:1:{i:0;s:58:\"/upimages/20180810/da6f2081c0d23952f35961965e29e5af748.jpg\";}',1,3,1533864557,0,2),(8,'可拖拽DIY','icon-shangxiatuozhuai','APP设计制作一站式解决方案，创造出独一无二的专属小程序。无需懂代码，都可以借助DIY官网可视化工具，顷刻间打造自已的个性化移动应用。','#b351e5','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','页面布局','多模块组合,细节调控,拖拽布局,实时预览','a:1:{i:0;s:58:\"/upimages/20180810/e36078cf6beb12818772b4f441c15a5d463.jpg\";}',1,4,1533865376,3,2),(9,'权限管理','icon-quanxian','自定义配置用户可使用的功能，分别给予权限。','#f6cd3d','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','招商,代理商管理','权限分配','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,5,1533865453,0,2),(10,'百度小程序','icon-baidu','百度小程序制作，无需编程，一键生成，百变应用，自由组合。','#7c56ec','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','小程序制作','界面DIY,营销功能,一键模板','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,6,1533865529,0,2),(11,'支付宝小程序','icon-zhifubao-copy-copy-copy-copy','支付宝小程序制作与发布，无需编程，一键生成。','#f88234','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','小程序制作','DIY,一键模板,营销功能','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,7,1533865584,0,2),(12,'数据分析','icon-shujufenxi','对小程序流量数据、订单数据、交易数据等进行分析，统计活跃用户和热销商品等。','#45d8be','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动,会员管理','生日提醒,积分榜单,热销榜单','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,8,1533865786,0,2),(13,'订单管理','icon-neirong','对多规格商品、秒杀商品、预约预定商品等订单状态操作。','#4a79ef','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','秒杀商城,拼团,预约预定','订单发货,订单取消,订单核销','a:1:{i:0;s:57:\"/upimages/20180810/720c33270ddf24449cea7eef17972f9664.jpg\";}',1,9,1533865942,0,2),(14,'手机客服插件','icon-kefu2','商家为客户提供线上的咨询服务，通过手机客服为客户解决需求问题。','#c3c3c2','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','详情咨询,问题提交,故障报修','自动回复,常见问题列表,人工客服','a:2:{i:0;s:58:\"/upimages/20180810/90fff8f1cdfb54c32fe537646ce95bdd933.jpg\";i:1;s:58:\"/upimages/20180810/36ba003b55b3e066a7f987015cbe183a969.jpg\";}',1,10,1533866023,1,2),(15,'积分管理','icon-jifen11','对分享获取积分、充值获取积分、签到获取积分等多种积分获取形式以及积分兑换进行管理。','#9557f1','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动','签到积分,积分商城,分享积分','a:1:{i:0;s:58:\"/upimages/20180810/fe6a14d2fd5890296d8bc527585e79a3485.jpg\";}',1,11,1533866092,0,2),(16,'一键模板','icon-template','多行业优秀模板可选，一键生成场景适用小程序页面。','#f88234','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','小程序制作','全行业模板,一键套用','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,12,1533866151,0,2),(17,'广告设置','icon-guanggao','对开屏广告、首页广告、弹窗广告等进行设置和管理。','#76ca9d','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','活动通知,节日祝福,产品促销','弹窗广告,开屏广告,首页广告','a:1:{i:0;s:58:\"/upimages/20180810/7702010680c056f122727e4c18b6c259584.jpg\";}',1,13,1533866227,0,2),(18,'自定义菜单','icon-index','底部菜单栏DIY，自定义外观、功能。','#b351e6','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','小程序制作','图标设置,跳转设置,选中设置','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,14,1533866307,0,2),(19,'多商户插件','icon-wodetuandui','多商户入驻平台插件','#f88234','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','服务平台','店铺管理,商家提现,订单管理','a:1:{i:0;s:58:\"/upimages/20180810/c0f43aaadb8d0fbb812aa951b7fcc651106.jpg\";}',1,15,1533866466,0,2),(20,'会员管理','icon-huiyuanguanli','对会员信息，会员开卡，会员卡折扣，会员卡积分等进行设置和管理。','#7c57f2','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动','会员开卡,会员积分,会员折扣','a:1:{i:0;s:58:\"/upimages/20180810/f348bcaa9a54811cf5773472141d5430573.jpg\";}',1,16,1533866537,0,2),(21,'内容库管理','icon-neirong1','对多种模型的内容（文章、组图、商品）进行快速筛选','#b3d246','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','商品分类,文章分类,图片分类','内容标签,内容分类,内容搜索','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,17,1533866693,1,2),(22,'评论管理','icon-pinglun','对文章、组图、商品等内容下的评论进行审核和管理。','#c3c3c3','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','组图欣赏,文章分享,商品评价','评论审核,评论删除,评论置顶','a:1:{i:0;s:58:\"/upimages/20180810/f587924d842c61466de73c0c08da766c590.jpg\";}',1,18,1533866772,0,2),(23,'小程序管理','icon-xiaochengxu','对小程序跳转进行管理。','#7c56ed','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533866863295780.jpg\" title=\"1533866863295780.jpg\" alt=\"组图和小程序.jpg\"/></p>','手机客服,预约预定,店内点餐,积分签到','小程序跳转','a:1:{i:0;s:58:\"/upimages/20180810/cde6141fe3289db668da56422f19ec65309.jpg\";}',1,19,1533866868,1,2),(24,'组图管理','icon-zutu','对图片、幻灯片进行设置和管理。','#f6cd3d','<p style=\"text-align: center\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533866915829315.jpg\" title=\"1533866915829315.jpg\" alt=\"组图和小程序.jpg\"/></p><p><br/></p>','客单展示,栏目图','多栏目,分享图,分享积分','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,20,1533866933,0,2),(25,'商品管理','icon-shangpin','对多规格商品、秒杀商品、预约商品进行设置和管理。','#f78133','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867019518945.jpg\" title=\"1533867019518945.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867020633729.jpg\" title=\"1533867020633729.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867020392106.jpg\" title=\"1533867020392106.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867020869205.jpg\" title=\"1533867020869205.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867020649907.jpg\" title=\"1533867020649907.jpg\"/></p><p style=\"text-align: center;\"><br/></p>','多规格商城,预约预定,秒杀商城','规格设置,万能表单','a:1:{i:0;s:58:\"/upimages/20180810/970b1c48c73885e69f847e30cb20be33743.jpg\";}',1,21,1533867047,0,2),(26,'充值管理','icon-chongzhi1','对充值优惠规则、积分规则等进行设置和管理。','#4a79ef','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动','充值规则','a:1:{i:0;s:59:\"/upimages/20180810/75e53806c9475da61ef8113cb1b6ea4e1000.jpg\";}',1,22,1533867153,1,2),(27,'预约报名','icon-yuyue','报名设预约报名期，在期限内预约用户进行报名。预约报名期内，用户通过填写和提交个人信息的方式进行报名，在约定期限内报满为止。','#45d8bd','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','培训机构,美容美发,婚纱摄影','万能表单,订单管理,核销','a:1:{i:0;s:58:\"/upimages/20180810/3528fa10c050a7cc449b4c4dd5c1bc1b596.jpg\";}',1,23,1533867221,0,2),(28,'文章管理系统','icon-wenzhangguanlixitong','对文章详细内容、所属栏目、访问量、评论、分享操作、底部菜单、关联文章等进行管理。','#9557f1','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533867294574848.jpg\" title=\"1533867294574848.jpg\" alt=\"文章.jpg\"/></p>','门店概况,案例展示','文章管理,分享获取积分,关联文章,评论审核','a:1:{i:0;s:58:\"/upimages/20180810/423d48bf2a67d156edfb12831549a169103.jpg\";}',1,24,1533867299,1,2),(30,'万能表单','icon-biaodan','超强大的自定义表单模块，不同行业和岗位的人员不需要特殊技能，都可以方便的创建出符合业务需求的表单小程序。数据收集，简单方便，客户登记、意见反馈、活动报名等轻松搞定。万能表单自动收集并整理数据，帮助用户节省工作时间，高效率、更便捷的完成工作。','#b3d145','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533882169607710.jpg\" title=\"1533882169607710.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533882169486865.jpg\" title=\"1533882169486865.jpg\"/></p><p style=\"text-align: center;\"><br/></p>','预约约定,自助报价,服务反馈','用户信息收集,交易信息提醒,系统预约','a:1:{i:0;s:58:\"/upimages/20180810/f4ea1f980dbb293c6c5dcd437c03a742606.jpg\";}',1,26,1533867533,1,2),(31,'消息通知','icon-jiaoliu','设置商品状态通知、成团通知、预约预定通知、系统表单通知、会员卡开卡通知等消息模板，配置商家收发消息邮箱实现邮件通知。','#77ca9e','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','预约通知,成团通知,退款通知','邮箱设置,消息模板','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,29,1533870982,0,2),(32,'分销模块','icon-fenxiao','帮助企业快速搭建企业独立在线商城,自由选择分销模式,从多方位,多角度提供服务支持,助力商户实现分销渠道裂变销货,连锁门店线上化高效经营。','#c3c3c3','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533871210186923.jpg\" title=\"1533871210186923.jpg\" alt=\"分销中心.jpg\"/></p>','分销','分销商申请,处理分销订单,快速提现','a:1:{i:0;s:58:\"/upimages/20180810/b6a9f632d5d97a2e50b36fe447cc6a68486.jpg\";}',1,32,1533871290,7,2),(33,'秒杀商城插件','icon-miaosha1','商品类型为秒杀商品，设置秒杀时间、限定数量，在规定内买家以秒杀价购买商品。','#4a78e9','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533871368782198.jpg\" title=\"1533871368782198.jpg\" alt=\"多规格商品4.jpg\"/></p>','营销活动,商品促销','秒杀商品,订单管理,在线支付','a:1:{i:0;s:58:\"/upimages/20180810/fc7ae60dc5e8a8dd53a3706f102ac507473.jpg\";}',1,0,1533871404,2,2),(34,'付费预约','icon-fufeiyuyue','通过付费缴纳定金的方式进行预约，用户预约成功后在对应时间获得商户指定商品或服务。','#76ca9d','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533872387170015.jpg\" title=\"1533872387170015.jpg\" alt=\"多规格商品5.jpg\"/></p>','培训机构,美容美发,快餐餐饮','万能表单,在线支付,订单管理','a:1:{i:0;s:58:\"/upimages/20180810/26442a179bcd9c1927b017d7e1d88a73401.jpg\";}',1,0,1533872404,0,2),(35,'优惠券','icon-youhuiquan3','优惠券是一种相对成熟的营销工具，可在后台添加优惠券','#4a79ee','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533872476164302.jpg\" title=\"1533872476164302.jpg\" alt=\"优惠券.jpg\"/></p>','商品购买','满减,打折券,代金券','a:2:{i:0;s:58:\"/upimages/20180810/216c215278fe0057ccef706e5812207f733.jpg\";i:1;s:58:\"/upimages/20180810/e7f26871de8f005e91b708456fa85d50422.jpg\";}',1,0,1533872505,0,2),(36,'拼团商城插件','icon-pintuan','参加拼团的商品都有单独购买价格和拼团价格，在规定时间内达到相应的标准人数购买，则拼团成功。','#45d8be','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','商品促销,营销活动','商品管理,订单管理,成团通知,退款管理','a:1:{i:0;s:58:\"/upimages/20180810/6c39c553cfc003e50bee0f649ac669ee881.jpg\";}',1,0,1533879008,1,2),(37,'店内点餐插件','icon-canyin','无需呼叫服务员，省去排队等待时间，立即点餐，即点即用。线上线下零距离对接商家厨房最短时间送餐上桌，一键快捷支付，省时省力。每个订单实时对接后台，财务报表、资金流水、客流量盈亏分析随时掌握。','#d8459b','<p><span style=\"color: rgb(255, 255, 255);\">1</span><br/></p>','店内点餐,线上订餐,外卖','购物车,在线支付,桌号管理,订单管理,点餐通知','a:1:{i:0;s:58:\"/upimages/20180810/40103b17449bdfc1828fe86ff30d2f47164.jpg\";}',1,0,1533880881,3,2),(38,'代理商管理','icon-wodetuandui','拥有底层源码系统，发展自己的代理商，列表清晰展示各代理商状态，详细设置对代理商账号信息、创建小程序的个数、系统到期时间等进行管理。','#e83f66','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','招商,代理商加盟','权限管理,到期时间','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,0,1533881005,0,2),(39,'积分签到插件','icon-qiandao1','用户登陆商家小程序进行每日签到，获取相应积分。','#f6cd3d','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动','积分管理,积分抵扣','a:1:{i:0;s:58:\"/upimages/20180810/f68f03cbf89ca84e2d3861685a6a6c4b790.jpg\";}',1,0,1533881081,1,2),(40,'多栏目管理','icon-XB_lanmu','对所有内容模型的栏目进行管理。','#76ca9d','<p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533881593451666.jpg\" title=\"1533881593451666.jpg\" width=\"1\" height=\"1\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533881694815225.jpg\" title=\"1533881694815225.jpg\" alt=\"多类型栏目管理1.jpg\"/></p><p style=\"text-align: center;\"></p><p><br/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533882069350984.jpg\" title=\"1533882069350984.jpg\" alt=\"多类型栏目管理2.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533881929187054.jpg\" title=\"1533881929187054.jpg\"/></p><p style=\"text-align: center;\"><img src=\"https://duli3.nttrip.cn/upimages/20180810/1533881988894589.jpg\" title=\"1533881988894589.jpg\" alt=\"多类型栏目管理4.jpg\"/></p><p style=\"text-align: center;\"><br/></p>','小程序制作','栏目增删,列表模式,幻灯片','a:1:{i:0;s:57:\"/upimages/20180810/dbd15640024ec507e4199b642231cf5941.jpg\";}',1,0,1533881702,0,2),(41,'积分兑换商城','icon-jifen11','用户获得积分后可以在积分商城中兑换优惠券、礼品卡或商家指定商品等。','#7c57f3','<p><span style=\"color: rgb(255, 255, 255);\">1</span></p>','营销活动','商品管理,积分兑换,订单管理','a:1:{i:0;s:58:\"/upimages/20180809/ad12d003da8b29cea7d56c054a52bf38563.jpg\";}',1,0,1533882242,2,2);
/*!40000 ALTER TABLE `ims_sudu8_page_com_func` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_news`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descs` varchar(255) NOT NULL,
  `tips` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `hits` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '1产品动态  2公告  3更新',
  `recommend` int(1) NOT NULL DEFAULT '2',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_news`
--

LOCK TABLES `ims_sudu8_page_com_news` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_com_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_solution`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_solution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_solution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `entitle` varchar(255) NOT NULL,
  `listbg` varchar(7) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `descs` varchar(255) NOT NULL,
  `typedesc` text NOT NULL,
  `slides` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `hits` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `recommend` int(1) NOT NULL DEFAULT '2',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_solution`
--

LOCK TABLES `ims_sudu8_page_com_solution` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_solution` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_com_solution` VALUES (2,'智慧餐饮','Smart food and beverage','#F6CD3D','icon-diancan','案例：水煎肉','a:15:{s:6:\"title1\";s:12:\"线上点餐\";s:5:\"icon1\";s:11:\"icon-canyin\";s:6:\"descs1\";s:75:\"支持在线选单、下单，支持在线选择桌号，支持线上支付\";s:6:\"title2\";s:12:\"优惠设置\";s:5:\"icon2\";s:16:\"icon-youhuiquan2\";s:6:\"descs2\";s:60:\"结算时可用优惠券、红包或积分抵消一定金额\";s:6:\"title3\";s:12:\"配送模式\";s:5:\"icon3\";s:12:\"icon-icon049\";s:6:\"descs3\";s:54:\"支持外卖配送、堂吃、到店取餐三种模式\";s:6:\"title4\";s:15:\"连锁店切换\";s:5:\"icon4\";s:13:\"icon-dianmian\";s:6:\"descs4\";s:60:\"根据所在地自由切换门店，获取不同门店信息\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:33:\"适用于线下餐厅、酒店等\";}','a:2:{i:0;s:58:\"/upimages/20180809/205f590497a037110fdfb9afd054e4ad844.png\";i:1;s:58:\"/upimages/20180809/bb7d67b961015170ac2b94c6ec9f295c204.jpg\";}',1,3,0,2,1533804226),(3,'智慧商城','Smart Mall','#4b7af0','icon-shangcheng','案例：燕郊盈讯网络、高密床垫、建宁超市共享田园、搜索猫','a:15:{s:6:\"title1\";s:15:\"多规格商品\";s:5:\"icon1\";s:14:\"icon-shangpin1\";s:6:\"descs1\";s:81:\"提供多样化产品规格，例如商家配送、平台配送或用户自提等\";s:6:\"title2\";s:9:\"购物车\";s:5:\"icon2\";s:16:\"icon-gouwucheman\";s:6:\"descs2\";s:54:\"将要购买的商品添加到购物车，统一结算\";s:6:\"title3\";s:12:\"营销功能\";s:5:\"icon3\";s:14:\"icon-yingxiao2\";s:6:\"descs3\";s:72:\"秒杀、团购、消费满减……多元化营销提高购买转化率\";s:6:\"title4\";s:12:\"数据分析\";s:5:\"icon4\";s:15:\"icon-shujufenxi\";s:6:\"descs4\";s:54:\"全方位掌控运营数据，帮助商家提升效益\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:83:\"服装/日用百货/食品/电器/母婴/自媒体等有电商需求的所有行业\";}','a:4:{i:0;s:58:\"/upimages/20180810/85d649f84c556f6e97320983677f9d6a958.jpg\";i:1;s:58:\"/upimages/20180810/6d2d9b35a99331dfe0073ca08392eff8287.jpg\";i:2;s:58:\"/upimages/20180810/022e845a9a96e05d4c21dfe81fc6e54e226.jpg\";i:3;s:58:\"/upimages/20180810/d10a1a9b5b4fc4e8c0c60eaa5dfe82b4881.jpg\";}',1,2,0,2,1533882543),(4,'智慧美业','Smart Beauty Industry','#7c57f5','icon-meirong','案例：美肌工坊石龙店、荆门美容美体、美发案例lite、爱尚美加、美崎发型','a:15:{s:6:\"title1\";s:12:\"服务预约\";s:5:\"icon1\";s:10:\"icon-yuyue\";s:6:\"descs1\";s:54:\"电话预约、提交预约表单，在线预约服务\";s:6:\"title2\";s:12:\"优惠活动\";s:5:\"icon2\";s:16:\"icon-youhuiquan2\";s:6:\"descs2\";s:27:\"打折活动，代金券等\";s:6:\"title3\";s:15:\"多门店切换\";s:5:\"icon3\";s:16:\"icon-duomendian1\";s:6:\"descs3\";s:45:\"根据所在地切换，选择附近的门店\";s:6:\"title4\";s:12:\"客服咨询\";s:5:\"icon4\";s:10:\"icon-kefu2\";s:6:\"descs4\";s:51:\"专家在线提供问题解答、美容美体建议\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:33:\"美容美发店、整形医院等\";}','a:3:{i:0;s:58:\"/upimages/20180810/bcab7ff9c87c73784ffe332dd90ec437669.jpg\";i:1;s:58:\"/upimages/20180810/a61ff88254db763a07dc9a8bd690e615301.jpg\";i:2;s:58:\"/upimages/20180810/405e0ddd853aa9291cbbc82bd0743ba0720.jpg\";}',1,2,0,2,1533886158),(5,'智慧旅游','Smart Tourism','#b3d246','icon-lvyou','案例：济南长清服务区、高密龙行天下旅行社、洛阳燕行天下旅行社、西安市旅游攻略、海南逍遥游、日照旅游指南','a:15:{s:6:\"title1\";s:12:\"咨询报价\";s:5:\"icon1\";s:9:\"icon-kefu\";s:6:\"descs1\";s:51:\"支持路线自主定价、联系客服咨询报价\";s:6:\"title2\";s:12:\"网络订票\";s:5:\"icon2\";s:13:\"icon-chongzhi\";s:6:\"descs2\";s:48:\"在线订票，车票、机票、景点门票等\";s:6:\"title3\";s:12:\"在线预约\";s:5:\"icon3\";s:10:\"icon-yuyue\";s:6:\"descs3\";s:48:\"填写信息表格，预约心仪线路旅游团\";s:6:\"title4\";s:12:\"旅游攻略\";s:5:\"icon4\";s:12:\"icon-neirong\";s:6:\"descs4\";s:39:\"图文、视频展示各地旅游攻略\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:27:\"旅行社、旅行景点等\";}','a:2:{i:0;s:58:\"/upimages/20180810/d1e3739fd4603838ac8c99ea656d1787128.jpg\";i:1;s:58:\"/upimages/20180810/ef139752d4ae6a66baf00128d27a52f6402.jpg\";}',1,1,0,2,1533887048),(6,'智慧休娱','Smart Recreation','#77ca9e','icon-jianshen','案例：Power健身会所、摩登天空KTV、腰石水库','a:15:{s:6:\"title1\";s:12:\"卡券系统\";s:5:\"icon1\";s:25:\"icon-membership-card_icon\";s:6:\"descs1\";s:60:\"会员卡折扣、消费获取积分抵扣金额、优惠券\";s:6:\"title2\";s:12:\"项目预约\";s:5:\"icon2\";s:10:\"icon-yuyue\";s:6:\"descs2\";s:36:\"预约包房、预约教练、课程\";s:6:\"title3\";s:12:\"网上购票\";s:5:\"icon3\";s:13:\"icon-chongzhi\";s:6:\"descs3\";s:27:\"在线购票，线下取票\";s:6:\"title4\";s:12:\"充值系统\";s:5:\"icon4\";s:7:\"icon-48\";s:6:\"descs4\";s:39:\"线上提前储金，获取充值积分\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:30:\"健身房、KTV、电影院等\";}','a:2:{i:0;s:58:\"/upimages/20180810/ce7997a1bf99ac8943aa72c75e34c3f2927.jpg\";i:1;s:58:\"/upimages/20180810/9577f1a9022182a1e6495999be0fc7bb907.jpg\";}',1,3,0,2,1533887719),(7,'智慧家装','Smart House Fitment','#b351e6','icon-jiazhuang','案例：天佑家居、云尚居家装装饰、天之蓝办公家具、揭阳家居建材、威海装修装饰平台、共享星管家、湖南千思智造家装饰','a:15:{s:6:\"title1\";s:12:\"案例展示\";s:5:\"icon1\";s:12:\"icon-neirong\";s:6:\"descs1\";s:48:\"客户装修案例图文、视频，分类展示\";s:6:\"title2\";s:12:\"客服中心\";s:5:\"icon2\";s:10:\"icon-kefu2\";s:6:\"descs2\";s:42:\"线上联系客服、设计师进行沟通\";s:6:\"title3\";s:12:\"在线商城\";s:5:\"icon3\";s:15:\"icon-shangcheng\";s:6:\"descs3\";s:30:\"建材、家具等材料出售\";s:6:\"title4\";s:12:\"预约设计\";s:5:\"icon4\";s:10:\"icon-yuyue\";s:6:\"descs4\";s:54:\"填写详细信息、风格要求，预约上门服务\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:45:\"家装公司、设计公司、建材出售等\";}','a:2:{i:0;s:58:\"/upimages/20180810/6349677ea4e674890c9eb3d8871ff10e454.jpg\";i:1;s:58:\"/upimages/20180810/379659f0d41f6ee7c767aa7138edbe1c239.jpg\";}',1,1,0,2,1533888535),(8,'智慧教育','Smart Education','#F6CD3D','icon-jiaoyu','案例：蕲春专业会计培训、小白杨艺术教育、菲尚舞蹈上角校区、通济理科培优、催眠学院','a:15:{s:6:\"title1\";s:12:\"预约试听\";s:5:\"icon1\";s:10:\"icon-yuyue\";s:6:\"descs1\";s:27:\"填写表格预约试听课\";s:6:\"title2\";s:12:\"活动报名\";s:5:\"icon2\";s:10:\"icon-group\";s:6:\"descs2\";s:51:\"在线报名讲座、游学等免费、付费活动\";s:6:\"title3\";s:12:\"校区查询\";s:5:\"icon3\";s:13:\"icon-dianmian\";s:6:\"descs3\";s:45:\"根据所在地切换，选择附近的校区\";s:6:\"title4\";s:19:\"付费文章/视频\";s:5:\"icon4\";s:9:\"icon-yuan\";s:6:\"descs4\";s:42:\"支持网络课程，文章或视频形式\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:42:\"线上线下培训机构、教学机构等\";}','a:2:{i:0;s:58:\"/upimages/20180810/ee303913bdca7431fb22384d9b539bd2658.jpg\";i:1;s:58:\"/upimages/20180810/e929b5b5556e4441764b3c243cf3b3d7964.jpg\";}',1,1,0,2,1533888693),(9,'婚纱摄影','Wedding Photography','#9457f0','icon-hunshasheying','案例：LiCiLiZi礼服高级定制、DREAM摄影Studios、梦想家儿童摄影、南通LOMO摄影、TurlyCouture、星座婚纱摄影、天空浮岛照相馆、唯意海外婚礼、路图全球摄影旅行','a:15:{s:6:\"title1\";s:12:\"客单展示\";s:5:\"icon1\";s:9:\"icon-zutu\";s:6:\"descs1\";s:51:\"不同风格客单的图文、组图、视频展示\";s:6:\"title2\";s:12:\"预约咨询\";s:5:\"icon2\";s:10:\"icon-yuyue\";s:6:\"descs2\";s:54:\"填写表格，选择风格，预约拍摄时间地点\";s:6:\"title3\";s:12:\"优惠活动\";s:5:\"icon3\";s:16:\"icon-youhuiquan2\";s:6:\"descs3\";s:72:\"会员卡、优惠券、积分抵扣、节日特价秒杀等优惠活动\";s:6:\"title4\";s:15:\"多门店切换\";s:5:\"icon4\";s:16:\"icon-duomendian1\";s:6:\"descs4\";s:39:\"根据所在地切换显示附近门店\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:27:\"影楼、摄影工作室等\";}','a:2:{i:0;s:58:\"/upimages/20180810/f35a4397b37f4a3cd68c38d4a9575f3f363.jpg\";i:1;s:58:\"/upimages/20180810/16ef00393262475abe1e6df1e2ee4858572.jpg\";}',1,2,0,2,1533888918),(10,'同城服务','City Service','#7588ff','icon-jiazhengfuwu','案例：五星家政连锁、我想洗衣','a:15:{s:6:\"title1\";s:15:\"多商户平台\";s:5:\"icon1\";s:16:\"icon-wodetuandui\";s:6:\"descs1\";s:27:\"支持多商户入驻平台\";s:6:\"title2\";s:12:\"预约服务\";s:5:\"icon2\";s:10:\"icon-yuyue\";s:6:\"descs2\";s:45:\"线上预约填写信息，提供上门服务\";s:6:\"title3\";s:12:\"卡券系统\";s:5:\"icon3\";s:25:\"icon-membership-card_icon\";s:6:\"descs3\";s:63:\"提供会员卡、优惠券、积分抵扣等多种优惠形式\";s:6:\"title4\";s:12:\"促销活动\";s:5:\"icon4\";s:12:\"icon-miaosha\";s:6:\"descs4\";s:45:\"轻松设定，开启秒杀、拼团等活动\";s:6:\"title5\";s:12:\"适用场合\";s:5:\"icon5\";s:15:\"icon-changjing1\";s:6:\"descs5\";s:39:\"家政服务、洗衣店、鲜花店等\";}','a:2:{i:0;s:58:\"/upimages/20180810/b23c2f1e0fc5991d327b7098b07dc5d3696.jpg\";i:1;s:58:\"/upimages/20180810/2e4d647a3d4c9578e95189a1f24c07dc722.jpg\";}',1,4,0,2,1533895881);
/*!40000 ALTER TABLE `ims_sudu8_page_com_solution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_com_staff`
--

DROP TABLE IF EXISTS `ims_sudu8_page_com_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_com_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `num` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_com_staff`
--

LOCK TABLES `ims_sudu8_page_com_staff` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_com_staff` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_com_staff` VALUES (1,'懒人源码','','www.lanrenzhijia.com',0,1,1578973213);
/*!40000 ALTER TABLE `ims_sudu8_page_com_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_comment`
--

DROP TABLE IF EXISTS `ims_sudu8_page_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '文章id',
  `text` text NOT NULL COMMENT '评论内容',
  `openid` varchar(255) NOT NULL,
  `flag` int(1) DEFAULT '0' COMMENT '0未审  1通过  2不通过',
  `createtime` int(11) NOT NULL,
  `follow` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_comment`
--

LOCK TABLES `ims_sudu8_page_comment` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_copyright`
--

DROP TABLE IF EXISTS `ims_sudu8_page_copyright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `copycon` mediumtext NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_copyright`
--

LOCK TABLES `ims_sudu8_page_copyright` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_copyright` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_copyright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_coupon`
--

DROP TABLE IF EXISTS `ims_sudu8_page_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL DEFAULT '50' COMMENT '序号排序',
  `title` varchar(255) DEFAULT NULL,
  `uniacid` int(11) NOT NULL COMMENT '小程序编号',
  `price` varchar(255) NOT NULL DEFAULT '0' COMMENT '优惠价格',
  `pay_money` varchar(255) NOT NULL DEFAULT '0' COMMENT '使用条件价格',
  `btime` int(11) NOT NULL DEFAULT '0' COMMENT '使用开始日期',
  `etime` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券结束日期',
  `counts` int(11) NOT NULL DEFAULT '-1' COMMENT '优惠券总数',
  `xz_count` int(11) NOT NULL DEFAULT '0' COMMENT '每人限制领取数',
  `creattime` int(11) NOT NULL COMMENT '优惠券创建时间',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '0关闭   1开启',
  `color` char(10) NOT NULL DEFAULT '#ff6600	',
  `nownum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_coupon`
--

LOCK TABLES `ims_sudu8_page_coupon` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_coupon_set`
--

DROP TABLE IF EXISTS `ims_sudu8_page_coupon_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_coupon_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_coupon_set`
--

LOCK TABLES `ims_sudu8_page_coupon_set` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon_set` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_coupon_user`
--

DROP TABLE IF EXISTS `ims_sudu8_page_coupon_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_coupon_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序id',
  `uid` int(11) DEFAULT NULL COMMENT '用户id',
  `cid` int(11) DEFAULT NULL COMMENT '优惠券id',
  `ltime` int(11) DEFAULT '0' COMMENT '领取时间',
  `utime` int(11) DEFAULT '0' COMMENT '使用时间',
  `btime` int(11) DEFAULT '0' COMMENT '开始时间',
  `etime` int(11) DEFAULT '0' COMMENT '结束时间',
  `flag` int(11) NOT NULL DEFAULT '0' COMMENT '0未使用1已使用2已过期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_coupon_user`
--

LOCK TABLES `ims_sudu8_page_coupon_user` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_coupon_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_customer_base`
--

DROP TABLE IF EXISTS `ims_sudu8_page_customer_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_customer_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_customer_base`
--

LOCK TABLES `ims_sudu8_page_customer_base` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_customer_pic`
--

DROP TABLE IF EXISTS `ims_sudu8_page_customer_pic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_customer_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT '用户openid',
  `uniacid` int(11) NOT NULL,
  `flag` int(1) NOT NULL COMMENT '1发 2',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_customer_pic`
--

LOCK TABLES `ims_sudu8_page_customer_pic` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_pic` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_pic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_customer_reply`
--

DROP TABLE IF EXISTS `ims_sudu8_page_customer_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_customer_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL COMMENT '1文本 2图片 3图文 4小程序卡片',
  `content` text NOT NULL,
  `uniacid` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1开启 2不开启',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_customer_reply`
--

LOCK TABLES `ims_sudu8_page_customer_reply` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_customer_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diy`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '页面名称',
  `url` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `creattime` int(11) DEFAULT NULL,
  `flag` int(11) DEFAULT '1' COMMENT '0关闭 1 发布',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diy`
--

LOCK TABLES `ims_sudu8_page_diy` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diy` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_diy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diy_md`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diy_md`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diy_md` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL COMMENT '小程序ID',
  `did` int(11) DEFAULT NULL COMMENT 'DIY表对应的id',
  `mid` int(11) DEFAULT NULL COMMENT '模块对应的id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diy_md`
--

LOCK TABLES `ims_sudu8_page_diy_md` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diy_md` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_diy_md` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diypage`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diypage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diypage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL COMMENT '小程序',
  `index` int(1) NOT NULL DEFAULT '0' COMMENT '是否首页',
  `page` varchar(3000) NOT NULL DEFAULT '' COMMENT '页面信息',
  `items` text NOT NULL COMMENT '组件信息',
  `tpl_name` varchar(32) NOT NULL COMMENT '模板名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diypage`
--

LOCK TABLES `ims_sudu8_page_diypage` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diypage` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_diypage` VALUES (1,1,1,'a:7:{s:10:\"background\";s:7:\"#f1f1f1\";s:13:\"topbackground\";s:7:\"#ffffff\";s:8:\"topcolor\";s:1:\"1\";s:9:\"styledata\";s:1:\"0\";s:5:\"title\";s:6:\"首页\";s:4:\"name\";s:6:\"首页\";s:10:\"visitlevel\";a:2:{s:6:\"member\";s:0:\"\";s:10:\"commission\";s:0:\"\";}}','a:4:{s:14:\"M1575463764732\";a:5:{s:4:\"icon\";s:28:\"iconfont2 icon-tuoyuankaobei\";s:6:\"params\";a:10:{s:5:\"totle\";s:1:\"2\";s:8:\"navstyle\";s:1:\"0\";s:9:\"styledata\";s:1:\"0\";s:6:\"repeat\";s:6:\"repeat\";s:9:\"positionx\";s:4:\"left\";s:9:\"positiony\";s:3:\"top\";s:4:\"size\";s:1:\"0\";s:13:\"backgroundimg\";s:0:\"\";s:9:\"navstyle2\";s:1:\"0\";s:4:\"imgh\";s:0:\"\";}s:5:\"style\";a:18:{s:8:\"dotstyle\";s:5:\"round\";s:8:\"dotalign\";s:4:\"left\";s:10:\"paddingtop\";s:2:\"10\";s:11:\"paddingleft\";s:2:\"10\";s:10:\"background\";s:7:\"#ffffff\";s:13:\"backgroundall\";s:7:\"#ffffff\";s:9:\"leftright\";s:1:\"5\";s:6:\"bottom\";s:1:\"5\";s:7:\"opacity\";s:3:\"0.8\";s:10:\"text_color\";s:4:\"#fff\";s:2:\"bg\";s:7:\"#000000\";s:9:\"jsq_color\";s:3:\"red\";s:3:\"pdh\";s:1:\"0\";s:3:\"pdw\";s:1:\"0\";s:2:\"mt\";s:2:\"10\";s:5:\"sizew\";s:2:\"20\";s:5:\"sizeh\";s:2:\"20\";s:5:\"speed\";s:1:\"5\";}s:4:\"data\";a:1:{s:14:\"C1575463764732\";a:4:{s:6:\"imgurl\";s:58:\"/upimages/20191204/eb8cd3955b77e1f72479949a6d232998243.jpg\";s:7:\"linkurl\";s:0:\"\";s:6:\"single\";s:1:\"1\";s:4:\"text\";s:12:\"文字描述\";}}s:2:\"id\";s:6:\"banner\";}s:14:\"M1575463780216\";a:5:{s:4:\"icon\";s:22:\"iconfont2 icon-anniuzu\";s:6:\"params\";a:8:{s:9:\"styledata\";s:1:\"0\";s:6:\"repeat\";s:6:\"repeat\";s:9:\"positionx\";s:4:\"left\";s:9:\"positiony\";s:3:\"top\";s:4:\"size\";s:1:\"0\";s:13:\"backgroundimg\";s:0:\"\";s:7:\"picicon\";s:1:\"1\";s:8:\"textshow\";s:1:\"1\";}s:5:\"style\";a:14:{s:8:\"navstyle\";s:0:\"\";s:10:\"background\";s:7:\"#ffffff\";s:6:\"rownum\";s:1:\"4\";s:8:\"showtype\";s:1:\"0\";s:7:\"pagenum\";s:1:\"8\";s:7:\"showdot\";s:1:\"1\";s:7:\"padding\";s:1:\"0\";s:11:\"paddingleft\";s:2:\"10\";s:2:\"mt\";s:2:\"10\";s:5:\"sizew\";s:2:\"20\";s:5:\"sizeh\";s:2:\"20\";s:6:\"iconfz\";s:2:\"14\";s:9:\"iconcolor\";s:7:\"#434343\";s:8:\"imgwidth\";s:2:\"30\";}s:4:\"data\";a:4:{s:14:\"C1575463780216\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-1.png\";s:7:\"linkurl\";s:33:\"/sudu8_page_plugin_food/food/food\";s:4:\"text\";s:15:\"点餐小程序\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}s:14:\"C1575463780217\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-2.png\";s:7:\"linkurl\";s:35:\"/sudu8_page_plugin_sign/index/index\";s:4:\"text\";s:12:\"签到页面\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}s:14:\"C1575463780218\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-3.png\";s:7:\"linkurl\";s:37:\"/sudu8_page_plugin_exchange/list/list\";s:4:\"text\";s:12:\"积分商城\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}s:14:\"C1575463780219\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-4.png\";s:7:\"linkurl\";s:33:\"/sudu8_page_plugin_pt/index/index\";s:4:\"text\";s:6:\"拼团\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}}s:2:\"id\";s:4:\"menu\";}s:14:\"M1575466748182\";a:5:{s:4:\"icon\";s:22:\"iconfont2 icon-anniuzu\";s:6:\"params\";a:8:{s:9:\"styledata\";s:1:\"0\";s:6:\"repeat\";s:6:\"repeat\";s:9:\"positionx\";s:4:\"left\";s:9:\"positiony\";s:3:\"top\";s:4:\"size\";s:1:\"0\";s:13:\"backgroundimg\";s:0:\"\";s:7:\"picicon\";s:1:\"1\";s:8:\"textshow\";s:1:\"1\";}s:5:\"style\";a:14:{s:8:\"navstyle\";s:0:\"\";s:10:\"background\";s:7:\"#ffffff\";s:6:\"rownum\";s:1:\"4\";s:8:\"showtype\";s:1:\"0\";s:7:\"pagenum\";s:1:\"8\";s:7:\"showdot\";s:1:\"1\";s:7:\"padding\";s:1:\"0\";s:11:\"paddingleft\";s:2:\"10\";s:2:\"mt\";s:2:\"10\";s:5:\"sizew\";s:2:\"20\";s:5:\"sizeh\";s:2:\"20\";s:6:\"iconfz\";s:2:\"14\";s:9:\"iconcolor\";s:7:\"#434343\";s:8:\"imgwidth\";s:2:\"30\";}s:4:\"data\";a:4:{s:14:\"C1575466748182\";a:5:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-1.png\";s:7:\"linkurl\";s:41:\"/sudu8_page_plugin_shake/index/index?id=1\";s:4:\"text\";s:9:\"摇一摇\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";}s:14:\"C1575466748183\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-2.png\";s:7:\"linkurl\";s:23:\"/sudu8_page/store/store\";s:4:\"text\";s:15:\"多商户列表\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}s:14:\"C1575466748184\";a:6:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-3.png\";s:7:\"linkurl\";s:41:\"/sudu8_page_plugin_shop/register/register\";s:4:\"text\";s:15:\"多商户入住\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";s:8:\"linktype\";s:4:\"page\";}s:14:\"C1575466748185\";a:5:{s:6:\"imgurl\";s:51:\"/diypage/resource/images/diypage/default/icon-4.png\";s:7:\"linkurl\";s:0:\"\";s:4:\"text\";s:13:\"按钮文字4\";s:5:\"color\";s:7:\"#666666\";s:4:\"icon\";s:14:\"icon-x-shouye2\";}}s:2:\"id\";s:4:\"menu\";}s:14:\"M1575536052765\";a:5:{s:3:\"max\";s:1:\"5\";s:4:\"icon\";s:23:\"iconfont2 icon-fuwenben\";s:6:\"params\";a:1:{s:7:\"content\";s:80:\"PHA+5b6u5Lqu54K556eR5oqA6L2v5Lu25byA5Y+R5YWs5Y+45ryU56S65Yqf6IO956iL5bqPPC9wPg==\";}s:5:\"style\";a:3:{s:10:\"background\";s:7:\"#ffffff\";s:7:\"padding\";s:2:\"10\";s:9:\"margintop\";s:2:\"10\";}s:2:\"id\";s:8:\"richtext\";}}','首页');
/*!40000 ALTER TABLE `ims_sudu8_page_diypage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diypage_sys`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diypage_sys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diypage_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL COMMENT '小程序',
  `index` int(1) NOT NULL DEFAULT '0' COMMENT '是否首页',
  `page` varchar(3000) NOT NULL DEFAULT '' COMMENT '页面信息',
  `items` mediumtext NOT NULL COMMENT '组件信息',
  `tpl_name` varchar(32) NOT NULL COMMENT '模板名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diypage_sys`
--

LOCK TABLES `ims_sudu8_page_diypage_sys` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diypage_sys` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_diypage_sys` VALUES (1,0,1,'a:7:{s:10:\"background\";s:7:\"#f1f1f1\";s:13:\"topbackground\";s:7:\"#ffffff\";s:8:\"topcolor\";s:1:\"1\";s:9:\"styledata\";s:1:\"0\";s:5:\"title\";s:21:\"小程序页面标题\";s:4:\"name\";s:18:\"后台页面名称\";s:10:\"visitlevel\";a:2:{s:6:\"member\";s:0:\"\";s:10:\"commission\";s:0:\"\";}}','b:0;','后台页面名称');
/*!40000 ALTER TABLE `ims_sudu8_page_diypage_sys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diypageset`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diypageset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diypageset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `go_home` int(1) NOT NULL DEFAULT '1' COMMENT '1倒计时 2按钮',
  `kp` varchar(255) NOT NULL,
  `kp_is` int(1) NOT NULL,
  `kp_url` varchar(255) DEFAULT NULL,
  `kp_urltype` varchar(255) NOT NULL,
  `kp_m` int(11) NOT NULL,
  `tc` varchar(255) NOT NULL,
  `tc_is` int(1) NOT NULL,
  `tc_url` varchar(255) NOT NULL,
  `tc_urltype` varchar(255) NOT NULL,
  `foot_is` int(1) NOT NULL DEFAULT '1' COMMENT '1默认 2diy底部',
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diypageset`
--

LOCK TABLES `ims_sudu8_page_diypageset` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diypageset` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_diypageset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diypagetpl`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diypagetpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diypagetpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `pageid` varchar(1000) NOT NULL,
  `template_name` varchar(18) NOT NULL COMMENT '模板名称',
  `thumb` varchar(158) NOT NULL COMMENT '页面封面图',
  `create_time` varchar(32) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diypagetpl`
--

LOCK TABLES `ims_sudu8_page_diypagetpl` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diypagetpl` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_diypagetpl` VALUES (1,27,'1','空白模板','/diypage/img/blank.jpg','1538397589',1),(2,26,'2','空白模板','/diypage/img/blank.jpg','1538652747',1),(3,29,'3','空白模板','/diypage/img/blank.jpg','1538664889',1),(4,1,'1','首页','http://cs.riyuanma.com/diypage/img/blank.jpg','1575463577',1);
/*!40000 ALTER TABLE `ims_sudu8_page_diypagetpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_diypagetpl_sys`
--

DROP TABLE IF EXISTS `ims_sudu8_page_diypagetpl_sys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_diypagetpl_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(5) NOT NULL,
  `pageid` varchar(1000) NOT NULL,
  `template_name` varchar(18) NOT NULL COMMENT '模板名称',
  `thumb` varchar(158) NOT NULL COMMENT '页面封面图',
  `create_time` varchar(32) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_diypagetpl_sys`
--

LOCK TABLES `ims_sudu8_page_diypagetpl_sys` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_diypagetpl_sys` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_diypagetpl_sys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_duo_products_address`
--

DROP TABLE IF EXISTS `ims_sudu8_page_duo_products_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_duo_products_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `more_address` varchar(1000) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `is_mo` int(1) NOT NULL DEFAULT '1',
  `creattime` int(11) NOT NULL,
  `froms` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_duo_products_address`
--

LOCK TABLES `ims_sudu8_page_duo_products_address` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_duo_products_gwc`
--

DROP TABLE IF EXISTS `ims_sudu8_page_duo_products_gwc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_duo_products_gwc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `pvid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_duo_products_gwc`
--

LOCK TABLES `ims_sudu8_page_duo_products_gwc` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_gwc` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_gwc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_duo_products_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_duo_products_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_duo_products_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `jsondata` text NOT NULL,
  `coupon` int(11) NOT NULL DEFAULT '0',
  `jf` varchar(255) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL DEFAULT '0',
  `m_address` varchar(1000) NOT NULL,
  `liuyan` varchar(1000) NOT NULL,
  `creattime` int(11) NOT NULL,
  `hxtime` int(11) NOT NULL DEFAULT '0',
  `nav` int(1) NOT NULL DEFAULT '1' COMMENT '1发货  2自提',
  `kuadi` varchar(255) NOT NULL,
  `kuaidihao` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0' COMMENT '0未支付1已支付2已结算3已过期',
  `formid` int(11) DEFAULT NULL,
  `qxbeizhu` varchar(255) DEFAULT NULL,
  `sid` int(11) DEFAULT '0' COMMENT '多商户id',
  `prepayid` varchar(255) DEFAULT NULL COMMENT '模板消息id',
  `kuaidi_th` varchar(255) DEFAULT NULL COMMENT '退货快递',
  `kuaidihao_th` varchar(255) DEFAULT NULL COMMENT '退货快递号',
  `th_orderid` varchar(255) DEFAULT NULL COMMENT '退货订单号',
  `payprice` float DEFAULT NULL COMMENT '微信支付金额',
  `hxinfo` varchar(255) DEFAULT NULL,
  `yhinfo` varchar(255) DEFAULT NULL,
  `qx_formid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_duo_products_order`
--

LOCK TABLES `ims_sudu8_page_duo_products_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_duo_products_type_value`
--

DROP TABLE IF EXISTS `ims_sudu8_page_duo_products_type_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_duo_products_type_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `type1` varchar(255) NOT NULL,
  `type2` varchar(255) NOT NULL,
  `type3` varchar(255) NOT NULL,
  `kc` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `hnum` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `updatetime` int(11) NOT NULL,
  `salenum` int(11) NOT NULL,
  `vsalenum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_duo_products_type_value`
--

LOCK TABLES `ims_sudu8_page_duo_products_type_value` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_type_value` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_type_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_duo_products_yunfei`
--

DROP TABLE IF EXISTS `ims_sudu8_page_duo_products_yunfei`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_duo_products_yunfei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `yfei` varchar(255) NOT NULL,
  `byou` varchar(255) NOT NULL,
  `formset` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_duo_products_yunfei`
--

LOCK TABLES `ims_sudu8_page_duo_products_yunfei` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_yunfei` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_duo_products_yunfei` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pcid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `counts` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `true_price` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `labels` varchar(255) NOT NULL,
  `product_txt` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `descimg` varchar(255) NOT NULL,
  `desccon` varchar(255) NOT NULL,
  `unit` char(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food`
--

LOCK TABLES `ims_sudu8_page_food` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_food` VALUES (1,0,1,0,1,'黄金鸡块5块状','/upimages/20191204/05208badd7c1d3974bdd105933c46af4846.png',245,'11.5','','','','','',1,'','精选鸡肉烹炸，搭配调味酱，口感香鲜酥脆',''),(2,0,2,0,1,'澳堡辣堡双人餐','/upimages/20191204/9589decd8fab200bd380955c43941823603.png',56,'35.5','','','','','',1,'','升级版新奥尔良鸡腿堡',''),(3,0,4,0,1,'香辣鸡腿堡','/upimages/20191204/9b6c29db89df1006abb9338170b79056250.png',198,'19','','','','','',1,'','整块无骨鸡腿肉，浓郁汉堡酱',''),(4,0,5,0,1,'波纹霸王薯条','/upimages/20191204/274bd18de2a901120071a91b92f3092b214.jpg',201,'12','','','','','',1,'','波纹霸王薯条',''),(5,0,6,0,1,'可口可乐（中）','/upimages/20191204/2781eb8d2c480f1686656c19bfc8b835456.jpg',65,'9.5','','','','','',1,'','主要原料：百事可乐糖浆，水，二氧化碳',''),(6,0,7,0,1,'鸡肉粥浆太阳蛋餐','/upimages/20191204/6cd84061824c5cdce4e8af9f4c8fa13f998.jpg',35,'18.5','','','','','',1,'','雪菜笋丁鸡肉粥1份+醇豆浆1杯+太阳蛋1个','');
/*!40000 ALTER TABLE `ims_sudu8_page_food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dateline` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food_cate`
--

LOCK TABLES `ims_sudu8_page_food_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food_cate` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_food_cate` VALUES (1,1,1,'爆款',0,1),(2,2,1,'优选套餐',0,1),(3,3,1,'火爆活动进行中',0,1),(4,4,1,'人气主食',0,1),(5,5,1,'小食类',0,1),(6,6,1,'饮品回头客',0,1),(7,7,1,'半价早餐',0,1);
/*!40000 ALTER TABLE `ims_sudu8_page_food_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `usertel` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `usertime` varchar(255) NOT NULL,
  `userbeiz` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `val` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `zh` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food_order`
--

LOCK TABLES `ims_sudu8_page_food_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food_order` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_food_order` VALUES (1,'201912232244219180',1,'Vq5lPf40','','',' ','',5,'undefined','s:0:\"\";','',1577112261,1,'打包/拼桌');
/*!40000 ALTER TABLE `ims_sudu8_page_food_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food_printer`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food_printer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food_printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL COMMENT '打印机名称',
  `title` varchar(255) NOT NULL COMMENT '头部标题',
  `models` varchar(255) NOT NULL COMMENT '打印机类型',
  `status` int(1) NOT NULL DEFAULT '2' COMMENT '1开启  2不开启',
  `nid` varchar(255) NOT NULL COMMENT '打印机终端号',
  `nkey` varchar(255) NOT NULL COMMENT '终端号秘钥',
  `uid` varchar(255) NOT NULL COMMENT '用户id',
  `apikey` varchar(255) NOT NULL COMMENT '秘钥',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food_printer`
--

LOCK TABLES `ims_sudu8_page_food_printer` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food_printer` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_food_printer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food_sj`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food_sj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food_sj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `times` varchar(255) NOT NULL,
  `fuwu` varchar(255) NOT NULL,
  `qita` varchar(255) NOT NULL,
  `usname` int(1) NOT NULL DEFAULT '0',
  `ustel` int(1) NOT NULL DEFAULT '0',
  `usadd` int(1) NOT NULL DEFAULT '0',
  `usdate` int(1) NOT NULL DEFAULT '0',
  `ustime` int(1) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL,
  `notice` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food_sj`
--

LOCK TABLES `ims_sudu8_page_food_sj` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food_sj` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_food_sj` VALUES (1,'/upimages/20191204/2e63c3a90820f719f5e0dd2d49007414904.jpg',1,'喜宝','24小时','全城配送','24小时',1,1,1,1,1,10,'18533015976','唐山市路北区车站路169号A座7层','汉堡,炸鸡','喜宝上新款了！！！！');
/*!40000 ALTER TABLE `ims_sudu8_page_food_sj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_food_tables`
--

DROP TABLE IF EXISTS `ims_sudu8_page_food_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_food_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `tnum` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_food_tables`
--

LOCK TABLES `ims_sudu8_page_food_tables` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_food_tables` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_food_tables` VALUES (1,1,10001,'九牛网科技',''),(2,1,10002,'九牛网科技',''),(3,1,10003,'九牛网科技',''),(4,1,10004,'九牛网科技',''),(5,1,10005,'九牛网科技',''),(6,1,10006,'九牛网科技','');
/*!40000 ALTER TABLE `ims_sudu8_page_food_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_form_config`
--

DROP TABLE IF EXISTS `ims_sudu8_page_form_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_form_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_form_config`
--

LOCK TABLES `ims_sudu8_page_form_config` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_form_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_form_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_form_dd`
--

DROP TABLE IF EXISTS `ims_sudu8_page_form_dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_form_dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `types` varchar(255) NOT NULL,
  `datys` int(11) NOT NULL,
  `pagedatekey` int(11) NOT NULL,
  `arrkey` int(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_form_dd`
--

LOCK TABLES `ims_sudu8_page_form_dd` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_form_dd` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_form_dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_form_duo`
--

DROP TABLE IF EXISTS `ims_sudu8_page_form_duo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_form_duo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formname` varchar(255) NOT NULL,
  `formid` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '字段名称',
  `ismust` int(1) NOT NULL DEFAULT '1' COMMENT '是否必填0非必填 1必填',
  `default_val` varchar(500) NOT NULL,
  `prompt` varchar(500) NOT NULL,
  `tp_text` varchar(500) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_form_duo`
--

LOCK TABLES `ims_sudu8_page_form_duo` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_form_duo` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_form_duo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_formcon`
--

DROP TABLE IF EXISTS `ims_sudu8_page_formcon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_formcon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  `val` varchar(2000) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `beizhu` varchar(255) NOT NULL,
  `vtime` int(11) DEFAULT NULL,
  `openid` varchar(255) NOT NULL,
  `formid` varchar(255) NOT NULL,
  `fid` int(11) NOT NULL,
  `source` mediumtext NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_formcon`
--

LOCK TABLES `ims_sudu8_page_formcon` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_formcon` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_formcon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_formlist`
--

DROP TABLE IF EXISTS `ims_sudu8_page_formlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_formlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `formname` varchar(255) NOT NULL,
  `tp_text` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_formlist`
--

LOCK TABLES `ims_sudu8_page_formlist` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_formlist` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_formlist` VALUES (1,4,'包房预约','a:4:{i:0;a:4:{s:4:\"name\";s:6:\"姓名\";s:4:\"type\";s:1:\"0\";s:6:\"ismust\";s:1:\"1\";s:7:\"tp_text\";s:1:\"0\";}i:1;a:4:{s:4:\"name\";s:6:\"电话\";s:4:\"type\";s:1:\"0\";s:6:\"ismust\";s:1:\"0\";s:7:\"tp_text\";s:1:\"0\";}i:2;a:4:{s:4:\"name\";s:12:\"选择日期\";s:4:\"type\";s:1:\"7\";s:6:\"ismust\";s:1:\"0\";s:7:\"tp_text\";s:0:\"\";}i:3;a:4:{s:4:\"name\";s:12:\"选择时间\";s:4:\"type\";s:2:\"11\";s:6:\"ismust\";s:1:\"0\";s:7:\"tp_text\";s:0:\"\";}}');
/*!40000 ALTER TABLE `ims_sudu8_page_formlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forms`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `wechat` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `single` varchar(255) DEFAULT NULL,
  `checkbox` varchar(255) DEFAULT NULL,
  `content` text,
  `time` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `vtime` int(10) DEFAULT NULL,
  `sss_beizhu` varchar(255) DEFAULT NULL,
  `timef` varchar(10) DEFAULT NULL,
  `t5` varchar(255) DEFAULT NULL,
  `t6` varchar(255) DEFAULT NULL,
  `c2` varchar(255) DEFAULT NULL,
  `s2` varchar(255) DEFAULT NULL,
  `con2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forms`
--

LOCK TABLES `ims_sudu8_page_forms` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forms_config`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forms_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forms_config` (
  `uniacid` int(11) NOT NULL DEFAULT '0',
  `forms_head` varchar(255) DEFAULT NULL,
  `forms_head_con` text,
  `forms_name` varchar(255) DEFAULT NULL,
  `forms_ename` varchar(255) DEFAULT NULL,
  `forms_title_s` varchar(255) DEFAULT NULL,
  `success` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT '姓名',
  `name_must` int(1) DEFAULT '1',
  `tel` varchar(255) DEFAULT '手机',
  `tel_use` int(1) DEFAULT '1',
  `tel_must` int(1) DEFAULT '1',
  `wechat` varchar(255) DEFAULT '微信',
  `wechat_use` int(1) DEFAULT '1',
  `wechat_must` int(1) DEFAULT '1',
  `address` varchar(255) DEFAULT '地址',
  `address_use` int(1) DEFAULT '1',
  `address_must` int(1) DEFAULT '1',
  `date` varchar(255) DEFAULT '预约时间',
  `date_use` int(1) DEFAULT '1',
  `date_must` int(1) DEFAULT '1',
  `single_n` varchar(255) DEFAULT '性别',
  `single_num` int(2) DEFAULT '2',
  `single_v` varchar(255) DEFAULT '男,女',
  `single_use` int(1) DEFAULT '1',
  `single_must` int(1) DEFAULT '1',
  `checkbox_n` varchar(255) DEFAULT '类型',
  `checkbox_num` int(2) DEFAULT '2',
  `checkbox_v` varchar(255) DEFAULT '栏目一,栏目二',
  `checkbox_use` int(1) DEFAULT '1',
  `content_n` varchar(255) DEFAULT '留言内容',
  `content_use` int(1) DEFAULT '1',
  `content_must` int(1) DEFAULT '1',
  `checkbox_must` int(1) DEFAULT '1',
  `mail_user` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_sendto` varchar(255) DEFAULT NULL,
  `forms_btn` varchar(255) DEFAULT NULL,
  `mail_user_name` varchar(255) DEFAULT NULL,
  `forms_style` int(2) DEFAULT '1',
  `forms_inps` int(2) DEFAULT '1',
  `subtime` int(2) DEFAULT '1',
  `time_use` int(1) DEFAULT '1',
  `time_must` int(1) DEFAULT '1',
  `time` varchar(255) DEFAULT NULL,
  `tel_i` int(1) DEFAULT '0',
  `wechat_i` int(1) DEFAULT '0',
  `address_i` int(1) DEFAULT '0',
  `date_i` int(1) DEFAULT '0',
  `time_i` int(1) DEFAULT '0',
  `single_i` int(1) DEFAULT '0',
  `checkbox_i` int(1) DEFAULT '0',
  `content_i` int(1) DEFAULT '0',
  `t5` varchar(255) DEFAULT NULL,
  `t6` varchar(255) DEFAULT NULL,
  `c2` varchar(255) DEFAULT NULL,
  `s2` varchar(255) DEFAULT NULL,
  `con2` varchar(255) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img1not` varchar(255) NOT NULL,
  PRIMARY KEY (`uniacid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forms_config`
--

LOCK TABLES `ims_sudu8_page_forms_config` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forms_config` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forms_config` VALUES (26,'header',NULL,'服务预约','Order & Date','title1','您已预约成功！','姓名',1,'电话',1,1,'地址',1,1,'地址',1,1,'预约时间',1,1,'性别',2,'男,女',1,1,'类型',2,'栏目一,栏目二',1,'需求描述',1,1,1,NULL,NULL,NULL,'预约',NULL,1,0,2,1,1,NULL,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,''),(1,'none',NULL,'自助预约','Self Booking','title1','您已预约成功！','姓名',1,'电话',1,1,'地址',0,1,'地址',0,1,'预约时间',1,0,'人数',4,'1,2,3,4,5,6,7,8',0,0,'拍摄类型',2,'婚纱摄影,亲子儿童,个人写真,情侣闺蜜',1,'备注',1,0,0,NULL,NULL,NULL,'立即预约',NULL,2,0,0,1,1,'预约时间',0,0,0,0,0,0,0,0,'a:4:{s:3:\"t5n\";s:0:\"\";s:3:\"t5u\";N;s:3:\"t5m\";N;s:3:\"t5i\";N;}','a:4:{s:3:\"t6n\";s:0:\"\";s:3:\"t6u\";N;s:3:\"t6m\";N;s:3:\"t6i\";N;}','a:6:{s:3:\"c2n\";s:0:\"\";s:5:\"c2num\";s:0:\"\";s:3:\"c2v\";s:0:\"\";s:3:\"c2u\";N;s:3:\"c2m\";N;s:3:\"c2i\";N;}','a:6:{s:3:\"s2n\";s:18:\"选择包房类型\";s:5:\"s2num\";s:1:\"3\";s:3:\"s2v\";s:0:\"\";s:3:\"s2u\";N;s:3:\"s2m\";N;s:3:\"s2i\";N;}','a:4:{s:5:\"con2n\";s:0:\"\";s:5:\"con2u\";N;s:5:\"con2m\";N;s:5:\"con2i\";N;}','a:5:{s:5:\"img1n\";N;s:5:\"img1u\";N;s:5:\"img1m\";N;s:5:\"img1i\";N;s:7:\"img1not\";N;}',''),(4,'header',NULL,'预约包房',NULL,'title2',NULL,'姓名',1,'手机',1,1,'微信',0,0,'地址',0,0,'预约日期',1,1,'性别',2,'男,女',0,0,'类型',2,'栏目一,栏目二',0,'留言内容',0,0,0,NULL,NULL,NULL,'确认预约',NULL,2,1,0,1,1,'预约时间',0,0,0,0,0,0,0,0,'a:4:{s:3:\"t5n\";s:0:\"\";s:3:\"t5u\";N;s:3:\"t5m\";N;s:3:\"t5i\";N;}','a:4:{s:3:\"t6n\";s:0:\"\";s:3:\"t6u\";N;s:3:\"t6m\";N;s:3:\"t6i\";N;}','a:6:{s:3:\"c2n\";s:0:\"\";s:5:\"c2num\";s:0:\"\";s:3:\"c2v\";s:0:\"\";s:3:\"c2u\";N;s:3:\"c2m\";N;s:3:\"c2i\";N;}','a:6:{s:3:\"s2n\";s:0:\"\";s:5:\"s2num\";s:0:\"\";s:3:\"s2v\";s:0:\"\";s:3:\"s2u\";N;s:3:\"s2m\";N;s:3:\"s2i\";N;}','a:4:{s:5:\"con2n\";s:0:\"\";s:5:\"con2u\";N;s:5:\"con2m\";N;s:5:\"con2i\";N;}','a:5:{s:5:\"img1n\";N;s:5:\"img1u\";N;s:5:\"img1m\";N;s:5:\"img1i\";N;s:7:\"img1not\";N;}','');
/*!40000 ALTER TABLE `ims_sudu8_page_forms_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_formt`
--

DROP TABLE IF EXISTS `ims_sudu8_page_formt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_formt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `val` varchar(50) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_formt`
--

LOCK TABLES `ims_sudu8_page_formt` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_formt` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_formt` VALUES (1,'单行文本','0',1),(2,'多行文本','1',1),(3,'下拉框','2',1),(4,'多选框','3',1),(5,'单选框','4',1),(6,'图片','5',1),(7,'身份证号码','6',0),(8,'日期','7',1),(9,'日期范围','8',0),(10,'城市','9',0),(11,'确认文本','10',0),(12,'时间','11',1),(13,'时间范围','12',0),(14,'提示文本','13',0),(15,'可独占选项','14',1);
/*!40000 ALTER TABLE `ims_sudu8_page_formt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_collection`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `collection` tinyint(1) NOT NULL DEFAULT '1',
  `rid` int(11) NOT NULL COMMENT 'release表id',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_collection`
--

LOCK TABLES `ims_sudu8_page_forum_collection` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_collection` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_collection` VALUES (1,1,5,2,2,'2019-12-05 16:59:10'),(2,1,5,2,1,'2019-12-05 16:59:15'),(3,1,5,2,0,'2019-12-05 17:05:29'),(4,1,22,1,0,'2019-12-31 15:41:31');
/*!40000 ALTER TABLE `ims_sudu8_page_forum_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_comment`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL COMMENT '发布的id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `uniacid` int(11) NOT NULL,
  `content` mediumtext NOT NULL COMMENT '评论内容',
  `createtime` datetime NOT NULL,
  `flag` int(1) NOT NULL COMMENT '1显示 2不显示',
  `likesNum` int(11) NOT NULL COMMENT '点赞数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_comment`
--

LOCK TABLES `ims_sudu8_page_forum_comment` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_comment` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_comment` VALUES (1,2,5,1,'l4C2jejA','2019-12-23 22:38:08',0,0),(2,1,5,1,'dFqZyEN9','2019-12-23 22:38:17',0,0),(3,0,5,1,'l4C2jejA','2019-12-23 22:45:43',0,0),(4,0,22,1,'习近平','2019-12-31 17:21:32',0,0);
/*!40000 ALTER TABLE `ims_sudu8_page_forum_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_comment_likes`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_comment_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `commentId` int(11) NOT NULL,
  `likes` tinyint(1) NOT NULL COMMENT '1点赞 2不点赞',
  `openid` varchar(255) NOT NULL,
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_comment_likes`
--

LOCK TABLES `ims_sudu8_page_forum_comment_likes` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_comment_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_func`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_func`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_func` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `func_img` varchar(255) NOT NULL,
  `page_type` int(1) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1启用 2不启用',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_func`
--

LOCK TABLES `ims_sudu8_page_forum_func` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_func` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_func` VALUES (1,1,'业务广告','/upimages/20191204/2e63c3a90820f719f5e0dd2d49007414904.jpg',3,15,1,'2019-12-07 12:40:59'),(2,1,'招聘广告','/upimages/20191204/2e63c3a90820f719f5e0dd2d49007414904.jpg',3,2,1,'2019-12-04 20:37:26');
/*!40000 ALTER TABLE `ims_sudu8_page_forum_func` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_likes`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `likes` tinyint(1) NOT NULL DEFAULT '1',
  `rid` int(11) NOT NULL COMMENT 'release表id',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_likes`
--

LOCK TABLES `ims_sudu8_page_forum_likes` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_likes` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_likes` VALUES (1,1,5,2,2,'2019-12-05 16:59:10'),(2,1,5,2,1,'2019-12-05 16:59:15'),(3,1,5,2,0,'2019-12-05 17:05:29');
/*!40000 ALTER TABLE `ims_sudu8_page_forum_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `release_money` decimal(5,2) NOT NULL,
  `stick_money` decimal(5,2) NOT NULL,
  `stick_days` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '2' COMMENT '1已支付  2未支付',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_order`
--

LOCK TABLES `ims_sudu8_page_forum_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_release`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_release` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fid` int(11) NOT NULL COMMENT '发布功能分类id',
  `content` mediumtext NOT NULL,
  `img` mediumtext NOT NULL,
  `uid` int(11) NOT NULL COMMENT '发布人id',
  `release_money` decimal(5,2) NOT NULL COMMENT '发布收费',
  `stick` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶（1置顶 2不置顶）',
  `hot` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否推荐（1推荐 2不推荐）',
  `hits` int(11) NOT NULL COMMENT '浏览人数',
  `likes` int(11) NOT NULL COMMENT '点赞数',
  `collection` int(11) NOT NULL COMMENT '收藏数',
  `comment` int(11) NOT NULL COMMENT '评论数',
  `telphone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `createtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_release`
--

LOCK TABLES `ims_sudu8_page_forum_release` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_release` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_release` VALUES (1,1,1,'发布新的需求','a:1:{i:0;s:58:\"/upimages/20191204/06ce8bfc13e9b3655024eacdf5e78a77425.jpg\";}',1,0.00,2,2,4,0,0,1,'18533015976','唐山市路北区人民政府(新华东道北)','2019-12-04 20:34:04','0000-00-00 00:00:00'),(2,1,1,'发布的第二条信息，有需要软件开发的，联系我','a:1:{i:0;s:58:\"/upimages/20191204/2892ba02790f803eef39e28b7634576a152.png\";}',1,0.00,2,2,3,0,0,1,'18533015976','路北区唐山市大学生创业辅导基地(车站路)','2019-12-04 20:36:38','0000-00-00 00:00:00'),(3,1,2,'招聘经理1人月工资8000','a:1:{i:0;s:58:\"/upimages/20191207/48246de5d8eb4dd80b793cb59e993101199.jpg\";}',2,0.00,1,2,0,0,0,0,'18533015976','开滦总医院','2019-12-07 12:43:00','0000-00-00 00:00:00'),(4,1,1,'习近平走路一挥手','a:1:{i:0;s:58:\"/upimages/20191231/c55265d6df74ffdf58b02f74a8357c4c408.jpg\";}',22,0.00,2,2,0,0,0,0,'','','2019-12-31 17:22:19','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `ims_sudu8_page_forum_release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_reply`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `commentId` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `uid` int(11) NOT NULL,
  `release_uid` int(11) NOT NULL,
  `likesNum` int(11) NOT NULL COMMENT '点赞数',
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_reply`
--

LOCK TABLES `ims_sudu8_page_forum_reply` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_set`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `release_money` decimal(5,2) NOT NULL DEFAULT '0.00',
  `stick_money` decimal(5,2) NOT NULL DEFAULT '10.00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_set`
--

LOCK TABLES `ims_sudu8_page_forum_set` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_set` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_set` VALUES (1,1,0.00,0.00);
/*!40000 ALTER TABLE `ims_sudu8_page_forum_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_forum_stick`
--

DROP TABLE IF EXISTS `ims_sudu8_page_forum_stick`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_forum_stick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `rid` int(11) NOT NULL COMMENT '发布id',
  `stick` int(1) NOT NULL COMMENT '是否置顶 1置顶 2不置顶',
  `stick_days` int(11) NOT NULL COMMENT '置顶时长',
  `stick_money` decimal(10,2) NOT NULL COMMENT '置顶费用',
  `stick_time` datetime NOT NULL COMMENT '置顶时间',
  `stick_status` int(1) NOT NULL COMMENT '置顶状态 1启用 2不启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_forum_stick`
--

LOCK TABLES `ims_sudu8_page_forum_stick` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_forum_stick` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_forum_stick` VALUES (1,1,3,1,100,0.00,'2019-12-07 12:43:18',1);
/*!40000 ALTER TABLE `ims_sudu8_page_forum_stick` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_fx_gz`
--

DROP TABLE IF EXISTS `ims_sudu8_page_fx_gz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_fx_gz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `fx_cj` int(1) NOT NULL DEFAULT '4' COMMENT '1一级2二级3三级4不启用',
  `sxj_gx` int(1) NOT NULL DEFAULT '1' COMMENT '1点击分享2首次下单3首次付款',
  `fxs_sz` int(1) NOT NULL DEFAULT '1' COMMENT '1无条件2申请3消费次数4消费金额5购买商品',
  `fxs_sz_val` varchar(255) NOT NULL DEFAULT '0' COMMENT '分销商规则值',
  `fxs_xy` text NOT NULL,
  `one_bili` int(11) NOT NULL DEFAULT '0' COMMENT '一级比例',
  `two_bili` int(11) NOT NULL DEFAULT '0' COMMENT '二级比例',
  `three_bili` int(11) NOT NULL DEFAULT '0' COMMENT '三级比例',
  `txmoney` float NOT NULL DEFAULT '10',
  `fxs_name` varchar(255) NOT NULL COMMENT '分销商',
  `certtext` varchar(2000) NOT NULL,
  `keytext` varchar(2000) NOT NULL,
  `catext` varchar(2000) NOT NULL,
  `thumb` varchar(255) NOT NULL COMMENT '分享推广图',
  `sq_thumb` varchar(255) NOT NULL COMMENT '申请图',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_fx_gz`
--

LOCK TABLES `ims_sudu8_page_fx_gz` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_gz` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_gz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_fx_ls`
--

DROP TABLE IF EXISTS `ims_sudu8_page_fx_ls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_fx_ls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(1000) NOT NULL COMMENT '消费者openid',
  `parent_id` varchar(1000) NOT NULL COMMENT '父级获得的钱',
  `parent_id_get` float NOT NULL COMMENT '父级获得的钱',
  `p_parent_id` varchar(1000) NOT NULL COMMENT '父级的父级的id',
  `p_parent_id_get` float NOT NULL COMMENT '父级的父级获得的钱',
  `p_p_parent_id` varchar(1000) NOT NULL COMMENT '父级的父级的父级的id',
  `p_p_parent_id_get` float NOT NULL COMMENT '父级的父级的父级获得的钱',
  `order_id` varchar(1000) NOT NULL COMMENT '订单id',
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1待分成2已分成3取消分成',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_fx_ls`
--

LOCK TABLES `ims_sudu8_page_fx_ls` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_ls` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_ls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_fx_sq`
--

DROP TABLE IF EXISTS `ims_sudu8_page_fx_sq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_fx_sq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `truename` varchar(255) NOT NULL,
  `truetel` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1申请中2已通过3不通过',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_fx_sq`
--

LOCK TABLES `ims_sudu8_page_fx_sq` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_sq` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_sq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_fx_tx`
--

DROP TABLE IF EXISTS `ims_sudu8_page_fx_tx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_fx_tx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(1000) NOT NULL,
  `money` float NOT NULL,
  `creattime` int(11) NOT NULL,
  `types` int(1) NOT NULL DEFAULT '1' COMMENT '1余额2微信3支付宝',
  `zfbzh` varchar(255) NOT NULL,
  `zfbxm` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1申请中2已通过3已拒绝',
  `txtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_fx_tx`
--

LOCK TABLES `ims_sudu8_page_fx_tx` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_fx_tx` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_fx_tx` VALUES (1,1,'undefined',0,1577112071,1,'','',1,0);
/*!40000 ALTER TABLE `ims_sudu8_page_fx_tx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_lottery_activity`
--

DROP TABLE IF EXISTS `ims_sudu8_page_lottery_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_lottery_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '活动名称',
  `begin` int(11) NOT NULL COMMENT '开始时间',
  `end` int(11) NOT NULL COMMENT '结束时间',
  `descp` varchar(3000) NOT NULL COMMENT '活动说明',
  `thumb` varchar(255) NOT NULL COMMENT '活动图片',
  `bg` varchar(255) NOT NULL DEFAULT '' COMMENT '活动背景',
  `text_img1` varchar(255) NOT NULL DEFAULT '' COMMENT '文字标题图片button',
  `text_img2` varchar(255) NOT NULL DEFAULT '' COMMENT '文字标题图片摇一摇',
  `nav_color` varchar(20) NOT NULL DEFAULT '' COMMENT '头部颜色',
  `base` varchar(3000) NOT NULL COMMENT '基础设置，详见看云说明',
  `status` int(1) NOT NULL COMMENT '0下架1上架',
  `participate` int(11) NOT NULL DEFAULT '0' COMMENT '参与人数',
  `win` int(11) NOT NULL DEFAULT '0' COMMENT '获奖人数',
  `browse` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `share` int(11) NOT NULL DEFAULT '0' COMMENT '分享量',
  `createtime` int(11) NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_lottery_activity`
--

LOCK TABLES `ims_sudu8_page_lottery_activity` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_activity` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_lottery_activity` VALUES (1,1,'九牛网科技',1575380272,1797514682,'<p>活动规则</p>','/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png','/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png','/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png','/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png','#FFFFFF','a:9:{s:5:\"means\";i:0;s:5:\"jifen\";i:10;s:10:\"every_join\";i:3;s:8:\"just_one\";s:1:\"1\";s:10:\"users_type\";i:0;s:9:\"fill_time\";s:1:\"1\";s:9:\"share_add\";i:1;s:14:\"everyday_share\";i:1;s:11:\"total_share\";i:1;}',1,0,0,7,0,1575466554);
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_lottery_prize`
--

DROP TABLE IF EXISTS `ims_sudu8_page_lottery_prize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_lottery_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '活动id',
  `num` varchar(255) NOT NULL DEFAULT '' COMMENT '9宫格八个格子，多规格',
  `title` varchar(255) NOT NULL COMMENT '奖项标题',
  `thumb` varchar(255) NOT NULL COMMENT '图',
  `total` int(11) NOT NULL COMMENT '总量',
  `storage` int(11) NOT NULL COMMENT '库存',
  `types` int(1) NOT NULL COMMENT '1积分2余额3实物4优惠券',
  `detail` varchar(255) NOT NULL COMMENT '奖励详情',
  `chance` int(11) NOT NULL COMMENT '中奖概率',
  `createtime` int(11) NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_lottery_prize`
--

LOCK TABLES `ims_sudu8_page_lottery_prize` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_prize` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_lottery_prize` VALUES (1,1,1,'1','奖项标题','/upimages/20191204/9589decd8fab200bd380955c43941823603.png',10000,10000,3,'汉堡套餐',9999,1575466730);
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_prize` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_lottery_record`
--

DROP TABLE IF EXISTS `ims_sudu8_page_lottery_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_lottery_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '活动id',
  `uid` int(11) NOT NULL COMMENT '中奖人id',
  `pid` int(11) DEFAULT NULL COMMENT '奖品id',
  `createtime` int(11) NOT NULL COMMENT '抽奖时间',
  `status` int(1) NOT NULL COMMENT '0未中奖1已中奖2已领',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_lottery_record`
--

LOCK TABLES `ims_sudu8_page_lottery_record` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_lottery_share`
--

DROP TABLE IF EXISTS `ims_sudu8_page_lottery_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_lottery_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '活动id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `createtime` int(11) NOT NULL COMMENT '分享时间',
  `flag` int(1) NOT NULL COMMENT '0未成功1成功',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_lottery_share`
--

LOCK TABLES `ims_sudu8_page_lottery_share` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_lottery_share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_message`
--

DROP TABLE IF EXISTS `ims_sudu8_page_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `mid` varchar(255) NOT NULL COMMENT '模板消息id',
  `url` varchar(255) NOT NULL COMMENT '页面路径',
  `flag` int(1) NOT NULL COMMENT '1支付通知 2系统表单通知 3预约通知  4点餐支付通知 5积分兑换成功通知',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_message`
--

LOCK TABLES `ims_sudu8_page_message` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_message` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_message` VALUES (1,1,'','',12);
/*!40000 ALTER TABLE `ims_sudu8_page_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_money`
--

DROP TABLE IF EXISTS `ims_sudu8_page_money`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '操作',
  `score` varchar(255) NOT NULL COMMENT '金钱',
  `message` varchar(255) NOT NULL COMMENT '说明',
  `creattime` int(11) NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_money`
--

LOCK TABLES `ims_sudu8_page_money` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_money` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_money` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_moneyoff`
--

DROP TABLE IF EXISTS `ims_sudu8_page_moneyoff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_moneyoff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `reach` float NOT NULL COMMENT '满多少',
  `del` float NOT NULL COMMENT '减多少',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_moneyoff`
--

LOCK TABLES `ims_sudu8_page_moneyoff` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_moneyoff` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_moneyoff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_multicate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_multicate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_multicate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `cid` varchar(255) NOT NULL COMMENT '栏目数组',
  `name` varchar(255) NOT NULL,
  `ename` varchar(255) NOT NULL,
  `cdesc` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT '模板类型',
  `statue` int(1) NOT NULL DEFAULT '1' COMMENT '多栏目状态',
  `num` int(10) NOT NULL DEFAULT '50' COMMENT '栏目排序',
  `list_type` int(2) NOT NULL COMMENT '列表显示类型',
  `list_style` int(2) NOT NULL COMMENT '列表样式',
  `list_stylet` char(10) NOT NULL COMMENT '列表样式里的标题样式',
  `list_tstylel` int(1) NOT NULL,
  `content` mediumint(9) NOT NULL,
  `pic_page_btn` int(1) NOT NULL DEFAULT '0',
  `pic_page_btn_zt` int(1) NOT NULL DEFAULT '0',
  `cateconf` varchar(500) NOT NULL,
  `onlyid` varchar(255) NOT NULL,
  `top_catas` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_multicate`
--

LOCK TABLES `ims_sudu8_page_multicate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_multicate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_multicate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_multicates`
--

DROP TABLE IF EXISTS `ims_sudu8_page_multicates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_multicates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(5) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `varible` varchar(12) NOT NULL COMMENT '筛选值名称',
  `pid` int(5) NOT NULL DEFAULT '0',
  `uniacid` int(5) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_multicates`
--

LOCK TABLES `ims_sudu8_page_multicates` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_multicates` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_multicates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_multipro`
--

DROP TABLE IF EXISTS `ims_sudu8_page_multipro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_multipro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `multi_id` int(11) NOT NULL,
  `proid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `tid` int(11) NOT NULL COMMENT '顶级栏目id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_multipro`
--

LOCK TABLES `ims_sudu8_page_multipro` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_multipro` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_multipro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_nav`
--

DROP TABLE IF EXISTS `ims_sudu8_page_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uniacid` int(11) NOT NULL COMMENT 'UID',
  `statue` int(1) NOT NULL,
  `type` int(2) NOT NULL COMMENT '首页，列表，单页，文章',
  `style` int(2) NOT NULL,
  `url` varchar(999) NOT NULL COMMENT '链接',
  `box_p_tb` float NOT NULL COMMENT '外边距',
  `box_p_lr` float NOT NULL COMMENT '左右间距',
  `number` int(2) NOT NULL COMMENT '数量',
  `img_size` float NOT NULL COMMENT '图片大小',
  `title_color` varchar(10) NOT NULL COMMENT '标题颜色',
  `title_position` int(1) NOT NULL COMMENT '标题样式',
  `title_bg` varchar(15) NOT NULL COMMENT '标题背景色',
  `color_bar` varchar(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ename` varchar(255) DEFAULT NULL,
  `name_s` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_nav`
--

LOCK TABLES `ims_sudu8_page_nav` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_nav` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_nav` VALUES (1,1,2,0,0,'',2,1,4,80,'#222',0,'#FFFFFF','',NULL,NULL,'1');
/*!40000 ALTER TABLE `ims_sudu8_page_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_navlist`
--

DROP TABLE IF EXISTS `ims_sudu8_page_navlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_navlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  `type` int(2) NOT NULL COMMENT '0链接 1电话 2导航 3客服 4小程序 5.网页',
  `title` varchar(40) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `url2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_navlist`
--

LOCK TABLES `ims_sudu8_page_navlist` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_navlist` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_navlist` VALUES (1,26,99,1,0,'关于我们','http://cs.riyuanma.com/assetsj/pigefanxin/nav1.png','/sudu8_page/page/page?cid=1620',''),(2,26,98,1,0,'服务项目','http://cs.riyuanma.com/assetsj/pigefanxin/nav2.png','/sudu8_page/listPic/listPic?cid=1612',''),(3,26,97,1,0,'服务展示','http://cs.riyuanma.com/assetsj/pigefanxin/nav3.png','',''),(4,26,96,1,0,'加盟培训','http://cs.riyuanma.com/assetsj/pigefanxin/nav4.png','/sudu8_page/page/page?cid=1621',''),(19,1,97,1,0,'书房系列','http://cs.riyuanma.com/assetsj/jiaju/nav3.png','/sudu8_page/listPro/listPro?cid=1648',''),(20,1,96,1,0,'阳台系列','http://cs.riyuanma.com/assetsj/jiaju/nav4.png','/sudu8_page/listPro/listPro?cid=1649',''),(18,1,98,1,0,'卧室系列','http://cs.riyuanma.com/assetsj/jiaju/nav2.png','/sudu8_page/listPro/listPro?cid=1647',''),(17,1,99,1,0,'所有产品','http://cs.riyuanma.com/assetsj/jiaju/nav1.png','/sudu8_page/listPro/listPro?cid=1646',''),(21,1,95,1,0,'客厅系列','http://cs.riyuanma.com/assetsj/jiaju/nav5.png','/sudu8_page/listPro/listPro?cid=1650',''),(22,1,94,1,0,'商务办公','http://cs.riyuanma.com/assetsj/jiaju/nav6.png','/sudu8_page/listPro/listPro?cid=1651',''),(23,1,93,1,0,'儿童系列','http://cs.riyuanma.com/assetsj/jiaju/nav7.png','/sudu8_page/listPro/listPro?cid=1652',''),(24,1,92,1,0,'储物系列','http://cs.riyuanma.com/assetsj/jiaju/nav8.png','/sudu8_page/listPro/listPro?cid=1653','');
/*!40000 ALTER TABLE `ims_sudu8_page_navlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `num` int(11) NOT NULL,
  `yhq` varchar(255) NOT NULL,
  `true_price` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `custime` int(11) DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  `pro_user_name` varchar(255) DEFAULT NULL,
  `pro_user_tel` varchar(255) DEFAULT NULL,
  `pro_user_txt` text NOT NULL,
  `overtime` int(11) DEFAULT NULL,
  `reback` int(11) DEFAULT '0' COMMENT '0未还  1已还',
  `is_more` int(1) DEFAULT '0',
  `order_duo` text,
  `coupon` int(11) DEFAULT NULL,
  `proaddress` text,
  `pro_user_add` varchar(100) DEFAULT NULL,
  `beizhu` varchar(500) NOT NULL,
  `beizhu_val` text NOT NULL,
  `nav` int(1) NOT NULL COMMENT '1发货 2到店自取',
  `address` int(11) NOT NULL COMMENT '地址id',
  `formid` int(11) NOT NULL DEFAULT '0' COMMENT '万能表单id',
  `prepayid` varchar(255) DEFAULT NULL COMMENT '模板消息prepayid',
  `tsid` int(11) NOT NULL DEFAULT '0' COMMENT 'tableselect_id',
  `th_orderid` varchar(255) DEFAULT NULL COMMENT '退货订单号',
  `qxbeizhu` varchar(255) DEFAULT NULL COMMENT '商家取消备注',
  `appoint_date` int(11) DEFAULT '0' COMMENT '预约发货时间',
  `form_id` varchar(255) DEFAULT NULL COMMENT '模板消息formid',
  `emp_id` int(11) DEFAULT NULL COMMENT '员工id',
  `modify_info` varchar(255) DEFAULT NULL COMMENT '预约信息修改',
  `kuaidi` varchar(64) DEFAULT NULL COMMENT '快递',
  `kuaidihao` varchar(64) DEFAULT NULL COMMENT '快递号',
  `qx_formid` varchar(255) DEFAULT NULL COMMENT '取消订单formid',
  `pay_price` float NOT NULL DEFAULT '0' COMMENT '微信支付金额',
  `dkscore` float NOT NULL DEFAULT '0' COMMENT '抵扣积分',
  `hxinfo` varchar(255) DEFAULT NULL COMMENT '核销信息',
  `yhinfo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_order`
--

LOCK TABLES `ims_sudu8_page_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_ordering`
--

DROP TABLE IF EXISTS `ims_sudu8_page_ordering`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_ordering` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pcid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `counts` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `true_price` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `labels` varchar(255) NOT NULL,
  `product_txt` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_ordering`
--

LOCK TABLES `ims_sudu8_page_ordering` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_ordering_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_ordering_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_ordering_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `dateline` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_ordering_cate`
--

LOCK TABLES `ims_sudu8_page_ordering_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_cate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_ordering_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_ordering_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_ordering_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `usertel` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `usertime` varchar(255) NOT NULL,
  `userbeiz` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `val` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_ordering_order`
--

LOCK TABLES `ims_sudu8_page_ordering_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_ordering_sj`
--

DROP TABLE IF EXISTS `ims_sudu8_page_ordering_sj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_ordering_sj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `names` varchar(255) NOT NULL,
  `times` varchar(255) NOT NULL,
  `fuwu` varchar(255) NOT NULL,
  `qita` varchar(255) NOT NULL,
  `usname` int(1) NOT NULL DEFAULT '0',
  `ustel` int(1) NOT NULL DEFAULT '0',
  `usadd` int(1) NOT NULL DEFAULT '0',
  `usdate` int(1) NOT NULL DEFAULT '0',
  `ustime` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_ordering_sj`
--

LOCK TABLES `ims_sudu8_page_ordering_sj` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_sj` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_ordering_sj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_page`
--

DROP TABLE IF EXISTS `ims_sudu8_page_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_page`
--

LOCK TABLES `ims_sudu8_page_page` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pic`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `imgurl` varchar(255) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1无 2七牛 3阿里云',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pic`
--

LOCK TABLES `ims_sudu8_page_pic` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pic` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pic` VALUES (1,NULL,NULL,'/upimages/20180929/ef38d6f86d0c732178e3ce4ba842bd50630.png',4),(2,NULL,NULL,'/upimages/20180929/dfa7aad1ea4960a49c960c20f24d109c595.jpg',4),(3,NULL,NULL,'/upimages/20180929/5f532558fa1f7f15aa4e5d8949a28364227.jpg',4),(4,NULL,NULL,'/upimages/20180929/e283a949825fa70bc13967c2dcde5b5e594.jpg',4),(5,1,0,'/upimages/20191204/9fb2e464328f134cd2dd4d52aaa8731116.png',1),(6,NULL,NULL,'/upimages/20191204/fe2d6c4b3b4c1b01f64be6dd6ea6beaf643.png',4),(7,1,0,'/upimages/20191204/2e63c3a90820f719f5e0dd2d49007414904.jpg',1),(8,1,0,'/upimages/20191204/2e2990eb8dead8200910ca7b08355210642.jpg',1),(9,1,0,'/upimages/20191204/05208badd7c1d3974bdd105933c46af4846.png',1),(10,1,0,'/upimages/20191204/51a712a9651fb7735eb9cef905e224d1410.jpg',1),(11,1,0,'/upimages/20191204/afed01c313336802918e0fc115343f03993.jpg',1),(12,1,0,'/upimages/20191204/9589decd8fab200bd380955c43941823603.png',1),(13,1,0,'/upimages/20191204/9b6c29db89df1006abb9338170b79056250.png',1),(14,1,0,'/upimages/20191204/274bd18de2a901120071a91b92f3092b214.jpg',1),(15,1,0,'/upimages/20191204/2781eb8d2c480f1686656c19bfc8b835456.jpg',1),(16,1,0,'/upimages/20191204/6cd84061824c5cdce4e8af9f4c8fa13f998.jpg',1),(17,1,0,'/upimages/20191207/197b6eb7938bf140cf1b6b8d28ea0dfa503.jpg',1),(18,1,0,'/upimages/20191207/b3b364eb841fc6a15789ab4714ac6d5f497.png',1),(19,1,0,'/upimages/20191207/b8d25f5eb556f6a3fc200263d5559c33282.png',1),(20,NULL,NULL,'/upimages/20191208/5b61f8d4ba837b3f65a6607d5e00a8a3352.png',4),(21,NULL,NULL,'/upimages/20191208/24eb92ec127debd64013f518f760b08684.png',4),(22,NULL,NULL,'/upimages/20200114/5b0dfed1a466cc79b0c0c0e00376a164292.jpg',4),(23,NULL,NULL,'/upimages/20200114/7fdc9d6ce991321631302ecaf2acf482620.jpg',4),(24,NULL,NULL,'/upimages/20200114/a7c0366f07be44b769567344e637ea52356.jpg',4),(25,NULL,NULL,'/upimages/20200227/b22971abedb5ec2b9744dc4e6bca59a8818.jpg',4);
/*!40000 ALTER TABLE `ims_sudu8_page_pic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_picgroup`
--

DROP TABLE IF EXISTS `ims_sudu8_page_picgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_picgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_picgroup`
--

LOCK TABLES `ims_sudu8_page_picgroup` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_picgroup` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_picgroup` VALUES (1,1,'图标');
/*!40000 ALTER TABLE `ims_sudu8_page_picgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pro_score_get`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pro_score_get`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pro_score_get` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `types` varchar(255) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `creattime` int(11) NOT NULL,
  `clickopenid` varchar(255) NOT NULL COMMENT '点击人openid',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pro_score_get`
--

LOCK TABLES `ims_sudu8_page_pro_score_get` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pro_score_get` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pro_score_get` VALUES (1,1,'undefined',49,'showPro_lv',10,1575693240,'opDoW0QrGdP8f8jAMeZ4of36PKY0');
/*!40000 ALTER TABLE `ims_sudu8_page_pro_score_get` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_products`
--

DROP TABLE IF EXISTS `ims_sudu8_page_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `pcid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `type_x` int(1) DEFAULT NULL,
  `type_y` int(1) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` mediumtext,
  `thumb` varchar(255) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `etime` int(10) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `type_i` int(1) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL COMMENT '门店价',
  `market_price` varchar(255) DEFAULT NULL COMMENT '市场价',
  `label_1` int(11) DEFAULT '1' COMMENT '标签',
  `label_2` int(11) DEFAULT '0' COMMENT '标签2',
  `sale_num` int(11) DEFAULT '0',
  `score` int(11) DEFAULT NULL COMMENT '评分',
  `product_txt` text,
  `pro_flag` int(11) NOT NULL DEFAULT '0',
  `pro_flag_tel` int(1) DEFAULT '0',
  `pro_flag_data_name` varchar(255) DEFAULT '时间',
  `pro_flag_data` int(1) DEFAULT '0',
  `pro_flag_time` int(1) DEFAULT '0',
  `pro_flag_ding` int(1) DEFAULT '0' COMMENT '是否确认订单',
  `pro_kc` int(11) NOT NULL DEFAULT '-1' COMMENT '库存',
  `pro_xz` int(11) NOT NULL DEFAULT '0' COMMENT '限购',
  `sale_tnum` int(11) NOT NULL DEFAULT '0' COMMENT '总库存不变',
  `sale_type` int(11) DEFAULT '1' COMMENT '0下架  1上架',
  `sale_time` int(11) DEFAULT '0',
  `labels` varchar(255) DEFAULT NULL,
  `is_more` int(1) DEFAULT '0' COMMENT '0不开启多规格 1开启多规格',
  `more_type` text COMMENT '多规格数据',
  `more_type_x` text,
  `more_type_num` text,
  `flag` int(1) DEFAULT '1' COMMENT '0下架1上架',
  `buy_type` varchar(255) NOT NULL DEFAULT '购买',
  `pro_flag_add` int(1) DEFAULT '0',
  `onlyid` varchar(255) DEFAULT NULL,
  `lanmu` varchar(255) DEFAULT NULL,
  `formset` varchar(255) NOT NULL,
  `is_score` int(1) NOT NULL DEFAULT '0',
  `score_num` int(11) NOT NULL DEFAULT '0',
  `share_type` int(1) DEFAULT NULL,
  `share_score` varchar(255) DEFAULT NULL,
  `share_num` int(11) DEFAULT NULL,
  `share_gz` int(1) DEFAULT NULL,
  `comment` int(1) DEFAULT NULL,
  `multi` int(1) NOT NULL DEFAULT '1',
  `types` int(1) NOT NULL DEFAULT '1',
  `top_catas` varchar(255) NOT NULL,
  `sons_catas` varchar(255) NOT NULL,
  `mulitcataid` int(5) NOT NULL DEFAULT '1',
  `get_share_gz` int(11) NOT NULL DEFAULT '2' COMMENT '1开启2关闭',
  `get_share_score` int(11) NOT NULL DEFAULT '0' COMMENT '他人点击分享获取积分',
  `get_share_num` int(11) NOT NULL DEFAULT '0' COMMENT '他人点击分享次数',
  `shareimg` varchar(255) NOT NULL,
  `glnews` text NOT NULL COMMENT '关联文章',
  `kuaidi` int(1) NOT NULL DEFAULT '0' COMMENT '0快递1到店自取',
  `edittime` int(11) NOT NULL,
  `sale_end_time` int(11) NOT NULL DEFAULT '0',
  `fx_uni` int(1) NOT NULL DEFAULT '2',
  `scoreback` varchar(255) NOT NULL DEFAULT '0',
  `commission_type` int(1) NOT NULL DEFAULT '1',
  `commission_one` float DEFAULT NULL,
  `commission_two` float DEFAULT NULL,
  `commission_three` float DEFAULT NULL,
  `music_art_info` varchar(3000) DEFAULT NULL,
  `stores` varchar(255) DEFAULT NULL,
  `con2` varchar(5000) DEFAULT NULL,
  `con3` varchar(5000) DEFAULT NULL,
  `vipconfig` varchar(255) DEFAULT NULL,
  `is_sale` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_products`
--

LOCK TABLES `ims_sudu8_page_products` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_products` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_products` VALUES (1,1612,1612,26,99,'showArt',0,0,'沙发维修','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art1.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(2,1612,1612,26,93,'showArt',0,0,'汽车内饰维修','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art2.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(3,1612,1612,26,98,'showArt',0,0,'沙发翻新','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art3.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(4,1612,1612,26,98,'showArt',0,0,'办公家具维修','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art4.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(5,1613,1613,26,99,'showArt',0,0,'亢龙太子酒店-----沙发维修','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art10.jpg',NULL,NULL,'亢龙太子酒店-----沙发维修',NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(6,1613,1613,26,93,'showArt',0,0,'豪宅------家具贴膜','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art11.jpg',NULL,NULL,'豪宅------家具贴膜',NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(7,1614,1614,26,99,'showArt',0,0,'产品特点','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art12.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(8,1614,1614,26,98,'showArt',0,0,'多种营养','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art13.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(9,1614,1614,26,98,'showArt',0,0,'六大优势','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art14.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(10,1614,1614,26,97,'showArt',0,0,'品牌支持','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art15.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(11,1614,1614,26,96,'showArt',0,0,'市场分析','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art16.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(12,1614,1614,26,95,'showArt',0,0,'利润分析','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art17.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(13,1614,1614,26,94,'showArt',0,0,'如何开店','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art18.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(14,1614,1614,26,93,'showArt',0,0,'代理加盟','这里是文章内容','http://cs.riyuanma.com/assetsj/pigefanxin/art19.jpg',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,0,0,NULL,NULL,0,0,'时间',0,0,0,-1,0,0,1,0,NULL,0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(15,1616,1615,26,99,'showPro',0,0,'修皮小套装','a:1:{i:0;s:57:\"http://cs.riyuanma.com/assetsj/pigefanxin/pro_a1_z1.jpg\";}','http://cs.riyuanma.com/assetsj/pigefanxin/pro1.jpg',NULL,NULL,'',NULL,1,NULL,'350','400',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,100,0,0,1,0,'',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(56,1653,1653,1,96,'showPro',0,1,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro4.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro4.jpg',NULL,NULL,'',NULL,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(55,1650,1650,1,96,'showPro',0,1,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro3.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro3.jpg',NULL,NULL,'',NULL,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(54,1649,1649,1,96,'showPro',1,0,'床垫','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro3.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro3.jpg',NULL,NULL,'',NULL,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(51,1646,1646,1,98,'showPro',0,1,'床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro5.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro5.jpg',NULL,NULL,'',5,0,NULL,'158','189',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,1,0,1,0,'床垫全棉床垫床褥1.8m双人垫被褥子1.2单人防滑0.9',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(50,1646,1646,1,99,'showPro',1,0,'床垫','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro1.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro1.jpg',NULL,NULL,'',3,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(53,1647,1647,1,97,'showPro',1,0,'床垫','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro2.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro2.jpg',NULL,NULL,'',2,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(52,1646,1646,1,97,'showPro',0,1,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子','a:1:{i:0;s:47:\"http://cs.riyuanma.com/assetsj/jiaju/pro1.jpg\";}','http://cs.riyuanma.com/assetsj/jiaju/pro1.jpg',NULL,NULL,'',2,0,NULL,'568','589',1,0,0,NULL,'这里是商品的详细介绍，可放图文',1,1,'时间',0,0,1,500,0,0,1,0,'床垫1.5m加厚1.8m记忆棉海绵席梦思单人1.2m床褥子',0,NULL,NULL,NULL,1,'购买',0,NULL,NULL,'',0,0,NULL,NULL,NULL,NULL,NULL,1,1,'','',1,2,0,0,'','',0,0,0,2,'0',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `ims_sudu8_page_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_cate`
--

LOCK TABLES `ims_sudu8_page_pt_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_cate` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pt_cate` VALUES (1,1,1,'水果蔬菜',1575466036),(2,1,2,'家居建材',1575466047),(3,1,3,'柴米油盐',1575466060);
/*!40000 ALTER TABLE `ims_sudu8_page_pt_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_gz`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_gz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_gz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `types` int(1) NOT NULL DEFAULT '1',
  `is_score` int(1) NOT NULL DEFAULT '1' COMMENT '1不启用 2启用【启用积分抵扣】',
  `is_tuanz` int(1) NOT NULL DEFAULT '1' COMMENT '1不启用2启用【启用团长优惠】',
  `is_pt` int(1) NOT NULL DEFAULT '2' COMMENT '1不启用2启用【是否自动成团】',
  `pt_time` int(11) NOT NULL DEFAULT '24' COMMENT '成团时间',
  `fahuo` int(11) NOT NULL DEFAULT '7' COMMENT '自动发货',
  `guiz` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_gz`
--

LOCK TABLES `ims_sudu8_page_pt_gz` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_gz` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pt_gz` VALUES (1,1,2,1,1,1,24,7,'<p>拼团功能<br/></p>');
/*!40000 ALTER TABLE `ims_sudu8_page_pt_gz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `jsondata` text NOT NULL,
  `coupon` int(11) NOT NULL DEFAULT '0',
  `jf` varchar(255) NOT NULL DEFAULT '0',
  `address` int(11) NOT NULL DEFAULT '0',
  `m_address` varchar(1000) NOT NULL,
  `liuyan` varchar(1000) NOT NULL,
  `creattime` int(11) NOT NULL,
  `hxtime` int(11) NOT NULL DEFAULT '0',
  `nav` int(1) NOT NULL DEFAULT '1',
  `kuadi` varchar(255) NOT NULL,
  `kuaidihao` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `types` int(1) NOT NULL DEFAULT '1' COMMENT '1拼团2立即购买',
  `pt_order` varchar(255) NOT NULL COMMENT '拼团的订单id',
  `ck` int(1) NOT NULL DEFAULT '1' COMMENT '1开团2参团',
  `jqr` int(1) NOT NULL DEFAULT '1' COMMENT '1买家2机器人',
  `hxinfo` varchar(255) DEFAULT NULL COMMENT '核销信息',
  `yue_price` float NOT NULL,
  `wx_price` float NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_order`
--

LOCK TABLES `ims_sudu8_page_pt_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_pro`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_pro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_pro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pcid` int(11) NOT NULL,
  `type_x` int(1) NOT NULL DEFAULT '0',
  `type_y` int(1) NOT NULL DEFAULT '0',
  `type_i` int(1) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT '0' COMMENT '拼团价[显示用，一般设置最低]',
  `mark_price` float NOT NULL DEFAULT '0' COMMENT '单买价[显示用]',
  `thumb` varchar(255) NOT NULL COMMENT '缩略图',
  `imgtext` varchar(2000) NOT NULL COMMENT '组图',
  `descs` varchar(1000) NOT NULL COMMENT '简介',
  `texts` text NOT NULL COMMENT '详情',
  `types` int(1) NOT NULL DEFAULT '1' COMMENT '拼团类型1单层团2阶梯团',
  `explains` varchar(255) NOT NULL COMMENT '标签',
  `pt_min` int(11) NOT NULL DEFAULT '2' COMMENT '拼团最小人数',
  `pt_max` int(11) NOT NULL DEFAULT '5' COMMENT '拼团最大人数',
  `score` int(11) NOT NULL COMMENT '最多可抵用积分',
  `xsl` int(11) NOT NULL DEFAULT '0',
  `onlyid` int(11) NOT NULL,
  `tz_yh` int(11) NOT NULL DEFAULT '10',
  `shareimg` varchar(255) NOT NULL,
  `kuaidi` int(1) NOT NULL DEFAULT '0' COMMENT '0快递1到店自取',
  `stores` varchar(255) DEFAULT NULL,
  `vipconfig` varchar(255) DEFAULT NULL,
  `show_pro` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_pro`
--

LOCK TABLES `ims_sudu8_page_pt_pro` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_pro` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pt_pro` VALUES (1,1,1,3,0,1,0,0,'九牛网科技软件开发',3000,6000,'/upimages/20191204/51a712a9651fb7735eb9cef905e224d1410.jpg','a:1:{i:0;s:58:\"/upimages/20191204/afed01c313336802918e0fc115343f03993.jpg\";}','产品简介','<p><img src=\"http://cs.riyuanma.com/upimages/20191204/1575466303978140.jpg\" title=\"1575466303978140.jpg\"/></p><p><img src=\"http://cs.riyuanma.com/upimages/20191204/1575466304333087.jpg\" title=\"1575466304333087.jpg\"/></p><p><img src=\"http://cs.riyuanma.com/upimages/20191204/1575466304403379.jpg\" title=\"1575466304403379.jpg\"/></p><p><br/></p>',0,'软件开发',2,5,0,0,2147483647,9,'/upimages/20191204/51a712a9651fb7735eb9cef905e224d1410.jpg',0,NULL,NULL,0);
/*!40000 ALTER TABLE `ims_sudu8_page_pt_pro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_pro_val`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_pro_val`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_pro_val` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `type1` varchar(255) NOT NULL,
  `type2` varchar(255) NOT NULL,
  `type3` varchar(255) NOT NULL,
  `kc` float NOT NULL,
  `price` float NOT NULL,
  `dprice` float NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `updatetime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_pro_val`
--

LOCK TABLES `ims_sudu8_page_pt_pro_val` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_pro_val` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_pt_pro_val` VALUES (1,1,'开发','','',0,0,0,'','定制',1575466356);
/*!40000 ALTER TABLE `ims_sudu8_page_pt_pro_val` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_robot`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_robot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_robot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `icon` varchar(2555) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_robot`
--

LOCK TABLES `ims_sudu8_page_pt_robot` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_robot` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_robot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_share`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `shareid` varchar(255) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL COMMENT '商品id',
  `creattime` int(11) NOT NULL DEFAULT '0',
  `join_count` int(11) NOT NULL DEFAULT '1',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1正在进行2已完成3已过期',
  `pt_min` int(11) NOT NULL,
  `pt_max` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_share`
--

LOCK TABLES `ims_sudu8_page_pt_share` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_pt_tx`
--

DROP TABLE IF EXISTS `ims_sudu8_page_pt_tx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_pt_tx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(1000) NOT NULL,
  `ptorder` varchar(255) NOT NULL COMMENT '拼团订单号',
  `money` float NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1申请中2已通过3已拒绝',
  `txtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_pt_tx`
--

LOCK TABLES `ims_sudu8_page_pt_tx` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_tx` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_pt_tx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_recharge`
--

DROP TABLE IF EXISTS `ims_sudu8_page_recharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `money` varchar(255) NOT NULL DEFAULT '0',
  `getmoney` varchar(255) NOT NULL DEFAULT '0',
  `getscore` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_recharge`
--

LOCK TABLES `ims_sudu8_page_recharge` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_recharge` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_recharge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_rechargeconf`
--

DROP TABLE IF EXISTS `ims_sudu8_page_rechargeconf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_rechargeconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `score` varchar(255) NOT NULL,
  `money` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '充值有礼',
  `score_shoppay` int(11) NOT NULL DEFAULT '0' COMMENT '店内最大抵用积分',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_rechargeconf`
--

LOCK TABLES `ims_sudu8_page_rechargeconf` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_rechargeconf` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_rechargeconf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_remote`
--

DROP TABLE IF EXISTS `ims_sudu8_page_remote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_remote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '2七牛  3阿里云',
  `bucket` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL COMMENT '域名',
  `domainIs` int(1) NOT NULL DEFAULT '2' COMMENT '是否开启自定义域名  1开  2否',
  `ak` varchar(255) NOT NULL COMMENT 'AccessKey',
  `sk` varchar(255) NOT NULL COMMENT 'SecretKey',
  `imgstyle` varchar(255) DEFAULT NULL COMMENT '图片样式接口',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_remote`
--

LOCK TABLES `ims_sudu8_page_remote` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_remote` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_remote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_score`
--

DROP TABLE IF EXISTS `ims_sudu8_page_score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_score`
--

LOCK TABLES `ims_sudu8_page_score` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_score` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_score` VALUES (1,1,'201912071234009673',5,'add','10','他人点击分享获取积分',1575693240);
/*!40000 ALTER TABLE `ims_sudu8_page_score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_score_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_score_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_score_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catepic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_score_cate`
--

LOCK TABLES `ims_sudu8_page_score_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_score_cate` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_score_cate` VALUES (1,1,1,'礼品','');
/*!40000 ALTER TABLE `ims_sudu8_page_score_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_score_get`
--

DROP TABLE IF EXISTS `ims_sudu8_page_score_get`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_score_get` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `descp` varchar(255) NOT NULL COMMENT '简介',
  `score` float NOT NULL DEFAULT '0' COMMENT '积分数',
  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `flag` int(1) NOT NULL COMMENT '0不开启 1开启',
  `fixed` int(2) DEFAULT NULL COMMENT '系统自动添加的几条',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_score_get`
--

LOCK TABLES `ims_sudu8_page_score_get` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_score_get` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_score_get` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_score_order`
--

DROP TABLE IF EXISTS `ims_sudu8_page_score_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_score_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `num` varchar(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  `custime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_score_order`
--

LOCK TABLES `ims_sudu8_page_score_order` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_score_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_score_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_score_shop`
--

DROP TABLE IF EXISTS `ims_sudu8_page_score_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_score_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `sale_num` int(11) NOT NULL,
  `buy_type` varchar(255) NOT NULL DEFAULT '兑换',
  `thumb` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `onlyid` varchar(255) NOT NULL,
  `desk` varchar(255) NOT NULL,
  `product_txt` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `market_price` varchar(255) NOT NULL,
  `pro_kc` int(11) NOT NULL DEFAULT '-1',
  `sale_tnum` int(22) NOT NULL DEFAULT '0',
  `labels` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_score_shop`
--

LOCK TABLES `ims_sudu8_page_score_shop` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_score_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_score_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_share_user`
--

DROP TABLE IF EXISTS `ims_sudu8_page_share_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_share_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `creattime` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_share_user`
--

LOCK TABLES `ims_sudu8_page_share_user` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_share_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_share_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_shops_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_shops_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_shops_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `num` int(11) NOT NULL COMMENT '排序越大越靠前',
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_shops_cate`
--

LOCK TABLES `ims_sudu8_page_shops_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_cate` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_shops_cate` VALUES (1,1,'手机通讯',1,1);
/*!40000 ALTER TABLE `ims_sudu8_page_shops_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_shops_goods`
--

DROP TABLE IF EXISTS `ims_sudu8_page_shops_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_shops_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `sid` int(11) DEFAULT NULL COMMENT '所属店铺',
  `buy_type` int(1) NOT NULL DEFAULT '0' COMMENT '0购买1预定',
  `hot` int(1) NOT NULL DEFAULT '0' COMMENT '0不推荐1推荐',
  `pageview` int(11) NOT NULL DEFAULT '0' COMMENT '访问量',
  `vsales` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `rsales` int(11) NOT NULL DEFAULT '0' COMMENT '真实销量',
  `sellprice` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '售价',
  `marketprice` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `storage` int(11) NOT NULL DEFAULT '0' COMMENT '库存量',
  `thumb` varchar(1000) DEFAULT NULL COMMENT '缩略图',
  `images` varchar(5000) DEFAULT NULL COMMENT '产品组图',
  `descp` varchar(2000) DEFAULT NULL COMMENT '产品详情',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '排序越大越靠前',
  `createtime` int(11) NOT NULL COMMENT '创建日期',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '0下架1上架',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0未审核1已审核',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_shops_goods`
--

LOCK TABLES `ims_sudu8_page_shops_goods` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_shops_set`
--

DROP TABLE IF EXISTS `ims_sudu8_page_shops_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_shops_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `apply` int(1) NOT NULL DEFAULT '1' COMMENT '0不需要审核1需要',
  `goods` int(1) NOT NULL DEFAULT '1' COMMENT '商品0不需审核1需要',
  `withdraw` int(1) NOT NULL DEFAULT '1' COMMENT '提现0不需要审核1需要',
  `minimum` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '最低提现金额',
  `bg` varchar(255) DEFAULT NULL COMMENT '商户申请入驻页头部背景图',
  `protocol` varchar(5000) DEFAULT NULL COMMENT '商户入驻协议',
  `tjnum` int(11) NOT NULL DEFAULT '6' COMMENT '推荐数',
  `num` int(11) NOT NULL DEFAULT '6' COMMENT '默认数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_shops_set`
--

LOCK TABLES `ims_sudu8_page_shops_set` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_set` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_shops_set` VALUES (1,1,1,1,1,0.00,NULL,'',6,6);
/*!40000 ALTER TABLE `ims_sudu8_page_shops_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_shops_shop`
--

DROP TABLE IF EXISTS `ims_sudu8_page_shops_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_shops_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `cid` varchar(255) DEFAULT NULL COMMENT '店铺分类id',
  `username` varchar(50) NOT NULL DEFAULT 'admin' COMMENT '登录名',
  `password` varchar(50) NOT NULL DEFAULT '12345' COMMENT '密码',
  `tixian` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `bg` varchar(255) DEFAULT NULL COMMENT '背景图',
  `yyzz` varchar(255) NOT NULL COMMENT '营业执照',
  `intro` varchar(255) DEFAULT '' COMMENT '一句话简介',
  `worktime` varchar(255) DEFAULT '' COMMENT '营业时间',
  `name` varchar(50) NOT NULL COMMENT '名字',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `address` varchar(50) NOT NULL COMMENT '地址',
  `latitude` float(10,6) NOT NULL COMMENT '纬度',
  `longitude` float(10,6) NOT NULL COMMENT '经度',
  `star` float DEFAULT NULL COMMENT '评分星星',
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态0下架1上架',
  `hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不推荐，1推荐',
  `authenticate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已认证0否1是',
  `descp` varchar(500) DEFAULT '' COMMENT '简介',
  `title` varchar(20) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '排序越大越靠前',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `images` varchar(2000) DEFAULT NULL COMMENT '组图',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0未审核1已审核',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_shops_shop`
--

LOCK TABLES `ims_sudu8_page_shops_shop` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_shops_tixian`
--

DROP TABLE IF EXISTS `ims_sudu8_page_shops_tixian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_shops_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `cid` varchar(255) DEFAULT NULL COMMENT '店铺分类id',
  `username` varchar(50) NOT NULL DEFAULT 'admin' COMMENT '登录名',
  `password` varchar(50) NOT NULL DEFAULT '12345' COMMENT '密码',
  `tixian` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '可提现金额',
  `logo` varchar(255) DEFAULT NULL COMMENT 'logo',
  `bg` varchar(255) DEFAULT NULL COMMENT '背景图',
  `yyzz` varchar(255) NOT NULL COMMENT '营业执照',
  `intro` varchar(255) DEFAULT '' COMMENT '一句话简介',
  `worktime` varchar(255) DEFAULT '' COMMENT '营业时间',
  `name` varchar(50) NOT NULL COMMENT '名字',
  `tel` varchar(20) NOT NULL COMMENT '电话',
  `address` varchar(50) NOT NULL COMMENT '地址',
  `latitude` float(10,6) NOT NULL COMMENT '纬度',
  `longitude` float(10,6) NOT NULL COMMENT '经度',
  `star` float DEFAULT NULL COMMENT '评分星星',
  `flag` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态0下架1上架',
  `hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不推荐，1推荐',
  `authenticate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已认证0否1是',
  `descp` varchar(500) DEFAULT '' COMMENT '简介',
  `title` varchar(20) DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '排序越大越靠前',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `images` varchar(2000) DEFAULT NULL COMMENT '组图',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0未审核1已审核',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_shops_tixian`
--

LOCK TABLES `ims_sudu8_page_shops_tixian` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_tixian` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_shops_tixian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_sign`
--

DROP TABLE IF EXISTS `ims_sudu8_page_sign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_sign`
--

LOCK TABLES `ims_sudu8_page_sign` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_sign` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_sign` VALUES (1,1,'opDoW0TyrOFisQggRrUOJD9anFHk',1575580638,0),(2,1,'opDoW0QrGdP8f8jAMeZ4of36PKY0',1576985446,0);
/*!40000 ALTER TABLE `ims_sudu8_page_sign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_sign_con`
--

DROP TABLE IF EXISTS `ims_sudu8_page_sign_con`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_sign_con` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `score` varchar(255) NOT NULL DEFAULT '10/20',
  `max_score` int(11) NOT NULL DEFAULT '10000',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_sign_con`
--

LOCK TABLES `ims_sudu8_page_sign_con` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_sign_con` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_sign_con` VALUES (1,1,'5/10',10);
/*!40000 ALTER TABLE `ims_sudu8_page_sign_con` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_sign_lx`
--

DROP TABLE IF EXISTS `ims_sudu8_page_sign_lx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_sign_lx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `max_count` int(11) NOT NULL DEFAULT '0',
  `all_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_sign_lx`
--

LOCK TABLES `ims_sudu8_page_sign_lx` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_sign_lx` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_sign_lx` VALUES (1,1,'opDoW0TyrOFisQggRrUOJD9anFHk',1,0,1),(2,1,'opDoW0QrGdP8f8jAMeZ4of36PKY0',1,0,1);
/*!40000 ALTER TABLE `ims_sudu8_page_sign_lx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_staff`
--

DROP TABLE IF EXISTS `ims_sudu8_page_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned DEFAULT NULL COMMENT '小程序ID',
  `realname` varchar(255) NOT NULL COMMENT '真实姓名',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `wxnumber` varchar(100) DEFAULT NULL COMMENT '微信号码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `province` varchar(100) DEFAULT NULL COMMENT '所属省',
  `proid` int(10) NOT NULL,
  `city` varchar(100) DEFAULT NULL COMMENT '所属城市',
  `cityid` int(10) NOT NULL,
  `area` varchar(100) DEFAULT NULL COMMENT '所属区/市/县',
  `areaid` int(10) NOT NULL,
  `address` varchar(100) DEFAULT NULL COMMENT '详细地址',
  `hxmm` int(11) DEFAULT NULL COMMENT '核销密码',
  `title` varchar(50) DEFAULT NULL COMMENT '头衔',
  `job` varchar(50) DEFAULT NULL COMMENT '职务',
  `pic` varchar(255) DEFAULT NULL COMMENT '照片',
  `contract` int(10) DEFAULT '0' COMMENT '签约状态 0-未签约  1-已签约  2-待续约',
  `auth` int(10) DEFAULT '0' COMMENT '认证状态  0-待认证, 1-已认证',
  `score` float(2,1) DEFAULT '0.0' COMMENT '评分  0-5星',
  `visit` int(10) DEFAULT '0' COMMENT '访问量',
  `zan` int(10) DEFAULT '0' COMMENT '点赞量',
  `forward` int(10) DEFAULT '0' COMMENT '转发量',
  `expand` varchar(255) DEFAULT NULL COMMENT '拓展内容',
  `price` int(10) DEFAULT '0' COMMENT '工时费',
  `descp` text COMMENT '介绍',
  `voice` varchar(255) DEFAULT NULL COMMENT '音频介绍',
  `autovoice` int(10) NOT NULL DEFAULT '0' COMMENT '是否自动播放语音',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '生成的二维码图片',
  `bqrcode` varchar(255) DEFAULT NULL COMMENT '后台生成二维码',
  `company` varchar(255) DEFAULT NULL COMMENT '所属公司',
  `visitor` varchar(255) DEFAULT NULL,
  `store` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_staff`
--

LOCK TABLES `ims_sudu8_page_staff` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_store`
--

DROP TABLE IF EXISTS `ims_sudu8_page_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `lat` varchar(20) NOT NULL,
  `lon` varchar(20) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `times` varchar(20) NOT NULL,
  `score` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `dateline` int(11) NOT NULL,
  `title1` varchar(50) NOT NULL,
  `title2` varchar(50) NOT NULL,
  `descp` varchar(255) NOT NULL,
  `onlyid` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `proid` int(10) DEFAULT NULL,
  `cityid` int(10) DEFAULT NULL,
  `desc2` text NOT NULL,
  `staff` varchar(1000) DEFAULT NULL COMMENT '员工',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_store`
--

LOCK TABLES `ims_sudu8_page_store` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_storeconf`
--

DROP TABLE IF EXISTS `ims_sudu8_page_storeconf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_storeconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `search` int(1) NOT NULL,
  `flag` int(1) NOT NULL,
  `mapkey` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_storeconf`
--

LOCK TABLES `ims_sudu8_page_storeconf` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_storeconf` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_storeconf` VALUES (1,1,1,1,'EC3BZ-JBZCF-DPSJ5-JMG5O-7TI67-ILFUZ',1575712831,'九牛网科技');
/*!40000 ALTER TABLE `ims_sudu8_page_storeconf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_system_base`
--

DROP TABLE IF EXISTS `ims_sudu8_page_system_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_system_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `top_banner` varchar(255) NOT NULL,
  `foot_logo` varchar(255) NOT NULL,
  `ptel` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `ftime` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `erweima` varchar(255) NOT NULL,
  `beianxx` varchar(500) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_system_base`
--

LOCK TABLES `ims_sudu8_page_system_base` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_system_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_system_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_system_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_page_system_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_system_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_system_cate`
--

LOCK TABLES `ims_sudu8_page_system_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_system_cate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_system_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_system_news`
--

DROP TABLE IF EXISTS `ims_sudu8_page_system_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_system_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `text` text NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `num` int(11) NOT NULL DEFAULT '50',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_system_news`
--

LOCK TABLES `ims_sudu8_page_system_news` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_system_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_system_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_user`
--

DROP TABLE IF EXISTS `ims_sudu8_page_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned DEFAULT NULL COMMENT '小程序ID',
  `openid` varchar(255) NOT NULL COMMENT '用户的唯一身份ID',
  `createtime` int(11) unsigned NOT NULL COMMENT '加入时间',
  `realname` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `icon` varchar(255) DEFAULT NULL COMMENT 'PC版头像',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ号',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别(0:保密 1:男 2:女)',
  `telephone` varchar(15) DEFAULT '' COMMENT '固定电话',
  `idcardtype` tinyint(1) DEFAULT '1' COMMENT '证件类型：身份证 护照 军官证等',
  `idcard` varchar(255) DEFAULT NULL COMMENT '证件号码',
  `address` varchar(255) DEFAULT '' COMMENT '邮寄地址',
  `zipcode` varchar(255) DEFAULT NULL COMMENT '邮编',
  `nationality` varchar(30) DEFAULT '' COMMENT '国籍',
  `resideprovince` varchar(30) DEFAULT '' COMMENT '居住省份',
  `residecity` varchar(30) DEFAULT '' COMMENT '居住城市',
  `residedist` varchar(30) DEFAULT '' COMMENT '居住行政区/县',
  `residecommunity` varchar(30) DEFAULT '' COMMENT '居住小区',
  `residesuite` varchar(30) DEFAULT '' COMMENT '小区、写字楼门牌号',
  `graduateschool` varchar(50) DEFAULT '' COMMENT '毕业学校',
  `company` varchar(50) DEFAULT '' COMMENT '公司',
  `education` varchar(10) DEFAULT '' COMMENT '学历',
  `occupation` varchar(30) DEFAULT '' COMMENT '职业',
  `position` varchar(30) DEFAULT '' COMMENT '职位',
  `revenue` varchar(10) DEFAULT '' COMMENT '年收入',
  `affectivestatus` varchar(30) DEFAULT '' COMMENT '情感状态',
  `lookingfor` varchar(255) DEFAULT '' COMMENT ' 交友目的',
  `bloodtype` varchar(5) DEFAULT '' COMMENT '血型',
  `height` varchar(5) DEFAULT '' COMMENT '身高',
  `weight` varchar(5) DEFAULT '' COMMENT '体重',
  `alipay` varchar(30) DEFAULT '' COMMENT '支付宝帐号',
  `msn` varchar(30) DEFAULT '' COMMENT 'MSN',
  `taobao` varchar(30) DEFAULT '' COMMENT '阿里旺旺',
  `site` varchar(30) DEFAULT '' COMMENT '主页',
  `bio` text COMMENT '自我介绍',
  `interest` text COMMENT '兴趣爱好',
  `money` float NOT NULL DEFAULT '0',
  `score` float NOT NULL DEFAULT '0',
  `flag` int(1) NOT NULL DEFAULT '0',
  `p_p_parent_id` varchar(1000) NOT NULL DEFAULT '0' COMMENT '父级的父级的父级',
  `p_parent_id` varchar(1000) NOT NULL DEFAULT '0' COMMENT '父级的父级',
  `parent_id` varchar(1000) NOT NULL DEFAULT '0' COMMENT '父级',
  `fxs` int(1) NOT NULL DEFAULT '1' COMMENT '1不是分销商2分销商',
  `fxstime` int(11) NOT NULL DEFAULT '0',
  `fx_allmoney` float NOT NULL DEFAULT '0' COMMENT '分销获得过的钱',
  `fx_getmoney` float NOT NULL DEFAULT '0' COMMENT '分销已经提现的钱',
  `fx_money` float NOT NULL DEFAULT '0' COMMENT '分销商获得过的钱分销可提现钱',
  `p_get_money` float NOT NULL DEFAULT '0' COMMENT '父级获得的钱',
  `p_p_get_money` float NOT NULL DEFAULT '0' COMMENT '父父级获得的钱',
  `p_p_p_get_money` float NOT NULL DEFAULT '0' COMMENT '父父父级获得的钱',
  `ewm` varchar(255) NOT NULL,
  `birth` varchar(255) DEFAULT NULL COMMENT '生日',
  `vipid` varchar(255) DEFAULT NULL COMMENT 'vip卡号',
  `vipcreatetime` varchar(255) DEFAULT NULL COMMENT 'vip创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_user`
--

LOCK TABLES `ims_sudu8_page_user` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_user` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_user` VALUES (1,1,'oqD4W0a3QZdgzGCkZS5nExyH0MLc',0,NULL,'岳冀川18533015976','https://wx.qlogo.cn/mmopen/vi_32/gnbClianDhojicraianIHFr9l1pibukbeMAD0MdfgcNEibsPtSIicZmiaQRiaCvmWuMzFia1LOA1c7AiaiaxkKAO4iaaa2xccg/132',NULL,NULL,NULL,1,'',1,NULL,NULL,NULL,'China','Hebei','Tangshan','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(2,1,'opDoW0QrGdP8f8jAMeZ4of36PKY0',1575464865,NULL,'岳冀川18533015976','https://wx.qlogo.cn/mmopen/vi_32/gnbClianDhoiaQwlIslNyeBKpxKtkJflO10ERwFJtk1kwDXtnb3jOVC3ibAqvgEFlSEfSssFSeTEhFmVNp0a6TY9A/132',NULL,NULL,NULL,1,'',1,NULL,NULL,NULL,'China','Hebei','Tangshan','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(3,1,'opDoW0bY4lfdelVpKogAGgVRnYtg',1575465641,NULL,' 不期而遇','https://wx.qlogo.cn/mmopen/vi_32/QKwesY1bGxH3IDO5XLUWicWsfEXUCr8juiajL7LCnVKQiconLO5aG9LVpRr1IGwriaic0vFSTJQzWegev1jFLPVnfQg/132',NULL,NULL,NULL,1,'',1,NULL,NULL,NULL,'China','Hebei','Tangshan','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(4,1,'',0,NULL,'满天星','https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEKSJcxfWmKH9fL2RBh21qwuPAT1eI4VCmSIv2LmJfnoNlxjJE8RzjycUDu7fo8UVfgTMHUZA6YLgQ/132',NULL,NULL,NULL,2,'',1,NULL,NULL,NULL,'','Parana','','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(5,1,'undefined',0,'null','满天星','https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEKSJcxfWmKH9fL2RBh21qwuPAT1eI4VCmSIv2LmJfnoNlxjJE8RzjycUDu7fo8UVfgTMHUZA6YLgQ/132',NULL,NULL,'',2,'',1,NULL,NULL,NULL,'','Parana','','','l4C2jejA','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,10,0,'0','0','0',1,0,0,0,0,0,0,0,'http://cs.riyuanma.com/image/1201912/120191215771121226784.jpg','null',NULL,NULL),(6,1,'opDoW0T6B0bHLBCb0N5ihz0UaClw',1575537997,NULL,'林以合','https://wx.qlogo.cn/mmhead/FlwglpT6huEfafpmBcc1icUEux9znib6SGzBuhtdXhrbI/132',NULL,NULL,NULL,0,'',1,NULL,NULL,NULL,'','','','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(7,1,'opDoW0TyrOFisQggRrUOJD9anFHk',1575580577,NULL,'李珮心','https://wx.qlogo.cn/mmhead/hxZ0yTicB8p8jgwKt2RVuGriaqX68m17nTdVicolWxT3NA/132',NULL,NULL,NULL,0,'',1,NULL,NULL,NULL,'','','','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(8,1,'opDoW0dFn-Mz6WXqCbPb3d1H7LF0',1575681352,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(9,1,'opDoW0QgJSznnBBxJiAlpdWIGPf0',1575765097,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(10,1,'opDoW0awxG2AlxA2tSBcBeZZVk-Q',1575857527,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(11,1,'opDoW0ZnYzl0860QStfkr59BQKqw',1575860958,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(12,1,'opDoW0X_pIA4kCGKuWmR7DRD9RwE',1576119266,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(13,1,'opDoW0Wc1hKOYFDyN172T_SgE1rI',1576119269,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(14,1,'opDoW0cuO4izc0isDiTFpfGPabvQ',1576119277,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(15,1,'opDoW0bwMpNf8eKjILcp8Vjf4sds',1576957478,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(16,1,'opDoW0V3GityzoW-T-X9HG1Sr9Zs',1576984582,NULL,'邱铭喆','https://wx.qlogo.cn/mmopen/vi_32/sUsLLYggczuzibh3GCzRawCZNicI1bzfLjntzt4F89ajNoUKMyCwIjPEia0WYyrOicoL23O2wbWiahNBbAWMWZuua9A/132',NULL,NULL,NULL,1,'',1,NULL,NULL,NULL,'China','Liaoning','Shenyang','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(17,1,'opDoW0akEulBF2Iz2Ee1UH8AcYp0',1577153174,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(18,1,'opDoW0b_u68-buo_2Lzi3OvBJzEY',1577153274,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(19,1,'opDoW0Yvgf7ZrTAjGOw_x6YARCVM',1577154603,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(20,1,'opDoW0X1-rd_TCikSaUVcE0NTo54',1577309701,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(21,1,'opDoW0aVVeRpLaxv8ZdmyZ4Ss3bs',1577573305,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(22,1,'opDoW0Z3r6FhtcYWMW23IQM6-j1M',1577778030,NULL,'rdgztest_JDXXLH','',NULL,NULL,NULL,0,'',1,NULL,NULL,NULL,'','','','','','','',NULL,'','',NULL,'','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(23,1,'opDoW0aeecdCITY6P9dluhW_nQ1Q',1578002872,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(24,1,'opDoW0dSEeNF5y8sDCOngX5rm6C0',1578523393,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(25,1,'opDoW0RJDIpejVsqYrFRpOVcQGII',1578773635,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(26,1,'opDoW0RGLrx6Tyzz0htKXYZ3KVpQ',1579380394,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(27,1,'opDoW0dgS5BvdkHqbMl8NnXdf10s',1579508881,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(28,1,'opDoW0VxBpxGZffMAzO0wr6i2i2E',1580028120,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(29,1,'opDoW0aen70KpbYp2pZtQ9mUhe-o',1580633639,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(30,1,'opDoW0XD3YPoRsKirb0BtSmvE7bk',1581142643,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(31,1,'opDoW0TBqX2uDwhyN0Zr1XkaTpS4',1581199346,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(32,1,'opDoW0ZnnHZKp_ZRheVC_RvAyu1o',1581562777,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL),(33,1,'opDoW0YZwf4f9y4WLs9ezD6yI9XU',1582167530,NULL,'','',NULL,NULL,NULL,0,'',1,NULL,'',NULL,'','','','','','','','','','','','','','','','','','','','','',NULL,NULL,0,0,0,'0','0','0',1,0,0,0,0,0,0,0,'',NULL,NULL,NULL);
/*!40000 ALTER TABLE `ims_sudu8_page_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_usercenter_set`
--

DROP TABLE IF EXISTS `ims_sudu8_page_usercenter_set`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_usercenter_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `usercenterset` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_usercenter_set`
--

LOCK TABLES `ims_sudu8_page_usercenter_set` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_usercenter_set` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_usercenter_set` VALUES (1,1,'a:78:{s:6:\"title1\";s:12:\"分销中心\";s:4:\"num1\";s:1:\"1\";s:6:\"thumb1\";s:38:\"http://cs.riyuanma.com/image/nifx.png\";s:5:\"flag1\";s:1:\"1\";s:4:\"url1\";s:41:\"/sudu8_page/fenxiao_center/fenxiao_center\";s:5:\"icon1\";s:15:\"icon-x-fenxiao2\";s:6:\"title2\";s:12:\"签到中心\";s:4:\"num2\";s:1:\"2\";s:6:\"thumb2\";s:38:\"http://cs.riyuanma.com/image/niqd.png\";s:5:\"flag2\";s:1:\"2\";s:4:\"url2\";s:35:\"/sudu8_page_plugin_sign/index/index\";s:5:\"icon2\";s:15:\"icon-x-qiandao2\";s:6:\"title3\";s:18:\"积分兑换中心\";s:4:\"num3\";s:1:\"3\";s:6:\"thumb3\";s:38:\"http://cs.riyuanma.com/image/nijf.png\";s:5:\"flag3\";s:1:\"1\";s:4:\"url3\";s:37:\"/sudu8_page_plugin_exchange/list/list\";s:5:\"icon3\";s:12:\"icon-x-jifen\";s:6:\"title4\";s:18:\"我的餐饮订单\";s:4:\"num4\";s:1:\"4\";s:6:\"thumb4\";s:38:\"http://cs.riyuanma.com/image/nicy.png\";s:5:\"flag4\";s:1:\"1\";s:4:\"url4\";s:39:\"/sudu8_page_plugin_food/food_my/food_my\";s:5:\"icon4\";s:14:\"icon-x-diancan\";s:6:\"title5\";s:21:\"我的多规格订单\";s:4:\"num5\";s:1:\"5\";s:6:\"thumb5\";s:38:\"http://cs.riyuanma.com/image/nidd.png\";s:5:\"flag5\";s:1:\"1\";s:4:\"url5\";s:43:\"/sudu8_page/order_more_list/order_more_list\";s:5:\"icon5\";s:12:\"icon-x-gouwu\";s:6:\"title6\";s:18:\"我的付费视频\";s:4:\"num6\";s:1:\"6\";s:6:\"thumb6\";s:38:\"http://cs.riyuanma.com/image/nisp.png\";s:5:\"flag6\";s:1:\"1\";s:4:\"url6\";s:27:\"/sudu8_page/order_v/order_v\";s:5:\"icon6\";s:13:\"icon-x-shipin\";s:6:\"title7\";s:15:\"我的优惠券\";s:4:\"num7\";s:1:\"7\";s:6:\"thumb7\";s:38:\"http://cs.riyuanma.com/image/niyh.png\";s:5:\"flag7\";s:1:\"1\";s:4:\"url7\";s:29:\"/sudu8_page/mycoupon/mycoupon\";s:5:\"icon7\";s:18:\"icon-x-youhuiquan2\";s:6:\"title8\";s:12:\"我的收藏\";s:4:\"num8\";s:1:\"8\";s:6:\"thumb8\";s:38:\"http://cs.riyuanma.com/image/nisc.png\";s:5:\"flag8\";s:1:\"1\";s:4:\"url8\";s:27:\"/sudu8_page/collect/collect\";s:5:\"icon8\";s:12:\"icon-c-xing1\";s:6:\"title9\";s:12:\"我的地址\";s:4:\"num9\";s:1:\"9\";s:6:\"thumb9\";s:38:\"http://cs.riyuanma.com/image/nidz.png\";s:5:\"flag9\";s:1:\"1\";s:4:\"url9\";s:27:\"/sudu8_page/address/address\";s:5:\"icon9\";s:12:\"icon-x-dizhi\";s:7:\"title10\";s:12:\"流水记录\";s:5:\"num10\";s:2:\"10\";s:7:\"thumb10\";s:38:\"http://cs.riyuanma.com/image/nijf.png\";s:6:\"flag10\";s:1:\"1\";s:5:\"url10\";s:31:\"/sudu8_page/scorelist/scorelist\";s:6:\"icon10\";s:14:\"icon-x-liushui\";s:7:\"title11\";s:12:\"拼团订单\";s:5:\"num11\";s:2:\"11\";s:7:\"thumb11\";s:38:\"http://cs.riyuanma.com/image/ptdd.png\";s:6:\"flag11\";s:1:\"1\";s:5:\"url11\";s:41:\"/sudu8_page_plugin_pt/orderlist/orderlist\";s:6:\"icon11\";s:14:\"icon-x-pintuan\";s:7:\"title12\";s:12:\"预约订单\";s:5:\"num12\";s:2:\"12\";s:7:\"thumb12\";s:38:\"http://cs.riyuanma.com/image/yydd.png\";s:6:\"flag12\";s:1:\"1\";s:5:\"url12\";s:23:\"/sudu8_page/order/order\";s:6:\"icon12\";s:15:\"icon-x-qiandao3\";s:7:\"title13\";s:12:\"秒杀订单\";s:5:\"num13\";s:2:\"13\";s:7:\"thumb13\";s:38:\"http://cs.riyuanma.com/image/ptdd.png\";s:6:\"flag13\";s:1:\"1\";s:5:\"url13\";s:39:\"/sudu8_page/orderlist_dan/orderlist_dan\";s:6:\"icon13\";s:14:\"icon-x-miaosha\";}');
/*!40000 ALTER TABLE `ims_sudu8_page_usercenter_set` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_video_pay`
--

DROP TABLE IF EXISTS `ims_sudu8_page_video_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_video_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `paymoney` float NOT NULL,
  `creattime` int(11) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_video_pay`
--

LOCK TABLES `ims_sudu8_page_video_pay` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_video_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_video_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_vip_apply`
--

DROP TABLE IF EXISTS `ims_sudu8_page_vip_apply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_vip_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) NOT NULL COMMENT '申请人',
  `uniacid` int(11) unsigned NOT NULL,
  `vipid` mediumtext NOT NULL COMMENT 'vip卡号',
  `fid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '提交表单信息id',
  `formid` varchar(255) NOT NULL COMMENT '模板消息formid',
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '3' COMMENT '3未审核 1通过  2不通过',
  `applytime` datetime NOT NULL COMMENT '申请时间',
  `examinetime` datetime NOT NULL COMMENT '审核时间',
  `beizhu` mediumtext NOT NULL COMMENT '审核不通过原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_vip_apply`
--

LOCK TABLES `ims_sudu8_page_vip_apply` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_vip_apply` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_vip_apply` VALUES (1,'undefined',1,'1577112142767700',0,'the formId is a mock one',3,'2019-12-23 22:42:22','0000-00-00 00:00:00','');
/*!40000 ALTER TABLE `ims_sudu8_page_vip_apply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_vip_config`
--

DROP TABLE IF EXISTS `ims_sudu8_page_vip_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_vip_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `isopen` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员卡0不开启1开启2强制开启',
  `name` varchar(255) NOT NULL DEFAULT '会员卡' COMMENT '会员卡名称',
  `recharge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '充值0直接可用1开卡后可用',
  `coupon` tinyint(1) NOT NULL DEFAULT '0' COMMENT '领优惠券0直接可用1开卡后可用',
  `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分签到0直接可用1开卡后可用',
  `exchange` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分兑换0直接可用1开卡后可用',
  `formid` int(11) DEFAULT '0',
  `shenhe` int(1) DEFAULT '2',
  `miaosha` int(1) NOT NULL,
  `duo` int(1) NOT NULL,
  `yuyue` int(1) NOT NULL,
  `pt` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_vip_config`
--

LOCK TABLES `ims_sudu8_page_vip_config` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_vip_config` DISABLE KEYS */;
INSERT INTO `ims_sudu8_page_vip_config` VALUES (1,1,1,'会员卡',0,0,0,0,0,1,0,0,0,0);
/*!40000 ALTER TABLE `ims_sudu8_page_vip_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_page_wxapps`
--

DROP TABLE IF EXISTS `ims_sudu8_page_wxapps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_page_wxapps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `pcid` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `type_i` int(1) DEFAULT NULL,
  `appId` varchar(20) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_page_wxapps`
--

LOCK TABLES `ims_sudu8_page_wxapps` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_page_wxapps` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_page_wxapps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_base`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_base` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `tel` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `xz` text NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_base`
--

LOCK TABLES `ims_sudu8_shop_base` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_cate`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_cate`
--

LOCK TABLES `ims_sudu8_shop_cate` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_cate` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_orders`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `mid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `allprice` varchar(255) NOT NULL,
  `creattime` int(11) NOT NULL,
  `val` text NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_orders`
--

LOCK TABLES `ims_sudu8_shop_orders` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_products`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `desc` varchar(255) NOT NULL,
  `product_txt` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `w_kc` int(11) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_products`
--

LOCK TABLES `ims_sudu8_shop_products` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_shops`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `ewm` varchar(255) NOT NULL,
  `products` varchar(255) NOT NULL,
  `products_kc` text NOT NULL,
  `creattime` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_shops`
--

LOCK TABLES `ims_sudu8_shop_shops` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_shops` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_shop_user`
--

DROP TABLE IF EXISTS `ims_sudu8_shop_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_shop_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned DEFAULT NULL COMMENT '小程序ID',
  `openid` varchar(255) NOT NULL COMMENT '用户的唯一身份ID',
  `createtime` int(11) unsigned NOT NULL COMMENT '加入时间',
  `realname` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `icon` varchar(255) DEFAULT NULL COMMENT 'PC版头像',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ号',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `gender` tinyint(1) DEFAULT '0' COMMENT '性别(0:保密 1:男 2:女)',
  `telephone` varchar(15) DEFAULT '' COMMENT '固定电话',
  `idcardtype` tinyint(1) DEFAULT '1' COMMENT '证件类型：身份证 护照 军官证等',
  `idcard` varchar(255) DEFAULT NULL COMMENT '证件号码',
  `address` varchar(255) DEFAULT '' COMMENT '邮寄地址',
  `zipcode` varchar(255) DEFAULT NULL COMMENT '邮编',
  `nationality` varchar(30) DEFAULT '' COMMENT '国籍',
  `resideprovince` varchar(30) DEFAULT '' COMMENT '居住省份',
  `residecity` varchar(30) DEFAULT '' COMMENT '居住城市',
  `residedist` varchar(30) DEFAULT '' COMMENT '居住行政区/县',
  `residecommunity` varchar(30) DEFAULT '' COMMENT '居住小区',
  `residesuite` varchar(30) DEFAULT '' COMMENT '小区、写字楼门牌号',
  `graduateschool` varchar(50) DEFAULT '' COMMENT '毕业学校',
  `company` varchar(50) DEFAULT '' COMMENT '公司',
  `education` varchar(10) DEFAULT '' COMMENT '学历',
  `occupation` varchar(30) DEFAULT '' COMMENT '职业',
  `position` varchar(30) DEFAULT '' COMMENT '职位',
  `revenue` varchar(10) DEFAULT '' COMMENT '年收入',
  `affectivestatus` varchar(30) DEFAULT '' COMMENT '情感状态',
  `lookingfor` varchar(255) DEFAULT '' COMMENT ' 交友目的',
  `bloodtype` varchar(5) DEFAULT '' COMMENT '血型',
  `height` varchar(5) DEFAULT '' COMMENT '身高',
  `weight` varchar(5) DEFAULT '' COMMENT '体重',
  `alipay` varchar(30) DEFAULT '' COMMENT '支付宝帐号',
  `msn` varchar(30) DEFAULT '' COMMENT 'MSN',
  `taobao` varchar(30) DEFAULT '' COMMENT '阿里旺旺',
  `site` varchar(30) DEFAULT '' COMMENT '主页',
  `bio` text COMMENT '自我介绍',
  `interest` text COMMENT '兴趣爱好',
  `money` varchar(255) NOT NULL DEFAULT '0',
  `score` varchar(255) NOT NULL DEFAULT '0',
  `flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_shop_user`
--

LOCK TABLES `ims_sudu8_shop_user` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_shop_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_shop_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ims_sudu8_webpage_base`
--

DROP TABLE IF EXISTS `ims_sudu8_webpage_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ims_sudu8_webpage_base` (
  `uniacid` int(10) NOT NULL DEFAULT '0',
  `url` varchar(800) DEFAULT NULL,
  `c_t` varchar(10) DEFAULT '#ffffff',
  `c_bg` varchar(10) DEFAULT '#E64340',
  `title` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uniacid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ims_sudu8_webpage_base`
--

LOCK TABLES `ims_sudu8_webpage_base` WRITE;
/*!40000 ALTER TABLE `ims_sudu8_webpage_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `ims_sudu8_webpage_base` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` int(10) NOT NULL COMMENT '操作人ID',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `text` varchar(255) NOT NULL COMMENT '操作内容',
  `action` varchar(50) NOT NULL DEFAULT '' COMMENT '操作',
  `level` int(1) NOT NULL DEFAULT '0' COMMENT '0 ordinary 1 commonly 2 important ',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '操作类型  0 操作记录  1  充值记录',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (1,1,1575435783,'九牛网科技管理员在2019-12-04 13:03:03, 开通了名称为九牛网官网的小程序,时间到2019.12.04, 类型为微信小程序.','',0,0),(2,1,1575435909,'九牛网科技管理员在2019-12-04 13:05:09, 对名称为九牛网官网的小程序进行了续费,时间到2019.12.03, 类型为微信小程序.','',0,0),(3,1,1575436255,'九牛网科技管理员在2019-12-04 13:10:55, 对名称为九牛网官网的小程序进行了续费,时间到2019.12.03, 类型为微信小程序.','',0,0),(4,1,1575436263,'九牛网科技管理员在2019-12-04 13:11:03, 对名称为九牛网官网的小程序进行了续费,时间到2019.12.04, 类型为微信小程序.','',0,0),(5,1,1575436359,'九牛网科技管理员在2019-12-04 13:12:39, 对名称为九牛网官网的小程序进行了续费,时间到2022.12.04, 类型为微信小程序.','',0,0),(6,1,1575436666,'九牛网科技管理员在2019-12-04 13:17:46, 为张立超代理商充值了2000元','',0,1),(7,3,1575509253,'张立超代理商在2019-12-05 09:27:33, 开通了名称为王磊的小程序的小程序,时间为30个月, 类型为微信小程序,总价为2400.00元.','',0,0),(8,1,1575625114,'九牛网科技管理员在2019-12-06 17:38:34, 为张立超代理商充值了2000元','',0,1),(9,1,1575625126,'九牛网科技管理员在2019-12-06 17:38:46, 为张立超代理商充值了400元','',0,1),(10,3,1575625193,'张立超代理商在2019-12-06 17:39:53, 开通了名称为全功能小程序的小程序,试用7天, 类型为微信小程序,总价为0元.','',0,0);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_url`
--

DROP TABLE IF EXISTS `products_url`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `randid` varchar(255) DEFAULT NULL,
  `appletid` int(11) DEFAULT NULL,
  `typeid` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_url`
--

LOCK TABLES `products_url` WRITE;
/*!40000 ALTER TABLE `products_url` DISABLE KEYS */;
INSERT INTO `products_url` VALUES (1,'2019114213044224',1,NULL,'/upimages/20191204/afed01c313336802918e0fc115343f03993.jpg',1575466356),(2,'2019117123213859',1,NULL,'/upimages/20191204/2e2990eb8dead8200910ca7b08355210642.jpg',1575693220);
/*!40000 ALTER TABLE `products_url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rule`
--

DROP TABLE IF EXISTS `rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '权限名称',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '上级分类',
  `sort` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rule`
--

LOCK TABLES `rule` WRITE;
/*!40000 ALTER TABLE `rule` DISABLE KEYS */;
INSERT INTO `rule` VALUES (1,'总览',0,100,1534149868,0),(2,'数据预览',1,100,1534150053,0),(3,'内容',0,100,1534150053,0),(4,'栏目管理',3,100,1534150186,0),(5,'预约预定商品',3,100,1534150186,0),(6,'秒杀商品',3,100,1534150244,0),(7,'文章管理',3,100,1534150264,0),(8,'多规格商品',3,100,1534150264,0),(9,'组图管理',3,100,1534150264,0),(10,'小程序管理',3,100,1534150333,0),(11,'评论管理',3,100,1534150333,0),(12,'文章底部菜单',3,100,1534150373,0),(13,'菜单组',12,100,1534150392,0),(14,'菜单',12,100,1534150405,0),(15,'多栏目',3,100,1534150405,0),(17,'管理',15,100,1534150405,0),(18,'筛选条件',15,100,1534150405,0),(19,'订单',0,100,1534150405,0),(20,'限时秒杀订单',19,100,1534150523,0),(21,'预约预定订单',19,100,1534150523,0),(22,'付费视频订单',19,100,1534150523,0),(23,'多规格订单',19,100,1534150577,0),(24,'会员',0,100,1534150577,0),(25,'会员管理',24,100,1534150577,0),(26,'消费流水',24,100,1534150577,0),(27,'全部',26,100,1534150679,0),(28,'获取记录',26,100,1534150702,0),(29,'消费记录',26,100,1534150726,0),(30,'店内支付',26,100,1534150752,0),(31,'积分流水',24,100,1534150752,0),(32,'全部',31,100,1534150752,0),(33,'充值获得',31,100,1534150752,0),(34,'消费抵扣',31,100,1534150752,0),(35,'签到获得',31,100,1534150752,0),(36,'分享获得',31,100,1534150879,0),(37,'店内抵扣',31,100,1534150879,0),(38,'开卡记录',24,100,1534150879,0),(39,'门店',0,100,1534150879,0),(40,'基础设置',39,100,1534150879,0),(41,'列表管理',39,100,1534150879,0),(42,'营销',0,100,1534151249,0),(43,'优惠劵',42,100,1534151249,0),(45,'管理',43,100,1534151249,0),(46,'设置',43,100,1534151301,0),(47,'领取记录',43,100,1534151301,0),(48,'核销密码',42,100,1534151301,0),(49,'充值管理',42,100,1534151301,0),(50,'充值管理',49,100,1534151301,0),(51,'充值规则',49,100,1534151301,0),(52,'分享积分',42,100,1534151301,0),(53,'积分流水',42,100,1534151301,0),(54,'多规格商品设置',42,100,1534151301,0),(55,'会员卡设置',42,100,1534151484,0),(56,'表单',42,100,1534151504,0),(57,'万能预约信息列表',56,100,1534151504,0),(58,'万能表单列表',56,100,1534151612,0),(59,'系统预约信息列表',56,100,1534151639,0),(60,'系统预约配置',56,100,1534151639,0),(61,'提醒接收人',56,100,1534151681,0),(62,'分销',0,100,1534151708,0),(63,'分销设置',62,100,1534151708,0),(64,'基本设置',63,100,1534151708,0),(65,'上下级关系及分销资格',63,100,1534151801,0),(66,'分销商申请协议',63,100,1534151832,0),(67,'分销推广',63,100,1534151859,0),(68,'分销商管理',62,100,1534151889,0),(69,'分销订单',62,100,1534151899,0),(70,'分销提现管理',62,100,1534151925,0),(71,'提现申请',70,100,1534151953,0),(72,'提现设置',70,100,1534151989,0),(73,'DIY',0,100,1534152032,0),(74,'DIY设置',73,100,1534152074,0),(75,'默认首页',73,100,1534152097,0),(76,'样式DIY',75,100,1534152113,0),(77,'幻灯片设置',75,100,1534152129,0),(78,'开屏广告',75,100,1534152155,0),(79,'弹窗广告',75,100,1534152175,0),(80,'首页广告',75,100,1534152189,0),(81,'导航设置',75,100,1534152204,0),(82,'自定义导航',75,100,1534152220,0),(83,'一键模板',75,100,1534152238,0),(84,'DIY布局',73,100,1534152238,0),(85,'系统',0,100,1534152286,0),(86,'基础设置',85,100,1534152299,0),(87,'公司介绍',85,100,1534152313,0),(88,'个人中心',85,100,1534152327,0),(89,'底部菜单',85,100,1534152347,0),(90,'新版菜单',89,100,1534152370,0),(91,'老板菜单',89,100,1534152389,0),(92,'版权管理',85,100,1534152410,0),(93,'版权内容',85,100,1534152435,0),(94,'邮箱配置',85,100,1534152457,0),(95,'模板消息',85,100,1534152457,0),(96,'支付通知',95,100,1534152503,0),(97,'系统表单通知',95,100,1534152520,0),(98,'预约通知',95,100,1534152536,0),(99,'多规格订单通知',95,100,1534152536,0),(100,'拼团订单通知',95,100,1534152587,0),(101,'会员卡开通通知',95,100,1534152609,0),(102,'远程附件',85,100,1534152628,0),(103,'上传审核',85,100,1534152650,0),(104,'模块',0,100,1534152665,0),(105,'应用中心',104,100,1534152685,0),(106,'拼团',104,100,1534152685,0),(107,'拼团设置',106,100,1534152721,0),(108,'栏目设置',106,100,1534152738,0),(109,'商品管理',106,100,1534152756,0),(110,'订单管理',106,100,1534152772,0),(111,'成团管理',106,100,1534152787,0),(112,'退款管理',106,100,1534152802,0),(113,'餐饮',104,100,1534152833,0),(114,'基础设置',113,100,1534152855,0),(115,'分类管理',113,100,1534152871,0),(116,'桌号管理',113,100,1534152890,0),(117,'商品管理',113,100,1534152908,0),(118,'订单管理',113,100,1534152922,0),(119,'打印机设置',113,100,1534152937,0),(120,'点餐通知',113,100,1534152952,0),(121,'积分兑换',104,100,1534152985,0),(122,'栏目管理',121,100,1534153003,0),(123,'商品管理',121,100,1534153017,0),(124,'订单管理',121,100,1534153032,0),(125,'积分兑换通知',121,100,1534153049,0),(126,'积分签到',104,100,1534153074,0),(127,'基础设置',126,100,1534153092,0),(128,'签到管理',126,100,1534153108,0),(129,'手机客服',104,100,1534153140,0),(130,'万能门店',104,100,1534153154,0),(131,'分类管理',130,100,1534153171,0),(132,'店铺管理',130,100,1534153186,0),(133,'商品管理',130,100,1534153200,0),(134,'订单管理',130,100,1534153213,0),(135,'提现管理',130,100,1534153236,0),(136,'系统设置',130,100,1534153250,0),(137,'帮助',0,100,1534153264,0),(138,'满额立减',42,100,1534325951,0),(139,'微同城',104,100,1534325951,0),(140,'分类管理',139,100,1534325951,0),(141,'发布管理',139,100,1534325951,0),(142,'评论管理',139,100,1534325951,0),(143,'相关设置',139,100,1534325951,0),(144,'微同城流水',25,100,1534325951,0),(145,'摇一摇抽奖万能门店',104,100,1535965758,0),(146,'活动管理',145,100,1535965827,0),(147,'积分规则',42,100,1536385921,0),(148,'申请记录',24,100,1535965758,0),(149,'员工管理',39,100,1537950600,0);
/*!40000 ALTER TABLE `rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_combo`
--

DROP TABLE IF EXISTS `time_combo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_combo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '套时长餐名称',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '套餐时间',
  `free_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠送时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `qita` varchar(255) NOT NULL DEFAULT '' COMMENT '其他',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '套餐类型: 0 试用  1 正式使用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_combo`
--

LOCK TABLES `time_combo` WRITE;
/*!40000 ALTER TABLE `time_combo` DISABLE KEYS */;
INSERT INTO `time_combo` VALUES (2,'一年期',12,1,0,'',1575436056,1),(3,'两年期',24,6,0,'',1575436095,1),(4,'三年期',36,12,0,'',1575436123,1);
/*!40000 ALTER TABLE `time_combo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-27 19:44:35
