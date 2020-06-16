<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
$food = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food`(  
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
		PRIMARY KEY (`id`)
    )";
$foodcate = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_cate`(  
    	`id` int(11) NOT NULL AUTO_INCREMENT,
		`num` int(11) NOT NULL,
		`uniacid` int(11) NOT NULL,
		`title` varchar(255) NOT NULL,
		`dateline` int(11) NOT NULL,
		`flag` int(1) NOT NULL DEFAULT '1',
		PRIMARY KEY (`id`)
    )";
$foodorder = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_order`(  
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
		PRIMARY KEY (`id`)
    )";
$foodsj = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_sj`(  
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
		PRIMARY KEY (`id`)
    )";
$foodtables = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_tables`(  
    	`id` int(11) NOT NULL AUTO_INCREMENT,
		`uniacid` int(11) DEFAULT NULL,
		`tnum` int(11) DEFAULT NULL,
		`title` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
    )";
$storeconf = "
    CREATE TABLE IF NOT EXISTS `ims_sudu8_page_storeconf`(  
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `search` int(1) NOT NULL,
					  `flag` int(1) NOT NULL,
					  `mapkey` varchar(255) NOT NULL,
					  `ctime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$customer_base = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_customer_base` (
					  `id` int(11) NOT NULL  AUTO_INCREMENT,
					  `openid` varchar(255) NOT NULL,
					  `uniacid` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$customer_pic = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_customer_pic` (
					  `id` int(11) NOT NULL  AUTO_INCREMENT,
					  `openid` varchar(255) NOT NULL COMMENT '用户openid',
					  `uniacid` int(11) NOT NULL,
					  `flag` int(1) NOT NULL COMMENT '1发 2',
					  PRIMARY KEY (`id`)
					)";
$customer_reply = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_customer_reply` (
					  `id` int(11) NOT NULL  AUTO_INCREMENT,
					  `type` int(1) DEFAULT NULL COMMENT '1文本 2图片 3图文 4小程序卡片',
					  `content` text NOT NULL,
					  `uniacid` int(11) NOT NULL,
					  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1开启 2不开启',
					  PRIMARY KEY (`id`)
					)";
$sign = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_sign` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  `score` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$sign_con = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_sign_con` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `score` varchar(255) NOT NULL DEFAULT '10/20',
					  `max_score` int(11) NOT NULL DEFAULT '10000',
					  PRIMARY KEY (`id`)
					)";
$sign_lx = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_sign_lx` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `count` int(11) NOT NULL DEFAULT '0',
					  `max_count` int(11) NOT NULL DEFAULT '0',
					  `all_count` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					)";
$score_cate = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_cate` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `num` int(11) NOT NULL,
					  `uniacid` int(11) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `catepic` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$score_order = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_order` (
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
					  PRIMARY KEY (`id`)
					)";
$score_shop = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_shop` (
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
					  PRIMARY KEY (`id`)
					)";
$score = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					 `uniacid` int(11) NOT NULL,
					  `orderid` varchar(255) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `type` varchar(255) NOT NULL,
					  `score` varchar(255) NOT NULL,
					  `message` varchar(255) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$comment = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_comment` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					 `uniacid` int(11) NOT NULL,
					  `aid` int(11) NOT NULL COMMENT '文章id',
					  `text` text NOT NULL COMMENT '评论内容',
					  `openid` varchar(255) NOT NULL,
					  `flag` int(1) DEFAULT '0' COMMENT '0未审  1通过  2不通过',
					  `createtime` int(11) NOT NULL,
					  `follow` int(11) DEFAULT '0',
					  PRIMARY KEY (`id`)
					)";
$share_user = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_share_user` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					 `uniacid` int(11) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `pid` int(11) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$printer = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_food_printer` (
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
					  PRIMARY KEY (`id`)
					)";
$message = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_message` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `mid` varchar(255) NOT NULL COMMENT '模板消息id',
					  `url` varchar(255) NOT NULL COMMENT '页面路径',
					  `flag` int(1) NOT NULL COMMENT '1支付通知 2系统表单通知 3预约通知  4点餐支付通知 5积分兑换成功通知',
					  PRIMARY KEY (`id`)
					)";
$multicate = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_multicate` (
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
					  PRIMARY KEY (`id`)
					)";
$multipro = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_multipro` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `multi_id` int(11) NOT NULL,
					  `proid` int(11) NOT NULL,
					  `cid` int(11) NOT NULL,
					  `tid` int(11) NOT NULL COMMENT '顶级栏目id',
					  PRIMARY KEY (`id`)
					)";
$duo_p_address = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_duo_products_address` (
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
					  PRIMARY KEY (`id`)
					)";
$duo_p_gwc = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_duo_products_gwc` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `pid` int(11) NOT NULL,
					  `pvid` int(11) NOT NULL,
					  `num` int(11) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  `flag` int(1) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
					)";
$duo_p_order = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_duo_products_order` (
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
					  PRIMARY KEY (`id`)
					)";
$duo_p_value = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_duo_products_type_value` (
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
					  PRIMARY KEY (`id`)
					)";
$duo_p_yunfei = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_duo_products_yunfei` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `yfei` varchar(255) NOT NULL,
					  `byou` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$fx_gz = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_fx_gz` (
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
					  PRIMARY KEY (`id`)
					)";
$fx_ls = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_fx_ls` (
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
					  PRIMARY KEY (`id`)
					)";
$fx_sq = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_fx_sq` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `truename` varchar(255) NOT NULL,
					  `truetel` varchar(255) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1申请中2已通过3不通过',
					  PRIMARY KEY (`id`)
					)";
$fx_tx = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_fx_tx` (
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
					  PRIMARY KEY (`id`)
					)";
