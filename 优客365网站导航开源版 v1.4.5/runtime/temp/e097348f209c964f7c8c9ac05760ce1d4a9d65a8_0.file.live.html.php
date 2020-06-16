<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:32:20
  from "D:\WWW\youke365_free\app\admin\view\live.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a0f42adf58_71068048',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e097348f209c964f7c8c9ac05760ce1d4a9d65a8' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\live.html',
      1 => 1537627843,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a0f42adf58_71068048 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
	<h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('live',array('act'=>'add'));?>
">+添加直播</a></span></h3>
    <div class="listbox">
        <form name="mform" method="post" action="<?php echo url('live');?>
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
            <option value="move" style="color: #06c;">移动内容</option>
            <option value="attr" style="color: #f60;">属性设置</option>
			</select>
			<input type="submit" class="btn" value="应用" onClick="if(IsCheck('id[]')==false){alert('请指定您要操作的直播ID！');return false;}else{return confirm('确认执行此操作吗？');}">
	
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo url('live');?>
?&cate_id='+this.options[this.selectedIndex].value+'&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order=<?php echo $_smarty_tpl->tpl_vars['order']->value;
echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="0" selected>所有分类</option>
			<?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>

			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo url('live');?>
?cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort='+this.options[this.selectedIndex].value+'<?php echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="1"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,1);?>
>按时间排列</option>
			<option value="2"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,2);?>
>按浏览排列</option>
			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo url('live');?>
?cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order='+this.options[this.selectedIndex].value+'<?php echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="DESC"<?php echo opt_selected($_smarty_tpl->tpl_vars['order']->value,'DESC');?>
>降序</option>
			<option value="ASC"<?php echo opt_selected($_smarty_tpl->tpl_vars['order']->value,'ASC');?>
>升序</option>
			</select>
		</div>
                    
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>所属分类</th>
				<th>直播标题</th>
                <th>属性状态</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lives']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<tr>
				<td><input name="id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['attr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['operate'];?>
</td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="7">无任何直播！</td></tr>
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
</em><span><a href="<?php echo url('live');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
    	<form name="mform" method="post" action="<?php echo url('live');?>
" enctype="multipart/form-data" >
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>所属分类：</th>
				<td><select name="cate_id" id="cate_id" class="sel"><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select></td>
			</tr>

			<tr>
				<th>直播标题：</th>
				<td><input name="title" type="text" class="ipt" id="title" size="50" maxlength="100" value="<?php if (!empty($_smarty_tpl->tpl_vars['live']->value['title'])) {
echo $_smarty_tpl->tpl_vars['live']->value['title'];
}?>" /></td>
			</tr>

			<tr>
				<th>直播流URL地址：</th>
				<td><input name="video_url" type="text" class="ipt" id="video_url" size="100"  value="<?php if (!empty($_smarty_tpl->tpl_vars['live']->value['video_url'])) {
echo $_smarty_tpl->tpl_vars['live']->value['video_url'];
}?>" /><span class="tips">直播地址。</span></td>
			</tr>

			<tr>
				<th>属性设置：</th>
				<td>
			
				　<input name="isbest" type="checkbox" id="isbest" value="1"<?php if (!empty($_smarty_tpl->tpl_vars['isbest']->value)) {
echo opt_checked($_smarty_tpl->tpl_vars['isbest']->value,1);
}?> /><label for="isbest">推荐</label></td>
			</tr> 
	
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['live']->value['id']) {?>
					<input name="id" type="hidden" id="id" value="<?php echo $_smarty_tpl->tpl_vars['live']->value['id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url('live');?>
';">
				</td>
			</tr>
		</table>
        </form>
	</div>           
	<?php }?>
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'move') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('live');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo url('live');?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th valign="top">已选定的内容：</th>
				<td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lives']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?><a href="<?php echo url('live');?>
&act=edit&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a><input name="id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['art']->value['id'];?>
"><br /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</td>
			</tr>
			<tr>
				<th>将以上内容移动至：</th>
				<td><select name="cate_id" id="cate_id" class="sel"><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url('live');?>
';">
				</td>
			</tr>
		</table>
		</form>
	</div>
	<?php }?>
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'attr') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('live');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo url('live');?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th valign="top">已选定的内容：</th>
				<td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lives']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
 - <a href="<?php echo url('live');?>
&act=edit&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a><input name="id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><br /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</td>
			</tr>
			<tr>
				<th>属性设置：</th>
				<td>
				<input name="isbest" type="checkbox" id="isbest" value="1" /><label for="isbest">推荐</label>
		

			</tr>

			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td colspan="2">
				<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
				<input type="submit" class="btn" value="保 存">&nbsp;
				<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url('live');?>
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
