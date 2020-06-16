<?php
/* Smarty version 3.1.31, created on 2019-12-13 18:35:09
  from "D:\WWW\youke365_free\themes\pc\default\home\feedback.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3695d637b92_37505384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5fb0da803bb5717db008f5ef6768854d9b0979fb' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\feedback.html',
      1 => 1524450783,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:base.html' => 1,
    'file:topbar.html' => 1,
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3695d637b92_37505384 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['site_keywords']->value;?>
" />
<meta name="Description" content="<?php echo $_smarty_tpl->tpl_vars['site_description']->value;?>
" />
<meta name="Copyright" content="Powered By www.youke365.site" />
<?php $_smarty_tpl->_subTemplateRender("file:base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</head>
<body>
<?php $_smarty_tpl->_subTemplateRender("file:topbar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="wrapper">
	<div class="subbox">
    	<div class="subbox-title">意见/建议反馈</div>
    	<div class="subbox-form">
			<form name="fbfrom" id="fbfrom" method="post" action="">
            	<ul class="formbox">
					<li class="clearfix"><strong>用户昵称：</strong><p><input type="text" name="nick" id="nick" class="fipt" size="50" maxlength="50" /></p></li>
					<li class="clearfix"><strong>电子邮件：</strong><p><input type="text" name="email" id="email" class="fipt" size="50" maxlength="50" /></p></li>
					<li class="clearfix"><strong>意见内容：</strong><p><textarea name="content" id="content" cols="60" rows="8" class="fipt"></textarea></p></li>
					<li class="clearfix"><strong>验证代码：</strong><p><input type="text" name="checkcode" id="checkcode" class="fipt" size="6" maxlength="6"
					  /><span id="mycode" class="tips"><img  title="点击刷新" src="<?php echo url('member/code');?>
" align="absbottom" 
					onclick="this.src='<?php echo url("member/code",array('type'=>'code'));?>
?'+Math.random();"></img></span></p></li>
					<li class="clearfix"><strong>&nbsp;</strong><p><input type="hidden" name="action" id="action" value="send"><input type="submit" name="submit" class="fbtn" value="提 交">&nbsp; <input type="reset" name="reset" class="fbtn" value="重 填"></p></li>
            	</ul>
			</form>
		</div>
	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
