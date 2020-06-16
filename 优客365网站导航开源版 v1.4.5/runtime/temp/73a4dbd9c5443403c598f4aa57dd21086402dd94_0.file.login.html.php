<?php
/* Smarty version 3.1.31, created on 2019-12-13 16:16:22
  from "D:\WWW\youke365_free\app\admin\view\login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df348d68e62e2_78470891',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73a4dbd9c5443403c598f4aa57dd21086402dd94' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\login.html',
      1 => 1524891761,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df348d68e62e2_78470891 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</title>
<link href="/public/admin/skin/css/global.css" rel="stylesheet" type="text/css" />
<link href="/public/admin/skin/css/login.css" rel="stylesheet" type="text/css" />
</head>

<body style="background-image:url('/public/admin/skin/images/bg.jpg')">
<div id="loginbox">
	<h2>后台管理中心</h2>
    <div>
    <form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
    	<div id="formbox">
		<table>
        	<tr>
				<th>用户名：</th>
				<td><input name="username" type="text" class="ipt" id="username" size="20" maxlength="25" autocomplete="off" /></td>
			</tr>
			<tr>
				<th>登录密码：</th>
				<td><input name="pass" type="password" class="ipt" id="pass" size="20" maxlength="25" /></td>


			</tr>

			<tr>
			<th>验证码：</th>
<td>
<input name="code" type="text" class="ipt" id="code" size="20" maxlength="25" style="width:85px" />
  <span id="mycode"><img  title="点击刷新" src="<?php echo url('member/code');?>
" align="absbottom" onclick="this.src='<?php echo url("member/code",array('type'=>'code'));?>
?'+Math.random();"></span></li>
</td>
			</tr>
		</table>
        </div>
    	<div id="btnbox">
		<input name="act" type="hidden" id="act" value="login">
		<input name="submit" type="submit" class="btn" value="登 陆">&nbsp;
    	</div>
    </form>
    <div class="copyright"> Powered by <a href="http://www.youke365.site" target="_blank">Youke365</a> </div>
    </div>
</div>
</body>
</html><?php }
}
