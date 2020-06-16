-- MySQL dump 10.13  Distrib 5.6.44, for Linux (x86_64)
--
-- Host: localhost    Database: 435184519
-- ------------------------------------------------------
-- Server version	5.6.44

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
-- Table structure for table `auth_block`
--

DROP TABLE IF EXISTS `auth_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_block` (
  `url` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `db` varchar(255) NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_block`
--

LOCK TABLES `auth_block` WRITE;
/*!40000 ALTER TABLE `auth_block` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_config`
--

DROP TABLE IF EXISTS `auth_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_config` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `switch` int(1) NOT NULL DEFAULT '1',
  `update` int(1) NOT NULL DEFAULT '1',
  `shms` varchar(50) NOT NULL,
  `shid` varchar(50) NOT NULL,
  `zfjk` varchar(50) NOT NULL,
  `sqjg` varchar(50) NOT NULL,
  `peie` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_config`
--

LOCK TABLES `auth_config` WRITE;
/*!40000 ALTER TABLE `auth_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_kms`
--

DROP TABLE IF EXISTS `auth_kms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_kms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `km` varchar(255) NOT NULL,
  `zt` varchar(255) NOT NULL,
  `addid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_kms`
--

LOCK TABLES `auth_kms` WRITE;
/*!40000 ALTER TABLE `auth_kms` DISABLE KEYS */;
INSERT INTO `auth_kms` VALUES (1,'zreq75nyjxTipT5O','0','1'),(2,'Kzs1AElx0qofrADi','0','1'),(3,'hPwTcZukoV4aHjKX','0','1'),(4,'tDX9uAYJ67C5Ghic','0','1'),(5,'Cu5re15rXe7HxhNO','1','1'),(6,'TcID6I5SQCw4dGPo','1','1'),(7,'71P2jucDP1OBzJJ5','1','1');
/*!40000 ALTER TABLE `auth_kms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_log`
--

DROP TABLE IF EXISTS `auth_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(111) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_log`
--

LOCK TABLES `auth_log` WRITE;
/*!40000 ALTER TABLE `auth_log` DISABLE KEYS */;
INSERT INTO `auth_log` VALUES (1,59079633,'生成卡密','2019-05-18 15:41:58','12345654','卡密zreq75nyjxTipT5O|数量3'),(2,59079633,'生成卡密','2019-05-18 15:41:58','12345654','卡密Kzs1AElx0qofrADi|数量3'),(3,59079633,'生成卡密','2019-05-18 15:41:58','12345654','卡密hPwTcZukoV4aHjKX|数量3'),(4,59079633,'查看日志','2019-05-18 15:45:35','12345654','无'),(5,59079633,'查看日志','2019-05-18 15:45:45','12345654','无'),(6,59079633,'查看日志','2019-05-19 03:53:03','12345654','无'),(7,59079633,'查看日志','2019-05-19 03:53:29','12345654','无'),(8,59079633,'生成卡密','2019-06-01 22:48:22','12345654','卡密tDX9uAYJ67C5Ghic|数量1'),(9,59079633,'生成卡密','2019-06-15 02:38:30','12345654','卡密Cu5re15rXe7HxhNO|数量3'),(10,59079633,'生成卡密','2019-06-15 02:38:30','12345654','卡密TcID6I5SQCw4dGPo|数量3'),(11,59079633,'生成卡密','2019-06-15 02:38:30','12345654','卡密71P2jucDP1OBzJJ5|数量3'),(12,435184519,'删除站点','2019-06-22 14:21:22','12345654','12346|64626|62a288fdf33ccf8957c7b4bc0f7ceee2|10'),(13,435184519,'删除站点','2019-06-22 14:21:26','12345654','223646|232323|1983d4914cb624033436dff7d60e8990|10'),(14,435184519,'删除站点','2019-06-22 14:21:30','12345654','2233|2233|d6d05114b70ec33cb362729812f68ac5|10'),(15,435184519,'删除站点','2019-06-22 14:21:34','12345654','12345678|12345678|758cc9e8a8e6e2bd8a5e8cd9c28a32df|10'),(16,435184519,'删除站点','2019-06-22 14:21:38','12345654','12345|12345|4dc6f698c7f2528873a32dfd739b15ad|10'),(17,435184519,'删除站点','2019-06-22 14:21:41','12345654','123456|123|a1d011e9f4d7c44f26af1bf1ab559166|10'),(18,435184519,'删除站点','2019-06-22 14:24:48','12345654','2394512055|oxog.cn|d25e29b37eae9c627dd231f43f879b36|10'),(19,435184519,'删除站点','2019-06-22 14:25:16','12345654','33299819|ds.jys0.cn|4608399175e35bd3a3cf22c904cb9254|10'),(20,435184519,'删除站点','2019-06-22 14:25:19','12345654','590796333|qwe.xiaoqwl.cn|74651cab3e8e564af608e03875024209|10'),(21,435184519,'删除站点','2019-06-22 14:25:53','12345654','59079632|dsw.xiaoqwl.cn|5ec53612e1f862d4ed8168608ba6e9e0|9'),(22,435184519,'删除站点','2019-06-22 14:25:57','12345654','59079631|ds.xiaoqwl.cn|af4c1c0c9fee579a1eb1fb6bd79996e0|8'),(23,435184519,'删除站点','2019-06-22 14:26:49','12345654','2864110865|yeqxiu.club|2018397a5dde36c09b6b9fcf67b71650|7'),(24,435184519,'删除站点','2019-06-22 14:26:53','12345654','1234567|fk.782km.com|cb08f6926e44d7ba553a4fbafadda290|6'),(25,435184519,'删除站点','2019-06-22 14:26:55','12345654','1119099749|ds.xiaoqwl.cn|aca46e2a5562f629d74e0669184fe941|5'),(26,435184519,'删除站点','2019-06-22 14:26:59','12345654','1119099479|xiaoqwl.cn|0839e7cf3b08617ae4110355e3883659|4'),(27,435184519,'删除站点','2019-06-22 14:27:02','12345654','2234025482|dsw.782km.com|a2f5005d7a96ff4d076d2fd8c0a0b6d1|3'),(28,435184519,'删除站点','2019-06-22 14:27:05','12345654','5907963|ds.782km.com|86bcb1735489c85cc14734b263004319|2'),(29,435184519,'删除站点','2019-06-22 14:27:08','12345654','59079633|782km.com|c5164e3c1340ffed4b6f8b51091ceea8|1'),(30,435184519,'删除站点','2019-06-22 14:28:02','12345654','1518559236|mo.j90k1.fun|85273dc75f3b4a003f5b17f3b0c3d2a7|10'),(31,435184519,'查看日志','2019-06-22 14:32:30','12345654','无'),(32,435184519,'删除站点','2019-06-22 14:34:51','12345654','|||'),(33,435184519,'删除站点','2019-06-22 14:35:00','12345654','|||'),(34,435184519,'删除站点','2019-06-22 14:35:01','12345654','|||'),(35,435184519,'删除站点','2019-06-22 14:35:02','12345654','|||'),(36,435184519,'删除站点','2019-06-22 14:35:03','12345654','|||'),(37,435184519,'删除站点','2019-06-22 14:35:06','12345654','|||'),(38,435184519,'删除站点','2019-06-22 14:35:06','12345654','|||'),(39,435184519,'删除站点','2019-06-22 14:35:07','12345654','|||'),(40,435184519,'删除站点','2019-06-22 14:35:07','12345654','|||'),(41,435184519,'删除站点','2019-06-22 14:35:07','12345654','|||');
/*!40000 ALTER TABLE `auth_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rz`
--

DROP TABLE IF EXISTS `auth_rz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rz` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `date` datetime NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(20) DEFAULT NULL,
  `syskey` varchar(40) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rz`
--

LOCK TABLES `auth_rz` WRITE;
/*!40000 ALTER TABLE `auth_rz` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_site`
--

DROP TABLE IF EXISTS `auth_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `addid` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(20) DEFAULT NULL,
  `syskey` varchar(40) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_site`
--

LOCK TABLES `auth_site` WRITE;
/*!40000 ALTER TABLE `auth_site` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `dlqq` varchar(150) NOT NULL,
  `peie` int(10) NOT NULL,
  `last` datetime DEFAULT NULL,
  `dlip` varchar(15) DEFAULT NULL,
  `per_sq` int(1) NOT NULL DEFAULT '0',
  `per_db` int(1) NOT NULL DEFAULT '0',
  `active` int(1) DEFAULT NULL,
  `token` text NOT NULL,
  `speie` int(11) NOT NULL DEFAULT '0' COMMENT '授权商配额',
  `super` int(1) NOT NULL DEFAULT '0',
  `addid` varchar(20) NOT NULL DEFAULT '1',
  `r_key` varchar(255) DEFAULT NULL,
  `r_log` int(11) DEFAULT NULL,
  `d_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_user`
--

LOCK TABLES `auth_user` WRITE;
/*!40000 ALTER TABLE `auth_user` DISABLE KEYS */;
INSERT INTO `auth_user` VALUES (1,'xiaoyu','123456','435184519',999999,'2019-06-22 14:41:25','117.155.5.197',1,1,1,'',997,1,'1',NULL,NULL,NULL),(4,'435184519','971878461','435184519',30,'2019-06-22 14:34:42','119.190.40.180',1,1,1,'',1,0,'1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `auth_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dl_data`
--

DROP TABLE IF EXISTS `dl_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dl_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` text NOT NULL,
  `stats` text NOT NULL,
  `json` text NOT NULL,
  `call_back` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dl_data`
--

LOCK TABLES `dl_data` WRITE;
/*!40000 ALTER TABLE `dl_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `dl_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xn_dd`
--

DROP TABLE IF EXISTS `xn_dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xn_dd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ddh` varchar(150) NOT NULL,
  `qq` varchar(150) NOT NULL,
  `ym` varchar(150) NOT NULL,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `ip` varchar(150) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `money` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xn_dd`
--

LOCK TABLES `xn_dd` WRITE;
/*!40000 ALTER TABLE `xn_dd` DISABLE KEYS */;
/*!40000 ALTER TABLE `xn_dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xn_kms`
--

DROP TABLE IF EXISTS `xn_kms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xn_kms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `km` varchar(255) NOT NULL,
  `zt` varchar(255) NOT NULL,
  `addid` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xn_kms`
--

LOCK TABLES `xn_kms` WRITE;
/*!40000 ALTER TABLE `xn_kms` DISABLE KEYS */;
/*!40000 ALTER TABLE `xn_kms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xn_user`
--

DROP TABLE IF EXISTS `xn_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xn_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yqm` varchar(150) NOT NULL,
  `qq` varchar(150) NOT NULL,
  `sq` varchar(150) NOT NULL,
  `sqs` varchar(150) NOT NULL,
  `gjsqs` varchar(150) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `zk` varchar(150) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xn_user`
--

LOCK TABLES `xn_user` WRITE;
/*!40000 ALTER TABLE `xn_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `xn_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zcd_dd`
--

DROP TABLE IF EXISTS `zcd_dd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zcd_dd` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(50) NOT NULL,
  `qq` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zcd_dd`
--

LOCK TABLES `zcd_dd` WRITE;
/*!40000 ALTER TABLE `zcd_dd` DISABLE KEYS */;
/*!40000 ALTER TABLE `zcd_dd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zcd_log`
--

DROP TABLE IF EXISTS `zcd_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zcd_log` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `adduser` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zcd_log`
--

LOCK TABLES `zcd_log` WRITE;
/*!40000 ALTER TABLE `zcd_log` DISABLE KEYS */;
INSERT INTO `zcd_log` VALUES (1,'xiaoqwl.cn','59079633','2019-05-18 15:46:08',1),(2,'ds.xiaoqwl.cn','59079633','2019-05-18 16:07:15',1),(3,'3114617770','59079633','2019-05-18 16:18:46',2),(4,'fk.782km.cn','59079633','2019-05-18 19:17:22',1),(5,'yeqxiu.club','59079633','2019-05-18 22:35:11',1),(6,'980505330','59079633','2019-05-19 03:51:00',2),(7,'ds.xiaoqwl.cn','59079633','2019-05-19 04:25:53',1),(8,'dsw.xiaoqwl.cn','59079633','2019-05-19 04:26:09',1),(9,'qwe.xiaoqwl.cn','59079633','2019-05-19 04:26:21',1),(10,'qy.52yzj.top','980505330','2019-05-19 09:45:46',1),(11,'ds.jys0.cn','59079633','2019-06-07 12:14:34',1),(12,'123','59079633','2019-06-14 19:08:29',1),(13,'12345','59079633','2019-06-14 19:08:37',1),(14,'12345678','59079633','2019-06-14 19:08:53',1),(15,'2233','59079633','2019-06-14 19:08:59',1),(16,'232323','59079633','2019-06-14 19:09:06',1),(17,'64626','59079633','2019-06-14 19:09:16',1),(18,'2458743261','435184519','2019-06-22 14:29:12',2);
/*!40000 ALTER TABLE `zcd_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zcd_mail`
--

DROP TABLE IF EXISTS `zcd_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zcd_mail` (
  `email_host` varchar(32) NOT NULL,
  `email_port` varchar(32) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `email_pass` varchar(255) NOT NULL,
  `email_active` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email_host`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zcd_mail`
--

LOCK TABLES `zcd_mail` WRITE;
/*!40000 ALTER TABLE `zcd_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `zcd_mail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-22 14:55:23
