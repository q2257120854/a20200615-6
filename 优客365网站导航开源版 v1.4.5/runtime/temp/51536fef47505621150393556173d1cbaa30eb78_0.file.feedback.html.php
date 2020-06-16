<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:33:25
  from "D:\WWW\youke365_free\app\admin\view\feedback.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a135bc51d0_27589587',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '51536fef47505621150393556173d1cbaa30eb78' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\feedback.html',
      1 => 1524557455,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a135bc51d0_27589587 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="listbox">
		<form name="mform" method="post" action="<?php echo url('feedback');?>
">
        <div class="search">
			<input name="keywords" type="text" id="keywords" class="ipt" size="30" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
			<input type="submit" class="btn" value="搜索" />
        </div>
        </form>
                   
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<div class="toolbar">
			<select name="act" id="act" class="sel">
			<option value="del" style="color: #FF0000;">删除选定</option>
			</select>
			<input type="submit" class="btn" value="应用" onClick="if(IsCheck('fb_id[]')==false){alert('请指定您要操作的意见ID！');return false;}else{return confirm('确认执行此操作吗？');}">
		</div>
                        
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th><input type="checkbox" id="ChkAll" onClick="CheckAll(this.form)"></th>
				<th>ID</th>
				<th>用户昵称</th>
				<th>电子邮件</th>
				<th>提交时间</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['feedback']->value, 'fb');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['fb']->value) {
?>
			<tr>
				<td><input name="fb_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_nick'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_email'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_date'];?>
</td>
				<td><a href="<?php echo url('feedback',array('act'=>'view','fb_id'=>$_smarty_tpl->tpl_vars['fb']->value['fb_id']));?>
">查看</a>&nbsp;|&nbsp;<a href="<?php echo url('feedback',array('act'=>'del','fb_id'=>$_smarty_tpl->tpl_vars['row']->value['fb_id']));?>
" onClick="return confirm('确认删除此内容吗？');">删除</a></td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="6">无任何反馈信息！</td></tr>
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

    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'view') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="formbox">
		<form name="mform" method="post" action="">
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
        	<tr>
            	<th>用户昵称：</th>
                <td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_nick'];?>
</td>
            </tr>
            <tr>
            	<th>电子邮件：</th>
                <td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_email'];?>
</td>
            </tr>
           	<tr>
            	<th>反馈内容：</th>
            	<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_content'];?>
</td>
            </tr>
            <tr>
            	<th>提交时间：</th>
            	<td><?php echo $_smarty_tpl->tpl_vars['fb']->value['fb_date'];?>
</td>
            </tr>
            <tr class="btnbox">
            	<th>&nbsp;</th>
            	<td>
                	<input type="button" class="btn" value="删 除" onclick="if (confirm('确认删除此内容吗？')) { window.location.href='<?php echo url("feedback",array("act"=>"del","fb_id"=>$_smarty_tpl->tpl_vars['fb']->value['fb_id']));?>
'}">&nbsp;
                	<input type="button" class="btn" value="返回列表" onClick="window.location.href='<?php echo url('feedback');?>
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
