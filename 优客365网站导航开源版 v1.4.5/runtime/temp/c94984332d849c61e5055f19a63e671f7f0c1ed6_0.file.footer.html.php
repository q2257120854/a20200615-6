<?php
/* Smarty version 3.1.31, created on 2019-12-13 21:37:56
  from "D:\WWW\youke365_free\themes\pc\default\home\footer.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df394348c5da9_03698110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c94984332d849c61e5055f19a63e671f7f0c1ed6' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\footer.html',
      1 => 1576244268,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df394348c5da9_03698110 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="blank10"></div>
<div class="wrapper">
<!-- 1200*90 广告开始 -->
<?php echo get_adcode(6);?>


<!-- 1200*90 广告结束 -->
<div class="blank10"></div>
</div>
<div class="footer">

  <div class="footer-main clearfix">
    <div class="footer-left">
      <div class="footer-wx">
        <img src="<?php echo $_smarty_tpl->tpl_vars['cfg']->value['qcode_img'];?>
">
        <p><?php echo $_smarty_tpl->tpl_vars['cfg']->value['qcode_name'];?>
</p>
      </div>
    </div>
    <div class="footer-right">
      <div class="linkbox clearfix">
        <div class="linkbox-left">友情链接：</div>
          <ul class="linkbox-list">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_links(), 'link');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['link']->value) {
?>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value['link_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['link']->value['link_name'];?>
</a></li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

          </ul>
        </div>
        <div class="footer-nav">

        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_pages(), 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['page_link'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['page_name'];?>
</a> | <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

        <a href="<?php echo url('update');?>
">最新收录</a>  | <a href="<?php echo url('top');?>
">TOP排行榜</a> |<a href="<?php echo url('feedback');?>
">意见反馈  | <a href="<?php echo url('home/index');?>
?visit=mobile">移动版</a> <?php echo $_smarty_tpl->tpl_vars['cfg']->value['site_code'];?>


<div class="kefu_qq">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, get_kefu(), 'vo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->value) {
?>
        <li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
&site=qq&menu=yes"><img border="0" src="/public/images/qq/button_1.gif" alt="点击这里给我发消息" title="点击这里给我发消息"/></a> </li>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</div>
        </div>


        <div class="footer-copy"> Copyright © 2018  Powered by <a href="http://www.youke365.site/" target="_blank">Youke365</a> v<?php echo @constant('SYS_VERSION');?>
</div>
      </div>
    </div>
  </div>
</div>

<?php }
}
