<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:44:00
  from "D:\WWW\youke365_free\app\admin\view\website.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a3b0f316a7_77020153',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e01468cc4bd4fd98fd700e442535b44fff9eb910' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\website.html',
      1 => 1576248238,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a3b0f316a7_77020153 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo url('website',array('act'=>'add'));?>
">+添加新站点</a></span></h3>
	<div class="listbox">
		<form name="mform" method="post" action="<?php echo url('website');?>
">
		<div class="search">
			<input name="keywords" type="text" id="keywords" class="ipt" size="30" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
			<input type="submit" class="btn" value="搜索" />
        </div>
        </form>
                    
		<form name="mform" method="post" action="<?php echo url('website');?>
">
		<div class="toolbar">
			<select name="act" id="act" class="sel">
			<option value="del" style="color: #f00;">批量删除</option>
			</select>
			<input type="submit" class="btn" value="确定删除" onClick="if(IsCheck('web_id[]')==false){alert('请指定您要操作的站点ID！');return false;}else{return confirm('确认执行此操作吗？');}">
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status='+this.options[this.selectedIndex].value+'&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order=<?php echo $_smarty_tpl->tpl_vars['order']->value;
echo $_smarty_tpl->tpl_vars['keyurl']->value;?>
';}">
			<option value="0">所有状态</option>
			<option value="1" style="color: #333;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,1);?>
>拉黑</option>
			<option value="2" style="color: #f30;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,2);?>
>待审核</option>
			<option value="3" style="color: #080;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,3);?>
>已审核</option>
			<option value="4" style=""<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,4);?>
>已顶置</option>
			<option value="5" style=""<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,5);?>
>已推荐</option>
			<option value="6" style=""<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,6);?>
>已付费</option>
			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&cate_id='+this.options[this.selectedIndex].value+'&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order=<?php echo $_smarty_tpl->tpl_vars['order']->value;
echo $_smarty_tpl->tpl_vars['keyurl']->value;?>
';}">
			<option value="0" selected>所有分类</option>
			<?php echo $_smarty_tpl->tpl_vars['category_option']->value;?>

			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort='+this.options[this.selectedIndex].value+'<?php echo $_smarty_tpl->tpl_vars['keyurl']->value;?>
';}">
			<option value="1"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,1);?>
>按提交时间排序</option>
            <option value="3"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,3);?>
>按百度权重排序</option>
            <option value="4"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,4);?>
>按搜狗权重排序</option>
			<option value="5"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,5);?>
>按Alexa排序</option>
			<option value="8"<?php echo opt_selected($_smarty_tpl->tpl_vars['sort']->value,8);?>
>按浏览排序</option>

			</select>
			<select class="sel" onChange="if(this.options[this.selectedIndex].value!=''){location='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
?status=<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
&user_id=<?php echo $_smarty_tpl->tpl_vars['user_id']->value;?>
&cate_id=<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
&sort=<?php echo $_smarty_tpl->tpl_vars['sort']->value;?>
&order='+this.options[this.selectedIndex].value+'<?php echo $_smarty_tpl->tpl_vars['keyurl']->value;?>
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
				<th>分类</th>
				<th>网站名称</th>
                <th>百度权重</th>
                <th>360权重</th>
                <th>搜狗权重</th>
				<th>Alexa排名</th>
				<th>入站次数</th>
				<th>出站次数</th>
				<th>浏览次数</th>
				<th>属性状态</th>
				<th>所 有 者</th>
				<th>收录时间</th>
				<th>操作选项</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['website']->value, 'web');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['web']->value) {
?>
			<tr>
				<td><input name="web_id[]" type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_cate'];?>
</td>
				<td class="ltext" style="width:200px;overflow:hidden"><img src="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_ico'];?>
"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
</td>
                <td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_brank'];?>
</td>
                <td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_r360'];?>
</td>
                <td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_srank'];?>
</td>
				<td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_arank'];?>
</td>
				<td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_instat'];?>
</td>
				<td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_outstat'];?>
</td>
				<td class="data"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_views'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_attr'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['web']->value['nick_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_ctime'];?>
</td>
				<td>
				<a href="<?php echo url('website',array('act'=>'edit','web_id'=>$_smarty_tpl->tpl_vars['web']->value['web_id']));?>
" >编辑</a>
				
				<a href="<?php echo url('website',array('act'=>'del','web_id'=>$_smarty_tpl->tpl_vars['web']->value['web_id']));?>
" onClick="return confirm('确认删除此内容吗？');">删除</a></td>
			</tr>
			<?php
}
} else {
?>

			<tr><td colspan="14">无任何网站！</td></tr>
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
</em><span><a href="<?php echo url('website');?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
    	<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>所属分类：</th>
				<td>
				<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['cate_id'])) {?>
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cate_pids']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
				<select name="level_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" id="level_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="sel"></select>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                <?php } else { ?>
                	<select name="level_0" id="level_0" class="sel"></select>
				<?php }?>
                

				<input type="hidden" name="cate_id" id="cate_id" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['cate_id'])) {
echo $_smarty_tpl->tpl_vars['web']->value['cate_id'];
}?>"></td>
			</tr>
			<tr>
				<th>网站名称：</th>
				<td><input name="web_name" type="text" class="ipt" id="web_name" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_name'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_name'];
}?>" /></td>
			</tr>
			<tr>
				<th>网站域名：</th>
				<td><input name="web_url" type="text" placeholder="http://或者https://必须存在" class="ipt" id="web_url" size="100" maxlength="100" " value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_url'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_url'];
}?>" /><input type="button" class="btn" id="meta_btn" value="抓取Meta" onclick="GetMeta()"><span class="tips">
				<br>注意：https站点用http 是无法抓取的；部分站点头部信息不完整，也是不可以抓取的。可以选择手动添加</span></td>
			</tr>
			<tr>
				<th>TAG标签：</th>
				<td><input name="web_tags" type="text" class="ipt" id="web_tags" size="50" maxlength="255" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_tags'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_tags'];
}?>" onBlur="javascript:this.value=this.value.replace(/，/ig,',');" /><span class="tips">多个标签用英文的“,”逗号隔开</span></td>
			</tr>
			<tr>
				<th valign="top">网站简介：</th>
				<td><textarea name="web_intro" cols="55" rows="8" class="ipt" id="web_intro"><?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_intro'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_intro'];
}?></textarea></td>
			</tr>
			<tr>
				<th valign="top">ico图标：</th>
				<td><input name="web_ico" type="text" cols="100" size="50" rows="8" class="ipt" id="web_ico" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_ico'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_ico'];
}?>">

				</td>
			</tr>		
            <tr>
				<th>服务器IP：</th>
				<td><input name="web_ip" type="text" class="ipt" id="web_ip" size="30" maxlength="30" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_ip'])) {
