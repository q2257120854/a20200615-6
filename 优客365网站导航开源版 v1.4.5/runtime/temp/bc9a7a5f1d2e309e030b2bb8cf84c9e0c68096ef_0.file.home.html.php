<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:34:47
  from "D:\WWW\youke365_free\themes\pc\default\member\home.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df306d7552c91_56182353',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc9a7a5f1d2e309e030b2bb8cf84c9e0c68096ef' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\member\\home.html',
      1 => 1524475988,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df306d7552c91_56182353 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div id="homebox">
	<h2><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['nick_name'];?>
 您好！欢迎登录<?php echo $_smarty_tpl->tpl_vars['site_name']->value;?>
 会员中心！</h2>
    <ol>
    	<li>1. 您现在的会员等级是 <strong><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['user_type'];?>
</strong>，注册于 <?php echo $_smarty_tpl->tpl_vars['userinfo']->value['join_time'];?>
，共登陆过 <strong><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['login_count'];?>
</strong> 次</li>
        <li>2. 目前您共提交 <strong><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</strong> 个站点，<a href="<?php echo url('website',array('act'=>'add'));?>
">继续提交>></a></li>
        <li>3. 最后一次登录时间：<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['login_time'];?>
，登录IP：<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['login_ip'];?>
</li>
    </ol>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
