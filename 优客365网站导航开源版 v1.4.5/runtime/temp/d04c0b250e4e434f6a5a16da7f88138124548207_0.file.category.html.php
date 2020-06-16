<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:44:22
  from "D:\WWW\youke365_free\app\admin\view\category.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a3c6635827_90147423',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd04c0b250e4e434f6a5a16da7f88138124548207' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\category.html',
      1 => 1576248167,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a3c6635827_90147423 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>

	<h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url($_GET['controller'],array('mod'=>$_smarty_tpl->tpl_vars['cate_mod']->value,'act'=>'add','root_id'=>$_smarty_tpl->tpl_vars['root_id']->value));?>
">+添加新分类</a></span></h3>
	<div class="listbox">
		<form name="mform" method="post" action="<?php echo url($_GET['controller']);?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>ID</th>
				<th>分类名称</th>
				<th>下级</th>
				<th>内容数量</th>
				<th>排序</th>
				<th>栏目</th>
				<th>操作</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'cate');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cate']->value) {
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_name'];?>
 </td>
		
				<td><a href="?root_id=<?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_childcount'];?>
</a></td>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_postcount'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_order'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_attr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['cate']->value['cate_operate'];?>
</td>
			</tr>
			<?php
}
} else {
?>

				<?php if ($_smarty_tpl->tpl_vars['root_id']->value == 0) {?>
				<tr><td colspan="8">无任何分类！</td></tr>
				<?php } else { ?>
				<tr><td colspan="8">该分类下无任何子分类！<a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
&root_id=0">返回顶级分类</a></td></tr>
			<?php }?>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</table>
		</form>
	</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'add' || $_smarty_tpl->tpl_vars['action']->value == 'edit') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('category',array('mod'=>$_smarty_tpl->tpl_vars['cate_mod']->value));?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
    	<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>分类：</th>
				<td><select name="root_id" id="root_id" class="sel"><option value="0">作为顶级分类</option><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select><input name="cate_mod" type="hidden" id="cate_mod" value="<?php echo $_smarty_tpl->tpl_vars['cate_mod']->value;?>
"></td>
			</tr>
			<tr>
				<th>分类名称：</th>
				<td><input name="cate_name" type="text" class="ipt" id="cate_name" size="35" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_name'])) {
echo $_smarty_tpl->tpl_vars['row']->value['cate_name'];
}?>" />  <input name="cate_isbest" type="checkbox" id="cate_isbest" value="1"<?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_isbest'])) {
echo opt_checked($_smarty_tpl->tpl_vars['row']->value['cate_isbest'],1);
}?> /><label for="cate_isbest">设为推荐</label></td>
			</tr>
			<tr>
				<th>目录名称：</th>
				<td><input name="cate_dir" type="text" class="ipt" id="cate_dir" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_dir'])) {
echo $_smarty_tpl->tpl_vars['row']->value['cate_dir'];
}?>" /></td>
			</tr>
			<tr>
				<th>跳转地址：</th>
				<td><input name="cate_url" type="text" class="ipt" id="cate_url" size="50" maxlength="255" value="<?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_url'])) {
echo $_smarty_tpl->tpl_vars['row']->value['cate_url'];
}?>" /></td>
			</tr>
			<tr>
				<th>关 键 词：</th>
				<td><input name="cate_keywords" type="text" class="ipt" id="cate_keywords" size="50" maxlength="255" value="<?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_keywords'])) {
echo $_smarty_tpl->tpl_vars['row']->value['cate_keywords'];
}?>" /><span class="tips">多个关键词之间用“逗号”隔开</span></td>
			</tr>
			<tr>
				<th valign="top">分类描述：</th>
				<td><textarea name="cate_description" cols="50" rows="6" class="ipt" id="cate_description"><?php if (!empty($_smarty_tpl->tpl_vars['row']->value['cate_description'])) {
echo $_smarty_tpl->tpl_vars['row']->value['cate_description'];
}?></textarea></td>
			</tr>
			<tr>
				<th>排列顺序：</th>
				<td><input name="cate_order" type="text" class="ipt" id="cate_order" size="10" maxlength="10" value="<?php echo empty($_smarty_tpl->tpl_vars['row']->value['cate_order']) ? '0' : $_smarty_tpl->tpl_vars['row']->value['cate_order'];?>
" /></td>
			</tr>
			<tr class="btnbox">
            	<td>&nbsp;</td>
				<td>
                    <input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
                    <input name="cate_mod" type="hidden" id="cate_mod" value="<?php echo $_smarty_tpl->tpl_vars['cate_mod']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['row']->value['cate_id']) {?>
					<input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cate_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
';">
				</td>
			</tr>
		</table>
        </form>
	</div>
	<?php }?>
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'reset') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('category',array('mod'=>$_smarty_tpl->tpl_vars['cate_mod']->value));?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
            	<th>注意事项：</th>
				<td>如果选择复位所有分类，则所有分类都将作为一级分类，这时您需要重新对各个分类进行归属的基本设置。<br />不要轻易使用该功能，仅在做出了错误的设置而无法复原分类之间的关系和排序的时候使用。</td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
                    <input name="cate_mod" type="hidden" id="cate_mod" value="<?php echo $_smarty_tpl->tpl_vars['cate_mod']->value;?>
">
					<input type="submit" class="btn" value="复 位">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
';">
				</td>
			</tr>
		</table>
		</form>
	</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'merge') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('category',array('mod'=>$_smarty_tpl->tpl_vars['cate_mod']->value));?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>将分类：</th>
				<td><select name="source_id" id="source_id" class="sel"><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select></td>
			</tr>
			<tr>
				<th>合并到：</th>
				<td><select name="target_id" id="target_id" class="sel"><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select></td>
			</tr>
			<tr>
            	<th>注意事项：</th>
				<td><font color="#ff0000">所有操作不可逆，请慎重操作！</font><br />不能在同一个分类内进行操作，不能将一个分类合并到其下属分类中，目标分类中不能含有子分类，合并后您所指定的分类（或者包括其下属分类）将被删除，所有内容将转移到目标分类中。</td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
                    <input name="cate_mod" type="hidden" id="cate_mod" value="<?php echo $_smarty_tpl->tpl_vars['cate_mod']->value;?>
">
					<input type="submit" class="btn" value="合 并">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
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
