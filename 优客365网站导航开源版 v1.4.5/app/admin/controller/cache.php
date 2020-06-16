<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.yunziyuan.com.cn                     */
/*  官方论坛：http://www.yunziyuan.com.cn                        */                           
/**************************************************************/

if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';
$fileurl = url('cache');
$tempfile = 'cache.html';
options_cache();
links_cache();
advers_cache();
categories_cache();
archives_cache();
stats_cache();
del_dir(ROOT_PATH.'runtime/');//更新缓存目录
msgbox('所有缓存更新成功！');

