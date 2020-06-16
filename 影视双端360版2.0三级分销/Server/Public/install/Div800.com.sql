-- MySQL dump 10.13  Distrib 5.6.44, for Linux (x86_64)
--
-- Host: localhost    Database: h5app_360
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
-- Table structure for table `bc_admin`
--

DROP TABLE IF EXISTS `bc_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_admin` (
  `id` int(111) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_admin`
--

LOCK TABLES `bc_admin` WRITE;
/*!40000 ALTER TABLE `bc_admin` DISABLE KEYS */;
INSERT INTO `bc_admin` VALUES (1,'admin','291dc77c4b3173d21dfaa24afd65f4bb');
/*!40000 ALTER TABLE `bc_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_adver`
--

DROP TABLE IF EXISTS `bc_adver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_adver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `picname` text,
  `link` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_adver`
--

LOCK TABLES `bc_adver` WRITE;
/*!40000 ALTER TABLE `bc_adver` DISABLE KEYS */;
INSERT INTO `bc_adver` VALUES (1,'大厅轮播1','http://baidu.com/Public/uploads/5d2857aed670b.jpg','http://tb.winds.fun',1,2),(2,'首页轮播图1','http://baidu.com/Public/uploads/5d2857aed670b.jpg','http://tb.winds.fun',1,1),(3,'风行视频','http://baidu.com/Public/uploads/858dfc56c4988f5e7b27881826bc0897_5c67a477f40a1.jpg','http://m.fun.tv/',7,3),(4,'爱奇艺','http://baidu.com/Public/uploads/5c5006cb695e7.jpg','http://m.iqiyi.com/vip',1,3),(5,'腾讯视频','http://baidu.com/Public/uploads/5c5006f3dfc6f.png','http://m.v.qq.com/tv.html',2,3),(6,'优酷视频','http://baidu.com/Public/uploads/5c50070a53d14.jpg','https://youku.com',3,3),(7,'搜狐视频','http://baidu.com/Public/uploads/5c50072699eb9.jpg','https://m.tv.sohu.com',4,3),(8,'PPTV','http://baidu.com/Public/uploads/680cd6e28a3480e6ba320ce917ee221b_5c67a40c97f15.jpg','http://m.pptv.com',5,3),(9,'乐视视频','http://baidu.com/Public/uploads/491f51153d49cf033230f7bad9377d84_5c67a46673a12.jpg','http://m.le.com',6,3),(10,'暴风影音','http://baidu.com/Public/uploads/a47cdd93ff62044c4d456bfe98a6c917_5c67a442d6dcc.jpg','http://m.baofeng.com/',8,3),(11,'成龙电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547465140655&di=47dd5d15270f304bd662d54052189c93&imgtype=0&src=http%3A%2F%2F5b0988e595225.cdn.sohucs.com%2Fq_70%2Cc_zoom%2Cw_640%2Fimages%2F20180715%2F119d12719e29431faf738c618f0331c7.jpeg','http://tx.hls.huya.com/huyalive/94525224-2460685722-10568564701724147712-2789253838-10057-A-0-1.m3u8',1,5),(12,'徐峥电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547465278085&di=92812069a299b3617c6ff4b41f699905&imgtype=0&src=http%3A%2F%2Fn.sinaimg.cn%2Fent%2Ftransform%2F299%2Fw440h659%2F20181118%2FQKbn-hnyuqhh6759461.jpg','http://tx.hls.huya.com/huyalive/30765679-2689675828-11552069718101721088-3048991626-10057-A-0-1.m3u8',2,5),(13,'周星驰电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547465694162&di=9262d8a9b5f9f3fd3af8175be0294e27&imgtype=0&src=http%3A%2F%2Fs11.sinaimg.cn%2Fmiddle%2F4a78a895x7633f6291e8a%26690','http://tx.hls.huya.com/huyalive/94525224-2460685313-10568562945082523648-2789274524-10057-A-0-1.m3u8',3,5),(14,'刘德华电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548060512&di=8234ebc34eefd335333a6ea4ca249702&imgtype=jpg&er=1&src=http%3A%2F%2Fi3.sinaimg.cn%2Fent%2Fm%2Fp%2F2012-09-26%2FU4611P28T3D3753520F234DT20120926233515.jpg','http://tx.hls.huya.com/huyalive/94525224-2467341872-10597152648291418112-2789274550-10057-A-0-1.m3u8',4,5),(15,'林正英电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547466053622&di=8411d92026d485bf74c0b1842eea2d77&imgtype=0&src=http%3A%2F%2Fimg.alicdn.com%2Fimgextra%2Fi3%2FTB1IelnPXXXXXXOXpXXXXXXXXXX_%2521%25210-item_pic.jpg_310x310.jpg','http://tx.hls.huya.com/huyalive/94525224-2460686034-10568566041753944064-2789274542-10057-A-0-1.m3u8',5,5),(16,'甄子丹电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547466146990&di=79df0141f8c266198ac4ef7db77703ae&imgtype=0&src=http%3A%2F%2Fimages.rednet.cn%2Farticleimage%2F2013%2F10%2F02%2F13428230.jpg','http://tx.hls.huya.com/huyalive/29169025-2686219938-11537226783573147648-2847699096-10057-A-1524024759-1.m3u8',6,5),(17,'王晶电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547466679969&di=01ade59f6ca287921efa575b14e9a5d0&imgtype=0&src=http%3A%2F%2Fimg01.9yaocn.com%2F2016-06%2F25%2F576d6535%2F576d6535f10d22040e4d2d51%2F1466801442942_696933.jpg','http://tx.hls.huya.com/huyalive/94525224-2579683592-11079656661667807232-2847687574-10057-A-0-1.m3u8',7,5),(18,'漫威电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547467032663&di=44677446bc97ceb2c21bafe17011a102&imgtype=0&src=http%3A%2F%2Fimg.zcool.cn%2Fcommunity%2F0152ff5a17ff46a80120908d3f4ba9.jpg%402o.jpg','http://tx.hls.huya.com/huyalive/30765679-2504742278-10757786168918540288-3049003128-10057-A-0-1.m3u8',8,5),(19,'犯罪战争电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547467245093&di=cfddfb6dbb3da95e0245ee0784dc20df&imgtype=0&src=http%3A%2F%2F5b0988e595225.cdn.sohucs.com%2Fimages%2F20170907%2F1de8a46b744e44db8c82fdee6a074c90.jpeg','http://tx.hls.huya.com/huyalive/30765679-2480288304-10652757150331305984-2789274538-10057-A-1511757260-1.m3u8',9,5),(20,'惊悚电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547467605029&di=0080821b90ca5ec120b63a0dbb06c207&imgtype=0&src=http%3A%2F%2Fpic14.photophoto.cn%2F20100227%2F0036036353466568_b.jpg','http://tx.hls.huya.com/huyalive/29106097-2689447600-11551089486305689600-2789274568-10057-A-1525420695-1.m3u8',10,5),(21,'真实改编电影直播','https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1547467564757&di=4ff88b97abb3cdb3ddc0dc8e9c838c0f&imgtype=0&src=http%3A%2F%2F5b0988e595225.cdn.sohucs.com%2Fimages%2F20181202%2Fd5d8c2afc91c41deaee3c5e84b0885ae.jpeg','http://tx.hls.huya.com/huyalive/30765679-2554414680-10971127511022305280-3048991634-10057-A-0-1.m3u8',11,5),(22,'默认启动图','http://baidu.com/Public/uploads/5d8b419d6881f.png','http://tb.winds.fun',1,4);
/*!40000 ALTER TABLE `bc_adver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_config`
--

DROP TABLE IF EXISTS `bc_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `webname` varchar(255) DEFAULT NULL,
  `jiekou1` varchar(200) DEFAULT NULL,
  `jiekou2` varchar(200) DEFAULT NULL,
  `jiekou3` varchar(200) DEFAULT NULL,
  `jiekou4` varchar(200) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `qun` varchar(200) DEFAULT NULL,
  `yi` int(11) DEFAULT NULL,
  `er` int(11) DEFAULT NULL,
  `san` int(11) DEFAULT NULL,
  `payh` varchar(200) DEFAULT NULL,
  `payk` varchar(200) DEFAULT NULL,
  `payt` varchar(200) DEFAULT NULL,
  `payu` varchar(200) DEFAULT NULL,
  `tixian` int(11) DEFAULT NULL,
  `xiazai` varchar(255) DEFAULT NULL,
  `jifen` int(11) DEFAULT NULL,
  `dailiqi` varchar(200) DEFAULT NULL,
  `dailiyi` varchar(222) DEFAULT NULL,
  `dailisan` varchar(222) DEFAULT NULL,
  `daililiu` varchar(222) DEFAULT NULL,
  `dailinian` varchar(222) DEFAULT NULL,
  `dailiyongjiu` varchar(222) DEFAULT NULL,
  `jiexi1` varchar(222) DEFAULT NULL,
  `jiexi2` varchar(222) DEFAULT NULL,
  `jiexi3` varchar(222) DEFAULT NULL,
  `jiexi4` varchar(222) DEFAULT NULL,
  `jiexi5` varchar(222) DEFAULT NULL,
  `jiexi6` varchar(222) DEFAULT NULL,
  `jiexi7` varchar(222) DEFAULT NULL,
  `jiexi8` varchar(222) DEFAULT NULL,
  `jiexi9` varchar(222) DEFAULT NULL,
  `kefu` varchar(222) DEFAULT NULL,
  `gonggao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_config`
--

LOCK TABLES `bc_config` WRITE;
/*!40000 ALTER TABLE `bc_config` DISABLE KEYS */;
INSERT INTO `bc_config` VALUES (1,'欢迎访问蝶影VIP','聚影VIP','http://api.hclyz.com:81/mf/json.txt','http://api.hclyz.com:81/mf/','http://api.zbjk.xyz:81/kuke/json.txt','http://api.zbjk.xyz:81/kuke/',200,'http://shang.qq.com/wpa/qunwpa?idkey=5d8c02a38055a27e1045d11896099402721c0381c35fd5e7b46be4f808ff8fee',30,20,10,'1089','pjEsK44BKp3pWTB6tBTt4T5dtso434OT','http','https://pay.xiaobaibk.cn/',12,'https://div800.com/forum-2-1.html',1,'1','2','3','4','5','1','http://jx.wslmf.com/?url=','http://api.nw3w.cn/youyi/?url=','','','','','','','','QQ2327299920','代理公告：代理公告：代理公告：代理公告：代理公告：代理公告：代理公告：');
/*!40000 ALTER TABLE `bc_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_fanxian`
--

DROP TABLE IF EXISTS `bc_fanxian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_fanxian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `shijian` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_fanxian`
--

LOCK TABLES `bc_fanxian` WRITE;
/*!40000 ALTER TABLE `bc_fanxian` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_fanxian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_jiage`
--

DROP TABLE IF EXISTS `bc_jiage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_jiage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` varchar(11) DEFAULT NULL,
  `month` varchar(11) DEFAULT NULL,
  `quarter` varchar(11) DEFAULT NULL,
  `half` varchar(11) DEFAULT NULL,
  `year` varchar(11) DEFAULT NULL,
  `daili` varchar(11) DEFAULT NULL,
  `yongjiu` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_jiage`
--

LOCK TABLES `bc_jiage` WRITE;
/*!40000 ALTER TABLE `bc_jiage` DISABLE KEYS */;
INSERT INTO `bc_jiage` VALUES (1,'0.1','10','20','30','40','0.1','60');
/*!40000 ALTER TABLE `bc_jiage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_jilu`
--

DROP TABLE IF EXISTS `bc_jilu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_jilu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `addtime` varchar(222) DEFAULT NULL,
  `shijian` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_jilu`
--

LOCK TABLES `bc_jilu` WRITE;
/*!40000 ALTER TABLE `bc_jilu` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_jilu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_kami`
--

DROP TABLE IF EXISTS `bc_kami`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_kami` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dianka` varchar(255) NOT NULL,
  `uid` int(11) DEFAULT '1',
  `ctime` int(11) DEFAULT '1528330296',
  `y` int(1) DEFAULT '0',
  `cha` int(11) DEFAULT NULL,
  `yid` int(1) DEFAULT '0',
  `time` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT '0',
  `name` varchar(255) DEFAULT '一年',
  `stime` int(11) DEFAULT NULL,
  `sbh` varchar(200) DEFAULT NULL,
  `syr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dianka` (`dianka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_kami`
--

LOCK TABLES `bc_kami` WRITE;
/*!40000 ALTER TABLE `bc_kami` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_kami` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_mess`
--

DROP TABLE IF EXISTS `bc_mess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_mess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `shijian` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_mess`
--

LOCK TABLES `bc_mess` WRITE;
/*!40000 ALTER TABLE `bc_mess` DISABLE KEYS */;
INSERT INTO `bc_mess` VALUES (1,'系统消息:VIP开通成功！','1565011312','2019-08-05 21:21:52 ',17),(2,'系统消息:代理开通成功！','1565011459','2019-08-05 21:24:19 ',17);
/*!40000 ALTER TABLE `bc_mess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_news`
--

DROP TABLE IF EXISTS `bc_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `con` text,
  `addtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_news`
--

LOCK TABLES `bc_news` WRITE;
/*!40000 ALTER TABLE `bc_news` DISABLE KEYS */;
INSERT INTO `bc_news` VALUES (1,'1、视频缓冲较慢','视频主线路是电视 所以移动联通的用户可能会缓冲较慢，请耐心等待！或者切换wifi观看 感谢您的支持','1569408913'),(2,'2、APP充值金币提示商户风险','本APP对接第三方支付 提示商户风险属于接口风险 属于正常情况.支付成功金币自动到账 请放心支付！','1569408913'),(4,'3、金币没有到账','用户充值金币没有到账 请提交充值的支付成功记录 截图 在意见反馈提交','1569408913');
/*!40000 ALTER TABLE `bc_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_notice`
--

DROP TABLE IF EXISTS `bc_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `neirong` varchar(255) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_notice`
--

LOCK TABLES `bc_notice` WRITE;
/*!40000 ALTER TABLE `bc_notice` DISABLE KEYS */;
INSERT INTO `bc_notice` VALUES (1,'欢迎使用盒子云影视系统','1569408635');
/*!40000 ALTER TABLE `bc_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_pay`
--

DROP TABLE IF EXISTS `bc_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_pay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outtrade` varchar(200) NOT NULL,
  `trade` varchar(200) NOT NULL,
  `type` char(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `money` decimal(11,2) NOT NULL,
  `trade_status` varchar(100) NOT NULL,
  `cid` int(11) NOT NULL,
  `time` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_pay`
--

LOCK TABLES `bc_pay` WRITE;
/*!40000 ALTER TABLE `bc_pay` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_tan`
--

DROP TABLE IF EXISTS `bc_tan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_tan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `nei` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `kai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_tan`
--

LOCK TABLES `bc_tan` WRITE;
/*!40000 ALTER TABLE `bc_tan` DISABLE KEYS */;
INSERT INTO `bc_tan` VALUES (1,'蝶影VIP提醒您','邀请还有免费获得会员哦！','http://baidu.com/App/Login/news.html',1);
/*!40000 ALTER TABLE `bc_tan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_tixian`
--

DROP TABLE IF EXISTS `bc_tixian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `beizhu` varchar(255) DEFAULT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `zhifubao` varchar(255) DEFAULT NULL,
  `shijian` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_tixian`
--

LOCK TABLES `bc_tixian` WRITE;
/*!40000 ALTER TABLE `bc_tixian` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_tixian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_type`
--

DROP TABLE IF EXISTS `bc_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `picname` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_type`
--

LOCK TABLES `bc_type` WRITE;
/*!40000 ALTER TABLE `bc_type` DISABLE KEYS */;
INSERT INTO `bc_type` VALUES (1,'战争','http://baidu.com/Public/uploads/5d28455a8a78b.png',NULL),(2,'爱情','http://baidu.com/Public/uploads/5d2844e7310ee.png',NULL),(3,'动作','http://baidu.com/Public/uploads/5d28453b5a926.png',NULL),(4,'剧情','http://baidu.com/Public/uploads/5d28456b73410.png',NULL),(5,'喜剧','http://baidu.com/Public/uploads/5d284585e452c.png',NULL),(6,'恐怖','http://baidu.com/Public/uploads/5d284597d683b.png',NULL),(7,'动漫','http://baidu.com/Public/uploads/5d2845b5cb7ae.png',NULL),(8,'恐怖','http://baidu.com/Public/uploads/5d2845c85757a.png',NULL);
/*!40000 ALTER TABLE `bc_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_user`
--

DROP TABLE IF EXISTS `bc_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `count` int(11) DEFAULT '0',
  `viptime` varchar(255) DEFAULT NULL,
  `money` double(8,2) DEFAULT '0.00',
  `num` int(11) DEFAULT '0',
  `logintime` varchar(255) DEFAULT NULL,
  `share` varchar(255) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `zhifubao` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mim` varchar(200) DEFAULT NULL,
  `uuid` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `jifen` varchar(11) DEFAULT '0',
  `qdtime` varchar(222) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_user`
--

LOCK TABLES `bc_user` WRITE;
/*!40000 ALTER TABLE `bc_user` DISABLE KEYS */;
INSERT INTO `bc_user` VALUES (1,'58833937','b0802181955a5408bf614eddcd0e99f7',1,'1569423803',0.00,0,'1569411803','907319','1569411803',0,NULL,NULL,'Ce736V`[','724163595945635',1,'0',NULL),(2,'58838796','837ea7e8a25c5638c12c3316edd488f3',1,'1569424382',0.00,0,'1569412382','396100','1569412382',0,NULL,NULL,'hl540LOP','861997045128373',1,'0',NULL);
/*!40000 ALTER TABLE `bc_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_user_rel`
--

DROP TABLE IF EXISTS `bc_user_rel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_user_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lv` varchar(222) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT '0',
  `addtime` varchar(255) DEFAULT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `shijian` varchar(222) DEFAULT NULL,
  `pname` varchar(222) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_user_rel`
--

LOCK TABLES `bc_user_rel` WRITE;
/*!40000 ALTER TABLE `bc_user_rel` DISABLE KEYS */;
/*!40000 ALTER TABLE `bc_user_rel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bc_video`
--

DROP TABLE IF EXISTS `bc_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bc_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `addtime` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT '0',
  `shijian` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bc_video`
--

LOCK TABLES `bc_video` WRITE;
/*!40000 ALTER TABLE `bc_video` DISABLE KEYS */;
INSERT INTO `bc_video` VALUES (1,'大鱼海棠','https://img.zcool.cn/community/011316578db59e0000018c1bda25ee.jpg@2o.jpg','https://youku.cdn-163.com/20180513/7357_e5cc4939/index.m3u8','1569412361',0,'2019-09-25 ');
/*!40000 ALTER TABLE `bc_video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-25 19:53:37
