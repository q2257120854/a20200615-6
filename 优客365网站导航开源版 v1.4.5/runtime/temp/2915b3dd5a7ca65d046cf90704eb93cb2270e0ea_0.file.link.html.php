<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:33:24
  from "D:\WWW\youke365_free\app\admin\view\link.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a1342b4724_02626209',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2915b3dd5a7ca65d046cf90704eb93cb2270e0ea' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\link.html',
      1 => 1524623144,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a1342b4724_02626209 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?act=add">+添加新链接</a></span></h3>
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
			<input type="submit" class="btn" value="应用" onClick="if(IsCheck('link_id[]')==false){alert('请指定您要操作的链接ID！');return false;}else{return confirm('确认执行此操作吗？');}">
        </div>
        
    	<table width="100%" border="0" cellspacing="1" cellpadding="0">
    		<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>网站名称</th>
				<th>链接地址</th>
				<th>是否可见</th>
				<th>排列顺序</th>
                <th>操作选项</th>
    		</tr>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['links']->value, 'link');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['link']->value) {
?>
    		<tr>
				<td><input name="link_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['link']->value['link_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_url'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_display'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_order'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['link']->value['link_operate'];?>
</td>
    		</tr>
			<?php
}
} else {
?>

			<tr><td colspan="7">无任何链接！</td></tr>
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
</em><span><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">返回列表&raquo;</a></span></h3>
    <div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>网站名称：</th>
				<td><input name="link_name" type="text" class="ipt" id="link_name" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['link']->value['link_name'])) {
echo $_smarty_tpl->tpl_vars['link']->value['link_name'];
}?>" /></td>
			</tr>
			<tr>
				<th>网站地址：</th>
				<td><input name="link_url" type="text" class="ipt" id="link_url" size="50" maxlength="255" value="<?php if (!empty($_smarty_tpl->tpl_vars['link']->value['link_url'])) {
echo $_smarty_tpl->tpl_vars['link']->value['link_url'];
}?>" /></td>
			</tr>
			<tr>
				<th>图标地址：</th>
				<td><input name="link_logo" type="text" class="ipt" id="link_logo" size="50" maxlength="255" value="<?php if (!empty($_smarty_tpl->tpl_vars['link']->value['link_logo'])) {
echo $_smarty_tpl->tpl_vars['link']->value['link_logo'];
}?>" /></td>
			</tr>
			<tr>
				<th>是否显示：</th>
				<td><input name="link_display" type="radio" id="link_display1" value="1"<?php echo opt_checked($_smarty_tpl->tpl_vars['display']->value,1);?>
><label for="link_display1">显示</label>　<input name="link_display" type="radio" id="link_display2" value="2"<?php echo opt_checked($_smarty_tpl->tpl_vars['display']->value,2);?>
><label for="link_display2">隐藏</label></td>
			</tr>
			<tr>
				<th>排列顺序：</th>
				<td><input name="link_order" type="number" class="ipt" id="link_order" size="10" maxlength="3" value="<?php if (!empty($_smarty_tpl->tpl_vars['link']->value['link_order'])) {
echo $_smarty_tpl->tpl_vars['link']->value['link_order'];
} else { ?>0<?php }?>" /></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['link']->value['link_id']) {?>
					<input name="link_id" type="hidden" id="link_id" value="<?php echo $_smarty_tpl->tpl_vars['link']->value['link_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">
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
