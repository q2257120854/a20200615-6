	function disabledFalse (ele){
		ele.attr('disabled',false);
		ele.css('backgroundColor','#f04447');
	}
	/*$('#username').bind('input propertychange',
    function() {
        disabledFalse( $('#btn_1'));
    }); 
	$('#SMSCode').bind('input propertychange',
    function() {
        disabledFalse( $('.confirmBtn'));
    }); 
	*/
var captcha_img = $('#verify');  
var verifyimg = captcha_img.attr("src");  
captcha_img.attr('title', '点击刷新');  
captcha_img.click(function(){  
    if( verifyimg.indexOf('?')>0){  
        $(this).attr("src", verifyimg+'&random='+Math.random());  
    }else{  
        $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());  
    }  
}); 
$('#btn_1').css('backgroundColor','#f04447');
$('.confirmBtn').css('backgroundColor','#f04447');
	var button = document.getElementById("send");
	var InterValObj; //timer变量，控制时间  
	var count = 60; //间隔函数，1秒执行  
	var curCount;//当前剩余秒数  
	curCount = count;
	function get_sms(){
    var verify_code = $("#verify_code").val();
	var phone = $("#username").val();
	var data = {"phone":phone,"verify_code":verify_code}
	$.post(ROOT + '/Wap/Login/img_send_sms_data',{ 
	    data:JSON.stringify(data)
	    },function(result){
		  if(result.status==0){
		   showLoading(result.message, 1000);
		  }else{
				var time = 60;
				function timeCountDown(){
					if(time==0){
						clearInterval(timer);
						$("#send").show();//启用按钮	removeClass				
						$(".secsText").hide();
						return true;
					}else{
						$("#send").hide();
						$('#wait').text(time+"s后重发");
						time--;
						return false;
					}
				}
				timeCountDown();
				var timer = setInterval(timeCountDown,1000);
				//InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次  
                showLoading("验证码已发送！", 1000);
				$(".phoneNumber").text($("#username").val());
				$(".shadeDiv").show();
				$(".codeDiv").show();
			  }
	},"json")
    }
    function check_tel() {
        var tel = $("#username").val();
        if (tel == "") {
            showLoading('请输入手机号', 3000);
            return false;
        } else {
            if (!$("#username").val().match(/^(((1[3|4|5|7|8][0-9]{1}))+\d{8})$/)) {
                showLoading('手机号不正确', 3000);
                return false;
            } else {
                return true;
            }
        }
		return true;
    }
    function check_pass() {
        var passwd = $("#password").val();
        if (passwd == "") {
            showLoading('请输入密码', 2000);
            return false;
        }
        if (passwd.length < 6 || passwd.length > 20) {
			showLoading('请输入大于6位小于16位的密码', 2000);
            return false;
        }
        return true;
    }
    $("#btn_1").click(function() {
        if (check_tel() && check_pass()){
			get_sms();
		} 
    });
    $(".confirmBtn").click(function() {
        send();
    });
    $(".close_02Btn").click(function() {
				$(".shadeDiv").hide();
				$(".codeDiv").hide();
    });
    $("#send").click(function() {
        get_sms();
    });
    $(".downLoad").click(function() {
        jump(ROOT+'/Wap/Login/login_show');
    });
    $("#showPassword").click(function() {
        
    });
    $("#btn_3").click(function() {
        if (check_pass()){ 
			send();
		} 
    });
    $("#tips").click(function() {
        $("#tips").removeClass("hide");
    });
    $("#isok").click(function() {
        $("#tips").addClass("hide");
    });
    $("#smsCodeError").click(function() {
        $("#tips").removeClass("hide");
    });
    $("#isok").click(function() {
        $("#tips").addClass("hide");
    });
	$("#showPassword").click(function(){
	if($(this).attr("data-status")==1){
		$(this).attr("data-status","2");
		$("#password").attr("type","text");
		$("#showPassword").text('隐藏');
		return;
	}
	if($(this).attr("data-status")==2){
		$(this).attr("data-status","1");
		$("#password").attr("type","password");
		$("#showPassword").text('显示');
		return;
		} 
	});

	function send() {
		var phone    = $("#username").val();
		var pass     = $("#password").val();
		var inviterMobile=$("#inviterMobile").val();
		var SMSCode     = $("#SMSCode").val();
		var proxy_id     = $("#proxy_id").val();
		var act     = $("#act").val();
		if(phone==''){
			showLoading("手机号不能为空！", 2000);
		}else if(!phone.match(/^(((1[3|4|5|7|8][0-9]{1}))+\d{8})$/)){
			showLoading("手机号不正确！", 2000);
		}else if(pass==''){
			showLoading("密码不能为空！", 2000);
		}else if(SMSCode==''){
			showLoading("短信验证码不能为空！", 2000);
		}else {
		$.ajax({
			type : 'POST',
			url : ROOT + '/Wap/Login/regist_user',
			data : 'passwd=' + pass + '&tel=' + phone + '&token=' + $("#token").val() + '&reg_xieyi=1&proxy_id=' + $("#proxy_id").val()+"&SMSCode="+SMSCode+"&inviterMobile="+inviterMobile +"&act="+$("#act").val(),
			dataType : 'JSON',
			async : false,
			success : function(data_t) {
				if (data_t['status'] == 1) {
					window.location = ROOT + '/Wap/Trading/index';
				} else {
					showLoading(data_t['info'], 2000);
					return false;
				}
			},
			error : function(data) {
				return false;
			}
		});
		}
	} 