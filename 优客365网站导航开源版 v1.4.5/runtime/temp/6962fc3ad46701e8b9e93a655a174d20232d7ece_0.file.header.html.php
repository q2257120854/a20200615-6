<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:25:54
  from "D:\WWW\youke365_free\themes\pc\default\member\header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df304c2b2cf98_51768985',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6962fc3ad46701e8b9e93a655a174d20232d7ece' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\member\\header.html',
      1 => 1575557320,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5df304c2b2cf98_51768985 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php echo '<script'; ?>
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
public/editor/kindeditor-min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/layui/layui.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/js/common.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
public/layui/css/layui.css" rel="stylesheet" type="text/css" />
<link href="<?php echo @constant('tpl');?>
skin/<?php echo $_smarty_tpl->tpl_vars['cfg']->value['default_skin'];?>
/member.css" rel="stylesheet" type="text/css" />
<meta name="author" content="http://www.youke365.site" />

</head>

<body>
 <div id="header">
        <div id="topbox"> 
            <div id="other">
                <a href="<?php echo $_smarty_tpl->tpl_vars['site_root']->value;?>
">
                    <img src="/public/images/logo.png">
                </a>
            </div>
            <div id="others">
                <span id="logo">会员中心</span>
            </div>
        </div>
        <div id="navbar">
            <ul>
                <li ><a href="/">首 页</a></li>
                <li><a href="<?php echo url('home');?>
">会员中心</a></li><li class="navline"></li>

                <li><a href="<?php echo url('claim');?>
">网站认领</a></li><li class="navline"></li>
                <li><a href="<?php echo url('info');?>
">个人资料</a></li><li class="navline"></li>
                <li><a href="<?php echo url('logout');?>
">安全退出</a></li><li class="navline"></li>
              
            </ul>
        </div>
    </div>
<div id="wrapper">
<div class="left">

            <ul class="layui-nav layui-nav-tree" lay-filter="demo">
          <li class="layui-nav-item layui-nav-itemed">
            <a href="javascript:;">文章管理</a>
            <dl class="layui-nav-child">
              <dd><a href="<?php echo url('article');?>
">文章列表</a></dd>
              <dd><a href="<?php echo url('article',array('act'=>'add'));?>
">添加文章</a></dd>
            </dl>
         
          <li class="layui-nav-item layui-nav-itemed">
            <a href="javascript:;">网站管理</a>
             <dl class="layui-nav-child">
              <dd><a href="<?php echo url('website');?>
">网站列表</a></dd>
              <dd><a href="<?php echo url('website',array('act'=>'add'));?>
">添加网站</a></dd>
            </dl>
             </li>
       
        </ul>

</div>
   <div class="right">

    <div id="mainbox" class="mtop10"><?php }
}
