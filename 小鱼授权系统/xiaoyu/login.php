<?php
/**
 * 登录
**/
$title='用户登录';
include_once "./head.php";
$mod='blank';
header("Content-Type: text/html; charset=UTF-8");
$act=$_GET['act'];
if(isset($_POST['user']) && isset($_POST['pass'])){
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$email=daddslashes($_POST['email']);	
	$code=daddslashes($_POST['code']);	
	$row = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	$log_file='./code/'.$code.'.log';
	if(file_exists($log_file))
	{
    if($row['user']==$user && $row['pass']==$pass){
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("auth_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		@unlink($log_file);
		exit("<script language='javascript'>alert('报告老大登陆成功！！');window.location.href='./';</script>");
	}		
	}else{
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('验证码不存在,请确认是否正确');history.go(-1);</script>");		
	}
	if($row['user']=='') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('此用户不存在');history.go(-1);</script>");
	}elseif($code == '') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('请不要留空验证码');history.go(-1);</script>");
	}elseif ($pass != $row['pass']) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif($user=='2147483647'){
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('非法登陆,有意见联系QQ3436901764');history.go(-1);</script>");		
	}
}elseif(isset($_GET['logout'])){
	setcookie("auth_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('注销了,那你就别登录了！');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	exit("<script language='javascript'>alert('都登陆了，想干啥你！');window.location.href='./';</script>");
}
?>
<style>body{background:linear-gradient(to right,#FFCCCC,#CCCCFF);font-family:"微软雅黑";
}
.yj{border-radius:20px;}
</style>
<div class="container" style="padding-top:40px;">
<div class="col-sm-12 col-md-9 center-block" style="float: none;">
      <div class="yj panel panel-default">
	  <div class="panel-body">
<div class="text-center logo">
<img src="../other/assets/img/logo.png" height="106px" width="106px" class="img-rounded img-circle img-thumbnail">
<br>
<br>
</div>
<form action="./login.php" method="post" class="form-horizontal" role="form">
<div class="list b-t-0 m-t padder-0">
<div class="input-group">
<span class="input-group-addon padder-0">账号</span>
<input type="text" name="user" class="form-control no-border"  placeholder="请输入用户名！" required="required" >
</div>
</div>
<br>
<div class="list b-t-0 m-t padder-0">
<div class="input-group">
<span class="input-group-addon padder-0">密码</span>
<input type="password" class="form-control no-border" name="pass" placeholder="请输入密码！" required="required" >
</div>
</div>
<br>
<div class="list b-t-0 m-t padder-0">
<div class="input-group">
<span class="input-group-addon padder-0">邮箱</span>
<input type="email" class="form-control no-border" name="email" placeholder="请输入QQ邮箱！" required="required" >
</div>
<br>
<div class="input-group">
<span class="input-group-addon padder-0">验证码</span>
<input type="txt" class="form-control no-border" placeholder="请输入验证码！" name="code" required="required" > 
<span class="input-group-addon" id="sendcode">获取验证码</span>
</div> 
</div>  
<br>
<center>
<button class="yj btn btn-default btn-block" type="submit" style="width:200px;">登&nbsp;&nbsp;录</button>
</center>
</div>
</div>
</div>
</div>
<script>
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
			$(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
	var phone;
	captchaObj.onReady(function () {
		$("#wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendsms",
			data : {phone:phone,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendsms");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
					captchaObj.reset();
				}
			} 
		});
	});
	$('#sendsms').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		phone=$("input[name='phone']").val();
		if(phone==''){layer.alert('手机号码不能为空！');return false;}
		if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
		captchaObj.verify();
	})
	// 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
$(document).ready(function(){
	$("select[name='type']").change(function(){
		if($(this).val() == 1){
			$("input[name='account']").attr("placeholder","支付宝账号");
		}else if($(this).val() == 2){
			$("input[name='account']").attr("placeholder","微信号");
		}else if($(this).val() == 3){
			$("input[name='account']").attr("placeholder","QQ号");
		}else if($(this).val() == 4){
			$("input[name='account']").attr("placeholder","银行卡号");
		}
	});
	$("select[name='type']").change();
	$("#sendcode").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var email=$("input[name='email']").val();
		if(email==''){layer.msg('邮箱不能为空！');return false;}
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(email)){layer.msg('邮箱格式不正确！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendcode",
			data : {email:email},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendcode");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.msg(data.msg);
				}
			} 
		});
	});
	$("#submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var type=$("select[name='type']").val();
		var account=$("input[name='account']").val();
		var username=$("input[name='username']").val();
        var qq=$("input[name='qq']").val();
		var url=$("input[name='url']").val();
		var email=$("input[name='email']").val();
		var phone=$("input[name='phone']").val();
		var code=$("input[name='code']").val();
		if(account=='' || username=='' || url=='' || email=='' || phone=='' || code==''|| qq==''){layer.alert('请确保各项不能为空！');return false;}
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		if (url.indexOf(" ")>=0){
			url = url.replace(/ /g,"");
		}
		if (url.toLowerCase().indexOf("http://")==0){
			url = url.slice(7);
		}
		if (url.toLowerCase().indexOf("https://")==0){
			url = url.slice(8);
		}
		if (url.slice(url.length-1)=="/"){
			url = url.slice(0,url.length-1);
		}
		$("input[name='url']").val(url);
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$(this).attr("data-lock", "true");
		$.ajax({
			type : "POST",
			url : "ajax.php?act=reg",
			data : {type:type,account:account,username:username,url:url,email:email,phone:phone,qq:qq,code:code},
			dataType : 'json',
			success : function(data) {
				$("#submit").attr("data-lock", "false");
				layer.close(ii);
				if(data.code == 1){
					layer.open({
					  type: 1,
					  title: '商户申请成功',
					  skin: 'layui-layer-rim',
					  content: '<li class="list-group-item"><b>商户ID：</b>'+data.pid+'</li><li class="list-group-item"><b>商户密钥：</b>'+data.key+'</li><li class="list-group-item">以上商户信息已经发送到您的邮箱中</li><li class="list-group-item"><a href="login.php?user='+data.pid+'&pass='+data.key+'" class="btn btn-default btn-block">返回登录</a></li>'
					});
					var mch_info = data.pid+"|"+data.key;
					$.cookie('mch_info', mch_info);
				}else if(data.code == 2){
					layer.open({
					  type: 1,
					  title: '支付确认页面',
					  skin: 'layui-layer-rim',
					  content: '<li class="list-group-item"><b>所需支付金额：</b>'+data.need+'元</li><li class="list-group-item text-center"><a href="../submit2.php?type=alipay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/alipay.ico" class="logo">支付宝</a>&nbsp;<a href="../submit2.php?type=wxpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/wechat.ico" class="logo">微信支付</a>&nbsp;<a href="../submit2.php?type=qqpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/qqpay.ico" class="logo">QQ钱包</a>&nbsp;<a href="../submit2.php?type=tenpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/tenpay.ico" class="logo">财付通</a></li><li class="list-group-item">提示：支付完成后请勿关闭网页，才能显示商户注册成功信息</li>'
					});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$.ajax({
		// 获取id，challenge，success（是否启用failback）
		url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
		type: "get",
		dataType: "json",
		success: function (data) {
			console.log(data);
			// 使用initGeetest接口
			// 参数1：配置参数
			// 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
			initGeetest({
				width: '100%',
				gt: data.gt,
				challenge: data.challenge,
				new_captcha: data.new_captcha,
				product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
				offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
				// 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
			}, handlerEmbed);
		}
	});
});
</script>	
</body>
</html>