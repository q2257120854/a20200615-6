var DISABLED = 'layui-btn-disabled';
layui.use(['form', 'layer', 'jquery', 'upload','element', 'util'], function () {
    var form = layui.form,
        layer = layui.layer,
        element = layui.element,
        util = layui.util,
        upload = layui.upload,
        $ = layui.jquery;
    $('.logi_logout').click(function () {
        loading = layer.load(2, {
            shade: [0.2, '#000']
        });
        var url = $(this).data('url');
        var locationurl = $(this).attr('location-url');
        $.getJSON(url, function (data) {
            if (data.code == 200) {
                layer.close(loading);
                layer.msg(data.msg, { icon: 1, time: 1000 }, function () {
                    location.href = locationurl;
                });
            } else {
                layer.close(loading);
                layer.msg(data.msg, { icon: 2, anim: 6, time: 1000 });
            }
        });
    });

    

    // //返回顶部图标
    // util.fixbar({
    //     bar1: '&#xe642;',
    //     bgcolor: '#009688',
    //     click: function (type) {
    //         if (type === 'bar1') {
    //             location.href = '/fadd.html';
    //         }
    //     }
    // });

    $('#sendsms').click(function () {
        var obj=$(this);
        var options = {
            seconds: 60
            , mobile: $('#L_mobile').val()
            , vercode: $('#L_vercode').val()
        };

        if($.trim(options.mobile)==''){
            layer.msg('手机号必填');
            return false;
        }

        if($.trim(options.vercode)==''){
            layer.msg('图形码必填');
            return false;
        }

        var locationurl = $(this).attr('location-url');
        $.getJSON(locationurl, options,function (data) {  
            if(data.code==0){
                layer.msg('发送成功');
                countDown($,60,obj);
            }else{
                layer.alert(data.msg);
                $('#captcha').trigger("click");
            }
           
        });

        
    });

    
    
})

function countDown ($,seconds,obj) {

    if (seconds > 1){

        seconds--;

        $(obj).addClass(DISABLED).html(seconds+"秒后可重新获取 ");//禁用按钮

        // 定时1秒调用一次

        setTimeout(function(){

            countDown($,seconds,obj);

        },1000);

    }else{

        $(obj).removeClass(DISABLED).html("获取验证码");//启用按钮

    }
}