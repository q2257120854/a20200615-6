<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:34:26
  from "D:\WWW\youke365_free\themes\pc\default\home\webdir.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df306c250bae6_73536248',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a700aa7790049b9b88538f1af16b3b78cc85d1d' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\webdir.html',
      1 => 1538060832,
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
function content_5df306c250bae6_73536248 (Smarty_Internal_Template $_smarty_tpl) {
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
            <div class="scatbox">
				<h3 class="scatbox-title">站点分类</h3>
				<ul class="clearfix scatbox-list">
                <?php if (!empty($_smarty_tpl->tpl_vars['child_category']->value)) {?>
               		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['child_category']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            		<li<?php if ($_smarty_tpl->tpl_vars['item']->value['cate_id'] == $_smarty_tpl->tpl_vars['category_id']->value) {?> class="highlight"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_postcount'];?>
)</a></li>
                   	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                 <?php }?>
                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'sub');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
?>
                    <?php if ($_smarty_tpl->tpl_vars['sub']->value['cate_mod'] == 'webdir') {?>
                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_postcount'];?>
)</a></li>
                    <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


				</ul>
			</div>
            <div class="blank10"></div>
            <!-- 广告 开始 930*90-->
            <div class="ad930x90"><?php echo get_adcode(15);?>
</div>
            <!-- 广告 结束 930*90-->


			<div class="blank10"></div>
			<div class="clearfix listbox">
				<h3 class="listbox-title">网站大全</h3>
				<ul class="sitelist">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['websites']->value, 'w', false, NULL, 'list', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['w']->value) {
?>
			

                	<li><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_link'];?>
" target="_blank">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_pic'];?>
" width="120" height="95" alt="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
" class="thumb" /></a>
                	<div class="info"><h3><a href="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['w']->value['web_name'];?>
</a> 

        
                	<?php if ($_smarty_tpl->tpl_vars['w']->value['web_istop'] == 1) {?>
                        <span class="top" title="置顶"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> 顶</span>
                    <?php }?> 
                    <?php if ($_smarty_tpl->tpl_vars['w']->value['web_isbest'] == 1) {?>
                	 <span class="recommend" title="推荐">
                	 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 推</span>
                	 <?php }?>

                	  <?php if ($_smarty_tpl->tpl_vars['w']->value['web_ispay'] == 1) {?>
                	 <span class="fasttrial" title="快审">
                	 <i class="fa fa-rmb" aria-hidden="true"></i> 快审</span>
                	 <?php }?>
 </h3>

                	 <p><?php echo $_smarty_tpl->tpl_vars['w']->value['web_intro'];?>
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
            <div class="blank10"></div>
            <!-- 广告 开始 250*200-->
            <div class="ad250x200"><?php echo get_adcode(16);?>
</div>
            <!-- 广告 结束 250*200-->
		</div>








	</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
