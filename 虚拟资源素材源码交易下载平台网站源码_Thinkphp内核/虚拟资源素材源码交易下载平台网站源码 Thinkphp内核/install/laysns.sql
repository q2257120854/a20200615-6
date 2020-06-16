/*Table structure for table `ls_addons` */

DROP TABLE IF EXISTS `ls_addons`;

CREATE TABLE `ls_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='插件表';



/*Table structure for table `ls_admin_user` */

DROP TABLE IF EXISTS `ls_admin_user`;

CREATE TABLE `ls_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` varchar(20) DEFAULT '0' COMMENT '注册时间',
  `last_login_time` varchar(20) DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  `salt` varchar(20) DEFAULT NULL COMMENT 'salt',
  `security_code` varchar(10) DEFAULT NULL COMMENT '安全码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='管理员表';

/*Data for the table `ls_admin_user` */

insert  into `ls_admin_user`(`id`,`username`,`password`,`status`,`create_time`,`last_login_time`,`last_login_ip`,`salt`) values 
(1,'admin','0dfc7612f607db6c17fd99388e9e5f9c',1,'1491037613','1517316140','113.45.231.40','1dFlxLhiuLqnUZe9kA');

/*Table structure for table `ls_apply` */

DROP TABLE IF EXISTS `ls_apply`;

CREATE TABLE `ls_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addtime` varchar(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `content` text,
  `type` varchar(20) DEFAULT NULL COMMENT '类型',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `result` varchar(100) DEFAULT NULL COMMENT '结果',
  `replytime` varchar(11) DEFAULT NULL COMMENT '审核时间',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


/*Table structure for table `ls_article` */

DROP TABLE IF EXISTS `ls_article`;

CREATE TABLE `ls_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `uid` int(11) NOT NULL COMMENT '用户',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `color` varchar(10) DEFAULT '' COMMENT '颜色',
  `outlink` varchar(200) DEFAULT NULL COMMENT '外链',
  `open` tinyint(1) NOT NULL DEFAULT '-1' COMMENT '显示',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `settop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '顶置',
  `carousel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '幻灯片',
  `zan` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量/下载量',
  `collect` int(11) DEFAULT '0' COMMENT '收藏数',
  `time` int(10) NOT NULL COMMENT '时间',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键词',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `coverpic` varchar(100) DEFAULT NULL,
  `attach` tinyint(1) DEFAULT '0' COMMENT '是否有附件',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `size` int(11) DEFAULT NULL COMMENT '大小',
  `reply` int(11) DEFAULT '0' COMMENT '回复',
  `remarks` varchar(200) DEFAULT NULL COMMENT '审核备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `ls_articlecate` */

DROP TABLE IF EXISTS `ls_articlecate`;

CREATE TABLE `ls_articlecate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `sort` int(11) DEFAULT '1' COMMENT '排序',
  `template` varchar(10) DEFAULT 'article' COMMENT '模板',
  `list_template` varchar(20) DEFAULT 'articlelist' COMMENT '列表页模板',
  `icon` varchar(100) DEFAULT NULL COMMENT '图标',
  `background` varchar(8) DEFAULT '#38C34B;' COMMENT '颜色',
  `alias` varchar(20) DEFAULT NULL COMMENT '别名',
  `keywords` varchar(100) NOT NULL COMMENT '关键词',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `hometextshow` tinyint(1) DEFAULT '1' COMMENT '首页文字显示',
  `homepicshow` tinyint(1) DEFAULT NULL COMMENT '首页图片显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

insert into `ls_articlecate` (`id`, `tid`, `name`, `sort`, `template`, `hometextshow`, `background`, `alias`, `homepicshow`, `icon`) values('1','0','栏目一','1','article','1','#38C34B;','lanmuyi',NULL,NULL),
('2','0','栏目二','1','soft','1','#38C34B;','lanmuer',NULL,NULL);


/*Table structure for table `ls_auth_group` */

DROP TABLE IF EXISTS `ls_auth_group`;

CREATE TABLE `ls_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='权限组表';

/*Data for the table `ls_auth_group` */

insert  into `ls_auth_group`(`id`,`title`,`status`,`rules`) values 
(1,'超级管理员',1,NULL);


/*Table structure for table `ls_auth_group_access` */

DROP TABLE IF EXISTS `ls_auth_group_access`;

CREATE TABLE `ls_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

/*Data for the table `ls_auth_group_access` */

insert  into `ls_auth_group_access`(`uid`,`group_id`) values 
(1,1);

/*Table structure for table `ls_auth_rule` */

DROP TABLE IF EXISTS `ls_auth_rule`;

CREATE TABLE `ls_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='规则表';

/*Data for the table `ls_auth_rule` */

