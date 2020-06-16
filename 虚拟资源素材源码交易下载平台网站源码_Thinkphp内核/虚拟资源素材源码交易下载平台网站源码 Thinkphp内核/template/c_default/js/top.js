var method = {
    msg_layer: function(a) {
        $(".msg-layer-bg,.msg-layer").remove();
        $("body").append('<div class="msg-layer-bg"></div><div class="msg-layer showAlert"><h5></h5><div class="msg-con"></div><div class="layer-close">&times;</div><div class="layer-btn"><div class="layer-cancel" style="background: gray;"></div><div class="layer-commit"></div></div></div>');
        var e = $(".msg-layer-bg"),
        b = $(".msg-layer"),
        f = $(".layer-close"),
        g = $(".layer-cancel"),
        h = $(".layer-commit");
        b.attr("data-animation", a.type);
        var c = $(window).height(),
        d = $(window).width();
        a.title ? b.find("h5").html(a.title) : b.find("h5").css("display", "none");
        b.find($(".msg-con")).html(a.content);
        e.css({
            display: "block"
        });
        a.close && "true" != a.close ? f.css("display", "none") : (f.css("display", "block"), f.on("click",
        function() {
            method.msg_close()
        }));
        a.area ? "auto" != a.area[0] && "auto" != a.area[1] ? b.css({
            width: a.area[0],
            height: a.area[1],
            left: d / 2 - parseFloat(a.area[0]) / 2,
            top: c / 2 - parseFloat(a.area[1]) / 2
        }) : "auto" != a.area[0] && "auto" === a.area[1] ? b.css({
            width: a.area[0],
            height: a.area[1],
            left: d / 2 - parseFloat(a.area[0]) / 2,
            top: c / 2 - (b.height() + 20) / 2
        }) : "auto" === a.area[0] && "auto" != a.area[1] && b.css({
            width: b.width() + 20,
            height: a.area[1],
            left: d / 2 - (b.width() + 20) / 2,
            top: c / 2 - parseFloat(a.area[1]) / 2
        }) : b.css({
            width: b.width() + 20,
            height: b.height() + 30,
            left: d / 2 - (b.width() + 20) / 2,
            top: c / 2 - (b.height() + 30) / 2
        });
        a.btn && (0 != a.btn[0] && (g.css("display", "inline-block"), g.html(a.btn[0]), g.on("click",
        function() {
            method.msg_close()
        })), 0 != a.btn[1] && (h.css("display", "inline-block"), h.html(a.btn[1])))
    },
    msg_close: function() {
        var a = null;
        $(".msg-layer").removeClass("showAlert").addClass("hideAlert");
        a = setTimeout(function() {
            clearTimeout(a);
            $(".msg-layer-bg").remove();
            $(".msg-layer").remove()
        },
        200)
    }
};
function openLoginK() {
    window.open("/logining.html")
}
$(function() {
    $(".header-user").mouseenter(function() {
        $(".show-data").addClass("layui-anim-scaleSpring").show()
    });
    $(".header-user").mouseleave(function() {
        $(".show-data").hide()
    })
});
$(function() {
    $(".phone_list_btn").live("click",
    function(a) {
        $(".navlan").append('<div class="pbc_index layui-layer-shade" id="layui-layer-shade1" times="1" style="cursor:pointer;z-index:1100; background-color:#000; opacity:0.5; filter:alpha(opacity=50);"></div>');
        $(".nav_list").css("right", "0")
    });
    $(".pbc_index").live("click",
    function(a) {
        $('#layui-layer-shade1').remove();
         $(".nav_list").css("right", "-105%")
    })
});
$(function() {
    var a = $(".web-nav"),
    e = $(window),
    b = $(document);
    e.scroll(function() {
        100 <= b.scrollTop() ? a.addClass("fixednav") : a.removeClass("fixednav")
    })
});
$(function() {
    var a = $("#anitOut"),
    e = $(window),
    b = $(document);
    e.scroll(function() {
        100 <= b.scrollTop() ? a.hide() : a.show()
    })
});