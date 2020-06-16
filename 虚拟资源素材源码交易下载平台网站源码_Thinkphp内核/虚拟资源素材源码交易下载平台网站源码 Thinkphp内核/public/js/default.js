layui.use(['form', 'layer', 'jquery', 'element', 'util'], function() {
    var form = layui.form,
        layer = layui.layer,
        element = layui.element,
        util = layui.util,
        $ = layui.jquery;
    $('.logi_logout').click(function() {
        loading = layer.load(2, {
            shade: [0.2, '#000']
        });
        var url = $(this).data('url');
        var locationurl = $(this).attr('location-url');
        $.getJSON(url, function(data) {
            if (data.code == 200) {
                layer.close(loading);
                layer.msg(data.msg, { icon: 1, time: 1000 }, function() {
                    location.href = locationurl;
                });
            } else {
                layer.close(loading);
                layer.msg(data.msg, { icon: 2, anim: 6, time: 1000 });
            }
        });
    });



    //返回顶部图标
    util.fixbar({
        bar1: '&#xe642;',
        bgcolor: '#009688',
        click: function(type) {

            if (type === 'bar1') {
                location.href = '/artadd.html';
                //layer.msg('打开 index.js，开启发表新帖的路径');

            }
        }
    });
})