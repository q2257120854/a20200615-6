<?php
/* Smarty version 3.1.31, created on 2019-12-13 22:39:31
  from "D:\WWW\youke365_free\app\admin\view\main.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5df3a2a3d5b211_90958633',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52162f96655200a9e68f8e4abaa249f76f9218db' => 
    array (
      0 => 'D:\\WWW\\youke365_free\\app\\admin\\view\\main.html',
      1 => 1576247970,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5df3a2a3d5b211_90958633 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div style="width:100%;padding:2px"></div>

<blockquote class="layui-elem-quote "><?php echo @constant('SYS_NAME');?>
 当前版本号 v<?php echo $_smarty_tpl->tpl_vars['server']->value['soft_version'];?>

<span id="new-version">暂无新版</span>
<span id="auth"></span>

<button id="update" data-v="<?php echo @constant('SYS_VERSION');?>
" data-url="<?php echo '<?php ';?>echo UPDATE_API_URL;<?php echo '?>';?>"  class="layui-btn layui-btn-normal" style="float:right;margin-top:-9px"><i class="layui-icon">&#xe681;</i> 检查升级</button></blockquote>
</blockquote>


<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">站内数据统计</h3>
    </div>
    <div class="panel-body">
        				<table class="layui-table">
			<tr height="30">
				<td>网站分类：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['cate_webdir'];?>
</b>　-　<a href="<?php echo url('category',array('mod'=>'webidr'));?>
">快速管理&raquo;</a></td>
				<td>网站数量：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['website'];?>
</b>　-　<a href="<?php echo url('website');?>
">快速管理&raquo;</a></td>
			</tr>
			 <tr height="30">
				<td>文章分类：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['cate_article'];?>
</b>　-　<a href="<?php echo url('category',array('mod'=>'article'));?>
">快速管理&raquo;</a></td>
				<td>文章数量：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['article'];?>
</b>　-　<a href="<?php echo url('article');?>
">快速管理&raquo;</a></td>
			</tr>
			 <tr height="30">
				<td>小游戏分类：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['cate_game'];?>
</b>　-　<a href="<?php echo url('category',array('mod'=>'game'));?>
">快速管理&raquo;</a></td>
				<td>小游戏数量：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['game'];?>
</b>　-　<a href="<?php echo url('game');?>
">快速管理&raquo;</a></td>
			</tr>

			 <tr height="30">
				<td>视频分类：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['cate_video'];?>
</b>　-　<a href="<?php echo url('category',array('mod'=>'video'));?>
">快速管理&raquo;</a></td>
				<td>视频数量：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['video'];?>
</b>　-　<a href="<?php echo url('video');?>
">快速管理&raquo;</a></td>
			</tr>

			<tr height="30">

				<td width="50%">友情链接：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['link'];?>
</b>　-　<a href="<?php echo url('link');?>
">快速管理&raquo;</a></td>
			
			</tr>
			<tr height="30">
				<td>网站提交：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['apply'];?>
</b>　-　<a href="<?php echo url('website',array('status'=>'2'));?>
">快速管理&raquo;</a></td>
				<td>意见反馈：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['feedback'];?>
</b>　-　<a href="<?php echo url('feedback',array('mod'=>'video'));?>
">快速管理&raquo;</a></td>
			</tr>

			<tr height="30">
				<td>注册会员：&nbsp;<b style="color: #008800;"><?php echo $_smarty_tpl->tpl_vars['stat']->value['user'];?>
</b>　-　<a href="<?php echo url('user');?>
">快速管理&raquo;</a></td>
				<td></td>
			</tr>
		</table>
    </div>
</div>
<div class="layui-card">
  <div class="layui-card-header">推荐信息</div>
  <div class="layui-card-body">

  1、赞助优客365开源产品：<a href="http://bbs.youke365.site/thread-365-1-1.html" target="_blank" class="red">我要赞助</a>
  </div>
</div>
    
<div class="panel panel-success" style="width:50%;height:270px;float:left">
    <div class="panel-heading">
        <h3 class="panel-title">官方交流区  <a href="http://bbs.youke365.site/forum.php?mod=forumdisplay&fid=36" target="_blank" style="float:right">反馈</a ></h3>

    </div>
    <div class="panel-body">
       <div class="youke" style="min-height:200px;">
        <?php echo '<script'; ?>
 type="text/javascript" src="http://bbs.youke365.site/api.php?mod=js&bid=3"><?php echo '</script'; ?>
>
    </div>
</div>


</div>




       <div class="panel panel-success" style="width:50%;height:270px;float:left">
    <div class="panel-heading">
        <h3 class="panel-title">服务器信息</h3>
    </div>
    <div class="panel-body">
        <table class="layui-table">
			<tr height="30">
				<td width="50%">服务器时间：&nbsp;<?php echo $_smarty_tpl->tpl_vars['server']->value['datetime'];?>
</td>
				<td width="50%">服务器类型：&nbsp;<?php echo $_smarty_tpl->tpl_vars['server']->value['software'];?>
</td>
			</tr>
			<tr height="30">
				<td>PHP版本：&nbsp;<?php echo $_smarty_tpl->tpl_vars['server']->value['php_version'];?>
</td>
				<td>MySQL版本：&nbsp;<?php echo $_smarty_tpl->tpl_vars['server']->value['mysql_version'];?>
</td>
			</tr>
               <tr>
                <td>技术支持QQ：1187668851</td>
                <td>官方QQ群：<a href="http://bbs.youke365.site/thread-29-1-1.html" target="_blank">查看</a></td>
               </tr>
                 <tr>
                <td>官网：<a href="http://www.youke365.site" target="_blank">http://www.youke365.site</a></td>
                <td>论坛：<a href="http://bbs.youke365.site" target="_blank">http://bbs.youke365.site</a></td>
               </tr>
		</table>
    </div>
</div>         


<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>

layui.use('layer', function(){
  var layer = layui.layer;


// setInterval(function(){ alert("Hello"); }, 3000);
});  

//升级
$(function(){
	$("#update").on("click",function(){
	var v = $(this).attr('data-v');
	var url = $(this).attr('data-url');

	parent.layer.msg('新版本检测中...', {
		time: 0,
	  icon: 16
	});
	ajax('check');
			function ajax(type){
				 $.ajax({
				  	type:"post",
				  	url:"./update.html",
				  	data:{v:v,"type":type,},
				  	success:function(json){
			         if(json.status == 1){
				



			         	// 升级前,请确认已经做好数据库和程序备份!
          					parent.layer.confirm(json.msg, {
                              title:['发现新版本','background:#393D49;color:#fff'],
          					  btn: ['确定升级','取消'] //按钮
          					}, function(){
          					    parent.layer.msg('升级中，请勿关闭！', {
          							time: 0,
          						    icon: 16
          						    ,shade: 0.5
          						 });

          						ajax('start');
          					
          					});   
			               
			         }else if(json.status == 2){   
               //更新成功   
                         parent.layer.msg(json.msg, {icon: 1,shade: 0.3});        

					   	location.reload();
			         }else if(json.status == -1){
			         	//更新失败
			       
						  parent.layer.msg(json.msg, {icon:2});  
			            }else{
			         	//已经是最新版
			         	parent.layer.msg(json.msg, {icon:4}); 
			            }
				  	   },
				  	dataType:"json"
				  });
			}

	});

	// auth
setTimeout(function(){
	var code =  "<?php echo @constant('CLIENT_AUTH_CODE');?>
";
    var v =  "<?php echo @constant('SYS_VERSION');?>
";
+"&code="+code+"&version="+v
  $.get("http://auth.youke365.site/api.php?type=check_auth&domain="+document.domain+"&code="+code+"&version="+v,function(json){

    if(json.code ==0){
         $("#auth").html('<span class="layui-badge layui-bg-blue">'+json.msg+'</span>');
    }else{
    	  $("#auth").html('<span class="layui-badge">'+json.msg+'</span>');
    }
  
  });
},3000);

setTimeout(function(){
	  var v =  "<?php echo @constant('SYS_VERSION');?>
";
  $.get("http://auth.youke365.site/api.php?type=get_new_version&version="+v,function(json){
  
    if(json.code ==0){
         $("#new-version").html('<span style="color:red">'+json.msg+json.data.name+'</span>');
    }
  
  });
},1000);
// 
});
<?php echo '</script'; ?>
><?php }
}