$multicates = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_multicates` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `sort` int(5) NOT NULL DEFAULT '1',
					  `status` int(1) NOT NULL DEFAULT '1',
					  `varible` varchar(12) NOT NULL COMMENT '筛选值名称',
					  `pid` int(5) NOT NULL DEFAULT '0',
					  `uniacid` int(5) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$video_pay = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_video_pay` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `pid` int(11) NOT NULL,
					  `orderid` varchar(255) NOT NULL,
					  `paymoney` float NOT NULL,
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
//拼团开始180417
$ptgz = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_gz` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `types` int(1) NOT NULL DEFAULT '1',
					  `is_score` int(1) NOT NULL DEFAULT '1' COMMENT '1不启用 2启用【启用积分抵扣】',
					  `is_tuanz` int(1) NOT NULL DEFAULT '1' COMMENT '1不启用2启用【启用团长优惠】',
					  `is_pt` int(1) NOT NULL DEFAULT '2' COMMENT '1不启用2启用【是否自动成团】',
					  `pt_time` int(11) NOT NULL DEFAULT '24' COMMENT '成团时间',
					  `fahuo` int(11) NOT NULL DEFAULT '7' COMMENT '自动发货',
					  `guiz` text NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$ptcate = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_cate` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `num` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$ptpro = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_pro` (
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
					  PRIMARY KEY (`id`)
					)";
$ptproval = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_pro_val` (
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
					  PRIMARY KEY (`id`)
					)";
$ptshare = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_share` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `shareid` varchar(255) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `pid` int(11) NOT NULL COMMENT '商品id',
					  `creattime` int(11) NOT NULL DEFAULT '0',
					  `join_count` int(11) NOT NULL DEFAULT '1',
					  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1正在进行2已完成3已过期',
					  PRIMARY KEY (`id`)
					)";
$ptorder = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_order` (
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
					  PRIMARY KEY (`id`)
					)";
$ptrobot = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_robot` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `openid` varchar(255) NOT NULL,
					  `nickname` varchar(255) NOT NULL,
					  `icon` varchar(2555) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$ptrobot = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_robot` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `openid` varchar(255) NOT NULL,
					  `nickname` varchar(255) NOT NULL,
					  `icon` varchar(2555) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$form_dd = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_form_dd` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `cid` int(11) NOT NULL,
					  `types` varchar(255) NOT NULL,
					  `datys` int(11) NOT NULL,
					  `pagedatekey` int(11) NOT NULL,
					  `arrkey` int(11) NOT NULL,
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$usercenter_set = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_usercenter_set` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
  						`usercenterset` varchar(2000) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$coupon_set = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_coupon_set` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
  						`flag` int(1) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
					)";
$score_get = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pro_score_get` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `pid` int(11) NOT NULL,
					  `types` varchar(255) NOT NULL,
					  `score` int(11) NOT NULL DEFAULT '0',
					  `creattime` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$art_navlist = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_art_navlist` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `cid` int(11) NOT NULL,
					  `type` int(1) NOT NULL,
					  `bgcolor` varchar(255) NOT NULL,
					  `url` varchar(255) NOT NULL,
					  `flag` int(1) NOT NULL COMMENT '1启用 2不启用',
					  `num` int(11) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$art_nav = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_art_nav` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `num` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL,
					  `flag` int(1) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
//拼团提现
$pt_tx = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pt_tx` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `openid` varchar(1000) NOT NULL,
					  `ptorder` varchar(255) NOT NULL  COMMENT '拼团订单号',
					  `money` float NOT NULL,
					  `creattime` int(11) NOT NULL,
					  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1申请中2已通过3已拒绝',
					  `txtime` int(11) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					)";
//会员卡设置 20180704
$vip_config = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_vip_config` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `isopen` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员卡0不开启1开启2强制开启',
					  `name` varchar(255) NOT NULL DEFAULT '会员卡' COMMENT '会员卡名称',
					  `recharge` tinyint(1) NOT NULL DEFAULT '0' COMMENT '充值0直接可用1开卡后可用',
					  `coupon` tinyint(1) NOT NULL DEFAULT '0' COMMENT '领优惠券0直接可用1开卡后可用',
					  `sign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分签到0直接可用1开卡后可用',
					  `exchange` tinyint(1) NOT NULL DEFAULT '0' COMMENT '积分兑换0直接可用1开卡后可用',
					  PRIMARY KEY (`id`)
					)";
//diy设置 20180712
$diypage = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_diypage` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(5) NOT NULL COMMENT '小程序',
					  `index` int(1) NOT NULL DEFAULT '0' COMMENT '是否首页',
					  `page` varchar(3000) NOT NULL DEFAULT '' COMMENT '页面信息',
					  `items` text NOT NULL COMMENT '组件信息',
					  `tpl_name` varchar(32) NOT NULL COMMENT '模板名称',
					  PRIMARY KEY (`id`)
					)";
//diy 20180712
$diypageset = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_diypageset` (
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
					  PRIMARY KEY (`id`)
					)";
//diy 20180712
$diypagetpl = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_diypagetpl` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(5) NOT NULL,
					  `pageid` varchar(64) NOT NULL COMMENT '页面id列表',
					  `template_name` varchar(18) NOT NULL COMMENT '模板名称',
					  `thumb` varchar(158) NOT NULL COMMENT '页面封面图',
					  `create_time` varchar(32) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
