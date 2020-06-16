<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:21:03
  from "D:\WWW\youke365_free\app\admin\view\msgbox.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3039f1d3b16_85806314',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '240156c72ebebb02a2a35778affa2b5f29d2c567' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\msgbox.html',
      1 => 1492157448,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df3039f1d3b16_85806314 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/public/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
* {margin: 0px; padding: 0px;}
body {background:#F2F2F2; font: 12px/23px Verdana, Arial, Helvetica, sans-serif;}
a {color:#0D95C9; text-decoration: none;}
a:hover {color: #f30; text-decoration: underline;}
.msgbox {border: solid 1px #FBFBFB;
    margin: 145px auto 0px auto;
    width: 450px;
    box-shadow: 0px 6px 14px #CDC8C8;}
.title {background: #3DB3F7; color: #fff; font: bold 16px normal; padding: 16px;}
.content {background: #fff; color:#5A5858;font-size: 17px;padding: 40px;}
.link {background: #fff; color:#E26902; line-height: 20px; padding: 3px; text-align: center;}
</style>
</head>

<body>
<div class="msgbox">
	<h2 class="title"><i class="fa fa-volume-up" aria-hidden="true"></i> 系统提示！</h2>
    <div class="content"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
    <div class="link"><strong>系统 <span id="seconds" style="color:#3DB3F7;">2</span> 秒后将自动跳转</strong><br /><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
">如果您的浏览器没有自动跳转，请点击这里...</a></div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
var i = 3;
var retime = setInterval(function() {
	i = i - 1;
	if (i < 0){
		window.location.href= '<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
';
		window.clearInterval(retime);
		return;
	}
	document.getElementById("seconds").innerHTML = i;
}, 1000);
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
