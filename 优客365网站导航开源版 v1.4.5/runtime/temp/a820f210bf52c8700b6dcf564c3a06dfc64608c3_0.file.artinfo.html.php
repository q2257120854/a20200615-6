<?php
/* Smarty version 3.1.31, created on 2019-12-13 17:20:18
  from "D:\WWW\youke365_free\themes\pc\default\home\artinfo.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df357d212f177_19467678',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a820f210bf52c8700b6dcf564c3a06dfc64608c3' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\artinfo.html',
      1 => 1576228815,
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
function content_5df357d212f177_19467678 (Smarty_Internal_Template $_smarty_tpl) {
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
<meta name="Copyright" content="Powered By 35dir.com" />



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
    <div class="mainbox" class="clearfix">
    	<div class="mainbox-left">
        	<div class="artinfo">
            	<h1 class="atitle"><?php echo $_smarty_tpl->tpl_vars['art']->value['art_title'];?>
</h1>
				<div class="aattr"><a href="<?php echo $_smarty_tpl->tpl_vars['art']->value['copy_url'];?>
" target="_blank" class="copyfrom"><?php echo $_smarty_tpl->tpl_vars['art']->value['copy_from'];?>
</a><?php echo $_smarty_tpl->tpl_vars['art']->value['art_ctime'];?>
 <span class="view"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $_smarty_tpl->tpl_vars['art']->value['art_views'];?>
</span></div>
				<div class="content"><?php echo $_smarty_tpl->tpl_vars['art']->value['art_content'];?>
</div>
          


               

                <ul class="prevnext">
                	<li>上一篇： <?php if (!empty($_smarty_tpl->tpl_vars['prev']->value)) {?><a href="<?php echo $_smarty_tpl->tpl_vars['prev']->value['art_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['prev']->value['art_title'];?>
</a><?php } else { ?>暂无<?php }?></li>
                    <li>下一篇： <?php if (!empty($_smarty_tpl->tpl_vars['next']->value)) {?><a href="<?php echo $_smarty_tpl->tpl_vars['next']->value['art_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['next']->value['art_title'];?>
</a><?php } else { ?>暂无<?php }?></li>
                </ul>
            </div>
            <div class="blank10"></div>

                        <?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_enabled_comment'] == 1) {?> 
                        <!-- 畅言评论 开始 -->
                  <div class="comment-form">
                                 <!--PC版-->
                            <div id="SOHUCS" sid="<?php echo $_smarty_tpl->tpl_vars['art']->value['art_id'];?>
"></div>
                            <?php echo '<script'; ?>
 charset="utf-8" type="text/javascript" src="http://changyan.sohu.com/upload/changyan.js" ><?php echo '</script'; ?>
>
                            <?php echo '<script'; ?>
 type="text/javascript">
                            window.changyan.api.config({
                            appid: "<?php echo $_smarty_tpl->tpl_vars['cfg']->value['changyan_appid'];?>
",
                            conf: "<?php echo $_smarty_tpl->tpl_vars['cfg']->value['changyan_conf'];?>
"
                            });
                            <?php echo '</script'; ?>
>
                 </div>
                   <!-- 畅言评论结束   -->
                   <?php }?>
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
					<span><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
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
           <?php echo get_adcode(10);?>

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
				
                   	<li><span><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
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
                      <!-- 广告开始 250x200-->
           <div class="ad250x200">
           <?php echo get_adcode(11);?>

           </div>
          <!-- 广告结束 250x200-->
          <div class="blank10"></div>
        </div>
    </div>

</div>
    <?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