//远程附件 20180725
$remote = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_remote` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `type` int(1) NOT NULL COMMENT '2七牛  3阿里云',
					  `bucket` varchar(255) NOT NULL,
					  `domain` varchar(255) NOT NULL COMMENT '域名',
					  `domainIs` int(1) NOT NULL DEFAULT '2' COMMENT '是否开启自定义域名  1开  2否',
					  `ak` varchar(255) NOT NULL COMMENT 'AccessKey',
					  `sk` varchar(255) NOT NULL COMMENT 'SecretKey',
					  `imgstyle` varchar(255) NOT NULL COMMENT '图片样式接口',
					  PRIMARY KEY (`id`)
					)";
//新版上传图片所有图片统计表 20180803
$page_pic = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_pic` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `gid` int(11) NOT NULL,
					  `imgurl` varchar(255) NOT NULL,
					  `type` int(1) NOT NULL COMMENT '1无 2七牛 3阿里云',
					  PRIMARY KEY (`id`)
					)";
//全能小程序多商户插件
$shops_cate = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_shops_cate` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `name` varchar(50) NOT NULL COMMENT '分类名称',
					  `num` int(11) NOT NULL COMMENT '排序越大越靠前',
					  `flag` tinyint(1) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`id`)
					)";
$shops_goods = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_shops_goods` (
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
					  PRIMARY KEY (`id`)
					)";
$shops_set = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_shops_set` (
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
					  PRIMARY KEY (`id`)
					)";
$shops_shop = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_shops_shop` (
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
					  PRIMARY KEY (`id`)
					)";
$shops_tixian = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_shops_tixian` (
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
					  PRIMARY KEY (`id`)
					)";
$picgroup = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_picgroup` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
  					`name` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$diypagetpl_sys = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_diypagetpl_sys` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(5) NOT NULL,
					  `pageid` varchar(64) NOT NULL COMMENT '页面id列表',
					  `template_name` varchar(18) NOT NULL COMMENT '模板名称',
					  `thumb` varchar(158) NOT NULL COMMENT '页面封面图',
					  `create_time` varchar(32) NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$diypage_sys = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_diypage_sys` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL COMMENT '小程序',
					  `index` int(1) NOT NULL DEFAULT '0' COMMENT '是否首页',
					  `page` varchar(3000) NOT NULL DEFAULT '' COMMENT '页面信息',
					  `items` mediumtext NOT NULL COMMENT '组件信息',
					  `tpl_name` varchar(32) NOT NULL COMMENT '模板名称',
					  PRIMARY KEY (`id`)
					)";
$forum_collection = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_collection` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `collection` tinyint(1) NOT NULL DEFAULT '1',
					  `rid` int(11) NOT NULL COMMENT 'release表id',
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_comment = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_comment` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `rid` int(11) NOT NULL COMMENT '发布的id',
					  `uid` int(11) NOT NULL COMMENT '用户id',
					  `uniacid` int(11) NOT NULL,
					  `content` mediumtext NOT NULL COMMENT '评论内容',
					  `createtime` datetime NOT NULL,
					  `flag` int(1) NOT NULL COMMENT '1显示 2不显示',
					  `likesNum` int(11) NOT NULL COMMENT '点赞数',
					  PRIMARY KEY (`id`)
					)";
$forum_func = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_func` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `title` mediumtext CHARACTER SET utf8 NOT NULL,
					  `func_img` varchar(255) NOT NULL,
					  `page_type` int(1) NOT NULL,
					  `num` int(11) NOT NULL DEFAULT '1',
					  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1启用 2不启用',
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_likes = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_likes` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `uid` int(11) NOT NULL,
					  `likes` tinyint(1) NOT NULL DEFAULT '1',
					  `rid` int(11) NOT NULL COMMENT 'release表id',
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_release = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_release` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `fid` int(11) NOT NULL COMMENT '发布功能分类id',
					  `content` mediumtext NOT NULL,
					  `img` mediumtext NOT NULL,
					  `uid` int(11) NOT NULL COMMENT '发布人id',
					  `release_money` decimal(5,2) NOT NULL COMMENT '发布收费',
					  `stick` tinyint(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT '是否置顶（1置顶 2不置顶）',
					  `stick_days` int(11) NOT NULL DEFAULT '7' COMMENT '置顶天数',
					  `stick_money` decimal(5,2) NOT NULL DEFAULT '10.00' COMMENT '置顶每天收费',
					  `hot` tinyint(1) UNSIGNED NOT NULL DEFAULT '2' COMMENT '是否推荐（1推荐 2不推荐）',
					  `hits` int(11) NOT NULL COMMENT '浏览人数',
					  `likes` int(11) NOT NULL COMMENT '点赞数',
					  `collection` int(11) NOT NULL COMMENT '收藏数',
					  `comment` int(11) NOT NULL COMMENT '评论数',
					  `telphone` varchar(255) NOT NULL,
					  `address` varchar(255) NOT NULL,
					  `createtime` datetime NOT NULL,
					  `updatetime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_set = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_set` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `release_money` decimal(5,2) NOT NULL DEFAULT '0.00',
					  `stick_money` decimal(5,2) NOT NULL DEFAULT '10.00',
					  PRIMARY KEY (`id`)
					)";
$forum_reply = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_reply` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `commentId` int(11) NOT NULL,
					  `content` mediumtext NOT NULL,
					  `uid` int(11) NOT NULL,
					  `release_uid` int(11) NOT NULL,
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_order = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_order` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `orderid` varchar(255) NOT NULL,
					  `uniacid` int(11) NOT NULL,
					  `release_money` decimal(5,2) NOT NULL,
					  `stick_money` decimal(5,2) NOT NULL,
					  `stick_days` int(11) NOT NULL,
					  `openid` varchar(255) NOT NULL,
					  `flag` int(1) NOT NULL DEFAULT '2' COMMENT '1已支付  2未支付',
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$forum_comment_likes = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_comment_likes` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `commentId` int(11) NOT NULL,
					  `likes` tinyint(1) NOT NULL COMMENT '1点赞 2不点赞',
					  `openid` varchar(255) NOT NULL,
					  `createtime` datetime NOT NULL,
					  PRIMARY KEY (`id`)
					)";
