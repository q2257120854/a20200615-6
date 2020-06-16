<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.yunziyuan.com.cn                     */
/*  官方论坛：http://www.yunziyuan.com.cn                        */                           
/**************************************************************/
error_reporting(0);
date_default_timezone_set("PRC");

// 升级文件保存目录

define('UPDATE_DIR',ROOT_PATH.'data/update/'); //默认 上级 data/update/  ,升级sql 放在此目录


/*******以下信息请勿修改********************************************* */ 

define('UPDATE_API_URL',"http://auth.youke365.site/update.php");  // 服务端通信地址

/***  需要服务端同步设置的常量 ***/
define('CLIENT_API_KEY','youke365'); //如服务端没有修改，客户端可不修改。用户不得随意修改，通信密钥，客户端与服务端必须一致，否则升级信息无法解密





