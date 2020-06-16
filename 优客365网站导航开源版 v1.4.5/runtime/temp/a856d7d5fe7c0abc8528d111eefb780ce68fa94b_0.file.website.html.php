<?php
/* Smarty version 3.1.31, created on 2019-12-13 11:25:54
  from "D:\WWW\youke365_free\themes\pc\default\member\website.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df304c2aa43f9_17248430',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a856d7d5fe7c0abc8528d111eefb780ce68fa94b' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\themes\\pc\\default\\member\\website.html',
      1 => 1524794446,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df304c2aa43f9_17248430 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		
            <div class="content">
            	<div class="title"><?php echo $_smarty_tpl->tpl_vars['pagename']->value;?>
</div>
                <div class="body">
        <?php if ($_smarty_tpl->tpl_vars['action']->value == 'list') {?>
        <div id="listbox">
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr>
					<th>ID</th>
					<th>所属分类</th>
					<th>网站名称</th>
					<th>网站地址</th>
					<th>属性状态</th>
					<th>提交时间</th>
					<th>操作选项</th>
				</tr>
          
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['weblist']->value, 'web');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['web']->value) {
?>
				<tr>
					<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['web']->value['cate_name'];?>
</td>
					<td class="textleft"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_name'];?>
</td>
					<td class="textleft"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_url'];?>
</td>
					<td style="color: #FF0000;"><?php echo $_smarty_tpl->tpl_vars['web']->value['web_status'];?>
</td>
					<td><?php echo $_smarty_tpl->tpl_vars['web']->value['web_ctime'];?>
</td>
					<td><a  href="<?php echo url('website',array('act'=>'edit','wid'=>$_smarty_tpl->tpl_vars['web']->value['web_id']));?>
" class="layui-btn layui-btn-normal layui-btn-small"><i class="layui-icon"></i></a></td>
                    <td></td>
				</tr>
				<?php
}
} else {
?>

				<tr><td colspan="7">您还未提交任何站点！</td></tr>
				<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

			</table>
		</div>
        <div id="showpage" class="clearfix"><?php echo $_smarty_tpl->tpl_vars['showpage']->value;?>
</div>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['action']->value == 'add' || $_smarty_tpl->tpl_vars['action']->value == 'edit') {?>
        <?php if ($_smarty_tpl->tpl_vars['cfg']->value['is_enabled_submit'] == 'yes') {?>

        <div id="formbox">
			<form name="myfrom" id="myfrom" method="post" action="<?php echo url('website');?>
">
		
        	<ul>
        		<li><strong>选择分类：</strong>
        		<?php if (!empty($_smarty_tpl->tpl_vars['cate_pids']->value)) {?>
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
}?>"></li>
        		<li><strong>网站名称：</strong><input type="text" name="web_name" id="web_name" class="ipt" size="50" maxlength="50" 
        		value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_name'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_name'];
}?>" /></li>
            	<li><strong>网站域名：</strong><input type="text" name="web_url" id="web_url" class="ipt" size="50" maxlength="50"  onblur="checkurl(this.value)" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value)) {
echo $_smarty_tpl->tpl_vars['web']->value['web_url'];
}?>" /><input type="button" class="btn" id="meta_btn" value="抓取Meta" onclick="getmeta()"> 必须带http:// 或者 https://</li>


            	<li><strong>TAG标签：</strong><input type="text" name="web_tags" id="web_tags" class="ipt" size="50" maxlength="50" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_tags'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_tags'];
}?>" onBlur="javascript:this.value=this.value.replace(/，/ig,',');" /></li>
            	<li><strong>网站简介：</strong><textarea name="web_intro" id="web_intro" cols="55" rows="6" class="ipt"><?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_intro'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_intro'];
}?></textarea></li>
				<li><strong>服务器IP：</strong><input name="web_ip" type="text" class="ipt" id="web_ip" size="30" maxlength="30" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_ip'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_ip'];
}?>" readonly /><input type="button" class="btn" id="data_btn" value="获取数据" onclick="getdata()">&nbsp;</li>
                <li><strong>百度权重：</strong><input name="web_brank" type="text" class="ipt" id="web_brank" size="10" maxlength="2" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_brank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_brank'];
} else { ?>0<?php }?>" readonly /></li>
                <li><strong>360权重：</strong><input name="web_r360" type="text" class="ipt" id="web_r360" size="10" maxlength="2" 
                value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_r360'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_r360'];
} else { ?>0<?php }?>" readonly /></li>
                <li><strong>搜狗权重：</strong><input name="web_srank" type="text" class="ipt" id="web_srank" size="10" maxlength="2" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_srank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_srank'];?>
0<?php } else { ?>0<?php }?>" readonly /></li>
				<li><strong>Alexa：</strong><input name="web_arank" type="text" class="ipt" id="web_arank" size="10" maxlength="10" value="<?php if (!empty($_smarty_tpl->tpl_vars['web']->value['web_arank'])) {
echo $_smarty_tpl->tpl_vars['web']->value['web_arank'];?>
0<?php } else { ?>0<?php }?>" readonly /></li>
            	<li><strong>&nbsp;</strong><input type="hidden" name="web_id" id="web_id" value="<?php echo $_smarty_tpl->tpl_vars['web']->value['web_id'];?>
"><input type="hidden" name="do" id="do" value="<?php echo $_smarty_tpl->tpl_vars['do']->value;?>
"><input type="submit" class="btn" value="提 交"> <input type="reset" class="btn" value="重 填"></li>
        	</ul>
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
        <?php } else { ?>
        <div style="background: #ffc; border: dashed 1px #f30; color: #f00; padding: 20px; text-align: center;"><?php echo $_smarty_tpl->tpl_vars['cfg']->value['submit_close_reason'];?>
</div>
        <?php }?>
		<?php }?>
                </div>
            </div>
<?php echo '<script'; ?>
>

//验证url
function checkurl(url){
    if (url == '') {
        $("#msg").html('请输入网站域名！');
        return false;
    }
      $.get('<?php echo url("api/collect",array("type"=>"check"));?>
?url='+url,function(json){
      if(json.code != 0){
         layer.msg(json.msg);  
      }

    });



}

//获取META
function getmeta() {

    var url = $("#web_url").val();
    if (url == '') {
        layer.msg('请输入网站域名！');
        $("#web_url").focus();
        return false;
    }
     $("#meta_btn").val('正在获取，请稍候...');
    $.get('<?php echo url("api/collect",array("type"=>"get_meta"));?>
?url='+url,function(json){
      if(json.code == 0){
        $("#web_name").val(json.data.title);
        $("#web_tags").val(json.data.keywords);
        $("#web_intro").val(json.data.description);

      }else{
         layer.msg(json.msg);
      }
    
     $("#meta_btn").val('重新获取');
    });
    
}

//获取IP, PageRank, Sogou PageRank, Alexa
function getdata() {
    var url = $("#web_url").val();
    if (url == '') {
        alert('请输入网站域名！');
        $("#web_url").focus();
        return false;
    }
$("#data_btn").val('正在获取，请稍候...');
  $.get('<?php echo url("api/collect",array("type"=>"data"));?>
?url='+url,function(json){
      if(json.code == 0){ 
         $("#web_ip").val(json.data.ip);
$("#web_r360").val(json.data.r360);
$("#web_brank").val(json.data.brank);
$("#web_srank").val(json.data.srank);
$("#web_arank").val(json.data.arank);

      }else{
         layer.msg(json.msg);
      }
    
     $("#data_btn").val('重新获取');
    });
    
}


<?php echo '</script'; ?>
>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
