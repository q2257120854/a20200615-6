<?php
/* Smarty version 3.1.31, created on 2019-12-13 17:36:48
  from "D:\WWW\youke365_free\themes\pc\default\member\msgbox.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df35bb04a84d9_65561389',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcb38d4022a6a6a5fc9c1620e1443101b724d3d7' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\member\\msgbox.html',
      1 => 1524652335,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df35bb04a84d9_65561389 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/public/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @constant('tpl');?>
skin/<?php echo $_smarty_tpl->tpl_vars['cfg']->value['default_skin'];?>
/member.css" rel="stylesheet" type="text/css" />
<style type="text/css">
* {margin: 0px; padding: 0px;}
body {background:#F2F2F2; font: 12px/23px Verdana, Arial, Helvetica, sans-serif;}
a {color:#0D95C9; text-decoration: none;}
a:hover {color: #f30; text-decoration: underline;}

</style>
</head>

<body>
<div id="msgbox">
	<h2 class="title-msg"><i class="fa fa-volume-up" aria-hidden="true"></i> 操作提示</h2>
    <div class="content"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
    <div class="link"><strong>系统 <span id="seconds" >2</span> 秒后将自动跳转</strong><br /><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
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
