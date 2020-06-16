<?php
/**
 * 安装向导
 */
header('Content-type:text/html;charset=utf-8');
// 检测是否安装过
if (file_exists('../data/install.lock')) {
    echo '你已经安装过该系统，请删除./install/文件';
    die;
}
define('VERSION', '2.55');
// 同意协议页面
if (@!isset($_GET['c']) || @$_GET['c'] == 'agreement') {
    require './agreement.html';
}
// 检测环境页面
if (@$_GET['c'] == 'test') {
    require './test.html';
}
// 创建数据库页面
if (@$_GET['c'] == 'create') {
    require './create.html';
}
// 安装成功页面
if (@$_GET['c'] == 'success') {
    // 判断是否为post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < 5; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }


        $data = $_POST;
        if (!preg_match("/^[a-zA-Z]{1}([0-9a-zA-Z]|[._]){4,19}$/", $data['admin_user'])) {
            die("<script>alert('后台管理用户名不符合规范：至少包含4个字符，需以字母开头');history.go(-1)</script>");
        }
       
            // if (!preg_match("/^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,22}$/", $data['admin_pass'])) {
            //     die("<script>alert('登录密码至少包含6个字符。可使用字母，数字和符号。');history.go(-1)</script>");
            // }
            if ($data['admin_pass'] != $data['admin_pass2']) {
                die("<script>alert('两次输入的密码不一致');history.go(-1)</script>");
       
            }
            $_SESSION['adminusername'] = $data['admin_user'];
            // 生成管理员
        $username = $data['admin_user'];
        $salt='xLhiuLqn'. $password;
        $pass = md5($data['admin_pass'].$salt);
        $create_time = time();
        $code = $data['code'];
           
            $link = new mysqli($data['DB_HOST'], $data['DB_USER'], $data['DB_PWD']);
           
            // 获取错误信息
            $error = $link->connect_error;
            if (!is_null($error)) {
                // 转义防止和alert中的引号冲突
                $error = addslashes($error);
                die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
            }
            // 设置字符集
            $link->query("SET NAMES 'utf8'");
            $link->server_info > 5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
            // 创建数据库并选中
            if (!$link->select_db($data['DB_NAME'])) {
                $create_sql = 'CREATE DATABASE IF NOT EXISTS ' . $data['DB_NAME'] . ' DEFAULT CHARACTER SET utf8;';
                $link->query($create_sql) or die('创建数据库失败');
                $link->select_db($data['DB_NAME']);
            }
            // 导入sql数据并创建表
            $shujuku_str = file_get_contents('./laysns.sql');
            $sql_array = preg_split("/;[\r\n]+/", str_replace('ls_', $data['DB_PREFIX'], $shujuku_str));
            foreach ($sql_array as $k => $v) {
                if (!empty($v)) {
                    $link->query($v);
                }
            }
            $table_admin = $data['DB_PREFIX'] . "admin_user";
            $link->query("UPDATE $table_admin SET username = '{$username}', password = '{$pass}',salt='{$salt}',security_code='{$code}' , status=1,create_time = '{$create_time}' WHERE id = 1");
  
            $table_user = $data['DB_PREFIX'] . "user";
            $link->query("UPDATE $table_user SET username = '{$username}', password = '{$pass}',salt='{$salt}' , status=1,regtime = '{$create_time}' WHERE id = 1");
  
            $link->close();

        $db_str = <<<php
<?php

return [
    'type'            => 'mysql',
    'hostname'        => '{$data['DB_HOST']}',
    'database'        => '{$data['DB_NAME']}',
    'username'        => '{$data['DB_USER']}',
    'password'        => '{$data['DB_PWD']}',
    'hostport'        => '{$data['DB_PORT']}',
    'dsn'             => '',
    'params'          => [],
    'charset'         => 'utf8',
    'prefix'          => '{$data['DB_PREFIX']}',
    'debug'           => true,
    'deploy'          => 0,
    'rw_separate'     => false,
    'master_num'      => 1,
    'slave_no'        => '',
    'fields_strict'   => true,
    'auto_timestamp'  => false,
    'datetime_format' => 'Y-m-d H:i:s',
    'sql_explain'     => false,
    'builder'         => '',
    'query'           => '\\think\\db\\Query',
    'resultset_type'  => '\\think\\Collection'
];
php;
        // 创建数据库链接配置文件

        $fp = fopen('../application/database.php', "w");

        fputs($fp, $db_str);

        fclose($fp);

        $db_str = <<<php
<?php

return [

        		'id'             => '',
        		// SESSION_ID的提交变量,解决flash上传跨域
        		'var_session_id' => '',
        		// SESSION 前缀
        		'prefix'         => '{$password}',
        		// 驱动方式 支持redis memcache memcached
        		'type'           => '',
        		// 是否自动开启 SESSION
        		'auto_start'     => true,
        		'secure'         => false,


];
php;
        $fp = fopen('../application/extra/session.php', "w");

        fputs($fp, $db_str);

        fclose($fp);

        $db_str = <<<php
<?php

return [


        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' =>'{$password}',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,

];
php;

        $fp = fopen('../application/extra/cache.php', "w");

        fputs($fp, $db_str);

        fclose($fp);
        $db_str = <<<php
<?php

return [

        // cookie 名称前缀
        'prefix'    =>'{$password}',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
];
php;

        $fp = fopen('../application/extra/cookie.php', "w");

        fputs($fp, $db_str);

        fclose($fp);
        @touch('../data/install.lock');
        require './success.html';
    }

}
