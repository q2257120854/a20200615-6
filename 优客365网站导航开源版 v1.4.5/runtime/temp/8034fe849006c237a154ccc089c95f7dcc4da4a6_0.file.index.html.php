<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:16:42
  from "D:\WWW\youke365_free\themes\pc\default\home\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df39d4ae01ed5_04434375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8034fe849006c237a154ccc089c95f7dcc4da4a6' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\index.html',
      1 => 1576246601,
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
function content_5df39d4ae01ed5_04434375 (Smarty_Internal_Template $_smarty_tpl) {
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
<?php $_smarty_tpl->_subTemplateRender("file:base.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</head>
<body>
<?php $_smarty_tpl->_subTemplateRender("file:topbar.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="wrapper">

<ul>




</ul>
<div class="ad1200x90">
<?php echo get_adcode(20);?>

</div>


		<?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_enabled_tj'] == 'yes') {?>
				<div class="count">
				<div class="count-title"><i class="fa fa-pie-chart" aria-hidden="true"></i> 数据统计</div>
				 <ul class="tj-list">
					<li style=""><a style=""><?php echo $_smarty_tpl->tpl_vars['stat']->value['website'];?>
</a> 个优秀站点</li>
					<li><a ><?php echo $_smarty_tpl->tpl_vars['stat']->value['apply'];?>
</a> 个站点正在排队审核</li>
					<li><a ><?php echo $_smarty_tpl->tpl_vars['stat']->value['article'];?>
</a> 篇新闻资讯</li>
					<li><a ><?php echo $_smarty_tpl->tpl_vars['stat']->value['user'];?>
</a> 个会员</li>

				</ul>
				<?php if (!empty($_smarty_tpl->tpl_vars['cfg']->value['home_pay_money'])) {?>
				<div class="count-pay-money">
				  快审服务: <?php echo $_smarty_tpl->tpl_vars['cfg']->value['home_pay_money'];?>
元/站 
				</div>
				<?php }?>
			</div>
		<div class="blank10"></div>
       <?php }?>


	<div class="homebox">


      <!-- 付费快审 结束-->

        <!-- 权威推荐 开始-->
        <?php if ($_smarty_tpl->tpl_vars['cfg']->value['home_best'] > 0) {?>
        <div class="recommended">
		<div class="main-top"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 权威推荐</div>
		<ul class="index-top">
		  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, getTop($_smarty_tpl->tpl_vars['cfg']->value['home_best']), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
          <li id="dowebok" class="qq animated bounceInDown">
            <a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['web_link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['vo']->value['web_name'];?>
</a>
          </li>
		   	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</ul>
		  <!-- 权威推荐 结束-->
       </div>
        <?php }?>
    
<div class="blank10"></div>



	<div class="homebox-right">
		<div class="blank10"></div>
<!-- 推荐 -->
<?php if ($_smarty_tpl->tpl_vars['cfg']->value['home_isbest'] > '0') {?>
<div class="bestbox">
	<div class="bestbox-body">
		<ul class="clearfix bestbox-list">
			<?php ob_start();
echo $_smarty_tpl->tpl_vars['cfg']->value['home_isbest'];
$_prefixVariable1=ob_get_clean();
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,$_prefixVariable1,true), 'best');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['best']->value) {
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_link'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
">
			<?php if ($_smarty_tpl->tpl_vars['best']->value['web_ico']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['best']->value['web_ico'];?>
" style="width:15px;height:15px;"><?php }?> <?php echo $_smarty_tpl->tpl_vars['best']->value['web_name'];?>
</a></li>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</ul>
	</div>
</div>
<div class="blank10"></div>
<!-- 广告 开始 -->
<div class="ad2">
<?php echo get_adcode(18);?>
	
</div> 
<!-- 广告 开始 -->
<div class="blank10"></div>
<?php }?>
<!-- 推荐分类 -->
	<div class="coolbox">
        <div class="coolbox-body">
		    <ul class="coolbox-list">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_best_categories('webdir'), 'item', false, NULL, 'isite', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_isite']->value['iteration']++;
?>
				<li class="clearfix">
				       <strong><a href="<?php echo url('home/webdir',array('cid'=>$_smarty_tpl->tpl_vars['item']->value['cate_id']));?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
</a></strong>
						<span>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites($_smarty_tpl->tpl_vars['item']->value['cate_id'],7,false,'ctime','asc'), 'cool');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cool']->value) {
?>
						<span id="coolbox-a"><a href="<?php echo $_smarty_tpl->tpl_vars['cool']->value['web_link'];?>
" 
						title="<?php echo $_smarty_tpl->tpl_vars['cool']->value['web_name'];?>
">
						<?php if ($_smarty_tpl->tpl_vars['cool']->value['web_ico']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['cool']->value['web_ico'];?>
" style="width:15px;height:15px;"><?php }
echo $_smarty_tpl->tpl_vars['cool']->value['web_name'];?>
</a></span>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</span>
						<em><a href="<?php echo url('home/webdir',array('cid'=>$_smarty_tpl->tpl_vars['item']->value['cate_id']));?>
" class="more">更多>></a></em>
				</li>
				<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_isite']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_isite']->value['iteration'] : null)%5 == 0 && (isset($_smarty_tpl->tpl_vars['__smarty_foreach_isite']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_isite']->value['iteration'] : null) != 20) {?>
				<li class="sline"></li>
				<?php }?>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</ul>
		</div>
	</div>
</div>


		<div class="homebox-left">
		<div class="blank10"></div>
			<div class="newsbox">
			<!-- 导航盒子 开始-->
				<?php echo $_smarty_tpl->tpl_vars['cfg']->value['nav_code'];?>

			<!-- 导航盒子结束 -->
			</div>
		<div class="blank10"></div>

        <!-- 首页左侧广告位 开始 250X90 -->
		<div class="youkeadverta">
			  <?php echo get_adcode(1);?>

		</div>
		<!-- 首页左侧广告位 结束 250X90 -->	
        <div class="blank10"></div>
		<div class="slideTxtBox-a box1">
		<div class="slideTxtBox">
			<div class="hd">
				<ul>
				<li>热门资讯</li>
				</ul>
			</div>
			<div class="bd">
		<!-- 显示文章 -->
    
				<ul>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_article_list('','views','desc'), 'vo', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['vo']->value) {
?>
					<li><a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['art_link'];?>
" target="_blank"><span class="layui-badge layui-bg-blue"><?php echo $_smarty_tpl->tpl_vars['key']->value+1;?>
</span> <?php echo $_smarty_tpl->tpl_vars['vo']->value['art_title'];?>
</a></li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				
				</ul>
            
			</div>
		</div>
		<div class="blank10"></div>

<div class="blank10"></div>

	</div>
</div>
<div class="blank10"></div>
<div class="wrapper">
	<div class="clearfix hcatebox">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_categories(0,5), 'cate', false, NULL, 'csite', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cate']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_csite']->value['iteration']++;
