<?php
$act = $_GET['act'];
switch($act){
	case 'zz_sq':
echo '
		<div class="layui-card-header" style="font-size: 1.5em;text-align: center;">自助在线授权</div>
			<p style="width: 100%;color: darkgray;font-size: 0.7em;text-indent: 1.6em;margin-top: 1em;">授权卡密80元一张</p>
  		<div class="layui-card-body">
    <div class="layui-input-company">
      <input type="text" id="zz_url" style="text-align: center;" name="zz_url"  lay-verify="required" lay-verType="tips" placeholder="请输入你要授权的域名" class="layui-input">
    </div></br>
    <div class="layui-input-company">
      <input type="text" id="zz_qq" style="text-align: center;" name="zz_qq"  lay-verify="required" lay-verType="tips" placeholder="请输入你的QQ号,方便获取源码" class="layui-input">
    </div></br>
    <div class="layui-input-company">
      <input type="text" id="zz_km" style="text-align: center;" name="zz_km"  lay-verify="required" lay-verType="tips" placeholder="请输入你的授权卡密" class="layui-input">
    </div></br>	
    <div class="layui-input-company">
      <z><button onclick="zzsq()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo">点我开始授权</button></z>
    </div>
		
		<br></div>
';
	
break;
	case 'gx_log':
echo '
		<div class="layui-card-header" style="font-size: 1.5em;text-align: center;">更新日志 </div>
			<p style="width: 100%;color: darkgray;font-size: 0.7em;text-indent: 1.6em;margin-top: 1em;">V2.5 - 2019-7-18号</p>
<div class="layui-card-body">全新升级2.5版本 [ 全局增强 ]<br>
1.修复了邮件发不了验证码问题<br>
2.布局也有很大变化<br>
3.增加了安装程序<br>
4.在安装时可以修改邮件配置（已删除）<br>
</div>
		
	</div>
';
	
break;
default:
    echo json_encode(array('code'=>0,'msg'=>'NOT ACT！'));
break;
}

?>