insert  into `ls_auth_rule`(`id`,`name`,`title`,`type`,`status`,`pid`,`icon`,`sort`,`condition`) values 
(1,'admin/System/index','系统配置',1,1,0,'fa-gears',10,''),
(2,'admin/System/siteConfig','站点配置',1,1,1,'',0,''),
(3,'admin/System/updateSiteConfig','更新配置',1,0,2,'',0,''),
(5,'admin/Bar/default','菜单管理',1,1,0,'fa-bars',9,''),
(6,'admin/Menu/index','后台菜单',1,1,5,'',0,''),
(7,'admin/Menu/add','添加菜单',1,0,6,'',0,''),
(8,'admin/Menu/save','保存菜单',1,0,6,'',0,''),
(9,'admin/Menu/edit','编辑菜单',1,0,6,'',0,''),
(10,'admin/Menu/update','更新菜单',1,0,6,'',0,''),
(11,'admin/Menu/delete','删除菜单',1,0,6,'',0,''),
(12,'admin/Nav/index','BBS导航管理',1,1,5,'',0,''),
(13,'admin/Content/default','内容管理',1,1,0,'fa fa-file-text',8,''),
(14,'admin/Forumcate/index','社区版块',1,1,13,'',0,''),
(15,'admin/Forumcate/add','添加版块',1,0,14,'',0,''),
(16,'admin/Forumcate/save','保存版块',1,0,14,'',0,''),
(17,'admin/Forumcate/edit','编辑版块',1,0,14,'',0,''),
(18,'admin/Forumcate/update','更新版块',1,0,14,'',0,''),
(19,'admin/Forumcate/delete','删除版块',1,0,14,'',0,''),
(20,'admin/Forum/index','帖子管理',1,1,13,'',0,''),
(21,'admin/Forum/toggle','帖子审核',1,0,20,'',0,''),
(22,'admin/Comment/index','评论管理',1,1,13,'',0,''),
(24,'admin/Message/index','消息管理',1,1,13,'',0,''),
(25,'admin/Message/add','添加消息',1,0,24,'',0,''),
(26,'admin/Message/save','保存消息',1,0,24,'',0,''),
(27,'admin/Message/edit','编辑消息',1,0,24,'',0,''),
(28,'admin/Message/update','更新消息',1,0,24,'',0,''),
(29,'admin/Message/delete','删除消息',1,0,24,'',0,''),
(30,'admin/User/default','用户管理',1,1,0,'fa-users',7,''),
(31,'admin/AuthGroup/add','添加权限组',1,0,88,'',0,''),
(32,'admin/AuthGroup/save','保存权限组',1,0,88,'',0,''),
(33,'admin/AuthGroup/edit','编辑权限组',1,0,88,'',0,''),
(34,'admin/AuthGroup/update','更新权限组',1,0,88,'',0,''),
(35,'admin/AuthGroup/delete','删除权限组',1,0,88,'',0,''),
(36,'admin/AuthGroup/auth','授权',1,0,88,'',0,''),
(37,'admin/AuthGroup/updateAuthGroupRule','更新权限组规则',1,0,88,'',0,''),
(39,'admin/Nav/add','添加导航',1,0,12,'',0,''),
(40,'admin/Nav/save','保存导航',1,0,12,'',0,''),
(41,'admin/Nav/edit','编辑导航',1,0,12,'',0,''),
(42,'admin/Nav/update','更新导航',1,0,12,'',0,''),
(43,'admin/Nav/delete','删除导航',1,0,12,'',0,''),
(44,'admin/User/add','添加用户',1,0,86,'',0,''),
(45,'admin/User/save','保存用户',1,0,86,'',0,''),
(46,'admin/User/edit','编辑用户',1,0,86,'',0,''),
(47,'admin/User/update','更新用户',1,0,86,'',0,''),
(48,'admin/User/delete','删除用户',1,0,86,'',0,''),
(49,'admin/AdminUser/add','添加管理员',1,0,87,'',0,''),
(50,'admin/AdminUser/save','保存管理员',1,0,87,'',0,''),
(51,'admin/AdminUser/edit','编辑管理员',1,0,87,'',0,''),
(52,'admin/AdminUser/update','更新管理员',1,0,87,'',0,''),
(53,'admin/AdminUser/delete','删除管理员',1,0,87,'',0,''),
(54,'admin/Extend/default','模板插件',1,1,0,'fa-wrench',5,''),
(73,'admin/ChangePassword/index','修改密码',1,1,1,'',0,''),
(74,'admin/ChangePassword/updatePassword','更新密码',1,0,73,'',0,''),
(75,'admin/ChangePassword/diachange_password','弹窗修改密码',1,0,73,'',0,''),
(76,'admin/Menu/updatestatus','更新菜单状态',1,0,6,'',0,''),
(77,'admin/Database/index?type=export','备份数据库',1,1,1,'',0,''),
(78,'admin/Database/index?type=import','恢复数据库',1,1,1,'',0,''),
(80,'admin/Database/optimize','优化表',1,0,77,'',0,''),
(81,'admin/Database/repair','修复表',1,0,77,'',0,''),
(82,'admin/Database/export','备份表',1,0,77,'',0,''),
(83,'admin/Database/import','恢复表',1,0,78,'',0,''),
(84,'admin/Database/delete','备份删除',1,0,78,'',0,''),
(85,'admin/Nav/updatestatus','更新导航状态',1,0,12,'',0,''),
(86,'admin/User/index','普通用户',1,1,30,'',0,''),
(87,'admin/AdminUser/index','管理员',1,1,30,'',0,''),
(88,'admin/AuthGroup/index','权限组',1,1,30,'',0,''),
(89,'admin/Forumcate/updatestatus','更新板块状态',1,0,14,'',0,''),
(90,'admin/usergrade/index','会员等级',1,1,30,'',0,''),
(91,'admin/usergrade/add','添加等级',1,0,90,'',0,''),
(92,'admin/usergrade/save','保存等级',1,0,90,'',0,''),
(93,'admin/usergrade/edit','编辑等级',1,0,90,'',0,''),
(94,'admin/usergrade/update','更新等级',1,0,90,'',0,''),
(95,'admin/usergrade/delete','删除等级',1,0,90,'',0,''),
(96,'admin/Forum/edit','编辑帖子',1,0,20,'',0,''),
(97,'admin/Forum/update','更新帖子',1,0,20,'',0,''),
(98,'admin/Forum/delete','删除帖子',1,0,20,'',0,''),
(99,'admin/Forum/alldelete','批量删除帖子',1,0,20,'',0,''),
(100,'admin/Comment/delete','评论删除',1,0,22,'',0,''),
(101,'admin/Comment/alldelete','批量删除删除',1,0,22,'',0,''),
(102,'admin/Addons/index','插件管理',1,1,54,'',1,''),
(104,'admin/InstallAddons/index','已装插件',1,1,0,'fa-sliders',4,''),
(105,'admin/Hooks/add','添加钩子',1,0,102,'',0,''),
(106,'admin/Hooks/save','保存钩子',1,0,102,'',0,''),
(107,'admin/Hooks/edit','编辑钩子',1,0,102,'',0,''),
(108,'admin/Hooks/update','更新钩子',1,0,102,'',0,''),
(109,'admin/Hooks/delete','删除钩子',1,0,102,'',0,''),
(110,'admin/Addons/adminlist','插件后台',1,0,103,'',0,''),
(111,'admin/Addons/config','设置插件',1,0,103,'',0,''),
(112,'admin/Addons/saveConfig','插件设置保存',1,0,103,'',0,''),
(113,'admin/Addons/install','安装插件',1,0,103,'',0,''),
(114,'admin/Addons/uninstall','卸载插件',1,0,103,'',0,''),
(115,'admin/Logmanage/index','记录管理',1,1,0,'fa-braille',6,''),
(116,'admin/Log/index','操作记录',1,1,115,'',0,''),
(117,'admin/Log/delete','删除记录',1,0,116,'',0,''),
(118,'admin/Log/alldelete','清空记录',1,0,116,'',0,''),
(119,'admin/PointNote/index','积分记录',1,1,115,'',0,''),
(120,'admin/PointNote/delete','删除记录',1,0,119,'',0,''),
(121,'admin/PointNote/alldelete','清空记录',1,0,119,'',0,''),
(122,'admin/navcms/index','CMS导航管理',1,1,5,'',0,''),
(123,'admin/articlecate/index','CMS版块',1,1,13,'',0,''),
(124,'admin/articles/index','文章管理',1,1,13,'',0,''),
(125,'admin/system/template','模板管理',1,1,54,'',2,''),
(126,'admin/system/ota','OTA设置',1,1,54,'',3,''),
('127','admin/navcms/add','添加CMS导航','1','0','122','','0',''),
('128','admin/navcmsNav/save','保存CMS导航','1','0','122','','0',''),
('129','admin/navcms/edit','编辑CMS导航','1','0','122','','0',''),
('130','admin/navcms/update','更新CMS导航','1','0','122','','0',''),
('131','admin/navcms/delete','删除CMS导航','1','0','122','','0',''),
('132','admin/navcms/updatestatus','更新CMS导航状态','1','0','122','','0',''),
('133','admin/Articlecate/add','添加分类','1','0','123','','0',''),
('134','admin/Articlecate/save','保存分类','1','0','123','','0',''),
('135','admin/Articlecate/edit','编辑分类','1','0','123','','0',''),
('136','admin/Articlecate/update','更新分类','1','0','123','','0',''),
('137','admin/Articlecate/delete','删除分类','1','0','123','','0',''),
('138','admin/Articlecate/updatestatus','更新分类状态','1','0','123','','0',''),
('139','admin/Articles/toggle','文章审核','1','0','124','','0',''),
('140','admin/Articles/add','添加文章','1','0','124','','0',''),
('141','admin/Articles/edit','编辑文章','1','0','124','','0',''),
('142','admin/Articles/update','更新文章','1','0','124','','0',''),
('143','admin/Articles/delete','删除文章','1','0','124','','0',''),
('144','admin/Articles/alldelete','批量删除文章','1','0','124','','0',''),
('145','admin/system/updateota','更新OTA配置','1','0','126','','0',''),
('146','admin/Addons/deladdon','删除插件','1','0','102','','0',''),
('147','admin/index/handle','下载/升级模板','1','0','125','','0',''),
('148','admin/system/usetpl','启用模板','1','0','125','','0',''),
('149','admin/template/update','删除模板','1','0','125','','0',''),
('150','admin/point_note/reward','奖励投稿者','1','0','124','','0',''),
('151','admin/orders/index','充值记录','1','1','115','','0',''),
('152','admin/superlinks/index','友情链接管理',1,1,13,'',0,''),
('153','admin/Artcomment/index','留言管理',1,1,13,'',0,''),
('154','admin/superlinks/index','幻灯片管理',1,1,13,'',0,'');
/*Table structure for table `ls_collect` */