?>
		<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_csite']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_csite']->value['iteration'] : null)%5 == 0) {?>
		<dl class="hcatebox-one" style="border-right: 0;">
		<?php } else { ?>
		<dl class="hcatebox-one">
		<?php }?>
			<dt><a href="<?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_link'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_name'];?>
</a></dt>
			<dd>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_categories($_smarty_tpl->tpl_vars['cate']->value['cate_id'],4), 'scate');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['scate']->value) {
?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['scate']->value['cate_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['scate']->value['cate_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['scate']->value['cate_name'];?>
</a>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </dd>
		</dl>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</div>
</div>

<div class="blank10"></div>

<!-- 1200*90 广告开始 -->
<?php echo get_adcode(3);?>


<!-- 1200*90 广告结束 -->

<?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_video_status'] != 'no') {?>
<!--===== 看视频模块 开始=====-->
<div class="wrapper">
<div class="inbox-title"><i class="fa fa-film" aria-hidden="true"></i> 看视频</div>
<div class="outBox" style="margin:0 auto">
<!-- <div class="hd"><ul><li>影视大全</li><li>电视剧</li><li>电影</li><li>综艺</li><li>动漫</li></ul></div> -->
<div class="">
  <div class="inBox">
    <div class="inBd">
      <ul>
        <li>
          <div class="youketvfl">

<div class="youkeleft-tv">

<div class="youketvleft">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_video_list('a.isbest = 1','ctime','desc',0,1), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
">
<div class="youkepa"><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</div>
<div class="youkea1">
<i class="fa fa-play-circle-o fa-4x" aria-hidden="true"></i>
</div>
</a>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</div>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_video_list('a.isbest = 1','ctime','desc',1,4), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>

<div class="youketvright">
  <a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
" alt="{$vo.title}>">
<div class="youkepb"><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</div>
<div class="youkea2"><i class="fa fa-play-circle-o fa-2x" aria-hidden="true"></i></div>
</a>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


</div>


<div class="tvselected">
<h2>热门精选</h2>
<div id="slideBox" class="slideBox">
<div class="tvbd">
<ul>
<?php $_smarty_tpl->_assignInScope('video', get_video_list('a.ishot = 1','ctime','desc',0,4));
if (!empty($_smarty_tpl->tpl_vars['video']->value)) {?>
<li>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['video']->value, 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<div class="youketvbottom">
<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
">
<div class="youkepf"><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</div>
<div class="youkea6"><i class="fa fa-play-circle-o fa-2x" aria-hidden="true"></i></div>
</a>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</li>
<?php }
$_smarty_tpl->_assignInScope('video1', get_video_list('a.ishot = 1','ctime','desc',4,8));
if (!empty($_smarty_tpl->tpl_vars['video1']->value)) {?>
<li>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['video1']->value, 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<div class="youketvbottom">
<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
" alt="{$vo.title}>">
<div class="youkepf"><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</div>
<div class="youkea6"><i class="fa fa-play-circle-o fa-2x" aria-hidden="true"></i></div>
</a>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</li>
<?php }
$_smarty_tpl->_assignInScope('video2', get_video_list('a.ishot = 1','ctime','desc',8,12));
if (!empty($_smarty_tpl->tpl_vars['video2']->value)) {?>
<li>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['video2']->value, 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<div class="youketvbottom">
<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
"  alt="{$vo.title}>">
<div class="youkepf"><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</div>
<div class="youkea6"><i class="fa fa-play-circle-o fa-2x" aria-hidden="true"></i></div>
</a>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</li>
<?php }?>
</ul>
</div>
<a class="prev" href="javascript:void(0)"></a>
<a class="next" href="javascript:void(0)"></a>
</div>
<?php echo '<script'; ?>
>
jQuery(".tvselected .slideBox").slide({mainCell:".tvbd ul",effect:"left",easing:"easeOutCirc",delayTime:1000});
<?php echo '</script'; ?>
>
</div>
</div>



<div class="youketvfr">      
<div class="slideyouke" style="margin:0 auto">
<div class="youkebd">
<div class="inyouke">
<div class="youkeHd">
<ul>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_categories_mod('video',5,'true'), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<li><?php echo $_smarty_tpl->tpl_vars['vo']->value['cate_name'];?>
</li>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</ul>
</div>
<div class="youkeBd">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_categories_mod('video',5,'true'), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>

<?php $_smarty_tpl->_assignInScope('cid', $_smarty_tpl->tpl_vars['vo']->value['cate_id']);
?>
<ul>
<li>
<div class="youkeranking">
<ul>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_video($_smarty_tpl->tpl_vars['cid']->value,24), 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


</ul>
</div>
</li>
</ul>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


</div>
<div class="youkeAD">
<div class="picScroll-left">
<div class="tempWrap">
<div class="bd">
<ul class="picList">
<!-- 最新视频 -->
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_video_list('','ctime','desc',0,4), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
<li>
<div class="pic">
<a href="<?php echo $_smarty_tpl->tpl_vars['vo']->value['url'];?>
" target="_blank">
<img src="<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
" alt="{$vo.title}>">
<div class="title">
<span><?php echo $_smarty_tpl->tpl_vars['vo']->value['title'];?>
</span>
</div>
</a>
</div>
</li>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</ul>
</div>
</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
jQuery(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:true,vis:2,delayTime:1000});
<?php echo '</script'; ?>
>
</div>
</div>
</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
/* 内层inBox渐显切换，注意titCell、mainCell等不能与外层相同 */
jQuery(".inyouke").slide({ titCell:".youkeHd li",mainCell:".youkeBd" });
/* 外层outBox左滚动切换 */
jQuery(".slideyouke").slide({ effect:"left" });
<?php echo '</script'; ?>
>
</div>
</li>
</ul>
</div>
</div>		
</div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
/* 内层inBox渐显切换，注意titCell、mainCell等不能与外层相同 */
jQuery(".inBox").slide({ titCell:".inHd li",mainCell:".inBd" });
/* 外层outBox左滚动切换 */
jQuery(".outBox").slide({ effect:"left" });
<?php echo '</script'; ?>
>
</div>
<!--===== 看视频模块 结束=====-->
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_game_status'] != 'no') {?>
<div class="blank10"></div>
<!-- 1200*90 广告开始 -->
<?php echo get_adcode(4);?>


<!-- 1200*90 广告结束 -->

<!--===== 小游戏模块 开始=====-->
<div class="wrapper">
    <div class="inbox-title game"><i class="fa fa-gamepad fa-lg" aria-hidden="true"></i> 玩游戏</div>
	<div id="slideBox" class="slideBox">
		<div class="bd">
			<ul>
				<li>
					<div class="youkegame">
						<div class="clearfix">
<!-- 广告开始 -->
							<?php echo get_adcode(19);?>

<!-- 广告结束 -->
						</div>
					</div>
				    <?php $_smarty_tpl->_assignInScope('gamelist', get_game(543,20));
?>
					<ul class="gamelist">
					    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gamelist']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
						<li>
							<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" target="_blank">
								<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['cover'];?>
" alt="{$v.title}>" />
								<h3><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</h3>
							</a>
						</li>
					    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

					</ul>
				</li>
			</ul>
		</div>
	    <a class="prev" href="javascript:void(0)"></a>
	    <a class="next" href="javascript:void(0)"></a>
	</div>
	<?php echo '<script'; ?>
 type="text/javascript">
	jQuery(".slideBox").slide({mainCell:".bd ul",effect:"left",trigger:"click"});
	<?php echo '</script'; ?>
>
</div>
<!--===== 小游戏模块 结束=====-->
<?php }?>
<div class="blank10"></div>


