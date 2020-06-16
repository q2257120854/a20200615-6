$(".phone_list_btn").live('click', function(e) {
    $("body").append('<div class="pbc_index layui-layer-shade" id="layui-layer-shade1" times="1" style="cursor:pointer;z-index:19891014; background-color:#000; opacity:0.5; filter:alpha(opacity=50);"></div>');
    $(".nav_list").css("right", "0");
});
$(".pbc_index").live('click', function(e) {
    $(this).remove();
    $(".nav_list").css("right", "-60%");
});