$moneyoff = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_moneyoff` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `reach` float NOT NULL COMMENT '满多少',
					  `del` float NOT NULL COMMENT '减多少',
					  PRIMARY KEY (`id`)
					)";
Db::query($moneyoff);  //20180820
Db::query($forum_comment_likes);  //20180820
Db::query($forum_order);  //20180820
Db::query($forum_reply);  //20180820
Db::query($forum_set);  //20180820
Db::query($forum_release);  //20180820
Db::query($forum_likes);  //20180820
Db::query($forum_func);  //20180820
Db::query($forum_comment);  //20180820
Db::query($forum_collection);  //20180820
Db::query($diypage_sys);  //20180815
Db::query($diypagetpl_sys);  //20180815
Db::query($picgroup);  //20180803
Db::query($shops_tixian);  //20180803
Db::query($shops_shop);  //20180803
Db::query($shops_set);  //20180803
Db::query($shops_goods);  //20180803
Db::query($shops_cate);  //20180803
Db::query($page_pic);  //20180803
Db::query($remote);  //20180725
Db::query($diypagetpl);  //20180712
Db::query($diypageset);  //20180712
Db::query($diypage);  //20180712
Db::query($vip_config);  //20180704
Db::query($pt_tx);  //180605
Db::query($art_nav);  //180507
Db::query($art_navlist);  //180507
Db::query($score_get);  //180507
Db::query($coupon_set);  //180504
Db::query($usercenter_set);  //180504
Db::query($form_dd);  //180420
Db::query($ptrobot);  //180417
Db::query($ptorder);  //180417
Db::query($ptshare);  //180417
Db::query($ptproval);  //180417
Db::query($ptpro);  //180417
Db::query($ptcate);  //180417
Db::query($ptgz);  //180417
Db::query($video_pay);  //180412
Db::query($multicates);  //180412
Db::query($fx_tx);  //180410 
Db::query($fx_sq);  //180410 
Db::query($fx_ls);  //180410 
Db::query($fx_gz);  //180410 
Db::query($duo_p_yunfei);  //180410 
Db::query($duo_p_value);  //180410 
Db::query($duo_p_gwc);  //180410 
Db::query($duo_p_order);  //180410  
Db::query($duo_p_address);  //180410  
Db::query($multipro);  //180330  多栏目商品表
Db::query($multicate);  //180330  多栏目栏目表
Db::query($message);
Db::query($printer);
Db::query($comment);
Db::query($share_user);
Db::query($score);
Db::query($score_shop);
Db::query($score_order);
Db::query($score_cate);
Db::query($sign);
Db::query($sign_lx);
Db::query($sign_con);
Db::query($food);
Db::query($foodcate);
Db::query($foodorder);
Db::query($foodsj);
Db::query($foodtables);
Db::query($storeconf);
Db::query($customer_base);
Db::query($customer_pic);
Db::query($customer_reply);
$applet_count_01 = Db::query("SHOW COLUMNS FROM applet");
if (count($applet_count_01) < 16) {
    Db::query("alter table applet add baidu_appID varchar(255) DEFAULT NULL comment '百度小程序appid'");
    Db::query("alter table applet add baidu_appSecret varchar(255) DEFAULT NULL comment '百度小程序appSecret'");
    Db::query("alter table applet add baidu_xcxId varchar(255) DEFAULT NULL comment '百度小程序原始ID'");
    Db::query("alter table applet add ali_appID varchar(255) DEFAULT NULL comment '支付宝小程序appid'");
    Db::query("alter table applet add ali_appSecret varchar(255) DEFAULT NULL comment '支付宝小程序appSecret'");
    Db::query("alter table applet add ali_xcxId varchar(255) DEFAULT NULL comment '支付宝小程序原始ID'");
    Db::query("alter table applet add pay_time int(10) DEFAULT 0 comment '开通时长,时长套餐id'");
    Db::query("alter table applet add end_time int(11) DEFAULT 0 comment '到期时间'");
    Db::query("alter table applet add price Decimal(15,2) DEFAULT 0 comment '订单价格'");
    Db::query("alter table applet add type varchar(100) DEFAULT '' comment '业务类型'");
    Db::query("alter table applet add overdue_date int(11) not null default 0 comment '到期时间';");
    Db::query("alter table applet add combo_id int(11) not null default 0 comment '套餐id';");
}
$admin_count_01 = Db::query("SHOW COLUMNS FROM admin");
if (count($admin_count_01) < 18) {
    Db::query("alter table admin add type varchar(100) not null default '' comment '代理商可以使用的业务类型'");
    Db::query("alter table admin add balance Decimal(15,2) not null default 0 comment '代理商余额'");
    Db::query("alter table admin add is_del int(1) not null default 0 comment '是否被删除  0  没有   1  已被删除'");
}
$log = "
	CREATE TABLE IF NOT EXISTS `log` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `admin` int(10) NOT NULL COMMENT '操作人ID',
					  `time` int(11) NOT NULL DEFAULT 0 COMMENT '操作时间',
					  `text` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作内容',
					  `action` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '操作',
					  `level` int(1) NOT NULL DEFAULT 0 COMMENT '0 ordinary 1 commonly 2 important ',
					  `type` int(1) NOT NULL DEFAULT 0 COMMENT '操作类型  0 操作记录  1  充值记录',
					  PRIMARY KEY (`id`)
					)";
Db::query($log);
$time_combo = "
	CREATE TABLE IF NOT EXISTS `time_combo` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '套时长餐名称',
					  `pay_time` int(11) NOT NULL DEFAULT 0 COMMENT '套餐时间',
					  `free_time` int(11) NOT NULL DEFAULT 0 COMMENT '赠送时间',
					  `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态',
					  `qita` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '其他',
					  `createtime` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
					  `type` int(1) NOT NULL DEFAULT 1 COMMENT '套餐类型: 0 试用  1 正式使用',
					  PRIMARY KEY (`id`)
					)";
