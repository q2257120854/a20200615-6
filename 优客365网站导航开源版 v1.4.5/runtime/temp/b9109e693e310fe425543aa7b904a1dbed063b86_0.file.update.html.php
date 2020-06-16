<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:25:49
  from "D:\WWW\youke365_free\themes\pc\default\home\update.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df304bd3a20e5_63544421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b9109e693e310fe425543aa7b904a1dbed063b86' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\update.html',
      1 => 1576207547,
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
function content_5df304bd3a20e5_63544421 (Smarty_Internal_Template $_smarty_tpl) {
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
	<div class="mainbox">
    	<div class="mainbox-left">
            <div class="clearfix listbox">
				<h3 class="listbox-title">最新收录</h3>
				<ul class="sitelist">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['websites']->value, 'w', false, NULL, 'list', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['w']->value) {
?>
                	<li><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_link'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_pic'];?>
" width="120" height="95" alt="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
" class="thumb" /></a><div class="info"><h3><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
</a> 
                	

                	</h3><p><?php echo $_smarty_tpl->tpl_vars['w']->value['web_intro'];?>
</p><cite><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_url'];?>
" target="_blank" class="visit" onClick="clickout(<?php echo $_smarty_tpl->tpl_vars['w']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['w']->value['web_url'];?>
</a> - <?php echo $_smarty_tpl->tpl_vars['w']->value['web_ctime'];?>
</cite></div></li>
                	<?php
}
} else {
?>

                	<li>该目录下无任何内容！</li>
                	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
				<div class="clearfix showpage"><?php echo $_smarty_tpl->tpl_vars['showpage']->value;?>
</div>
			</div>
		</div>
		<div class="mainbox-right">

            <!-- 广告 开始 250*200-->
            <div class="ad250x200"><?php echo get_adcode(17);?>
</div>
            <!-- 广告 结束 250*200-->
                    <div class="blank10"></div>
			<div class="webbox">
				<div class="webbox-title">推荐站点</div>
				<ul class="webbox-list">
                   	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,5,true), 'best');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['best']->value) {
?>
                   	<li><h3><a href="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
</a></h3><p><?php echo $_smarty_tpl->tpl_vars['best']->value['web_intro'];?>
</p><cite><a href="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_url'];?>
" target="_blank" class="visit" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['best']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['best']->value['web_url'];?>
</a></cite></li>
                   	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
			</div>

		</div>
	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
