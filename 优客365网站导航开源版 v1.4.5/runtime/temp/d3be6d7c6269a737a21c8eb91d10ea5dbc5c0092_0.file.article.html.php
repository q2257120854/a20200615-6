<?php
/* Smarty version 3.1.31, created on 2019-12-13 18:26:48
  from "D:\WWW\youke365_free\app\admin\view\article.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df36768db7256_39596887',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd3be6d7c6269a737a21c8eb91d10ea5dbc5c0092' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\article.html',
      1 => 1576150534,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df36768db7256_39596887 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
	<h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('article',array('act'=>'add'));?>
">+添加文章</a></span></h3>
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
			<option value="del" style="color: #FF0000;">批量删除</option>

			</select>
			<input type="submit" class="btn" value="确定删除" onClick="if(IsCheck('art_id[]')==false){alert('请指定您要操作的文章ID！');return false;}else{return confirm('确认执行此操作吗？');}">
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status='+this.options[this.selectedIndex].value+'&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order=<?php echo $_smarty_tpl->tpl_vars['order']->value;
echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="0">所有状态</option>
			<option value="2" style="color: #f30;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,2);?>
>待审核</option>
			<option value="3" style="color: #080;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,3);?>
>已审核</option>
			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&cate_id='+this.options[this.selectedIndex].value+'&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order=<?php echo $_smarty_tpl->tpl_vars['order']->value;
echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="0" selected>所有分类</option>
			<?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>

			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort='+this.options[this.selectedIndex].value+'<?php echo $_smarty_tpl->tpl_vars['key_url']->value;?>
';}">
			<option value="1"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,1);?>
>按时间排列</option>
			<option value="2"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,2);?>
>按浏览排列</option>
			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
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
				<th>文章标题</th>
                <th>浏览次数</th>
				<th>文章作者</th>
                <th>属性状态</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['articles']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<tr>
				<td><input name="art_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_name'];?>
</td>

				<td><a href="<?php echo url('/home/artinfo',array('aid'=>$_smarty_tpl->tpl_vars['item']->value['art_id']));?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['art_title'];?>
</a></td>
           
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['art_views'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['nick_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['art_attr'];?>
</td>
				<td>
				<a href="<?php echo url('article',array('act'=>'edit','art_id'=>$_smarty_tpl->tpl_vars['item']->value['art_id']));?>
">编辑</a>
				&nbsp;|&nbsp;
				<a href="<?php echo url('article',array('act'=>'del','art_id'=>$_smarty_tpl->tpl_vars['item']->value['art_id']));?>
" onClick="return confirm(\'确认删除此内容吗？\');">删除</a>
				</td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="7">无任何文章！</td></tr>
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
				<th>所属分类：</th>
				<td><select name="cate_id" id="cate_id" class="sel"><?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>
</select></td>
			</tr>
			<tr>
				<th>文章标题：</th>
				<td><input name="art_title" type="text" class="ipt" id="art_title" size="50" maxlength="100" value="<?php if (!empty($_smarty_tpl->tpl_vars['article']->value['art_title'])) {
echo $_smarty_tpl->tpl_vars['article']->value['art_title'];
}?>" /></td>
			</tr>

			<tr>
				<th>内容来源：</th>
				<td><input name="copy_from" type="text" class="ipt" id="copy_from" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['article']->value['copy_from'])) {
echo $_smarty_tpl->tpl_vars['article']->value['copy_from'];
}?>" /><span class="tips">如: 凤凰网</span></td>
			</tr>
			<tr>
				<th>来源地址：</th>
				<td><input name="copy_url" type="text" class="ipt" id="copy_url" size="50" maxlength="200" value="<?php if (!empty($_smarty_tpl->tpl_vars['article']->value['copy_url'])) {
echo $_smarty_tpl->tpl_vars['article']->value['copy_url'];
}?>" /><span class="tips">如: http://www.youke365.site/</span></td>
			</tr>
			<tr>
				<th>文章内容：</th>
				<td>
				<!-- 加载编辑器的容器 -->
<?php echo '<script'; ?>
 name="art_content" id="art_content" type="text/plain" style="width:600px;height:400px;">
<?php if (!empty($_smarty_tpl->tpl_vars['article']->value['art_content'])) {
echo $_smarty_tpl->tpl_vars['article']->value['art_content'];
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
        window.um = UM.getEditor('art_content', {
        	/* 传入配置参数,可配参数列表看umeditor.config.js */
        });
    });
 <?php echo '</script'; ?>
>
		          
                </td>
			</tr>
 			<tr>
				<th>浏览次数：</th>
				<td><input name="art_views" type="text" class="ipt" id="art_views" size="10" maxlength="10" value="<?php if (!empty($_smarty_tpl->tpl_vars['article']->value['art_views'])) {
echo $_smarty_tpl->tpl_vars['article']->value['art_views'];
} else { ?>0<?php }?>" /> 次</td>
			</tr>
			<tr>
				<th>属性设置：</th>
				<td><input name="art_ispay" type="checkbox" id="art_ispay" value="1" <?php if (!empty($_smarty_tpl->tpl_vars['ispay']->value)) {?>
				<?php echo opt_checked($_smarty_tpl->tpl_vars['ispay']->value,1);
}?> /><label for="art_ispay">付费</label>　<input name="art_istop" type="checkbox" id="art_istop" value="1" <?php if (!empty($_smarty_tpl->tpl_vars['istop']->value)) {?>
				<?php echo opt_checked($_smarty_tpl->tpl_vars['istop']->value,1);
}?> /><label for="art_istop">置顶</label>　<input name="art_isbest" type="checkbox" id="art_isbest" value="1" <?php if (!empty($_smarty_tpl->tpl_vars['isbest']->value)) {?>
				<?php echo opt_checked($_smarty_tpl->tpl_vars['isbest']->value,1);
}?>/><label for="art_isbest">推荐</label></td>
			</tr>
			<tr>
				<th>审核状态：</th>
				<td><select name="art_status" id="art_status" class="sel">
			
				<option value="2" style="color: #f30;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,2);?>
>待审核</option>

				<option value="3" style="color: #080;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,3);?>
>已审核</option></select></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['article']->value['art_id']) {?>
					<input name="art_id" type="hidden" id="art_id" value="<?php echo $_smarty_tpl->tpl_vars['article']->value['art_id'];?>
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
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'move') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th valign="top">已选定的内容：</th>
				<td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['articles']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
&act=edit&art_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['art_title'];?>
</a><input name="art_id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['art']->value['art_id'];?>
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
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
';">
				</td>
			</tr>
		</table>
		</form>
	</div>
	<?php }?>
    
	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'attr') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th valign="top">已选定的内容：</th>
				<td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['articles']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
 - <a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
&act=edit&art_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['art_title'];?>
</a><input name="art_id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['art_id'];?>
"><br /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</td>
			</tr>
			<tr>
				<th>属性设置：</th>
				<td><input name="art_ispay" type="checkbox" id="art_ispay" value="1" /><label for="art_ispay">付费</label> <input name="art_istop" type="checkbox" id="art_istop" value="1" /><label for="art_istop">置顶</label>　<input name="art_isbest" type="checkbox" id="art_isbest" value="1" /><label for="art_isbest">推荐</label></td>
			</tr>
			<tr>
				<th>审核状态：</th>
				<td><select name="art_status" id="art_status" class="sel"><option value="1" style="color: #333;">草稿</option><option value="2" style="color: #f30;">待审核</option><option value="3" selected="selected" style="color: #080;">已审核</option></select></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td colspan="2">
				<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
				<input type="submit" class="btn" value="保 存">&nbsp;
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