echo long2ip($_smarty_tpl->tpl_vars['web']->value['web_ip']);
}?>
				" /><input type="button" class="btn" id="data_btn" value="获取数据" onclick="GetData()"><span class="tips">例: 127.0.0.1</span></td>
			</tr>
 			<tr>
				<th>百度BR：</th>
				<td><input name="web_brank" type="text" class="ipt" id="web_brank" size="10" maxlength="1" value="<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_brank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_brank'];
} else { ?>0<?php }?>" /></td>
			</tr>
		    <tr>
				<th>360R：</th>
				<td><input name="web_r360" type="text" class="ipt" id="web_r360" size="10" maxlength="1" value="<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_r360'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_r360'];
} else { ?>0<?php }?>" /></td>
			</tr>
 			<tr>
				<th>搜狗SR：</th>
				<td><input name="web_srank" type="text" class="ipt" id="web_srank" size="10" maxlength="1" value="<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_srank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_srank'];
} else { ?>0<?php }?>" /></td>
			</tr>
 			<tr>
				<th>Alexa：</th>
				<td><input name="web_arank" type="text" class="ipt" id="web_arank" size="10" maxlength="10" value="<?php if (isset($_smarty_tpl->tpl_vars['web']->value['arank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['arank'];
} else { ?>0<?php }?>" /></td>
			</tr>

 			<tr>
				<th>浏览次数：</th>
				<td><input name="web_views" type="text" class="ipt" id="web_views" size="10" maxlength="10" value="<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_views'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_views'];
} else { ?>0<?php }?>" /> 次</td>
			</tr>

			<tr>
				<th>属性设置：</th>
				<td>
				<input name="web_ispay" type="checkbox" id="web_ispay" value="1" <?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_ispay'])) {
echo opt_checked($_smarty_tpl->tpl_vars['web']->value['web_ispay'],1);
}?> /><label for="web_ispay">付费</label>
				<input name="web_istop" type="checkbox" id="web_istop" value="1"<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_istop'])) {
echo opt_checked($_smarty_tpl->tpl_vars['web']->value['web_istop'],1);
}?> /><label for="web_istop">置顶</label>
				<input name="web_isbest" type="checkbox" id="web_isbest" value="1"<?php if (isset($_smarty_tpl->tpl_vars['web']->value['web_isbest'])) {
echo opt_checked($_smarty_tpl->tpl_vars['web']->value['web_isbest'],1);
}?> />
				<label for="web_isbest">推荐</label></td>
			</tr>
			<tr>
				<th>审核状态：</th>
				<td><select name="web_status" id="web_status" class="sel"><option value="1" style="color: #333;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,1);?>
>黑名单</option><option value="2" style="color: #f30;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,2);?>
>待审核</option><option value="3" style="color: #080;"<?php echo opt_selected($_smarty_tpl->tpl_vars['status']->value,3);?>
>已审核</option></select></td>
			</tr>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td>
					<input name="act" type="hidden" id="act" value="<?php echo $_smarty_tpl->tpl_vars['h_action']->value;?>