DROP TABLE IF EXISTS `ls_collect`;

CREATE TABLE `ls_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `sid` int(10) unsigned NOT NULL COMMENT '对方id或者帖子id',
  `time` varchar(10) DEFAULT NULL COMMENT '操作时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 好友  1 帖子 3文章',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='收藏关注表';



/*Table structure for table `ls_comment` */

DROP TABLE IF EXISTS `ls_comment`;

CREATE TABLE `ls_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级评论',
  `uid` int(11) NOT NULL COMMENT '所属会员',
  `fid` int(11) NOT NULL COMMENT '所属帖子',
  `time` varchar(11) NOT NULL COMMENT '时间',
  `zan` varchar(11) DEFAULT '0' COMMENT '赞',
  `reply` varchar(11) DEFAULT '0' COMMENT '回复',
  `content` text NOT NULL COMMENT '内容',
  `jubao` int(2) DEFAULT '0',
  `status` TINYINT(1) DEFAULT 1 NULL, 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='评论表';


/*Table structure for table `ls_file` */

DROP TABLE IF EXISTS `ls_file`;

CREATE TABLE `ls_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` varchar(255) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` varchar(255) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `resolution` varchar(11) DEFAULT NULL COMMENT '分辨率',
  `md5` varchar(255) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` varchar(255) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  `download` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文件表';

