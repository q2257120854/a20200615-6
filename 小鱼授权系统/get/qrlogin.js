function getqrpic(qq){
	var qq=$("input[name='qq']").val();
	var getvcurl='login.php?do=getyzm&qq='+qq;
	
	if(qq == ''){
		layer.alert('请填写你授权的QQ');		
		return;
	}
	
	$('#an').html('获取验证码中...');
	$.get(getvcurl, function(d) {
		if(d.code ==0){
			$('#an').html('获取成功');
		    layer.alert('验证码已经发放,注意查收邮箱！');
            $('#an_div').hide();
            $('#dl').show();			
		}else{
			$('#an').html('点击重新获取..');
		    layer.alert(d.msg);						
		}
	});
}
function checkqq(qq){
	var qq=$("input[name='yzm']").val();
	var getvcurl='login.php?do=checkyzm&yzm='+qq;
	
	if(qq == ''){
		layer.alert('请输入验证码！');		
		return;
	}
	
	
	$.get(getvcurl, function(d) {
		if(d.code ==0){
		$('#dl_div').hide();			
		$('#down_div').html('<a href="http://授权系统/download/release_installer.zip" class="btn btn-block btn-primary">开始下载源码</a>');	
		$('#down_div').show();			
		    layer.alert('验证成功,正在为你挑选下载路线！');			
		}else{
		    layer.alert(d.msg);						
		}
	});
}