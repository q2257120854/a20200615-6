<?php
/* Smarty version 3.1.31, created on 2019-12-13 18:34:59
  from "D:\WWW\youke365_free\themes\pc\default\home\archives.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df369538a29e0_93291483',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a25c7811f2f3e6060b6f8d8d5a600678ce557d0b' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\archives.html',
      1 => 1537088810,
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
function content_5df369538a29e0_93291483 (Smarty_Internal_Template $_smarty_tpl) {
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
            <div class="clearfix arcbox">
				<ul class="arcbox-list">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_archives(), 'arr', false, 'year');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['year']->value => $_smarty_tpl->tpl_vars['arr']->value) {
?>
                	<li>
                    	<strong><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
年</strong>
                    	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'item', false, 'month');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['month']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
						<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['arc_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['year']->value;?>
年<?php echo $_smarty_tpl->tpl_vars['month']->value;?>
月共有<?php echo $_smarty_tpl->tpl_vars['item']->value['site_count'];?>
个站点"><?php echo $_smarty_tpl->tpl_vars['month']->value;?>
月</a>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                	</li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
			</div>
			<div class="blank10"></div>
			<div class="clearfix listbox">
				<h3 class="listbox-title"><?php echo $_smarty_tpl->tpl_vars['pagename']->value;?>
</h3>
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
</a> <?php if ($_smarty_tpl->tpl_vars['w']->value['web_ispay'] == 1) {?><img src="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/images/attr/audit.gif" border="0"><?php }?>
            <?php if ($_smarty_tpl->tpl_vars['w']->value['web_istop'] == 1) {?>
                     <span class="top">顶置</span><?php }?> 
                     <?php if ($_smarty_tpl->tpl_vars['w']->value['web_isbest'] == 1) {?>
                	 <span class="top">推荐</span><?php }?>

                	</h3><p><?php echo $_smarty_tpl->tpl_vars['w']->value['web_intro'];?>
</p><cite><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_furl'];?>
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
			<div style="height: 250px;"><?php echo get_adcode(4);?>
</div>
			<div class="blank10"></div>
			<div class="webbox">
                <div class="webbox-title">推荐站点</div>
				<ul class="webbox-list">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,5,false,true), 'best');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['best']->value) {
?>
                    <li><h3><a href="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
</a></h3><p><?php echo $_smarty_tpl->tpl_vars['best']->value['web_intro'];?>
</p><cite><a href="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_furl'];?>
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