/*Table structure for table `ls_forum` */

DROP TABLE IF EXISTS `ls_forum`;

CREATE TABLE `ls_forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `uid` int(11) NOT NULL COMMENT '用户',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '精贴',
  `settop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '顶置',
  `carousel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '幻灯片',
  `zan` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `view` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `time` int(11) NOT NULL COMMENT '时间',
  `add_time` int(11)  NULL COMMENT '增加时间',
  `reply` varchar(11) NOT NULL DEFAULT '0' COMMENT '回复',
  `keywords` varchar(100) DEFAULT NULL COMMENT '关键词',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `remarks` varchar(200) DEFAULT NULL COMMENT '审核备注',
  `content` text NOT NULL COMMENT '内容',
  `jiacu` tinyint(1) NOT NULL DEFAULT '0',
  `yanse` char(20) NOT NULL DEFAULT '#000000',
  `memo` tinyint(1) DEFAULT '0' COMMENT '备忘',
  `attach` tinyint(1) DEFAULT '0' COMMENT '是否有附件',
  `coverpic` varchar(100) DEFAULT NULL COMMENT '封面图片',
  `collect` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/*Table structure for table `ls_forumcate` */

DROP TABLE IF EXISTS `ls_forumcate`;

CREATE TABLE `ls_forumcate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '显示',
  `sidebar` tinyint(1) NOT NULL DEFAULT '1' COMMENT '侧栏',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `pic` varchar(100) NOT NULL COMMENT '图片',
  `time` varchar(32) NOT NULL COMMENT '时间',
  `template` varchar(32) NOT NULL DEFAULT 'thread' COMMENT '模板',
  `list_template` varchar(20) DEFAULT 'threadlist' COMMENT '列表页模板',
  `keywords` varchar(100) NOT NULL COMMENT '关键词',
  `description` varchar(200) NOT NULL COMMENT '描述',
  `alias` varchar(10) NOT NULL COMMENT '别名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='社区分类表';

/*Data for the table `ls_forumcate` */

insert  into `ls_forumcate`(`id`,`tid`,`name`,`type`,`show`,`sidebar`,`sort`,`pic`,`time`,`keywords`,`description`,`alias`) values 
(1,0,'板块一',1,1,1,1,'','1492604139','LaySNS轻社区 程序发布','LaySNS轻社区程序发布版块','chengxu'),
(2,0,'板块二',1,1,1,1,'','1492604176','问题建议','问题建议','idea');

/*Table structure for table `ls_hooks` */

DROP TABLE IF EXISTS `ls_hooks`;

CREATE TABLE `ls_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件 ''，''分割',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



/*Table structure for table `ls_log` */

DROP TABLE IF EXISTS `ls_log`;

CREATE TABLE `ls_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `username` varchar(55) NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



/*Table structure for table `ls_mail_queue` */

