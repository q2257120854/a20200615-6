<?php
/* Smarty version 3.1.31, created on 2019-12-13 21:53:14
  from "D:\WWW\youke365_free\themes\pc\default\home\siteinfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df397ca889536_95570690',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed6d83bc6255695614b1d8e620aed0c125ae70ab' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\siteinfo.html',
      1 => 1576228798,
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
function content_5df397ca889536_95570690 (Smarty_Internal_Template $_smarty_tpl) {
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
		<span class="layui-breadcrumb"><?php echo $_smarty_tpl->tpl_vars['site_path']->value;?>
</span>
	<div class="mainbox">
    	<div class="mainbox-left">
			
            <div class="siteinfo">
            	<h1 class="wtitle"><span style="float: right;"></span><a href="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_furl'];?>
" target="_blank" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
</a></h1>
				<ul class="wdata">
					<li class="line"><em style="color: #f00;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_views'];?>
</em>人气指数</li>
					<li class="line"><em style="color: #083;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_brank'];?>
</em>百度权重</li>
					<li class="line"><em style="color: #083;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_r360'];?>
</em>360权重</li>
					<li class="line"><em style="color: #083;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_srank'];?>
</em>搜狗权重</li>
					<li class="line"><em style="color: #083;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_arank'];?>
</em>Alexa</li>
					<li class="line"><em><?php echo $_smarty_tpl->tpl_vars['web']->value['web_instat'];?>
</em>入站次数</li>
					<li class="line"><em><?php echo $_smarty_tpl->tpl_vars['web']->value['web_outstat'];?>
</em>出站次数</li>
					<li class="line"><em><?php echo $_smarty_tpl->tpl_vars['web']->value['web_ctime'];?>
</em>收录日期</li>
					<li><em style="color: #f60;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_utime'];?>
</em>更新日期</li>
				</ul>
				<div class="clearfix params">
					<a href="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_furl'];?>
" target="_blank">
					<img src="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_pic'];?>
" width="130" height="110" alt="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
" class="wthumb" /></a>
					<ul class="siteitem">
						<li><strong>网站地址：</strong>
						<a href="<?php echo url('open',array('id'=>$_smarty_tpl->tpl_vars['web']->value['web_id']));?>
?url=<?php echo $_smarty_tpl->tpl_vars['web']->value['web_furl'];?>
" target="_blank" class="visit" onclick="clickout(<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
)">
						<font color="#008000"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_url'];?>
</font><span class="site-info-in">直达</span></a></li>
						<li><strong>服务器IP：</strong><a href="http://ip.chinaz.com/?ip=<?php echo $_smarty_tpl->tpl_vars['web']->value['web_ip'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_ip'];?>
</a></li>
						<li><strong>网站描述：</strong><span style="line-height: 23px;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_intro'];?>
</span></li>
						<?php if ($_smarty_tpl->tpl_vars['user']->value['user_qq'] != '') {?>
						<li><strong>联系站长：</strong>
						<!-- <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $_smarty_tpl->tpl_vars['user']->value['user_qq'];?>
&amp;site=<?php echo $_smarty_tpl->tpl_vars['user']->value['nick_name'];?>
&amp;menu=yes" target="_blank"><img border="0" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:<?php echo $_smarty_tpl->tpl_vars['user']->value['user_qq'];?>
:46"></a> -->
                         <a title="点击这里给联系我" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $_smarty_tpl->tpl_vars['user']->value['user_qq'];?>
&amp;site=localhost&amp;menu=yes" target="_blank">
                         <img src="http://pub.idqqimg.com/qconn/wpa/button/button_11.gif"></a>
						</li><?php } else { ?>

						<?php }?>
						<li><strong>网站状态：</strong>
                        	<?php if ($_smarty_tpl->tpl_vars['user']->value['user_qq'] != '') {?>
                        	已认领<?php } else { ?>未认领<a href="<?php echo url('member/claim');?>
?url=<?php echo $_smarty_tpl->tpl_vars['web']->value['web_url'];?>
" class="site-info-in">认领</a>
                         	<?php }?>
                        	</li>

						<li><strong>TAG标签：</strong><?php echo $_smarty_tpl->tpl_vars['web']->value['web_tags'];?>
</li>
						<li></li>
					</ul>
				</div>
			</div>
			<div class="blank10"></div>
			<div class="clearfix relsite">
				<div class="relsite-title">相关站点</div>
				<ul class="relsite-list">
              		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['related_website']->value, 'rel');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['rel']->value) {
?>
               		<li><a href="<?php echo $_smarty_tpl->tpl_vars['rel']->value['web_link'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['rel']->value['web_name'];?>
">
               			<img src="<?php echo $_smarty_tpl->tpl_vars['rel']->value['web_pic'];?>
" width="100" height="80" alt="<?php echo $_smarty_tpl->tpl_vars['rel']->value['web_name'];?>
" /><p><?php echo $_smarty_tpl->tpl_vars['rel']->value['web_name'];?>
</p></a></li>
               		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
			</div>
			<div class="blank10"></div>

	
			
	  	    </div>
		</div>

		<div class="mainbox-right">
			<div class="newbox">
				<div class="newbox-title">最新收录</div>
				<ul class="newbox-list">
                	<?php ob_start();
echo $_smarty_tpl->tpl_vars['cfg']->value['home_new'];
$_prefixVariable1=ob_get_clean();
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,$_prefixVariable1), 'new');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['new']->value) {
?>
					<li><span><?php echo $_smarty_tpl->tpl_vars['new']->value['web_ctime'];?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['new']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['new']->value['web_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['new']->value['web_name'];?>
</a></li>
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
