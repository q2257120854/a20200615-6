<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:21:29
  from "D:\WWW\youke365_free\themes\pc\default\home\header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df303b9ef1422_16307087',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '25a7f1ed8bc5135c723d315b21053712df42a0ae' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\header.html',
      1 => 1576145842,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df303b9ef1422_16307087 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="wrapper">
	<div class="clearfix sobox">
    	<a href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
" class="logo" title="<?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
"><h1><?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
</h1></a>

			<!-- 搜索开始-->
	<div class="search">
		<form action="" data-type="baidu"  target="_blank" name="search_form1" class="search_form1" method="get">
		<ul class="search-head" >
		    <li data-cate="webpage" ><a href="javascript: void(0);" class="blue-bg">网页</a></li>
		    <li data-cate="news"><a href="javascript: void(0);" >新闻</a></li>
		    <li data-cate="video"><a href="javascript: void(0);" >视频</a></li>
		    <li data-cate="image"><a href="javascript: void(0);" >图片</a></li> 
		    <li data-cate="music"><a href="javascript: void(0);" >音乐</a></li>
		    <li data-cate="zhidao"><a href="javascript: void(0);" >知道</a></li>
		    <li data-cate="wenku"><a href="javascript: void(0);" >文库</a></li>
		</ul>
			<!-- 搜索主要部分 -->
		   <div class="search-main">
		        <div class="search-title">
		          <h4 data-name="baidu">百度</h4>
		          <ul class="search-other">
	
				      <li data-name="360">360搜索</li>
				      <li data-name="sogo">搜狗搜索</li>
				     <li data-name="baidu">百度</li>
				      <li data-name="site">站内搜索</li>
				  </ul>
				</div>
		    <div class="search-keywords">
				<input name="word" class="keywords" type="text" autocomplete="off" ><input type="submit" class="submit" value="搜索">

				<div class="hot-search">

				</div>
		    </div>
		        <div class="right-txt">
	 		<div class="txtScroll-top">
				<div class="bd">

				<!-- 文字广告 -->
					<ul class="infoList" style="overflow:hidden">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ad_text']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
						<li><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                     <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</ul>
				</div>
			</div>

			<?php echo '<script'; ?>
 type="text/javascript">
jQuery(".txtScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true});
			<?php echo '</script'; ?>
>
    </div>
		   </div>
		</form>
    </div>
	<!-- 搜索结束-->

	</div>
</div>
	<div class="navbox">
		<ul class="navbar">
			<li class="navcur"><a href="/"><span></span><i class="fa fa-home" aria-hidden="true"></i> 首页</a></li>

		<?php echo $_smarty_tpl->tpl_vars['cfg']->value['home_nav'];?>


		<?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_enabled_submit_collect'] == 'yes') {?>	
			<li ><a href="<?php echo url('member/website',array('act'=>'add'));?>
"><i class="fa fa-plus" aria-hidden="true"></i> 提交收录</a>
			</li>
          <?php }?>
		</ul>
	</div>
<div class="blank10"></div>

<?php }
}