<!-- 1200*90 广告开始 -->
<?php echo get_adcode(5);?>


<!-- 1200*90 广告结束 -->

<!-- 最新点入模块 -->
<div class="wrapper">
<?php if ($_smarty_tpl->tpl_vars['cfg']->value['home_instat'] > '0') {?>
	<div class="inbox">
		<div class="inbox-title">最新点入（实时更新）</div>
		<ul class="clearfix inbox-list">
          	
			<?php ob_start();
echo $_smarty_tpl->tpl_vars['cfg']->value['home_instat'];
$_prefixVariable2=ob_get_clean();
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_websites(0,$_prefixVariable2,false,'instat'), 'instat');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['instat']->value) {
?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['instat']->value['web_name'];?>
">
             <li>
			   <div class="inbox-list-top">
			     <?php echo $_smarty_tpl->tpl_vars['instat']->value['web_name'];?>

			  </div>
			  <div class="inbox-list-bottom">
			    <span>人气<br> <?php echo $_smarty_tpl->tpl_vars['instat']->value['web_views'];?>
</span>&nbsp;<div class="intro"><?php echo $_smarty_tpl->tpl_vars['instat']->value['web_intro'];?>
</div>&nbsp;
			  </div>  
			</li>
			</a>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            
		</ul>
	</div>
	<div class="blank10"></div>
<?php }?>
</div>
</div>

<!-- 返回顶部 -->
<div class="youketop">
  	<div class="toTop" id="roll_top" title="返回顶部">
	    <i class="fa fa-angle-up fa-3x" aria-hidden="true"></i>
	</div>
</div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