DROP TABLE IF EXISTS `ls_mail_queue`;

CREATE TABLE `ls_mail_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mail_to` varchar(120) NOT NULL,
  `mail_subject` varchar(255) NOT NULL,
  `mail_body` text NOT NULL,
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `err_num` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL,
  `lock_expiry` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `ls_mail_queue` */

/*Table structure for table `ls_message` */

DROP TABLE IF EXISTS `ls_message`;

CREATE TABLE `ls_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '所属会员',
  `touid` int(11) NOT NULL DEFAULT '0' COMMENT '发送对象',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1系统消息2帖子动态',
  `content` text NOT NULL COMMENT '内容',
  `time` varchar(32) NOT NULL COMMENT '时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息表';


/*Table structure for table `ls_nav` */

DROP TABLE IF EXISTS `ls_nav`;

CREATE TABLE `ls_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `pid` tinyint(3) unsigned NOT NULL COMMENT '顶部还是底部',
  `sid` tinyint(3) unsigned NOT NULL COMMENT '内部还是外部',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `description` VARCHAR(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='导航表';

/*Data for the table `ls_nav` */

insert  into `ls_nav`(`id`,`pid`,`sid`,`name`,`alias`,`link`,`icon`,`target`,`status`,`sort`) values 
(1,1,1,'用户中心','Home','user/index/index','','_self',1,0);

/*Table structure for table `ls_nav_cms` */

DROP TABLE IF EXISTS `ls_nav_cms`;

CREATE TABLE `ls_nav_cms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级',
  `pid` tinyint(3) unsigned NOT NULL COMMENT '顶部还是底部',
  `sid` tinyint(3) unsigned NOT NULL COMMENT '内部还是外部',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `description` VARCHAR(255) DEFAULT '' COMMENT '描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
insert  into `ls_nav_cms`(`id`,`tid`,`pid`,`sid`,`name`,`alias`,`link`,`icon`,`target`,`status`,`sort`,`description`) values 
(1,0,1,1,'用户中心','Home','user/index/index','','_self',1,0,''),
(2,0,2,0,'QQ交流群','点击加入','https://jq.qq.com/?_wv=1027&k=5Q9c16B','/public/images/qq.png','_blank',1,0,'更多福利进来瞅瞅吧');

/*Data for the table `ls_nav_cms` */




/*Table structure for table `ls_point_note` */

DROP TABLE IF EXISTS `ls_point_note`;

CREATE TABLE `ls_point_note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `pointid` int(10) unsigned NOT NULL,
  `score` int(10) NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Data for the table `ls_point_note` */
DROP TABLE IF EXISTS `ls_point_refer`;
CREATE TABLE `ls_point_refer` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `alias` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`,`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分参照表';

insert  into `ls_point_refer`(`id`,`alias`,`title`) values 
(1,'alipay','积分充值'),
(2,'articleadd','添加文章'),
(3,'articledelete','删除文章'),
(4,'buyshop','购买插件'),
(5,'commentadd','回帖'),
(6,'forumadd','发帖'),
(7,'forumdelete','删帖'),
(8,'fufeiforum','付费阅读'),
(9,'NewYearReward','新年签到奖励'),
(10,'tipauthor','打赏'),
(11,'usersign','签到'),
(12,'findbug','找BUG奖励'),
(13,'rewardForumAuthor','发帖找BUG'),
(14,'attachlink','附件资源下载'),
(15,'KeepSign','连续签到奖励'),
(16,'point2plugin','积分兑换插件'),
(17,'Point2RMB','开发者积分提现'),
(18,'AuthPresent','授权赠送'),
(20,'selfdeposit','卡密自助充值'),
(21,'jifenBack','积分回退');
/*Table structure for table `ls_qqconnect` */

DROP TABLE IF EXISTS `ls_qqconnect`;

CREATE TABLE `ls_qqconnect` (
  `openid` varchar(255) NOT NULL COMMENT 'openid',
  `head` varchar(255) NOT NULL COMMENT '头像',
  `nickname` varchar(255) NOT NULL COMMENT '昵称',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所有人',
  `add_time` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `errorcode` varchar(255) NOT NULL COMMENT '错误代码',
  PRIMARY KEY (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='互联表';


/*Table structure for table `ls_readmessage` */

DROP TABLE IF EXISTS `ls_readmessage`;

CREATE TABLE `ls_readmessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '消息对象',
  `status` tinyint(1) DEFAULT '0' COMMENT '消息状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='消息表';

/*Data for the table `ls_readmessage` */


/*Table structure for table `ls_superlinks` */

DROP TABLE IF EXISTS `ls_superlinks`;

CREATE TABLE `ls_superlinks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '类别（1：图片，2：普通）',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '站点名称',
  `cover_id` int(10) NOT NULL COMMENT '图片ID',
  `link` char(140) NOT NULL DEFAULT '' COMMENT '链接地址',
  `level` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '优先级',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态（0：禁用，1：正常）',
  `nofollow` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'nofollow（0：默认，1：nofollow）',
  `contacts` char(30) NOT NULL DEFAULT '' COMMENT '联系方式',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `onwhere` char(10) DEFAULT 'default' COMMENT '显示位置',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='友情连接表';



/*Table structure for table `ls_system` */

DROP TABLE IF EXISTS `ls_system`;

CREATE TABLE `ls_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

/*Data for the table `ls_system` */

insert into `ls_system` (`id`, `name`, `value`) values('1','site_config','a:59:{s:10:\"site_title\";s:6:\"LaySNS\";s:7:\"favicon\";s:0:\"\";s:7:\"cmslogo\";s:23:\"/public/images/logo.png\";s:7:\"bbslogo\";s:23:\"/public/images/logo.png\";s:6:\"uclogo\";s:23:\"/public/images/logo.png\";s:9:\"seo_title\";s:33:\"轻量级综合网站管理系统\";s:11:\"seo_keyword\";s:45:\"LaySNS,PHP网站,PHP源码,TP5,layui,ThinkPHP\";s:15:\"seo_description\";s:127:\"LaySNS是一款轻量级，基于ThinkPHP5+Layui2架构的集内容管理与社区互动为一体的综合网站管理系统。\";s:14:\"site_copyright\";s:30:\"武汉类森科技有限公司\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:0:\"\";s:7:\"cb_open\";s:1:\"3\";s:8:\"site_wjt\";s:1:\"0\";s:8:\"user_reg\";s:1:\"1\";s:10:\"article_sh\";s:1:\"0\";s:8:\"forum_sh\";s:1:\"1\";s:8:\"email_sh\";s:1:\"1\";s:8:\"site_yzm\";s:3:\"1,4\";s:13:\"security_code\";s:1:\"0\";s:11:\"thumb_width\";s:4:\"2000\";s:5:\"upext\";s:23:\"jpg,png,bmp,gif,rar,zip\";s:6:\"upsize\";s:11:\"5*1024*1024\";s:14:\"c_home_newlist\";s:2:\"88\";s:11:\"c_home_text\";s:2:\"12\";s:10:\"c_home_pic\";s:2:\"10\";s:11:\"c_list_main\";s:2:\"10\";s:10:\"c_list_phb\";s:2:\"10\";s:13:\"c_list_choice\";s:2:\"10\";s:11:\"c_view_main\";s:2:\"15\";s:10:\"c_view_phb\";s:2:\"10\";s:13:\"b_home_settop\";s:1:\"5\";s:11:\"b_home_main\";s:2:\"15\";s:10:\"b_home_phb\";s:2:\"12\";s:10:\"b_home_hot\";s:2:\"15\";s:11:\"b_list_main\";s:2:\"15\";s:10:\"b_list_hot\";s:2:\"15\";s:10:\"b_list_phb\";s:2:\"12\";s:12:\"b_view_reply\";s:1:\"5\";s:10:\"b_view_hot\";s:2:\"15\";s:11:\"smtp_server\";s:0:\"\";s:9:\"smtp_port\";s:0:\"\";s:9:\"smtp_user\";s:0:\"\";s:9:\"smtp_pass\";s:0:\"\";s:15:\"mail_tpl_active\";s:2287:\"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p>Hi，<b>{username}</b>：</p><p>欢迎加入 <b>{site_title}</b>！请点击下面的链接来认证您的邮箱。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>\";s:17:\"mail_tpl_resetpwd\";s:2314:\"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <p>您好，<b>{username}</b> ：</p><p>您正在找回<b> {site_title}</b> 网站登录密码！如果是你本人进行的操作，请点击下面的链接来认证您的邮箱。否则，请忽略该邮件。</p><p>{url}</p><p>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。</p><p><br></p>\";s:7:\"smtp_cs\";s:0:\"\";s:10:\"jifen_name\";s:6:\"金币\";s:11:\"jifen_email\";s:1:\"0\";s:9:\"jifen_reg\";s:1:\"0\";s:11:\"jifen_login\";s:1:\"0\";s:9:\"jifen_add\";s:1:\"0\";s:13:\"jifen_comment\";s:1:\"0\";s:12:\"jifen_artadd\";s:1:\"0\";s:10:\"open_taoke\";s:1:\"0\";s:9:\"open_sign\";s:1:\"1\";s:12:\"open_qqlogin\";s:1:\"0\";s:9:\"open_7niu\";s:1:\"0\";s:8:\"open_pay\";s:1:\"0\";s:8:\"open_sms\";s:1:\"0\";}');
insert into `ls_system` (`id`, `name`, `value`) values('2','version','2.55');
insert into `ls_system` (`id`, `name`, `value`) values('3','qqlogin','a:3:{s:5:\"appid\";s:0:\"\";s:6:\"appkey\";s:0:\"\";s:8:\"callback\";s:0:\"\";}');
insert into `ls_system` (`id`, `name`, `value`) values('4','qiniu','a:7:{s:9:\"AccessKey\";s:0:\"\";s:9:\"SecretKey\";s:0:\"\";s:6:\"bucket\";s:0:\"\";s:6:\"domain\";s:0:\"\";s:6:\"global\";s:1:\"1\";s:8:\"allowExt\";s:0:\"\";s:7:\"maxSize\";s:0:\"\";}');
insert into `ls_system` (`id`, `name`, `value`) values('5','taoke','a:3:{s:4:\"type\";s:1:\"1\";s:8:\"quan_api\";s:0:\"\";s:3:\"url\";s:0:\"\";}');
insert into `ls_system` (`id`, `name`, `value`) values('6','payservice','a:8:{s:7:\"paytype\";s:1:\"1\";s:6:\"apiurl\";s:24:\"http://www.youzipay.com/\";s:7:\"partner\";s:0:\"\";s:3:\"key\";s:0:\"\";s:8:\"sitename\";s:0:\"\";s:8:\"scorenum\";s:2:\"10\";s:6:\"minnum\";s:1:\"1\";s:5:\"token\";s:1:\"0\";}');
insert into `ls_system` (`id`, `name`, `value`) values('7','template','a:3:{s:7:\"cms_tpl\";s:9:\"c_default\";s:7:\"bbs_tpl\";s:9:\"b_default\";s:8:\"user_tpl\";s:9:\"u_default\";}');
insert into `ls_system` (`id`, `name`, `value`) values('8','otaservice','a:3:{s:9:\"updateurl\";s:38:\"http://www.laysns.com/api/index/update\";s:9:\"updatekey\";s:27:\"test12345678912345678911111\";s:5:\"token\";s:1:\"0\";}');
insert into `ls_system` (`id`, `name`, `value`) values('9','watermark','a:9:{s:6:"switch";s:1:"1";s:9:"mark_type";s:1:"1";s:4:"font";s:2:"25";s:9:"font_path";s:11:"simfang.ttf";s:4:"code";s:7:"#66ccff";s:8:"position";s:1:"9";s:4:"text";s:6:"LaySNS";s:3:"img";s:23:"/public/images/logo.png";s:5:"token";s:1:"0";}');

/*Table structure for table `ls_user` */

DROP TABLE IF EXISTS `ls_user`;

CREATE TABLE `ls_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `userip` varchar(32) NOT NULL COMMENT 'IP',
  `username` varchar(32) NOT NULL COMMENT '名称',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `userhead` varchar(100) DEFAULT '/public/images/default.png' COMMENT '头像',
  `usermail` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `qqid` varchar(11) DEFAULT '' COMMENT 'QQ号',
  `regtime` varchar(32) NOT NULL COMMENT '注册时间',
  `grades` tinyint(1) NOT NULL DEFAULT '1' COMMENT '等级',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '验证1表示正常2邮箱验证3手机认证5手机邮箱全部认证',
  `userhome` varchar(32) DEFAULT NULL COMMENT '家乡',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `last_login_time` varchar(20) DEFAULT '0' COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  `salt` varchar(20) DEFAULT NULL COMMENT 'salt',
  `developer` tinyint(1) DEFAULT '0' COMMENT '开发者',
  `collect` int(11) DEFAULT '0' COMMENT '被关注数',
  `zan` int(11) DEFAULT '0' COMMENT '被赞数',
  `tips` int(11) DEFAULT '0' COMMENT '被打赏次数',
  `attestation` varchar(50) DEFAULT '' COMMENT '认证',
  `openid` VARCHAR(50) DEFAULT '' COMMENT '第三方登录账户ID',
  `freezepoint` int(10)  DEFAULT 0 COMMENT '冻结积分',
  `alipayid` VARCHAR(64) DEFAULT '' COMMENT '支付宝',
  `weixinpayid` VARCHAR(64) DEFAULT '' COMMENT '微信账号',
  `forget_passwd_token` VARCHAR(32) DEFAULT '' NULL,
  `forget_passwd_endtime` INT(10) DEFAULT 0 NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `usermail` (`usermail`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';
insert  into `ls_user`(`id`,`username`,`grades`,`password`,`status`,`regtime`,`last_login_time`,`last_login_ip`,`developer`,`salt`) values 
(1,'admin',1,'0dfc7612f607db6c17fd99388e9e5f9c',5,'1491037613','1517316140','113.45.231.40',1,'1dFlxLhiuLqnUZe9kA');


/*Table structure for table `ls_user_sign` */

DROP TABLE IF EXISTS `ls_user_sign`;

CREATE TABLE `ls_user_sign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `days` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '连续签到的天数',
  `is_share` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否分享过',
  `is_sign` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否签到过',
  `stime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '签到的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户签到表';

/*Data for the table `ls_user_sign` */

/*Table structure for table `ls_user_signrule` */

DROP TABLE IF EXISTS `ls_user_signrule`;

CREATE TABLE `ls_user_signrule` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `days` int(5) unsigned NOT NULL COMMENT '连续天数',
  `score` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户签到积分规则';

/*Data for the table `ls_user_signrule` */

insert  into `ls_user_signrule`(`id`,`days`,`score`) values 
(9,1,2),
(10,10,8),
(11,4,4);

/*Table structure for table `ls_usergrade` */

DROP TABLE IF EXISTS `ls_usergrade`;

CREATE TABLE `ls_usergrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` TINYINT(1) DEFAULT 1 NULL COMMENT '1 积分用户组 2自定义组',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `score` int(11) NOT NULL COMMENT '等级所需积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员等级表';

/*Data for the table `ls_usergrade` */

insert  into `ls_usergrade`(`id`,`name`,`score`) values 
(1,'普通会员',0);

/*Table structure for table `ls_zan` */

DROP TABLE IF EXISTS `ls_zan`;

CREATE TABLE `ls_zan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '顶部还是底部',
  `sid` int(11) unsigned NOT NULL COMMENT '对方id或者帖子id或者回复的id',
  `time` varchar(10) DEFAULT '0' COMMENT '操作时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 好友  1 帖子2 回复评论',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='导航表';

DROP TABLE IF EXISTS `ls_banzhu`;

CREATE TABLE `ls_banzhu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cid` int(11) unsigned NOT NULL COMMENT '版块id',
  `type` int(1) NULL DEFAULT '1' COMMENT '类别（1：包含子版块，2：不包含）',
  `uids` varchar(80) NOT NULL DEFAULT '' COMMENT '版主ID',
  `onwhere` varchar(11)  NOT NULL DEFAULT 'bbs' COMMENT 'BBS或CMS',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='版主列表';
insert into ls_banzhu value (null,0,1,'','bbs');
insert into ls_banzhu value (null,0,1,'','cms');

DROP TABLE IF EXISTS `ls_payread`;
CREATE TABLE `ls_payread` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `fid` int(10) NOT NULL DEFAULT '0' ,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:付费阅读 2：回复可见',
  `onwhere` varchar(6) NOT NULL DEFAULT 'bbs' ,
  `score` int(10) NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
DROP TABLE IF EXISTS `ls_payreaduser`;

DROP TABLE IF EXISTS `ls_payreadlog`;

CREATE TABLE `ls_payreadlog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` int(10) NOT NULL DEFAULT '0' ,
  `uid` int(10) NOT NULL DEFAULT '0' ,
  `score` int(3) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `ls_jubao`;
CREATE TABLE `ls_jubao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户',
  `sid` int(11) unsigned NOT NULL COMMENT '对方id或者帖子id或者回复的id',
  `time` varchar(10) DEFAULT '0' COMMENT '操作时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 好友  1 帖子2 回复评论',
  `content` varchar(50) DEFAULT NULL COMMENT '举报理由',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='举报表';

DROP TABLE IF EXISTS `ls_orders`;
CREATE TABLE `ls_orders` (
  `id` varchar(30) NOT NULL COMMENT '订单ID',
  `trade_no` varchar(255) NOT NULL COMMENT '订单ID',
  `price` decimal(16,2) NOT NULL,
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所有人',
  `add_time` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `errorcode` varchar(255) NOT NULL COMMENT '错误代码',
  `paytype` tinyint(1) DEFAULT '2' COMMENT '支付方式;1柚子 2支付宝 3微信',
  `subject` varchar(100) DEFAULT NULL COMMENT '商品名称',
  `body` varchar(200) DEFAULT NULL COMMENT '商品描述',
  `nexttable` varchar(20) DEFAULT NULL COMMENT '下个表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付订单表';

DROP TABLE IF EXISTS `ls_artcomment`;
CREATE TABLE `ls_artcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL COMMENT '上级评论',
  `uid` int(11) NOT NULL COMMENT '所属会员',
  `fid` int(11) NOT NULL COMMENT '所属帖子',
  `time` varchar(11) NOT NULL COMMENT '时间',
  `zan` int(11) DEFAULT '0' COMMENT '赞',
  `reply` int(11) DEFAULT '0' COMMENT '回复',
  `content` text NOT NULL COMMENT '内容',
  `jubao` int(2) DEFAULT '0',
  `status` TINYINT(1) DEFAULT 1 NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章点评表';

DROP TABLE IF EXISTS `ls_sms`;
CREATE TABLE `ls_sms`( 
  `id` INT NOT NULL AUTO_INCREMENT, 
  `content` VARCHAR(8),
  `mobile` VARCHAR(11),
  `type` VARCHAR(20) NULL,
   `ip` VARCHAR(20) NULL,
  `error_num` int(1)  NULL DEFAULT '0' COMMENT '所属帖子',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` DATETIME,
  `expiry_time` DATETIME,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信验证码表'; 

DROP TABLE IF EXISTS `ls_blacklist`;
CREATE TABLE `ls_blacklist`(
   `id` INT NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(20), 
    `content` VARCHAR(30), 
    `created_at` DATETIME, 
    `expiry_time` DATETIME,
     `description` VARCHAR(255), 
     PRIMARY KEY (`id`) 
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='黑名单表'; 