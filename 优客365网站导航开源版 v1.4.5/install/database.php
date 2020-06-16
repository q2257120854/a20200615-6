<?php 
require('config.php'); 
define('ROOT_PATH', str_replace("\\", '/', substr(__FILE__, 0, strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR))).'/');

require('function.php');

//判断是否已经安装过
if (file_exists(ROOT_PATH.'data/install.lock')) {
	failure('你已经安装过本系统！<br />如果还继续安装，请先删除data/install.lock，再继续');
	exit;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>优客365网址导航系统 安装向导</title>
<link href="./style/style.css" rel="stylesheet" type="text/css" />
<link href="/public/layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="/public/steps/steps.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="main">
	<?php require('include/header.php'); ?>
	<div class="central">
	<div class="ui-steps steps-auto">
  <div class="wrap">
    <div class="finished">
      <label><span class="round">1<i class="ui-icon icon-pc-right"></i></span><span>安装检测</span></label><i class="triangle-right-bg"></i><i class="triangle-right"></i>
    </div>
  </div>
  <div class="wrap">
    <div class="finished">
      <label><span class="round">2</span><span>使用协议</span></label><i class="triangle-right-bg"></i><i class="triangle-right"></i>
    </div>
  </div>
  <div class="wrap">
    <div class="finished">
      <label><span class="round">2</span><span>初始配置</span></label><i class="triangle-right-bg"></i><i class="triangle-right"></i>
    </div>
  </div>
  <div class="wrap">
    <div class="todo">
      <label><span class="round">3</span><span>安装成功</span></label>
    </div>
  </div>
</div>
		<div class="right">
			<form action="install.php" method="post" name="form" id="form">
            	<div class="right_title">初始配置</div> 
            	<div style="font-size: 14px; line-height: 25px; padding: 20px 0; text-align: left;">
				<table class="layui-table" lay-size="sm" >
				
					<tr>
                    	<td width="14%">数据库类型：</td>
                    	<td width="37%"><input type="text" class="setup_input" name="DB_TYPE" value="mysql"  disabled="disabled" /></td>
                    	<td width="49%" class="lightcolor">数据库类型，不需要修改 </td>
					</tr>
					<tr>
					
                    	<td width="14%">数据库地址：</td>
                    	<td width="37%"><input type="text" class="setup_input" name="DB_HOST" value="localhost" /></td>
                    	<td width="49%" class="lightcolor">数据库服务器地址，一般为localhost </td>
					</tr>
				
					<tr><th colspan="3"></th></tr>
                    	<td width="14%">数据库端口：</td>
                    	<td width="37%"><input type="text" class="setup_input" name="DB_PORT" value="3306" /></td>
                    	<td width="49%" class="lightcolor">数据库端口，一般为3306 </td>
					</tr>
				
					<tr>
						<td>数据库名称：</td>
                    	<td><input type="text" class="setup_input" name="DB_NAME" value="youke365" /></td>
                    	<td class="lightcolor"> 请先建立数据库</td>
					</tr>
				
					<tr>
                    	<td>数据库账号：</td>
                    	<td><input type="text" class="setup_input" name="DB_USER" value="root" /></td>
                    	<td class="lightcolor"> 您的MySQL 用户名 </td>
					</tr>
				
					<tr>
                    	<td>数据库密码：</td>
                    	<td><input type="password" class="setup_input" name="DB_PASS" value="" /></td>
                    	<td class="lightcolor"> 您的MySQL密码</td>
					</tr>
				
					<tr>
						<td>数据表前缀：</td>
                    	<td><input type="text" class="setup_input" name="TABLE_PREFIX" value="yk365_" /></td>
                    	<td class="lightcolor">同一数据库安装多个程序请设置前缀</td>
					</tr>
			
				</table>
                </div>
                <div class="right_title">帐号设置</div> 
				<div style="font-size: 14px; line-height: 25px; padding: 20px 0; text-align: left;">
				
				<table class="layui-table">
						<colgroup>
							<col width="100">
							<col width="150">
							<col >
						</colgroup>

						<tbody>
							<tr>
							<td>管理员账号</td>
							<td><input type="text" class="setup_input" name="username" value="admin" /></td>
							<td>管理员帐号</td>
							</tr>
							<tr>
							<td>登录密码</td>
							<td><input type="text" class="setup_input" name="pass" value="123456" /></td>
							<td>登录密码</td>
							</tr>
							<tr>
							<td>邮箱</td>
							<td><input type="text" class="setup_input" name="email" value="admin@qq.com" /></td>
							<td>邮箱帐号，格式为admin@qq.com</td>
							</tr>
						</tbody>
						</table>


                </div>
				<div class="agree"  align="center">
				<a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary" />返回上一步</a>
				<input type="submit" class="layui-btn layui-btn-normal" hidefocus="true" value="立即安装" />
                </div>
			</form>
		</div>
	</div>
</div>
<?php require('include/footer.php'); ?>
</body>
</html>