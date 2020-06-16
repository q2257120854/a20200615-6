<?php

$_GET['m'] = 'Admin';
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('PHP 版本必须大于等于5.3.0 !');

define('DIR_SECURE_CONTENT', 'powered by http://www.aikenwu.com/');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

define('APP_PATH','./Application/');
require './#ThinkPHP/ThinkPHP.php';