">
					<?php if ($_smarty_tpl->tpl_vars['action']->value == 'edit' && $_smarty_tpl->tpl_vars['web']->value['web_id']) {?>
					<input name="web_id" type="hidden" id="web_id" value="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
">
					<?php }?>
					<input type="submit" class="btn" value="保 存">&nbsp;
					<input type="reset" class="btn" value="取 消" onClick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
';">
				</td>
			</tr>
		</table>
        </form>
        <?php echo '<script'; ?>
 type="text/javascript" src="/public/js/linkage.select.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
        var url = '<?php echo url("api/collect",array("type"=>"category"));?>
';
		var options = {ajax :url, field_name : '[name=cate_id]', auto : true}
		var sel = new LinkageSelect(options);
		<?php if ($_smarty_tpl->tpl_vars['action']->value == 'add') {?>
	     	sel.bind('#level_0');
		<?php } else { ?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cate_pids']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
		      sel.bind('#level_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
', <?php echo $_smarty_tpl->tpl_vars['item']->value;?>
);
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		<?php }?>
        <?php echo '</script'; ?>
>
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['websites']->value, 'web');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['web']->value) {
?><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
&act=edit&web_id=<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
</a><input name="web_id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
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
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['websites']->value, 'web');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['web']->value) {
echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
 - <a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
&act=edit&web_id=<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
</a><input name="web_id[]" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
"><br /><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</td>
			</tr>
			<tr>
				<th>属性设置：</th>
				<td><input name="web_istop" type="checkbox" id="web_istop" value="1" /><label for="web_istop">置顶</label>　
				<input name="web_isbest" type="checkbox" id="web_isbest" value="1" /><label for="web_isbest">推荐</label>
				<input name="web_ispay" type="checkbox" id="web_ispay" value="1" /><label for="web_ispay">付费</label>
				</td>
			</tr>
			<tr>
				<th>审核状态：</th>
				<td><select name="web_status" id="web_status" class="sel"><option value="1" style="color: #333;">黑名单</option><option value="2" style="color: #f30;">待审核</option><option value="3" selected="selected" style="color: #080;">已审核</option></select></td>
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

	 <?php if ($_smarty_tpl->tpl_vars['action']->value == 'down') {?>
    <h3 class="title"><em><?php echo $_smarty_tpl->tpl_vars['pagetitle']->value;?>
</em><span><a href="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">返回列表&raquo;</a></span></h3>
	<div class="formbox">
		<form name="mform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['fileurl']->value;?>
">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<th>注意事项：</th>
				<td>下载远程图片，将占用一定的服务器资源，请避免在白天流量高峰期时段使用</td>
			<tr class="btnbox">
            	<th>&nbsp;</th>
				<td colspan="2">
				<input type="button" class="btn" value="下载所有站点图片" onClick="window.location.href='<?php echo url('webpic',array('act'=>'down','type'=>'all'));?>
';">&nbsp;
				<input type="button" class="btn" value="下载失败图片" onClick="window.location.href='<?php echo url('webpic',array('act'=>'down','type'=>'part'));?>
';">&nbsp;
                <input type="button" class="btn" value="失效图片检测" onClick="window.location.href='<?php echo url('webpic',array('act'=>'check'));?>
';">
				</td>
			</tr>
		</table>
		</form>
	</div>
    <?php }?>

<?php echo '<script'; ?>
>
//获取META
function GetMeta() {
	var url = $("#web_url").val();

	if (url == '') {
		alert('请输入网站域名！');
		$("#web_url").focus();
		return false;
	}
	$(document).ready(function(){$("#meta_btn").val('正在获取，请稍候...'); 
		$.ajax({type: "GET", 
			url: "<?php echo url('website',array('act'=>'metainfo'));?>
", 
			data: 'url=' + url,
			 datatype: "script",
			  cache: false, 
			success: function(data){
				if(data =='-1'){
					alert('请输入正确的网站域名！');
				}else if(data =='-2'){
                   alert('请输入网站域名！');
				}else{
					$("body").append(data); 
				}
				
		

			$("#meta_btn").val('重新获取');
		}});});		
}



//获取ip, PageRank, Sogou PageRank, Alexa
function GetData() {
	var url = $("#web_url").val();
	if (url == '') {
		alert('请输入网站域名！');
		$("#web_url").focus();
		return false;
	}
	$(document).ready(function(){$("#data_btn").val('正在获取，请稍候...');
	$.ajax({type: "GET", url:"<?php echo url('website',array('act'=>'webdata'));?>
", data: 'url=' + url, datatype: "script", cache: false, 
		success: function(data){
					if(data =='-1'){
					alert('请输入正确的网站域名！');
				}else if(data =='-2'){
                   alert('请输入网站域名！');
				}else{
					$("body").append(data); 
				}

		$("#data_btn").val('重新获取');}});});		
}


<?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
