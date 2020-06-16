$(':input[name=uname]').blur(function(){
	var name = $(this).val();
	if (name.length < 3) {
		promptmsg($('.reg_right p').eq(0),0,'<span></span>用户名为3--15个字符!');
		return;
	}
	$.ajax({
		url:APP+'/home/Register/finduser',
		type:'post',
		data:{uname:name},
		success:function(data){
			if (data==1) {
				promptmsg($('.reg_right p').eq(0),0,'<span></span>用户名已存在!');
				return;
			}
			promptmsg($('.reg_right p').eq(0),1,'<span></span>');
		}
	});
});
$(':input[name=pwd]').blur(function(){
	var pwd = $(this).val();
	if ($(this).val()==$(':input[name=uname]').val()) {
		promptmsg($('.reg_right p').eq(1),0,'<span></span>用户名和密码不能相同!');
		return;
	};
	if (pwd.length < 6) {
		promptmsg($('.reg_right p').eq(1),0,'<span></span>密码最少位6个字符!');
		return;
	}
	pwdinfo($('.reg_right p').eq(1),checkpwd(pwd));
});
$(':input[name=repwd]').blur(function(){
	if ($(this).val() == $(':input[name=pwd]').val()) {
		promptmsg($('.reg_right p').eq(2),1,'<span></span>');
		return;
	}
	promptmsg($('.reg_right p').eq(2),0,'<span></span>两次密码输入不相同!');
});
$(':input[name=email]').blur(function(){
	var $email = $(this).val();
	if (!checkemail($(this).val())) {
		promptmsg($('.reg_right p').eq(3),0,'<span></span>邮箱地址格式不正确!');
		return;
	}
	//判断邮箱是否存在
	$.ajax({
		url:APP+'/home/Register/findemail',
		type:'post',
		data:{email:$email},
		success:function(data){
			if (data==1) {
				promptmsg($('.reg_right p').eq(3),0,'<span></span>邮箱已存在!');
				return;
			}
			promptmsg($('.reg_right p').eq(3),1,'<span></span>');
		}
	});
	promptmsg($('.reg_right p').eq(3),1,'<span></span>');
});
$(':input[name=vcode]').blur(function(){
	$.ajax({
		url:APP+'/home/Register/code',
		type:'post',
		data:{code:$(this).val()},
		success:function(data){
			
			if (data==1) {
				promptmsg($('.reg_right p').eq(4),1,'<span></span>');
			}else{
				promptmsg($('.reg_right p').eq(4),0,'<span></span>请输入正确的验证码!');
			}
		}
	});
});

$(':input[type=checkbox]').click(function(){
	$(this).toggleClass('inp_error_info');
});

$('#reg_form').submit(function(){
	if ($('.inp_error_info').length || inputempty(':input',5) != 5) {
		return false;
	}
	return true;
});

function inputempty(input,num){
	var emptynum = 0;
	for (var i = 0; i < num; i++) {
		if ($("input").eq(i).val()) {
			emptynum++;
		};
	};
	return emptynum;
}

function checkemail(email){
	if (email.match(/^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/)) {
		return true;
	}
	return false;
}

function pwdinfo(element,passlevel){
	switch(passlevel){
		case 1:
			promptmsg(element,1,'<b class="reg_pwd pwdlevel_1"><i></i><i></i><i></i><br />密码强度：弱</b>');
			break;
		case 2:
			promptmsg(element,1,'<b class="reg_pwd pwdlevel_2"><i></i><i></i><i></i><br />密码强度：中</b>');
			break;
		case 3:
			promptmsg(element,1,'<b class="reg_pwd pwdlevel_3"><i></i><i></i><i></i><br />密码强度：高</b>');
			break;
	}
}

function checkpwd(pwdval) {
	var passlevel = 0;
	if(pwdval.match(/\d+/g)) {
		passlevel ++;
	}
	if(pwdval.match(/[a-z]+/ig)) {
		passlevel ++;
	}
	if(pwdval.match(/[^a-z0-9]+/ig)) {
		passlevel ++;
	}
	return passlevel;
}

function promptmsg(element,type,msg){
	if (type == 0) {
		element.attr('class','inp_error_info');
		element.html(msg);
		return;
	}
	element.attr('class','inp_success_info');
	element.html(msg);
}