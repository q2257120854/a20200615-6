layui.use('layer', function() {
    var layer = layui.layer;
    $(".jc_list li a").hover(function() {
        if ($(this).attr("title") != '') {
            layer.tips($(this).attr("title"), $(this).parent("li"), { area: ["auto"], tips: [1, '#313333'] });
        }
    }, function() {
        layer.closeAll();
    });


});