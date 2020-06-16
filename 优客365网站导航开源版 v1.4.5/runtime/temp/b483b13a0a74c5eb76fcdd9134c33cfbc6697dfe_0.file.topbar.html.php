<?php
/* Smarty version 3.1.31, created on 2019-12-13 21:37:56
  from "D:\WWW\youke365_free\themes\pc\default\home\topbar.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df39434756a41_04857506',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b483b13a0a74c5eb76fcdd9134c33cfbc6697dfe' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\home\\topbar.html',
      1 => 1576244274,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df39434756a41_04857506 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="topbox">
	<div class="wrapper">
		<div style="width:300px;float:left;height:30px;padding-top:3px;margin-left:20px;">
		<!-- 天气显示 -->
		<iframe width="300" scrolling="no" height="25" frameborder="0" allowtransparency="true" src="//i.tianqi.com/index.php?c=code&id=10&icon=1&site=12"></iframe>	</div>
	
	
		<div class="login-status">
			<!--  -->

			<?php if (empty($_smarty_tpl->tpl_vars['user_info']->value)) {?>
			<div class="top-ulogin">
				<a href="<?php echo url('member/login');?>
"><i class="fa fa-sign-in" aria-hidden="true"></i> 登录</a>
				<a href="<?php echo url('member/register');?>
"><i class="fa fa-registered" aria-hidden="true"></i> 注册</a>
				<a href="<?php echo url('member/getpwd');?>
"><i class="fa fa-envelope-o" aria-hidden="true"></i> 找回密码</a>
		    </div>
		    <?php } else { ?>

          <div class="top-uinfo">您好 <?php echo $_smarty_tpl->tpl_vars['user_info']->value['nick_name'];?>
，
				<a href="<?php echo url('member/home');?>
"><i class="fa fa-user-circle" aria-hidden="true"></i> 会员中心</a> | 
				<a href="<?php echo url('member/logout');?>
"><i class="fa fa-sign-out" aria-hidden="true"></i> 退出</a>
		  </div>
		    <?php }?>
			<!--  -->
		</div>
	</div>
</div>




</div><?php }
}
