<?php
/* Smarty version 3.1.31, created on 2019-12-13 21:39:12
  from "D:\WWW\youke365_free\app\admin\view\user.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df39480b5b662_95489589',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c971f98ec911a9c94e6a84476bd181f5b22d403c' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\user.html',
      1 => 1525875610,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df39480b5b662_95489589 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('user',array('act'=>'add'));?>
">+添加新会员</a></span></h3>
	<div class="listbox">
		<form name="mform" method="post" action="<?php echo url('user');?>
">
		<div class="search">
			<input name="keywords" type="text" id="keywords" placeholder="会员昵称" class="ipt" size="30" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
			<input type="submit" class="btn" value="搜索" />
        </div>
        </form>
                    
		<form name="mform" method="post" action="<?php echo url('user');?>
">
		<div class="toolbar">
			<select name="act" id="act" class="sel">
			<option value="del" style="color: #f00;">删除选定</option>
            <option value="setpass" style="color: #083;">验证通过</option>
            <option value="nopass" style="color: #f60;">取消验证</option>
			</select>
			<input type="submit" class="btn" value="应用" onClick="if(IsCheck('user_id[]')==false){alert('请指定您要操作的会员ID！');return false;}else{return confirm('确认执行此操作吗？');}">

		</div>
	
    	<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>用户名</th>
				<th>会员类型</th>
				<th>电子邮件</th>
				<th>QQ</th>
				<th>注册时间</th>
				<th>会员状态</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<tr>
				<td><input name="user_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['user_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['user_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['nick_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['user_type'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['user_email'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['user_qq'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['join_time'];?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['item']->value['user_id'] != 1) {
echo $_smarty_tpl->tpl_vars['item']->value['user_status'];
} else { ?>正常<?php }?></td>
				<td><?php if ($_smarty_tpl->tpl_vars['item']->value['user_id'] != 1) {
echo $_smarty_tpl->tpl_vars['item']->value['user_operate'];
}?></td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="9">无任何会员！</td></tr>
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
</em><span><a href="<?php echo url('user');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
    	<form name="mform" method="post" action="<?php echo url('user');?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>会员类型：</th>
				<td><select name="user_type" id="user_type" class="sel"><?php echo $_smarty_tpl->tpl_vars['usertype_option']->value;?>
</select></td>
			</tr>
						<tr>
				<th>用户名：</th>
				<td><input name="nick_name" type="text" class="ipt" id="nick_name" size="50" maxlength="20" value="<?php if (!empty($_smarty_tpl->tpl_vars['user']->value['nick_name'])) {
echo $_smarty_tpl->tpl_vars['user']->value['nick_name'];
}?>"  <?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit') {?> readonly <?php }?> /><?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit') {?> 用户名禁止修改<?php } else { ?>*<?php }?></td>
			</tr>

			<tr>
				<th>登录密码：</th>
				<td><input name="user_pass" type="text" class="ipt" id="user_pass" size="50" maxlength="50" value="" />*</td>
			</tr>
			<tr>
				<th>电子邮箱：</th>
				<td><input name="user_email" type="text" class="ipt" id="user_email" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['user']->value['user_email'])) {
echo $_smarty_tpl->tpl_vars['user']->value['user_email'];
}?>" />*</td>
			</tr>
			<tr>
				<th>QQ号 码：</th>
				<td><input name="user_qq" type="text" class="ipt" id="user_qq" size="30" maxlength="30" value="<?php if (!empty($_smarty_tpl->tpl_vars['user']->value['user_qq'])) {
echo $_smarty_tpl->tpl_vars['user']->value['user_qq'];
}?>" /></td>
			</tr>
	<!-- 		<tr>
				<th>会员积分：</th>
				<td><input name="user_score" type="text" class="ipt" id="user_score" size="10" maxlength="10" value="<?php if (!empty($_smarty_tpl->tpl_vars['user']->value['user_score'])) {
echo $_smarty_tpl->tpl_vars['user']->value['user_score'];
}?>" /></td>
			</tr> -->
			<tr>
				<th>会员状态：</th>
				<td><select name="user_status" id="user_status" class="sel"><option value="0" style="color: #f60;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,0);?>
>待验证</option><option value="1" style="color: #080;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,1);?>
>已验证</option></select></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['user']->value['user_id']) {?>
					<input name="user_id" type="hidden" id="user_id" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['user_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo url('user');?>
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
