<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:33:39
  from "D:\WWW\youke365_free\app\admin\view\page.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a143e7f983_31581571',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db80d44edefd692bda25cf36450ff0baea53f5b9' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\page.html',
      1 => 1535676671,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a143e7f983_31581571 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
	<h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('page',array('act'=>'add'));?>
">+添加新页面</a></span></h3>
    <div class="listbox">
        <form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
        <div class="search">
        	<input name="keywords" type="text" id="keywords" class="ipt" size="30" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
        	<input type="submit" class="btn" value="搜索" />
        </div>
        </form>
        
        <form name="mform" method="post" action="">
        <div class="toolbar">
			<select name="act" id="act" class="sel">
			<option value="del" style="color: #FF0000;">删除选定</option>
			</select>
			<input type="submit" class="btn" value="应用" onClick="if(IsCheck('page_id[]')==false){alert('请指定您要操作的页面ID！');return false;}else{return confirm('确认执行此操作吗？');}">
		</div>
                    
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>页面名称</th>
				<th>页面说明</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
?>
			<tr>
				<td><input name="page_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['page']->value['page_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['page']->value['page_intro'];?>
</td>
				<td><a href="<?php echo url('page',array('act'=>'edit','page_id'=>$_smarty_tpl->tpl_vars['page']->value['page_id']));?>
">编辑</a>
				&nbsp;|&nbsp;<a href="<?php echo url('page',array('act'=>'del','page_id'=>$_smarty_tpl->tpl_vars['page']->value['page_id']));?>
" 
				onClick="return confirm(\'确认删除此内容吗？\');">删除</a></td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="5">无任何自定义页面！</td></tr>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</table>
		</form>
        <div class="pagebox"><?php echo $_smarty_tpl->tpl_vars['showpage']->value;?>
</div>
	</div>
	<?php }?>
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'add' || $_smarty_tpl->tpl_vars['action']->value == 'edit') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('page');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
    	<form name="mform" method="post" action="<?php echo url('page');?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>页面名称：</th>
				<td><input name="page_name" type="text" class="ipt" id="page_name" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['page']->value['page_name'])) {
echo $_smarty_tpl->tpl_vars['page']->value['page_name'];
}?>" /></td>
			</tr>
			<tr>
				<th>页面说明：</th>
				<td><input name="page_intro" type="text" class="ipt" id="page_intro" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['page']->value['page_intro'])) {
echo $_smarty_tpl->tpl_vars['page']->value['page_intro'];
}?>" /><span class="tips">页面说明，可不填写，字数限制在50个以内</span></td>
			</tr>
			<tr>
				<th>页面内容：</th>
				<td>
									<!-- 加载编辑器的容器 -->
<?php echo '<script'; ?>
 name="page_content" id="page_content" type="text/plain" style="width:600px;height:400px;">
<?php if (!empty($_smarty_tpl->tpl_vars['page']->value['page_content'])) {
echo htmlspecialchars_decode($_smarty_tpl->tpl_vars['page']->value['page_content']);
}
echo '</script'; ?>
>
<!-- 样式文件 -->
<link rel="stylesheet" href="/public/umeditor/themes/default/css/umeditor.css">

<!-- 配置文件 -->
<?php echo '<script'; ?>
 type="text/javascript" src="/public/umeditor/umeditor.config.js"><?php echo '</script'; ?>
>
<!-- 编辑器源码文件 -->
<?php echo '<script'; ?>
 type="text/javascript" src="/public/umeditor/umeditor.js"><?php echo '</script'; ?>
>

<!-- 实例化编辑器代码 -->
<?php echo '<script'; ?>
 type="text/javascript">
    $(function(){
        window.um = UM.getEditor('page_content', {
        	/* 传入配置参数,可配参数列表看umeditor.config.js */
        });
    });
 <?php echo '</script'; ?>
>
                </td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['page']->value['page_id']) {?>
					<input name="page_id" type="hidden" id="page_id" value="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url("page");?>
';">
				</td>
			</tr>
		</table>
        </form>
	</div>           
	<?php }?>

<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