Db::query($time_combo);
$combo = "
	CREATE TABLE IF NOT EXISTS `combo` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '套餐名称',
					  `createtime` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
					  `status` int(1) NOT NULL DEFAULT 0 COMMENT '状态',
					  `combo_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '套餐简介',
					  `node_id` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '套餐权限ID',
					  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '套餐图标',
					  `wx_price` int(10) NOT NULL DEFAULT 0 COMMENT '套餐微信价格',
					  `baidu_price` int(10) NOT NULL DEFAULT 0 COMMENT '套餐百度价格',
					  `ali_price` int(10) NOT NULL DEFAULT 0 COMMENT '套餐支付宝价格',
					  PRIMARY KEY (`id`)
					)";
Db::query($combo);
$rule = "
	CREATE TABLE IF NOT EXISTS `rule` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(50) NOT NULL COMMENT '权限名称',
					  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '上级分类',
					  `sort` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
					  `createtime` int(11) NOT NULL COMMENT '创建时间',
					  `status` int(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`id`)
					)";
Db::query($rule);
$rule_count = Db::query("SELECT count(*) AS num FROM rule");
if ($rule_count[0]['num'] == 0) {
    Db::query("INSERT INTO `rule` (`id`, `name`, `pid`, `sort`, `createtime`, `status`) VALUES
(1, '总览', 0, 100, 1534149868, 0),
(2, '数据预览', 1, 100, 1534150053, 0),
(3, '内容', 0, 100, 1534150053, 0),
(4, '栏目管理', 3, 100, 1534150186, 0),
(5, '预约预定商品', 3, 100, 1534150186, 0),
(6, '秒杀商品', 3, 100, 1534150244, 0),
(7, '文章管理', 3, 100, 1534150264, 0),
(8, '多规格商品', 3, 100, 1534150264, 0),
(9, '组图管理', 3, 100, 1534150264, 0),
(10, '小程序管理', 3, 100, 1534150333, 0),
(11, '评论管理', 3, 100, 1534150333, 0),
(12, '文章底部菜单', 3, 100, 1534150373, 0),
(13, '菜单组', 12, 100, 1534150392, 0),
(14, '菜单', 12, 100, 1534150405, 0),
(15, '多栏目', 3, 100, 1534150405, 0),
(17, '管理', 15, 100, 1534150405, 0),
(18, '筛选条件', 15, 100, 1534150405, 0),
(19, '订单', 0, 100, 1534150405, 0),
(20, '限时秒杀订单', 19, 100, 1534150523, 0),
(21, '预约预定订单', 19, 100, 1534150523, 0),
(22, '付费视频订单', 19, 100, 1534150523, 0),
(23, '多规格订单', 19, 100, 1534150577, 0),
(24, '会员', 0, 100, 1534150577, 0),
(25, '会员管理', 24, 100, 1534150577, 0),
(26, '消费流水', 24, 100, 1534150577, 0),
(27, '全部', 26, 100, 1534150679, 0),
(28, '获取记录', 26, 100, 1534150702, 0),
(29, '消费记录', 26, 100, 1534150726, 0),
(30, '店内支付', 26, 100, 1534150752, 0),
(31, '积分流水', 24, 100, 1534150752, 0),
(32, '全部', 31, 100, 1534150752, 0),
(33, '充值获得', 31, 100, 1534150752, 0),
(34, '消费抵扣', 31, 100, 1534150752, 0),
(35, '签到获得', 31, 100, 1534150752, 0),
(36, '分享获得', 31, 100, 1534150879, 0),
(37, '店内抵扣', 31, 100, 1534150879, 0),
(38, '开卡记录', 24, 100, 1534150879, 0),
(39, '门店', 0, 100, 1534150879, 0),
(40, '基础设置', 39, 100, 1534150879, 0),
(41, '列表管理', 39, 100, 1534150879, 0),
(42, '营销', 0, 100, 1534151249, 0),
(43, '优惠劵', 42, 100, 1534151249, 0),
(45, '管理', 43, 100, 1534151249, 0),
(46, '设置', 43, 100, 1534151301, 0),
(47, '领取记录', 43, 100, 1534151301, 0),
(48, '核销密码', 42, 100, 1534151301, 0),
(49, '充值管理', 42, 100, 1534151301, 0),
(50, '充值管理', 49, 100, 1534151301, 0),
(51, '充值规则', 49, 100, 1534151301, 0),
(52, '分享积分', 42, 100, 1534151301, 0),
(53, '积分流水', 42, 100, 1534151301, 0),
(54, '多规格商品设置', 42, 100, 1534151301, 0),
(55, '会员卡设置', 42, 100, 1534151484, 0),
(56, '表单', 42, 100, 1534151504, 0),
(57, '万能预约信息列表', 56, 100, 1534151504, 0),
(58, '万能表单列表', 56, 100, 1534151612, 0),
(59, '系统预约信息列表', 56, 100, 1534151639, 0),
(60, '系统预约配置', 56, 100, 1534151639, 0),
(61, '提醒接收人', 56, 100, 1534151681, 0),
(62, '分销', 0, 100, 1534151708, 0),
(63, '分销设置', 62, 100, 1534151708, 0),
(64, '基本设置', 63, 100, 1534151708, 0),
(65, '上下级关系及分销资格', 63, 100, 1534151801, 0),
(66, '分销商申请协议', 63, 100, 1534151832, 0),
(67, '分销推广', 63, 100, 1534151859, 0),
(68, '分销商管理', 62, 100, 1534151889, 0),
(69, '分销订单', 62, 100, 1534151899, 0),
(70, '分销提现管理', 62, 100, 1534151925, 0),
(71, '提现申请', 70, 100, 1534151953, 0),
(72, '提现设置', 70, 100, 1534151989, 0),
(73, 'DIY', 0, 100, 1534152032, 0),
(74, 'DIY设置', 73, 100, 1534152074, 0),
(75, '默认首页', 73, 100, 1534152097, 0),
(76, '样式DIY', 75, 100, 1534152113, 0),
(77, '幻灯片设置', 75, 100, 1534152129, 0),
(78, '开屏广告', 75, 100, 1534152155, 0),
(79, '弹窗广告', 75, 100, 1534152175, 0),
(80, '首页广告', 75, 100, 1534152189, 0),
(81, '导航设置', 75, 100, 1534152204, 0),
(82, '自定义导航', 75, 100, 1534152220, 0),
(83, '一键模板', 75, 100, 1534152238, 0),
(84, 'DIY布局', 73, 100, 1534152238, 0),
(85, '系统', 0, 100, 1534152286, 0),
(86, '基础设置', 85, 100, 1534152299, 0),
(87, '公司介绍', 85, 100, 1534152313, 0),
(88, '个人中心', 85, 100, 1534152327, 0),
(89, '底部菜单', 85, 100, 1534152347, 0),
(90, '新版菜单', 89, 100, 1534152370, 0),
(91, '老板菜单', 89, 100, 1534152389, 0),
(92, '版权管理', 85, 100, 1534152410, 0),
(93, '版权内容', 85, 100, 1534152435, 0),
(94, '邮箱配置', 85, 100, 1534152457, 0),
(95, '模板消息', 85, 100, 1534152457, 0),
(96, '支付通知', 95, 100, 1534152503, 0),
(97, '系统表单通知', 95, 100, 1534152520, 0),
(98, '预约通知', 95, 100, 1534152536, 0),
(99, '多规格订单通知', 95, 100, 1534152536, 0),
(100, '拼团订单通知', 95, 100, 1534152587, 0),
(101, '会员卡开通通知', 95, 100, 1534152609, 0),
(102, '远程附件', 85, 100, 1534152628, 0),
(103, '上传审核', 85, 100, 1534152650, 0),
(104, '模块', 0, 100, 1534152665, 0),
(105, '应用中心', 104, 100, 1534152685, 0),
(106, '拼团', 104, 100, 1534152685, 0),
(107, '拼团设置', 106, 100, 1534152721, 0),
(108, '栏目设置', 106, 100, 1534152738, 0),
(109, '商品管理', 106, 100, 1534152756, 0),
(110, '订单管理', 106, 100, 1534152772, 0),
(111, '成团管理', 106, 100, 1534152787, 0),
(112, '退款管理', 106, 100, 1534152802, 0),
(113, '餐饮', 104, 100, 1534152833, 0),
(114, '基础设置', 113, 100, 1534152855, 0),
(115, '分类管理', 113, 100, 1534152871, 0),
(116, '桌号管理', 113, 100, 1534152890, 0),
(117, '商品管理', 113, 100, 1534152908, 0),
(118, '订单管理', 113, 100, 1534152922, 0),
(119, '打印机设置', 113, 100, 1534152937, 0),
(120, '点餐通知', 113, 100, 1534152952, 0),
(121, '积分兑换', 104, 100, 1534152985, 0),
(122, '栏目管理', 121, 100, 1534153003, 0),
(123, '商品管理', 121, 100, 1534153017, 0),
(124, '订单管理', 121, 100, 1534153032, 0),
(125, '积分兑换通知', 121, 100, 1534153049, 0),
(126, '积分签到', 104, 100, 1534153074, 0),
(127, '基础设置', 126, 100, 1534153092, 0),
(128, '签到管理', 126, 100, 1534153108, 0),
(129, '手机客服', 104, 100, 1534153140, 0),
(130, '全能小程序', 104, 100, 1534153154, 0),
(131, '分类管理', 130, 100, 1534153171, 0),
(132, '店铺管理', 130, 100, 1534153186, 0),
(133, '商品管理', 130, 100, 1534153200, 0),
(134, '订单管理', 130, 100, 1534153213, 0),
(135, '提现管理', 130, 100, 1534153236, 0),
(136, '系统设置', 130, 100, 1534153250, 0),
(137, '帮助', 0, 100, 1534153264, 0),
(138, '满额立减', 42, 100, 1534325951, 0),
(139, '微论坛', 104, 100, 1534325951, 0),
(140, '分类管理', 139, 100, 1534325951, 0),
(141, '发布管理', 139, 100, 1534325951, 0),
(142, '评论管理', 139, 100, 1534325951, 0),
(143, '相关设置', 139, 100, 1534325951, 0),
(144, '论坛流水', 25, 100, 1534325951, 0);");
}
/* 2.28  更新数据库字段默认值  180905 start */
Db::query("ALTER TABLE `ims_sudu8_page_remote` CHANGE `imgstyle` `imgstyle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图片样式接口';");
Db::query("ALTER TABLE `ims_sudu8_page_pic` CHANGE `uniacid` `uniacid` INT(11) NULL;");
Db::query("ALTER TABLE `ims_sudu8_page_pic` CHANGE `gid` `gid` INT(11) NULL;");
/* 2.28  更新数据库字段默认值 end*/
/* 2.32  摇一摇插件 20180908 start*/
//权限表插入最新数据  $rule_count[0]['num']  数据条数
if ($rule_count[0]['num'] == 142) {
    Db::query("INSERT INTO `rule` (`id`, `name`, `pid`, `sort`, `createtime`, `status`) VALUES
		(145, '摇一摇抽奖全能小程序', 104, 100, 1535965758, 0),
		(146, '活动管理', 145, 100, 1535965827, 0),
		(147, '积分规则', 42, 100, 1536385921, 0);");
}
if ($rule_count[0]['num'] == 145) {
    Db::query("INSERT INTO `rule` (`id`, `name`, `pid`, `sort`, `createtime`, `status`) VALUES
		(148, '申请记录', 42, 100, 1535965758, 0);");
}
if ($rule_count[0]['num'] == 146) {
    Db::query("INSERT INTO `rule` (`id`, `name`, `pid`, `sort`, `createtime`, `status`) VALUES
		(149, '员工管理', 39, 100, 1537950600, 0);");
}
$lottery_activity = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_lottery_activity` (
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
					  PRIMARY KEY (`id`)
					)";
Db::query($lottery_activity);
$lottery_share = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_lottery_share` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `aid` int(11) NOT NULL COMMENT '活动id',
					  `uid` int(11) NOT NULL COMMENT '用户id',
					  `createtime` int(11) NOT NULL COMMENT '分享时间',
					  `flag` int(1) NOT NULL COMMENT '0未成功1成功',
					  PRIMARY KEY (`id`)
					)";
Db::query($lottery_share);
$lottery_prize = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_lottery_prize` (
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
					  PRIMARY KEY (`id`)
					)";
Db::query($lottery_prize);
$lottery_record = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_lottery_record` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `aid` int(11) NOT NULL COMMENT '活动id',
					  `uid` int(11) NOT NULL COMMENT '中奖人id',
					  `pid` int(11) DEFAULT NULL COMMENT '奖品id',
					  `createtime` int(11) NOT NULL COMMENT '抽奖时间',
					  `status` int(1) NOT NULL COMMENT '0未中奖1已中奖2已领',
					  PRIMARY KEY (`id`)
					)";
Db::query($lottery_record);
$lottery_score_get = "
	CREATE TABLE IF NOT EXISTS `ims_sudu8_page_score_get` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uniacid` int(11) NOT NULL,
					  `title` varchar(255) NOT NULL COMMENT '标题',
					  `descp` varchar(255) NOT NULL COMMENT '简介',
					  `score` float NOT NULL DEFAULT '0' COMMENT '积分数',
					  `link` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
					  `flag` int(1) NOT NULL COMMENT '0不开启 1开启',
					  `fixed` int(2) DEFAULT NULL COMMENT '系统自动添加的几条',
					  PRIMARY KEY (`id`)
					)";
Db::query($lottery_score_get);
/* 2.32  摇一摇插件 20180908 end*/
/* 修改数据库rule微论坛为微同城、论坛流水为微同城流水 20180917 */
Db::query("UPDATE `rule` SET `name` = '微同城' WHERE `rule`.`id` = 139;");
Db::query("UPDATE `rule` SET `name` = '微同城流水' WHERE `rule`.`id` = 144;");
/* 删除forum_release字段stick_days stick_money 20180920*/
$stick_days = Db::query("show columns from `ims_sudu8_page_forum_release` like 'stick_days' ");
if ($stick_days) {
    Db::query("ALTER TABLE `ims_sudu8_page_forum_release` DROP `stick_days`;");
}
$stick_money = Db::query("show columns from `ims_sudu8_page_forum_release` like 'stick_money' ");
if ($stick_money) {
    Db::query("ALTER TABLE `ims_sudu8_page_forum_release` DROP `stick_money`;");
}
$forum_reply_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_forum_reply");
if (count($forum_reply_01) < 8) {
    Db::query("ALTER table ims_sudu8_page_forum_reply ADD likesNum int(11) DEFAULT 0");
}
//微同城置顶表20180920 v2.40
$forum_stick = "
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_forum_stick` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `uniacid` int(11) NOT NULL,
				  `rid` int(11) NOT NULL COMMENT '发布id',
				  `stick` int(1) NOT NULL COMMENT '是否置顶 1置顶 2不置顶',
				  `stick_days` int(11) NOT NULL COMMENT '置顶时长',
				  `stick_money` decimal(10,2) NOT NULL COMMENT '置顶费用',
				  `stick_time` datetime NOT NULL COMMENT '置顶时间',
				  `stick_status` int(1) NOT NULL COMMENT '置顶状态 1启用 2不启用',
				  PRIMARY KEY (`id`)
				)";
