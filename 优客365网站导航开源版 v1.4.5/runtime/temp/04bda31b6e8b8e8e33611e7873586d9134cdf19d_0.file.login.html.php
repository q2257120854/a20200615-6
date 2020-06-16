<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:28:39
  from "D:\WWW\youke365_free\themes\pc\default\member\login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a017f136b4_59432662',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '04bda31b6e8b8e8e33611e7873586d9134cdf19d' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\member\\login.html',
      1 => 1524652605,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df3a017f136b4_59432662 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['site_keywords']->value;?>
">
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['site_description']->value;?>
">

<link href="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript">var sitepath = '<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
'; var rewrite = '<?php echo $_smarty_tpl->tpl_vars['cfg']->value['is_enabled_rewrite'];?>
';<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/js/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/js/common.js"><?php echo '</script'; ?>
>
<link href="<?php echo @constant('tpl');?>
skin/<?php echo $_smarty_tpl->tpl_vars['cfg']->value['default_skin'];?>
/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="loginbanner clearfix">
    <div class="loginlogo">
        <div class="header">
           <div class="loginlogo-left">
                <a href="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
">
                    <img src="/public/images/logo.png">
                </a>
           </div>
           <div class="loginlogo-right">
              <span>登录</span>
           </div>
        </div>
    </div>
    <div class="wrapper clearfix">
    	<div class="loginform">
        	<h3><span>用户登录</span></h3>
            <form name="myform" method="post" action="">
            <ul>
                <li><label>用户名：</label><input type="text" name="nick_name" size="30" maxlength="50" class="ipt" /></li>
            	<!-- <li><label>电子邮箱：</label><input type="text" name="email" size="30" maxlength="50" class="ipt" /></li> -->
                <li><label>登录密码：</label><input type="password" name="pass" size="30" maxlength="50" class="ipt" /></li>
                <li><label>&nbsp;</label><input type="hidden" name="action" value="login" /><input type="submit" value="登 录" class="btn" /></li>

                <li>            
                  <div class="youkeqq">
                    <a href="<?php echo url('member/connect',array('type'=>'init'));?>
" onclick='toQzoneLogin()'><i class="fa fa-qq youke-blue" aria-hidden="true"></i>&nbsp;QQ登录</a>
                  </div>
                  <div class="toplink">
                    <a href="<?php echo url('register');?>
">免费注册 <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                  </div>
                  <div class="loginpass">
                   <a href="<?php echo url('getpwd');?>
">忘记密码？</a>
                  </div>
                </li>
            </ul>
            </form>
    	</div>
     
    </div>
  
</div>
     <div class="footer">
     
    Powered by <a href="http://www.youke365.site/" target="_blank">Youke365</a> v<?php echo @constant('SYS_VERSION');?>


    </div>
</body>
</html><?php }
}
