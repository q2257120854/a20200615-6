<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:40:26
  from "D:\WWW\youke365_free\app\admin\view\database.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a2da9ecbe7_95084406',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0bffbc4d50aa48c87ad3732b349c064b46e214e4' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\database.html',
      1 => 1524031359,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a2da9ecbe7_95084406 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    
    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'backup') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>备份类型：</th>
				<td><input name="baktype" type="radio" id="baktype1" value="full" checked="checked" onclick="$('#table').hide();"><label for="baktype1">全部备份(推荐) - 备份数据库所有表</label><br /><input name="baktype" type="radio" id="baktype2" value="custom" onclick="$('#table').show();"><label for="baktype2">自定义备份 - 根据自行选择备份数据表</label></td>
			</tr>
			<tr id="table" style="display: none;">
				<th>数 据 表：</th>
				<td>
                	<table cellpadding="0" cellspacing="1">
                   	  <tr>
                      	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tables']->value, 'item');
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$__foreach_item_0_saved = $_smarty_tpl->tpl_vars['item'];
?>
						<td style="padding: 3px 10px;"><input name="table[]" type="checkbox" id="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" size="50" maxlength="255" value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
" /><label for="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</label></td>
                      	<?php if (!($_smarty_tpl->tpl_vars['item']->iteration % 4)) {?></tr><tr><?php }?>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                      </tr>
                  </table>      
              </td>
			</tr>
			<tr>
				<th>分卷文件大小：</th>
				<td><input name="volsize" type="text" class="ipt" id="volsize" size="10" maxlength="10" value="2048" /> KB</td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<input type="submit" class="btn" value="数据库备份">
				</td>
			</tr>
		</table>
        </form>
	</div>           
	<?php }?>
    
    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'restore') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="listbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>文件名称</th>
				<th>文件大小</th>
				<th>修改时间</th>
				<th>操作选项</th>
			</tr>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['files']->value, 'item');
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$__foreach_item_1_saved = $_smarty_tpl->tpl_vars['item'];
?>
            <tr>
            	<td><?php echo $_smarty_tpl->tpl_vars['item']->value['filename'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['filesize'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['filemtime'];?>
</td>
                <td><a href="<?php echo url('database',array('act'=>'import','file'=>$_smarty_tpl->tpl_vars['item']->value['filename']));?>
" onClick="return confirm('确认导入此文件吗？')">导入</a>&nbsp;|&nbsp;<a href="<?php echo url('database',array('act'=>'delete','file'=>$_smarty_tpl->tpl_vars['item']->value['filename']));?>
" onClick="return confirm('确认删除此文件吗？注：删除后将无法恢复！')">删除</a></td>
            </tr>
            <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_1_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</table>
        </form>
	</div>           
	<?php }?>

    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'maintain') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>选择操作：</th>
				<td><input name="do[]" type="checkbox" id="check" value="check" checked="checked"><label for="check">检查表</label></td>
			</tr>
			<tr>
				<th></th>
				<td><input name="do[]" type="checkbox" id="repair" value="repair" checked="checked"><label for="repair">修复表</label></td>
			</tr>
			<tr>
				<th></th>
				<td><input name="do[]" type="checkbox" id="analyze" value="analyze" checked="checked"><label for="analyze">分析表</label></td>
			</tr>
			<tr>
				<th></th>
				<td><input name="do[]" type="checkbox" id="optimize" value="optimize" checked="checked"><label for="optimize">优化表</label></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<input type="submit" class="btn" value="数据库维护">
				</td>
			</tr>
		</table>
        </form>
	</div>    
	<?php }?>
    
    <?php if ($_smarty_tpl->tpl_vars['action']->value == 'dbinfo') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em></h3>
    <div class="listbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
 		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>数据表名称</th>
                <th>数据表类型</th>
				<th>创建时间</th>
				<th>最后更新时间</th>
				<th>记录数</th>
                <th>数据</th>
                <th>索引</th>
                <th>碎片</th>
			</tr>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tables']->value, 'item');
$_smarty_tpl->tpl_vars['item']->iteration = 0;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->iteration++;
$__foreach_item_2_saved = $_smarty_tpl->tpl_vars['item'];
?>
            <tr>
            	<td><?php echo $_smarty_tpl->tpl_vars['item']->value['Name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Engine'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Create_time'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Update_time'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Rows'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Data_length'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Index_length'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['Data_free'];?>
</td>
            </tr>
            <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_item_2_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            <tr>
            	<td colspan="4">共 <?php echo $_smarty_tpl->tpl_vars['table_num']->value;?>
 个数据表</td>
                <td><?php echo $_smarty_tpl->tpl_vars['table_rows']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['data_size']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['index_size']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['free_size']->value;?>
</td>
            </tr>
		</table>
        </form>
	</div>           
	<?php }?>
    
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