Db::query($forum_stick);
//会员卡添加审核和万能表单 20180921 v2.41
$vip_config_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_vip_config");
if (count($vip_config_01) < 9) {
    Db::query("ALTER table ims_sudu8_page_vip_config ADD formid int(11) DEFAULT 0");
    Db::query("ALTER table ims_sudu8_page_vip_config ADD shenhe int(1) DEFAULT 2");
}
$vip_apply = "
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_vip_apply` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `openid` varchar(255) NOT NULL COMMENT '申请人',
				  `uniacid` int(11) UNSIGNED NOT NULL,
				  `vipid` mediumtext NOT NULL COMMENT 'vip卡号',
				  `fid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '提交表单信息id',
				  `formid` varchar(255) NOT NULL COMMENT '模板消息formid',
				  `flag` tinyint(1) UNSIGNED NOT NULL DEFAULT '3' COMMENT '3未审核 1通过  2不通过',
				  `applytime` datetime NOT NULL COMMENT '申请时间',
				  `examinetime` datetime NOT NULL COMMENT '审核时间',
				  `beizhu` mediumtext NOT NULL COMMENT '审核不通过原因',
				  PRIMARY KEY (`id`)
				)";
Db::query($vip_apply);
//文章底部菜单添加文字颜色 20180921 v2.41
$art_navlist_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_art_navlist");
if (count($art_navlist_01) < 10) {
    Db::query("ALTER table ims_sudu8_page_art_navlist ADD textcolor varchar(32) NOT NULL");
}
//万能表单结果 20180921 v2.41
$formcon_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_formcon");
if (count($formcon_01) < 9) {
    Db::query("ALTER table ims_sudu8_page_formcon ADD openid varchar(255) NOT NULL");
    Db::query("ALTER table ims_sudu8_page_formcon ADD formid varchar(255) NOT NULL");
    Db::query("ALTER table ims_sudu8_page_formcon ADD fid int(11) NOT NULL");
    Db::query("ALTER table ims_sudu8_page_formcon ADD source varchar(65535) NOT NULL");
}
Db::query("ALTER TABLE `ims_sudu8_page_com_about` CHANGE `qq` `qq` varchar(255) NOT NULL");

