<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:34:32
  from "D:\WWW\youke365_free\themes\pc\default\home\top.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df306c8c9aba5_39573148',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd2a499cf0aab4aa11aeb00686973aa8bfb956a19' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\top.html',
      1 => 1523442182,
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
function content_5df306c8c9aba5_39573148 (Smarty_Internal_Template $_smarty_tpl) {
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
    	<div class="mainbox-left" style="width:1200px">
            <div class="topsite" style="margin-right: 10px;">
				<div class="topsite-title">入站排行榜 TOP10</div>
				<ul class="topsite-list">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,10,false,'instat'), 'instat', false, NULL, 'instat_website', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['instat']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_instat_website']->value['iteration']++;
?>
					<li><span><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_instat_website']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_instat_website']->value['iteration'] : null);?>
</span>
					<a href="<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_name'];?>
" class="site_title"><?php echo $_smarty_tpl->tpl_vars['instat']->value['web_name'];?>
</a> - <em><a href="<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_url'];?>
" class="visit" target="_blank" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['instat']->value['web_url'];?>
</a></em></li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
            </div>
          <!--   <div class="topsite">
				<div class="topsite-title">出站排行榜 TOP10</div>
				<ul class="topsite-list">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,10,false,'outstat'), 'outstat', false, NULL, 'outstat_website', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['outstat']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_outstat_website']->value['iteration']++;
?>
					<li><span><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_outstat_website']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_outstat_website']->value['iteration'] : null);?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_link'];?>
" class="site_title" title="<?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_name'];?>
</a> - <em><a href="<?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_url'];?>
" class="visit" target="_blank" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['outstat']->value['web_url'];?>
</a></em></li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
            </div> -->
            <div class="topsite" style="margin-right: 10px;">
				<div class="topsite-title">最新收录 TOP10</div>
				<ul class="topsite-list">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,10,false,'ctime'), 'new', false, NULL, 'new_website', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['new']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_new_website']->value['iteration']++;
?>
					<li><span><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_new_website']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_new_website']->value['iteration'] : null);?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['new']->value['web_link'];?>
" class="site_title" title="<?php echo $_smarty_tpl->tpl_vars['new']->value['web_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['new']->value['web_name'];?>
</a> - <em><a href="<?php echo $_smarty_tpl->tpl_vars['new']->value['web_url'];?>
" class="visit" target="_blank" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['new']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['new']->value['web_url'];?>
</a></em></li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
            </div>
            <div class="topsite" style="">
				<div class="topsite-title">热门浏览 TOP10</div>
				<ul class="topsite-list">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,10,false,'views'), 'hot', false, NULL, 'hot_website', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hot']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_hot_website']->value['iteration']++;
?>
					<li><span><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_hot_website']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_hot_website']->value['iteration'] : null);?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['hot']->value['web_link'];?>
" class="site_title" title="<?php echo $_smarty_tpl->tpl_vars['hot']->value['web_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['hot']->value['web_name'];?>
</a> - <em><a href="<?php echo $_smarty_tpl->tpl_vars['hot']->value['web_url'];?>
" class="visit" target="_blank" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['hot']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['hot']->value['web_url'];?>
</a></em></li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
            </div>
		</div>
		<div class="mainbox-right">
			<div class="blank10"></div>
		</div>
	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
