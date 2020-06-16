/**
 * Created by Administrator on 2018/6/25.
 */
$(function () {
    $('#Submission').on('click', function () {
        var mobile = $.trim($('#mobile').val());
        var password = $.trim($('#password').val());
        var password1 = $.trim($('#password1').val());
        var code = $.trim($('#code').val());
        if (!checkMobile(mobile)) {
            layer.open({
                content: '请输入用户名!',
                skin: 'msg',
                time: 2 //停留2秒
            });
            $('#user').focus();
            return false;
        }
        if (!code) {
            layer.open({
                content: '请输入验证码!',
                skin: 'msg',
                time: 2
            });
            $('#code').focus();
            return false;
        }
        if (!password) {
            layer.open({
                content: '请设置新密码!',
                skin: 'msg',
                time: 2
            });
            $('#password').focus();
            return false;
        }
        if (!password1) {
            layer.open({
                content: '请再次输入新密码!',
                skin: 'msg',
                time: 2
            });
            $('#password1').focus();
            return false;
        }
        if (password != password1) {
            layer.open({
                content: '你输入的密码格式不正确!',
                skin: 'msg',
                time: 2
            });
            return false;
        }
        $.ajax({
	        url: '{:U("Index/Login/editpwd")}',
	        type: "post",
	        data: $("#formpot").serialize(),
			dataType:'json',
	        beforeSend: function () {
	        	$('#Submission').text("处理中...").addClass("disabled");
	        },
	        success: function (data) {
                if(data.url){
                	layer.open({
                        content: data.info,
                        skin: 'msg',
                        time: 2
                    });
				    setTimeout(function(){location.href=data.url}, 2000);
	            }else{
	            	layer.open({
	                    content: data.info,
	                    skin: 'msg',
	                    time: 2
	                });
	                return false;
                }
                $('#Submission').text(btn_text).removeClass('disabled');
	        }
	    });
    });
});

function checkMobile(tel) {
    var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
    if (reg.test(tel)) {
        return true;
    }else{
        return false;
    };
}

var flag = true;
function send_sms_reg_code(){
	if(flag){
		flag = false;
		var mobile = $('#mobile').val();
	    if(!checkMobile(mobile)){
	    	layer.open({
	            content: '请输入正确的手机号码!',
	            skin: 'msg',
	            time: 2 //停留2秒
	        });
	    	flag = true;
	        return;
	    }
	    var url = "/index.php/index/sem/send_edit_code/mobile/"+mobile;
	    $.get(url,function(data){
	        obj = $.parseJSON(data);
	        if(obj.status == 1)
			{
	        	setTime();
			}
	        layer.open({
	            content: obj.msg,
	            skin: 'msg',
	            time: 2
	        });
	    })
	}
}

//倒计时验证码
var countDown = 10;
function setTime() {
    if (countDown == 0) {
    	$('.getcode').attr("disabled",false);
        $('.getcode').css({color: '#fff',background:"#23d41e"});
        $('#Submission').css({color:'#ff62a4'}).removeAttr('disabled')
        $('.getcode').val("获取验证码");
        countDown = 10;
        flag = true;
        return;
    } else {
    	$('.getcode').attr("disabled", true);
        $('.getcode').css({color: '#999',background:"#ccc"});
        $('.getcode').val("重新发送(" + countDown + ")");
        $('#Submission').css({color:'#ccc'}).attr("disabled", true);
        countDown--;
    }
    setTimeout(function () {
        setTime()
    }, 1000)
}