$video_pay_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_video_pay");
if (count($video_pay_01) < 8) {
    Db::query("ALTER table ims_sudu8_page_video_pay ADD type int(1) NOT NULL DEFAULT '1'");
}

//20180927  2.42  修改DIY模板下页面id字段长度
Db::query("ALTER TABLE `ims_sudu8_page_diypagetpl` CHANGE `pageid` `pageid` varchar(1000) NOT NULL");
Db::query("ALTER TABLE `ims_sudu8_page_diypagetpl_sys` CHANGE `pageid` `pageid` varchar(1000) NOT NULL");
//员工表添加
$staff ="
CREATE TABLE IF NOT EXISTS `ims_sudu8_page_staff` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `uniacid` int(11) UNSIGNED DEFAULT NULL COMMENT '小程序ID',
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
				  PRIMARY KEY (`id`)
				)";
Db::query($staff);

$page_order_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_order");
if (count($page_order_01) < 28) {
    Db::query("ALTER table ims_sudu8_page_order ADD nav int(1) NOT NULL COMMENT '1发货 2到店自取'");
    Db::query("ALTER table ims_sudu8_page_order ADD address int(11) NOT NULL COMMENT '地址id'");
    Db::query("ALTER table ims_sudu8_page_order ADD formid int(11) NOT NULL DEFAULT '0' COMMENT '万能表单id'");
    Db::query("ALTER table ims_sudu8_page_order ADD prepayid varchar(255) DEFAULT NULL COMMENT '模板消息prepayid'");
    Db::query("ALTER table ims_sudu8_page_order ADD tsid int(11) NOT NULL DEFAULT '0' COMMENT 'tableselect_id'");
    Db::query("ALTER table ims_sudu8_page_order ADD th_orderid varchar(255) DEFAULT NULL COMMENT '退货订单号'");
    Db::query("ALTER table ims_sudu8_page_order ADD qxbeizhu varchar(255) DEFAULT NULL COMMENT '商家取消备注'");
    Db::query("ALTER table ims_sudu8_page_order ADD appoint_date int(11) DEFAULT '0' COMMENT '预约发货时间'");
    Db::query("ALTER table ims_sudu8_page_order ADD form_id varchar(255) DEFAULT NULL COMMENT '模板消息formid'");
    Db::query("ALTER table ims_sudu8_page_order ADD emp_id int(11) DEFAULT NULL COMMENT '员工id'");
    Db::query("ALTER table ims_sudu8_page_order ADD modify_info varchar(255) DEFAULT NULL COMMENT '预约信息修改'");
    Db::query("ALTER table ims_sudu8_page_order ADD kuaidi varchar(64) DEFAULT NULL COMMENT '快递'");
    Db::query("ALTER table ims_sudu8_page_order ADD kuaidihao varchar(64) DEFAULT NULL COMMENT '快递号'");
    Db::query("ALTER table ims_sudu8_page_order ADD qx_formid varchar(255) DEFAULT NULL COMMENT '取消订单formid'");
    Db::query("ALTER table ims_sudu8_page_order ADD pay_price float NOT NULL DEFAULT '0' COMMENT '微信支付金额'");
    Db::query("ALTER table ims_sudu8_page_order ADD dkscore float NOT NULL DEFAULT '0' COMMENT '抵扣积分'");
    Db::query("ALTER table ims_sudu8_page_order ADD hxinfo varchar(255) COMMENT '核销信息'");
} 

$page_order_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_order");
if (count($page_order_01) < 23) {
   Db::query("ALTER table ims_sudu8_page_pt_order ADD hxinfo varchar(255) COMMENT '核销信息'");
} 


$pt_pro_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
if (count($pt_pro_01) < 26) {
    Db::query("ALTER table ims_sudu8_page_pt_pro ADD stores varchar(255) NULL DEFAULT NULL");
}