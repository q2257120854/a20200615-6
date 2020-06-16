<?php
/* Smarty version 3.1.31, created on 2019-12-13 17:20:17
  from "D:\WWW\youke365_free\themes\pc\default\home\article.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df357d126f332_89249245',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c506d2a597476e38593eb7c47a9763247cde9f3' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\article.html',
      1 => 1576228813,
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
function content_5df357d126f332_89249245 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

    <div class="mainbox" class="clearfix">
    	<div class="mainbox-left">
	
        	<div class="subcate" class="clearfix">
            	<h3>分类</h3>
                <ul class="scatbox-list">
                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'sub');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
?>
                    <?php if ($_smarty_tpl->tpl_vars['sub']->value['cate_mod'] != 'webdir') {?>
                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_name'];?>
<em>(<?php echo $_smarty_tpl->tpl_vars['sub']->value['cate_postcount'];?>
)</em></a></li>
                    <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                </ul>
            </div>
<div class="blank10"></div>
<!-- 广告开始 930*90-->
<?php echo get_adcode(7);?>

<!-- 广告结束  930*90-->
            <div class="blank10"></div>
            <div class="listbox" class="clearfix">
            	<h2><?php echo $_smarty_tpl->tpl_vars['cate_name']->value;?>
</h2>

            	<ul class="artlist">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['articles']->value, 'a', false, NULL, 'list', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['a']->value) {
?>
					 
                	<li> 
					<?php if (get_img($_smarty_tpl->tpl_vars['a']->value['art_content'])) {?><div class="article-cover">
					    <img src="<?php echo get_img($_smarty_tpl->tpl_vars['a']->value['art_content']);?>
" style="width:250px;height:160px"></div>
						<?php }?>
					<div class="article-right" <?php if (!get_img($_smarty_tpl->tpl_vars['a']->value['art_content'])) {?> style="width:99%;float:none" <?php }?> ><h3><a href="<?php echo $_smarty_tpl->tpl_vars['a']->value['art_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['a']->value['art_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['a']->value['art_title'];?>
</a>

                        <?php if ($_smarty_tpl->tpl_vars['a']->value['art_istop'] == 1) {?>
                            <span class="top" title="置顶"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> 顶</span>
                        <?php }?> 
                        <?php if ($_smarty_tpl->tpl_vars['a']->value['art_isbest'] == 1) {?>
                         <span class="recommend" title="推荐">
                         <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 推</span>
                         <?php }?>

                          <?php if ($_smarty_tpl->tpl_vars['a']->value['art_ispay'] == 1) {?>
                         <span class="fasttrial" title="快审">
                         <i class="fa fa-rmb" aria-hidden="true"></i> 快审</span>
                         <?php }?>


                    </h3>
					<?php $_smarty_tpl->_assignInScope('artstr', get_str($_smarty_tpl->tpl_vars['a']->value['art_content']));
?>
					<p><?php echo mb_substr($_smarty_tpl->tpl_vars['artstr']->value,0,100);?>
</p>
					<div class="art-bottom"><span class="cate-cname"><?php echo $_smarty_tpl->tpl_vars['a']->value['cate_name'];?>
</span><span><?php echo show_time($_smarty_tpl->tpl_vars['a']->value['art_ctime']);?>
</span></div></div></li>
                	<?php
}
} else {
?>

                	<li>暂无内容！</li>
                	<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</ul>
            	<div class="showpage"><?php echo $_smarty_tpl->tpl_vars['showpage']->value;?>
</div>
            </div>
        </div>
        <div class="mainbox-right">

            <div class="blank10"></div>
            <div class="bestart">
            	<h3>推荐资讯</h3>
                <ul class="artlist_b">
                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_articles(0,10), 'art', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['art']->value) {
?>
                	<li>
					<span <?php if ($_smarty_tpl->tpl_vars['k']->value+1 > 4) {?>style="background:#ccc"<?php }?>><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['art']->value['art_link'];?>
" class="best-art-title"><?php echo $_smarty_tpl->tpl_vars['art']->value['art_title'];?>
</a></li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                </ul>
            </div>
            <div class="blank10"></div>
            <!-- 广告开始 250x200-->
           <div class="ad250x200">
           <?php echo get_adcode(8);?>

           </div>
          <!-- 广告结束 250x200-->
            <div class="blank10"></div>
            <div class="art-hot" class="mag">
            	<h3>热门资讯</h3>
                <ul class="art-hot-b">
                   	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_articles(0,5,false,'views'), 'hot', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['hot']->value) {
?>
				
                   	<li><span <?php if ($_smarty_tpl->tpl_vars['k']->value+1 > 4) {?>style="background:#ccc"<?php }?>><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
</span><a href="<?php echo $_smarty_tpl->tpl_vars['hot']->value['art_link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['hot']->value['art_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['hot']->value['art_title'];?>
</a></li>
                   	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

               	</ul>
            </div>
          <div class="blank10"></div>
           <div class="ad250x200"><?php echo get_adcode(9);?>
</div>
            <div class="blank10"></div>
        </div>
    </div>
 
</div>
   <?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
