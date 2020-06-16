    $('#password').on('input propertychange',
    function() {
        $("#login_btn").removeClass("btn-dis");
    });
    function check_data() {
        var tel = $("#username").val();
        var passwd = $("#password").val();
        if (tel == "") {
            showLoading('请输入手机号', 3000);
            return false;
        } else {
            if (!$("#username").val().match(/^(((1[0|3|4|5|7|8][0-9]{1}))+\d{8})$/)) {
                showLoading('手机号不正确', 3000);
                return false;
            } else {
                return true; 
            }
        }
        if (passwd == "") {
            showLoading('请输入密码', 3000);
            return false;
        }
        if (passwd.length < 6 || passwd.length > 20) {
           showLoading('请输入大于6位小于20位的密码', 3000);
            return false;
        }
        return true;
    }
    $("#login_btn").click(function() {
        if (check_data()) 
			$.ajax({
            type: "POST",
            dataType: "json",
            url: 'login',
            data: 'tel=' + $("#username").val() + '&usrPwd=' + $("#password").val() + '&select_s=0',
            beforeSend: function() {
                showLoading('登陆中...')
            },
            success: function(n) {
                var i = n.status;
                switch (i) {
                case 1:
                    /*var s = n.data.username;
                    $.cookie("username", s, {
                        expires: 7776e6,
                        path: "/"
                    });
                    var o = {};
                    o.username = t.username,
                    e.isMobile(o.username) && e.saveStorageParams(u, o),
					*/
                    showLoading('登陆成功！', 1000) 
					window.location = ROOT + '/Wap/Trading/index';
                    break;
                case 0 : default:
                    showLoading(n.info, 3000);
                }
            },
            error: function() {
                hideLoading()
            },
            complete: function() {
                //hideLoading()
            }
        })
    });