/**
 * Created by Administrator on 2018/6/25.
 */
$(function() {
    $('#registerbtn').on('click', function () {
        var mobile = $.trim($('#mobile').val());
        var verify = $.trim($('#verify').val());
        var code = $.trim($('#code').val());
        var zhifubao = $.trim($('#zhifubao').val());
        var weixin = $.trim($('#weixin').val());
        var password = $.trim($('#password').val());
        var password1 = $.trim($('#password1').val());
        var password2 = $.trim($('#password2').val());
        var password21 = $.trim($('#password21').val());
        if (!checkMobile(mobile)) {
            layer.open({
                content: '请输入手机号码!',
                skin: 'msg',
                time: 2 //停留2秒
            });
            $('#phone').focus();
            return false;
        }
        if (!verify) {
            layer.open({
                content: '请输入图形验证码!',
                skin: 'msg',
                time: 2
            });
            $('#GrCode').focus();
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
        if (!zhifubao) {
            layer.open({
                content: '请输入支付宝账号!',
                skin: 'msg',
                time: 2
            });
            $('#zhifubao').focus();
            return false;
        }
        if (!weixin) {
            layer.open({
                content: '请输入微信号!',
                skin: 'msg',
                time: 2
            });
            $('#weixin').focus();
            return false;
        }
        if (!password) {
            layer.open({
                content: '请输入登录密码!',
                skin: 'msg',
                time: 2
            });
            $('#loginpassword').focus();
            return false;
        }
        if (!password1) {
            layer.open({
                content: '请再次输入登录密码!',
                skin: 'msg',
                time: 2
            });
            $('#ConfirmLogin').focus();
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
        if (!password2) {
            layer.open({
                content: '请输入交易密码!',
                skin: 'msg',
                time: 2
            });
            $('#password2').focus();
            return false;
        }
        if (!password21) {
            layer.open({
                content: '请再次输入交易密码!',
                skin: 'msg',
                time: 2
            });
            $('#password21').focus();
            return false;
        }
        if (password2 != password21) {
            layer.open({
                content: '你输入的交易密码格式不正确!',
                skin: 'msg',
                time: 2
            });
            return false;
        }
        $.ajax({
			url:'{:U("Index/Sem/regSempost")}',
			type:'POST',
			data:$("#myform").serialize(),
			dataType:'json',
			success:function(json){
				layer.open({
	                content: json.info,
	                skin: 'msg',
	                time: 2 //停留2秒
	            });
				if(json.result ==1){
					window.location.href='{:U("Index/Login/index")}';	
				}
			},
			error:function(){
				layer.open({
	                content: '网络故障',
	                skin: 'msg',
	                time: 2 //停留2秒
	            });
			}
		})	
    });
})

function checkMobile(tel) {
    var reg = /(^1[3|4|5|7|8][0-9]{9}$)/;
    if (reg.test(tel)) {
        return true;
    }else{
        return false;
    };
}

function send_sms_reg_code(){
	var mobile = $('#mobile').val();
	var verify=$("#verify").val();
    if(!checkMobile(mobile)){
    	layer.open({
            content: '请输入正确的手机号码!',
            skin: 'msg',
            time: 2 //停留2秒
        });
        return;
    }
	if(verify==''){
		layer.open({
            content: '请输入正确的图形验证码!',
            skin: 'msg',
            time: 2 //停留2秒
        });
        return;
	}
    var url = "/index.php/index/sem/send_sms_reg_code/mobile/"+mobile+"/verify/"+verify;
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

//倒计时验证码
var countDown = 10;
function setTime() {
    if (countDown == 0) {
    	$('.getcode').attr("disabled",false);
        $('.getcode').css({color: '#fff',background:"#23d41e"});
        $('#registerbtn').css({color:'#ff62a4'}).removeAttr('disabled')

        $('.getcode').val("获取验证码");
        countDown = 10;
        return;
    } else {
        $('.getcode').attr("disabled",true);
        $('.getcode').css({color: '#999',background:"#ccc"});
        $('.getcode').val("重新发送(" + countDown + ")");
        $('#registerbtn').css({color:'#ccc'}).attr("disabled", true);
        countDown--;
    }
    setTimeout(function () {
        setTime()
    }, 1000)
}