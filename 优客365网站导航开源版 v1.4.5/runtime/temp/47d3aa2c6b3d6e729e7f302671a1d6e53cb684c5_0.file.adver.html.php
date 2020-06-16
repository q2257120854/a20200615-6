<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:33:22
  from "D:\WWW\youke365_free\app\admin\view\adver.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a1322def83_04783218',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '47d3aa2c6b3d6e729e7f302671a1d6e53cb684c5' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\adver.html',
      1 => 1524707348,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a1322def83_04783218 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
    <h3 class="title"><em>广告列表</em><span><a href="<?php echo url('adver',array('act'=>'add'));?>
">+添加新广告</a></span></h3>
	<div class="listbox">
        <form name="mform" method="post" action="<?php echo url('adver');?>
">
        <div class="search">
        	<input name="keywords" type="text" id="keywords" class="ipt" size="30" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
        	<input type="submit" class="btn" value="搜索" />
        </div>
        </form>
        
        <form name="mform" method="post" action="<?php echo url('adver');?>
">
        <div class="toolbar">
        	<select name="act" id="act" class="sel">
        	<option value="del" style="color: #FF0000;">删除选定</option>
        	</select>
        	<input type="submit" class="btn" value="应用" onClick="if(IsCheck('adver_id[]')==false){alert('请指定您要操作的广告ID！');return false;}else{return confirm('确认执行此操作吗？');}">
        
        </div>
                        
    	<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>广告类型</th>
				<th>广告名称</th>
				<th>有效天数</th>
				<th>广告显示状态</th>
				<th>到期时间</th>
				<th>前台调用代码</th>
				<th>广告状态</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['advers']->value, 'ad');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ad']->value) {
?>
			<tr>
				<td><input name="adver_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_id'];?>
</td>
				<td>代码广告</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_days'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_time_status'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_date'];?>
</td>
				<td><?php echo '<{get_adcode(';
echo $_smarty_tpl->tpl_vars['ad']->value['adver_id'];
echo ')}>';?>
</td></td>
                <td><?php if ($_smarty_tpl->tpl_vars['ad']->value['adver_status'] == 1) {?><span class="label label-success">开启</span><?php } else { ?><span class="label label-default">关闭</span><?php }?></td>
				<td><?php echo $_smarty_tpl->tpl_vars['ad']->value['adver_operate'];?>
</td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="8">无任何网站广告！</td></tr>
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
</em><span><a href="<?php echo url('adver');?>
">返回列表&raquo;</a></span></h3>
    <div class="formbox">
    	<form name="mform" method="post" action="<?php echo url('adver');?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>广告类型：</th>
				<td><input name="adver_type" type="radio" id="adver_type2" value="1" <?php if (!empty($_smarty_tpl->tpl_vars['ad_type']->value)) {
echo opt_checked($_smarty_tpl->tpl_vars['ad_type']->value,1);?>
 <?php }?> onClick="$('#url').hide(); $('#code').show();" /><label for="adver_type2">广告代码</label></td>
			</tr>
			<tr>
				<th>广告名称：</th>
				<td><input name="adver_name" type="text" class="ipt" id="adver_name" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_name'])) {
echo $_smarty_tpl->tpl_vars['adver']->value['adver_name'];
}?>" /></td>
			</tr>

			<tr id="code" >
				<th valign="top">广告代码：</th>
				<td><textarea name="adver_code" cols="50" rows="10" class="ipt" id="adver_code"><?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_code'])) {
echo $_smarty_tpl->tpl_vars['adver']->value['adver_code'];
}?></textarea></td>
			</tr>
			<tr>
				<th>过期提示：</th>
				<td><input name="adver_etips" type="text" class="ipt" id="adver_etips" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_etips'])) {
echo $_smarty_tpl->tpl_vars['adver']->value['adver_etips'];
}?>" /></td>
			</tr>
			<tr>
				<th>有效天数：</th>
				<td><input name="adver_days" type="text" class="ipt" id="adver_days" size="10" maxlength="3" value="<?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_days'])) {
echo $_smarty_tpl->tpl_vars['adver']->value['adver_days'];
} else { ?>0<?php }?>" /> 天<span class="tips">当有效天数为0时，表示广告长期有效</span></td>
			</tr>
			<tr>
				<th>广告状态：</th>
				<td><input name="adver_status" type="radio"  value="1" <?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_status'])) {
echo opt_checked($_smarty_tpl->tpl_vars['adver']->value['adver_status'],1);
}?>/><label for="adver_status1">显示</label>　<input name="adver_status" type="radio"  value="0" 
				<?php if (!empty($_smarty_tpl->tpl_vars['adver']->value['adver_status'])) {
echo opt_checked($_smarty_tpl->tpl_vars['adver']->value['adver_status'],0);
}?>
				/><label for="adver_status2">关闭</label></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['adver']->value['adver_id']) {?>
					<input name="adver_id" type="hidden" id="adver_id" value="<?php echo $_smarty_tpl->tpl_vars['adver']->value['adver_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url('adver');?>
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
