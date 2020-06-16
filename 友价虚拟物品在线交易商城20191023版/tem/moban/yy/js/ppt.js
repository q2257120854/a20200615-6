layui.use("layer", function() {});
released = function(a) {
    layer.load();
    $.get("/html/released", {
        type: a
    }, function(a) {
        layer_ly(a, !1, !0, "560px", "auto")
    })
};
sign = function(a) {
    Aform("sign", "mode=" + (a || 0), function(a) {
        if (-2 == a.state) return layer_lp("签到", "sign"), !1;
        Rs(a)
    })
};
expost = function(a, b) {
    $.post("/html/expost", {
        mode: a,
        number: b || 0
    }, function(a) {
        layer_ly(a, !1, !1)
    })
};
layer_lp = function(a, b) {
    layer.confirm('亲，您需要先<font color="red">登录</font>才能<font color="#ff6600">' + a + "</font>哦！", {
        icon: 0,
        btn: ["去登录", "打酱油"]
    }, function() {
        layer.closeAll();
        layer_login("再" + a, b)
    }, function() {
        layer.msg("好吧，亲，那您就继续打酱油吧！")
    })
};
layer_login = function(a, b) {
    /*document.domain = "hmbwz.com";
    height = (title = (a = a || !1) ? ["亲！先登个录" + a, "border:none; background:#f2f2f2; color:#333;font-size:14px;"] : !1) ? 500 : 460;
    layer.open({
        type: 2,
        title: title,
        shadeClose: !1,
        shade: [.05, "#000"],
        area: ["400px", height + "px"],
        content: ["https://my.hmbwz.com/html/login?c=" + (b || ""), "no"]
    })*/
	window.location.href="/reg/";
};

function UCheck(a) {
    a = a || "ajax_login";
    0 < $('input[name="ureturn"]').length ? (a = $.trim($('input[name="ureturn"]').val()), CheckHzurl(a) ? window.location.href = a : window.location.reload()) : ("ajax_login" == a || "ajax_logout" == a) && 0 < $(".top_box").length ? (Aform(a, "", function(a) {
        1 == a.state ? $.each(a, function(a, b) {
            0 < $("." + a).length && $("." + a).html(b)
        }) : Rs(a)
    }), 0 < $(".lay-login").length && $(".lay-login").remove(), 0 < $(".click-cite.curr").length && fixed_tool(2), 0 < $(".click-cite").length && $(".click-cite").data("rtime", 0)) : isNaN(a) || (a = layer.getChildFrame("body", a).find('input[name="uclick"]').val().split("|"), "click" == $.trim(a[0]) && $($.trim(a[1])).trigger("click"));
    layer.closeAll("iframe")
}

function deling(a) {
    uploader.removeFile(a);
    $("#file-" + a).remove();
    0 >= $("#FileListing tr[id]").length && 0 >= $("#FileListing .dl").length ? $("#pluing").hide() : $("#pluing u").html(uploader.files.length)
}

function budget() {
    var a = $("input[name=money]").val(),
        b = $("input[name=role]:checked").val(),
        c = $("input[name=fees]:checked").val();
    b && a && c ? (b = .02 * a, $("#budget").show(), "buy" == c ? ($("#bm").html(1 * a + 1 * b), $("#sm").html(a)) : "sell" == c ? ($("#bm").html(a), $("#sm").html(a - b)) : ($("#bm").html(1 * a + .5 * b), $("#sm").html(a - .5 * b))) : $("#budget").hide()
}

function verify(a) {
    var b = $("input[name=vcode]").val();
    if ("phone" == a && 4 != b.length || "email" == a && 6 != b.length) return $("input[name=vcode]").val("").focus(),
        layer.tips("验证码错误，请重新输入", $("input[name=vcode]")), !1;
    "phone" != a && "email" != a || Aform("verify", $("form *[value!='']").serialize() + "&mode=" + a)
}
prompt_people = function(a, b, c, d) {
    c = c || 0;
    d = d || 0;
    var e = .7 * document.body.offsetWidth < $(a).offset().left ? "right" : "left",
        f = "right" == e ? $(a).offset().left + d - 332 : $(a).offset().left + $(a).width() + d + 5,
        g = $(a).offset().top + $(a).height() / 2 + c - 58,
        k = $('<div class="prompt_obj" style="width:' + $(a).width() + "px;height:" + $(a).height() + "px;top:" + ($(a).offset().top + c - 4) + "px;left:" + ($(a).offset().left + d - 4) + 'px;"></div><div class="prompt_people ' + e + '" style="top:' + g + "px;left:" + f + 'px;"><dl><dd><div id="wrap"><div id="subwrap"><div id="content">' + b + "</div></div></div></dd></dl></div>");
    k.appendTo("body");
    setTimeout(function() {
        k.fadeOut("fast", function() {
            k.remove()
        })
    }, 3E3)
};
sendbtn = function(a, b, c) {
    var d = $(a).attr("data");
    c = c || "";
    if (!judge($("input[name=" + d + "]").val(), d)) return layer.tips($("input[name=" + d + "]").attr("placeholder"), $("input[name=" + d + "]"), {
            tips: [3, "#f90"]
        }),
        $("input[name=" + d + "]").focus(), !1;
    $(a).attr("disabled", !0);
    Aform("sendinfo", $("form" + c).serialize(), function(c) {
        -1 == c.state ? sendtime(a, b) : $(a).attr("disabled", !1);
        Rs(c)
    })
};
sendtime = function(a, b) {
    function c(b) {
        return function() {
            if (b == d) $(a).removeClass("layui-btn-disabled"),
                $(a).val("发送验证码"),
                $(a).attr("disabled", !1);
            else {
                var c = d - b;
                $(a).val(c + "秒后可以重发")
            }
        }
    }
    var d = b || 60;
    $(a).attr("disabled", !0);
    $(a).val(d + "秒后可以重发").addClass("layui-btn-disabled");
    for (b = 1; b <= d; b++) setTimeout(c(b), 1E3 * b)
};
fixed_tool = function(a) {
    /*a = a || "";
    var b = $(".click-cite.curr"),
        c = Date.parse(new Date),
        d = parseInt(b.data("rtime")),
        e = b.data("click");
    if ("" != a || c >= d) {
        var f = $(".fixed-loading").show();
        $.ajax({
            type: "POST",
            url: "/apage/",
            async: !0,
            data: "list=fixed_tool&action=" + e + "&page=" + a,
            dataType: "json",
            success: function(c) {
                if (-2 == c.state) return fixed_login();
                c.jq ? $.ajax({
                    url: c.jq,
                    dataType: "script",
                    cache: !0
                }).done(function() {
                    fixed_result(e, c)
                }) : fixed_result(e, c);
                "" == a && b.data("rtime", Date.parse(new Date) + 3E4)
            },
            error: function() {
                f.hide();
                layer.msg("加载失败，请重试！");
                return !1
            }
        })
    } else $(".fixed-" + e + "-box").addClass("curr").siblings(".fixed-click-box").removeClass("curr")*/
};
fixed_result = function(a, b) {
    $.each(b, function(b, c) {
        b = "." == b.substr(0, 1) ? b : ".fixed-" + a + "-box #" + b;
        $(b).empty().html(c)
    });
    "cart" == a && ($(".form_render").click(), $(".fixed-" + a + "-box .more").off("click").on("click", function() {
        var a = $(this).closest("dl").find(".ly");
        a.hasClass("hide") ? a.removeClass("hide").animate({
            right: "0"
        }) : a.animate({
            right: "-100%"
        }, function() {
            a.addClass("hide")
        })
    }));
    var c = $(".fixed-" + a + "-box .tips");
    0 < c.length && ($.isFunction($.fn.tipso) ? c.unbind().tipso() : $.ajax({
        url: "//statics.hmbwz.com/js/tipso.min.js",
        dataType: "script",
        cache: !0
    }).done(function() {
        c.unbind().tipso()
    }));
    $(".fixed-" + a + "-box").addClass("curr").siblings(".fixed-click-box").removeClass("curr");
    $(".fixed-loading").hide()
};
fixed_login = function() {
    0 == $(".lay-login").length && $.get("/html/login?c=fixed-login", function(a) {
        $(".fixed-login").append(a)
    });
    $(".fixed-login-box").addClass("curr").siblings(".fixed-click-box").removeClass("curr");
    $(".fixed-loading").hide()
};
$(".pingfen_btn").live("hover", function(a) {
    "mouseenter" == a.type ? $(this).addClass("active") : $(this).removeClass("active")
});
$(".uim p,.uim a").live("click", function() {
    var a = $(this),
        b = a.closest("span"),
        c = a.parents(),
        d = b.data("info").split("|");
    layer.load();
    $.get("/template/uqq.php", {
        uqq: c.attr("i"),
        curr: c.attr("c"),
        type: c.attr("class")
    }, function(a) {
        layer_ly(a, '<img src="' + d[1] + '" style="width:20px;height:20px;margin-left:-10px;float:left;margin-top:10px;padding:1px;border: 1px solid #ddd;"><strong style="float:left;max-width:130px;overflow:hidden;color:#ff6600;padding:0 5px;">' + d[0] + '</strong> <span style="color:#666;float:left;">' + c.attr("title") + "</span>", !0, "330px")
    })
});
$(document).ready(function() {
    function a(a) {
        b && ($(a).hide(), $(".toggle_center").removeClass("mcur"))
    }
    layer_photos();
    $.isFunction($.fn.tipso) && $(".tips").tipso();
    $(".checkLen").each(function() {
        CheckLen(this, parseInt($(this).attr("d_len")))
    });
    updateEndTime();
    $(".tablelist:not(.noodd) tbody tr:odd,.imgtable tbody tr:odd").addClass("odd");
    $(".service-qq").click(function() {
        if (0 == $("#layer_cont").length) return !0;
        layer.confirm('<b style="font-size:15px;color:#ff6600">亲，您要联系【商家客服】还是【管理客服】？</b><br><span style="color:#666;">注：管理客服仅处理投诉、帐号等平台方面问题<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商品问题请联系咨询各店铺的商家客服人员</span> <div class="layui-layer-btn layui-layer-btn-" style="position: absolute;left:0;bottom: 0;padding:0;width:100%;"><a class="layui-layer-btn0">联系商家</a><a class="layui-layer-btn1" target="_blank" href="' + $(this).attr("href") + '">联系管理</a></div>', {
            icon: 3,
            area: ["450px", "210px"],
            btn: !1
        }, function(a) {
            layer.close(a);
            SellContact()
        }, function(a) {
            layer.close(a)
        });
        return !1
    });
    $(".fixed-right cite[hover]").hover(function() {
        $(this).addClass("curr").siblings("cite").removeClass("curr")
    }, function() {
        $(this).removeClass("curr")
    });
    $(".fixed-right cite[data-click]").click(function() {
        var a = $(this);
        if ($(".fixed-right").hasClass("curr")) {
            if ($(this).hasClass("curr")) return $(".fixed-right").stop(!0, !1).animate({
                right: 0
            }, 330, function() {
                $(this).removeClass("curr");
                a.removeClass("curr")
            }), !1
        } else $(".fixed-right").addClass("curr").stop(!0, !1).animate({
            right: 330
        }, 300);
        $(this).addClass("curr").siblings("cite").removeClass("curr");
        fixed_tool()
    });
    $(".fixed-right-bg").click(function() {
        $(".click-cite.curr").click()
    });
    $(".fixed-click .refresh").click(function() {
        var a = $(".click-cite.curr"),
            b = Date.parse(new Date);
        a = parseInt(a.data("rtime"));
        b >= a ? fixed_tool() : layer.alert("<b>请勿频繁刷新，等待" + (a - b) / 1E3 + "秒后再试！</b>", {
            icon: 5
        })
    });
    $(".fixed-stretch").click(function() {
        $(".fixed-right").toggleClass("simple");
        var a = $(".fixed-right").hasClass("simple") ? "top" : "bottom";
        $.cookie("fixed-right-mode", a, {
            expires: 365,
            path: "/",
            domain: "hmbwz.com"
        });
        "top" == a ? $(".simple-box").removeClass("fixed-tab-bottom").appendTo(".fixed-tab-" + a) : $(".simple-box").addClass("fixed-tab-" + a).appendTo(".fixed-tab")
    });
    $(".fixed-mg").click(function() {
        var a = $(this).closest("cite"),
            b = $(".aciton-nav");
        a.toggleClass("on");
        a.hasClass("on") ? b.addClass("curr") : b.removeClass("curr");
        $.cookie("fixed-mg", Number(a.hasClass("on")), {
            expires: 365,
            path: "/",
            domain: "hmbwz.com"
        })
    });
    $(".fixed-mg-box label").click(function() {
        var a = $(".aciton-nav label");
        $(this).hasClass("IChecked") ? a.removeClass("IChecked") : a.addClass("IChecked")
    });
    if (0 < $(".c_r_des").length) $(window).one("scroll", function() {
        //var index = layer.load(0, {time: 10*100});
    });
    else if (0 < $("input[name=selist]").length)
        if ("noscroll" == $("input[name=selist]").val()) selist();
        else $(window).one("scroll", function() {
            selist()
        });
    0 < $(".lazyload img[lay-src]").length && (layui.use("flow", function() {
        layui.flow.lazyimg({
            elem: ".lazyload img"
        })
    }), layer_photos(".lazyload"));
    0 < $("#layer_top").length && $("#layer_top").layer_top();
    0 < $(".adsbygoogle").length && loadScript("//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js");
    0 < $(".scroll-box").length && ($(".scroll-box").vTicker({
        showItems: $(".scroll-box").attr("items"),
        pause: $(".scroll-box").attr("times")
    }), $(".scroll-action").click(function() {
        $(".scroll-box").vTicker($(this).attr("action"), {
            animate: !0
        })
    }));
    0 < $(".gotop").length && ($(window).scroll(function(a) {
        h = $(window).height();
        t = $(document).scrollTop();
        t > h ? $(".gotop").show() : $(".gotop").hide()
    }), $(".gotop").click(function() {
        $("html,body").animate({
            scrollTop: 0
        }, 300)
    }));
    $(".share-a").click(function() {
        var a = encodeURIComponent($(this).data("title") ? $(this).attr("title") : $(document).attr("title")),
            b = $(this).data("link") ? $(this).data("link") : location.href,
            e = $(this).data("image") ? $(this).data("image") : 0 < $(".G-image").length ? $(".G-image")[0].src : "",
            f = encodeURIComponent($(this).data("desc") ? $(this).data("desc") : $("meta[name=description]").attr("content")),
            g = encodeURIComponent("互站网");
        switch ($(this).attr("data")) {
            case "sina":
                window.open("http://v.t.sina.com.cn/share/share.php?url=" + b + "&title=" + a + "&content=utf8&pic=" + e);
                break;
            case "qq":
                window.open("http://connect.qq.com/widget/shareqq/index.html?url=" + b + "&title=" + a + "&desc=" + f + "&pics=" + e + "&site=" + g);
                break;
            case "qzone":
                window.open("http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=" + b + "&title=" + a + "&desc=" + f + "&pics=" + e + "&site=" + g);
                break;
            default:
                layer_iframe("/html/getqr.php?size=9&u=" + b, $(this).attr("title"), "330px", "370px")
        }
    });
    $(".searchtype cite").click(function() {
        $(".searchtype").toggleClass("curr")
    });
    $(".searchlist li").click(function() {
        $(".searchtype cite").html($(this).html());
        $(this).addClass("cur").siblings().removeClass("cur");
        $(".searchtype").removeClass("curr")
    });
    $(".searchbtn").click(function() {
        var a = $(".searchval");
        if ("" == a.val().replace(/\s/, "")) return layer.alert("请输入搜索关键词", {
            icon: 0
        }, function(b) {
            a.focus();
            layer.close(b)
        }), !1;
        //window.location.href = $(".searchlist .cur").data("link") + "key/" + a.val()
		document.topf1.action = "/search/index.php?admin="+$(".searchlist .cur").data("aid");
		document.topf1.submit();
    });
    $(".add_custom").click(function() {
        layer_iframe("/html/custom/", !1, "88%", "90%", !0)
    });
    $("#interactive").click(function() {
        if ($(this).hasClass("curr")) return !1;
        var a = $(this);
        Aform("interactive", {
            action: a.data("action"),
            obj: a.data("obj"),
            pro: a.data("pro")
        }, function(b) {
            if (-2 == b.state) return layer_lp(a.attr("title"), "interactive"), !1;
            Rs(b)
        })
    });
    var b = !1;
    $(".toggle_center").hover(function() {
        $(this).parent().next().show();
        $(this).addClass("mcur");
        b = !1
    }, function() {
        $this = $(this).parent().next();
        b = !0;
        window.clearTimeout(c);
        var c = window.setTimeout(function() {
            a($this)
        }, 300)
    });
    $(".toggle_pop,.rev_pop").hover(function() {
        b = !1
    }, function() {
        $this = $(this);
        b = !0;
        window.clearTimeout(c);
        var c = window.setTimeout(function() {
            a($this)
        }, 300)
    });
    $(".top_box li:not(.not)").live({
        mouseenter: function() {
            $(this).addClass("curr")
        },
        mouseleave: function() {
            $(this).removeClass("curr")
        }
    });
    $(".w_d_list .l2,.w_list .l2").hover(function() {
        var a = $(this);
        item1Timer = setTimeout(function() {
            $(a).children("span").show().animate({
                top: 0,
                height: "100%"
            }, 300)
        }, 100)
    }, function() {
        var a = $(this);
        clearTimeout(item1Timer);
        $(a).children("span").animate({
            top: "50%",
            height: 0
        }, 300, function() {
            $(a).children("span").hide()
        })
    })
});
$(".imfav").live("click", function() {
    if ($(this).hasClass("curr")) return !1;
    var id = $(this).attr("id");
	var that = $(this);
	$.get("../tem/favshopInto.php?id=" + id, function(response) {
        if(response=="err1"){return layer_lp("收藏", a), !1;}
		else if(response=="err2"){layer.alert("亲~不能收藏自己的店铺哦",{icon:5});return false;}
		else if(response=="ok"){
		  layer.alert('成功收藏该店铺！',{icon:6});
		  that.html('<i class="iconfont va-1">&#xe61c;</i>已收藏</a>');
		}else{alert("未知错误，请刷新重试");return false;}
    })
});
$(".imfav2").live("click", function() {
    if ($(this).hasClass("curr")) return !1;
    var id = $(this).attr("id");
	var that = $(this);
	$.get("../tem/favshopInto.php?id=" + id, function(response) {
        if(response=="err1"){return layer_lp("收藏", a), !1;}
		else if(response=="err2"){layer.alert("亲~不能收藏自己的店铺哦",{icon:5});return false;}
		else if(response=="ok"){
		  layer.alert('成功收藏该店铺！',{icon:6});
		  that.html('已收藏</a>');
		}else{alert("未知错误，请刷新重试");return false;}
    })
});
$(".Search-inp").live("keypress", function(a) {
    13 == (a.keyCode ? a.keyCode : a.which ? a.which : a.charCode) && $(this).closest(".Search-box").find(".Search-btn").click()
});
$(".o_number").live("keyup", function() {
    var a = $(this).val();
    $(this).val(a.replace(/\D|^0/g, ""))
});
$(".checkLen").live("keyup", function() {
    CheckLen(this, parseInt($(this).attr("d_len")))
});
$(".installing").live("click", function() {
    $.get("../template/fujian/check.php?" + attArr(this), function(a) {
        layer_ly(a, "安装服务详情", !0, "600px")
    })
});
$(".preview").live("click", function() {
    var a = "undefined" == typeof $(this).attr("good") ? $("input[name=good]").val() : $(this).attr("good"),
        b = "undefined" == typeof $(this).attr("action") ? $("input[name=action]").val() : $(this).attr("action"),
        c = "undefined" == typeof $(this).attr("scroll") ? "no" : !0;
    layer_iframe("/html/preview/" + a + "/" + b, " ", "880px", "510px", c)
});
$(".serve_btn").live("click", function() {
    layer.load();
    var a = $(this),
        b = "undefined" == typeof $(this).attr("number") ? readmeta("Or-Number") : $(this).attr("number");
    $Me = $(".Edition a.cur");
    Aform("u", "", function(c) {
        if (-2 == c.state) return layer_login("购买", "." + a.attr("class")), !1;
        $.post("/deal/addserve", {
            number: b,
            money: parseInt($Me.attr("data")),
            edition: $Me.attr("title"),
            piece: $("#tkcnum").val()
        }, function(a) {
            layer_ly(a, "服务下单", !1, "700px")
        })
    })
});
$(".allmoney").live("click", function() {
    $.post("/html/allmoney", {
        number: $(this).attr("number")
    }, function(a) {
        layer_ly(a, !1, !0, "650px", "", "", !0)
    })
});
$(".Edition a").live("click", function() {
    var a = $(this).closest("div").find(".price_m"),
        b = $(this).closest("div").find(".Price_range");
    $(this).hasClass("cur") ? (a.html(b.html()), $(this).removeClass("cur")) : (a.html($(this).attr("data")), $(this).addClass("cur").siblings("a").removeClass("cur"))
});
$(".addred").live("click", function() {
    var a = $(this).siblings("#addred_num"),
        b = 1;
    "-" == $(this).val() && (b = -1);
    b = parseInt(a.val()) + b;
    if ("day" == a.attr("data")) {
        if (0 >= b || 60 < b) return layer.alert("交易周期，不能小于1天或大于60天", {
            icon: 2
        }), !1
    } else if ("piece" == a.attr("data")) {
        if (0 >= b) return layer.alert("购买数量不能小于1件", {
            icon: 2
        }), !1;
        $(".ly_total").html(toDecimal2(parseInt($(".ly_money").html()) * b))
    } else if ("use" == a.attr("data")) {
        if (0 >= b) return layer.alert("使用数量不能小于1件", {
            icon: 2
        }), !1;
        if (b > parseInt(a.attr("have"))) return layer.alert("使用数量不能大于拥有数量", {
            icon: 2
        }), !1
    }
    a.val(b)
});
$(".see_stats").live("click", function() {
    $.get("/html/stats", {
        number: $(this).attr("id"),
        type: $(this).attr("data"),
        order_id: $(this).attr("order_id")
    }, function(a) {
        layer_ly(a, "网站统计详情", !0, "652px")
    })
});
$(".login_click").live("click", function() {
    var a = $(this).attr("id");
    if ("qq" == a || "baidu" == a) var b = 720,
        c = 450;
    else "sina" == a ? (b = 770, c = 530) : "alipay" == a ? (b = .9 * $(window).width(), c = .96 * $(window).height()) : (b = 570, c = 530);
    document.domain = "hmbwz.com";
    layer_iframe("//my.hmbwz.com/oauth/login/" + a, $(this).attr("title"), b + "px", c + "px", "no", !1)
});
$(".Sw-share:not([ing])").live("click", function() {
    var a = $(".Sw-share-box .G-share"),
        b = $(this);
    b.attr("ing", 1);
    a.is(":visible") ? (b.removeClass("curr"), $(".Sw-share-box .G-share").animate({
        "margin-left": -104
    }, 500, function() {
        $(this).hide();
        b.removeAttr("ing")
    })) : (b.addClass("curr"), $(".Sw-share-box .G-share").css("margin-left", -104).show().animate({
        "margin-left": 0
    }, 500, function() {
        b.removeAttr("ing")
    }))
});

function openwindow(a, b, c, d) {
    window.open(a, b, "height=" + d + ",,innerHeight=" + d + ",width=" + c + ",innerWidth=" + c + ",top=" + (window.screen.availHeight - 30 - d) / 2 + ",left=" + (window.screen.availWidth - 10 - c) / 2 + ",toolbar=no,menubar=no,scrollbars=auto,resizable=yes,location=yes,status=no")
}

function replace_html(a) {
    a = a.replace(/<img[^>]*>/ig, "");
    a = a.replace(/<a[^>]*>/ig, "");
    return a = a.replace(/<\/a>/ig, "")
}

function CheckLen(a, b) {
    var c = $(a).val().replace(/[, ]/g, "");
    myinfo = getStrleng(c, b);
    myinfo[0] > 2 * b ? ($(a).val(c.substring(0, myinfo[1] - 1)), $count = 0) : $count = Math.floor((2 * b - myinfo[0]) / 2);
    $check_tisp = $(a).parent().siblings("#check_count");
    0 >= $check_tisp.length && ($check_tisp = $(a).parent().parent().find("#check_count"));
    $check_tisp.html($count)
}

function getStrleng(a, b) {
    for (i = myLen = 0; i < a.length && myLen <= 2 * b; i++) 0 < a.charCodeAt(i) && 128 > a.charCodeAt(i) ? myLen++ : myLen += 2;
    return [myLen, i]
}

function judge(a, b) {
    return ("phone" == b ? /^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/ : "tel" == b ? /^(?:(?:0\d{2,3})-)?(?:\d{7,8})(-(?:\d{3,}))?$/ : "domain" == b ? /^([\w-]+\.)+((com)|(cn)|(com\.cn)|(net)|(net\.cn)|(org)|(org\.cn)|(ac)|(ac\.cn)|(asia)|(audio)|(band)|(bid)|(bike)|(biz)|(blue)|(club)|(cab)|(camp)|(care)|(cash)|(cc)|(cheap)|(city)|(click)|(cloud)|(club)|(cn\.com)|(co)|(com\.hk)|(com\.tw)|(cool)|(date)|(design)|(download)|(email)|(engineer)|(eu)|(fail)|(farm)|(fish)|(flowers)|(fund)|(game)|(games)|(gift)|(gov\.cn)|(green)|(guide)|(guru)|(help)|(hiphop)|(hk)|(host)|(hosting)|(house)|(in)|(info)|(ink)|(io)|(it)|(jp)|(kim)|(la)|(land)|(lawyer)|(life)|(limo)|(link)|(live)|(loan)|(lol)|(ltd)|(ltd\.uk)|(market)|(me)|(me\.uk)|(media)|(mobi)|(mom)|(name)|(news)|(ninja)|(onLine)|(online)|(org\.uk)|(party)|(photo)|(pics)|(pink)|(plc\.uk)|(poker)|(press)|(pro)|(pub)|(pw)|(red)|(ren)|(rocks)|(science)|(sexy)|(sg)|(sh)|(shoes)|(shop)|(site)|(so)|(social)|(software)|(solar)|(space)|(store)|(studio)|(tax)|(tech)|(tips)|(tm)|(today)|(tools)|(top)|(town)|(toys)|(trade)|(travel)|(tv)|(tw)|(us)|(vc)|(video)|(vip)|(wang)|(watch)|(website)|(wiki)|(win)|(work)|(ws)|(xin)|(xyz)|(gg)|(zone)|(中国)|(信息)|(公司)|(在线)|(移动)|(网址)|(网店)|(网络))$/ : /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/).test(a) ? !0 : !1
}

function filterStr(a) {
    100 < a.length && (a = a.substring(0, 100));
    for (var b = /[`~!@#$^&*()=|{}':;',\[\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？%+_]/, c = "", d = 0; d < a.length; d++) c += a.substr(d, 1).replace(b, "");
    return c
}

function readmeta(a) {
    return $("meta[name=" + a + "]").attr("content")
}
layer_photos = function(a) {
    a = a || ".bfiles";
    0 < $(a).length && setTimeout(function() {
        layer.photos({
            photos: a,
            shift: 5
        })
    }, 100)
};
var acimg = function(a) {
    var b = $(".layui-layer-photos img"),
        c = $(".layui-layer-content"),
        d = $(".layui-layer-photos"),
        e = $(window).width(),
        f = $(window).height(),
        g = b.attr("ow"),
        k = b.attr("oh"),
        l = d.width(),
        m = d.height();
    g > l ? (f = (k - f) / 2 * -1, e = (g - e) / 2 * -1) : (f = (f - k) / 2, e = (e - g) / 2);
    d.css({
        height: k,
        width: g,
        top: f,
        left: e
    });
    b.attr({
        oh: m,
        ow: l
    });
    c.height(k);
    $(a).hide().siblings().show()
};
Aform = function(a, b, c, d) {
    $.ajax({
        type: "POST",
        url: "/aform/index/" + a,
        async: d || !1,
        data: b,
        dataType: "json",
        success: function(a) {
            c ? c(a) : Rs(a)
        },
        error: function() {
            layer.closeAll("loading");
         
            return !1
        }
    })
};
dform = function(a, b, c) {
    $.ajax({
        type: "POST",
        url: "/dform/" + b,
        async: !0,
        data: a,
        dataType: "json",
        success: function(a) {
            c ? c(a) : Rs(a)
        },
        error: function() {
            layer.closeAll("loading");
          
            return !1
        }
    })
};
Rs = function(a) {
    layer.closeAll("loading");
    switch (a.state) {
        case -1:
            layer.tips(a.info, a.element, {
                tips: [a.tips || 1, a.color || "#f90"],
                time: a.time || 4E3
            });
            $(a.element).val("").focus();
            a.fun && eval(a.fun);
            break;
        case -2:
            layer.confirm(a.info || "登录失效，请重新登录！", {
                icon: a.icon || 8,
                btn: [a.btn1 || "登录", a.btn2 || "取消"]
            }, function(b) {
                a.btn1fun ? eval(a.btn1fun) : a.url ? location.href = a.url : layer_login();
                layer.close(b)
            }, function(b) {
                a.btn2fun && eval(a.btn2fun);
                layer.close(b)
            });
            a.fun && eval(a.fun);
            break;
        case -3:
            a.fun && eval(a.fun);
            break;
        case 301:
            location.href = a.url;
            break;
        default:
            a.clear || layer.alert(a.info, {
                icon: a.state
            }, function(b) {
                a.fun ? eval(a.fun) + layer.close(b) : a.url ? 1 == a.url ? location.reload() : location.href = a.url : a.element ? $(a.element).val("").focus() + layer.close(b) : layer.close(b)
            })
    }
};
layer_ly = function(a, b, c, d, e) {
    layer.open({
        type: 1,
        title: b,
        closeBtn: 1,
        shade: [.05, "#000"],
        area: [d || "auto", e || "auto"],
        shadeClose: c || !1,
        content: a
    });
    layer.closeAll("loading")
};
layer_iframe = function(a, b, c, d, e, f) {
    d = d || "100px";
    layer.open({
        type: 2,
        title: b,
        shadeClose: f ? !0 : !1,
        shade: [.05, "#000"],
        area: [c, d],
        content: [a, e || "no"],
        success: function(a, b) {
            "100px" == d && window[a.find("iframe")[0].name].iframeautos(b)
        }
    })
};

function iframeautos(a) {
    $height = $(document).height() + 44;
    $height > $(window.parent.window).height() && ($height = parseInt(.9 * $(window.parent.window).height()));
    $top = ($(window.parent.window).height() - $height) / 2 + "px";
    parent.layer.iframeAuto(a);
    parent.layer.style(a, {
        height: $height + "px",
        top: $top
    })
}
Player_alert = function(a, b, c) {
    layer.closeAll();
    layer.alert(a, {
        icon: b
    }, function(a) {
        1 == c ? location.reload() : 0 == c ? layer.close(a) : window.location.href = c
    })
};

function attArr(a) {
    a = a.attributes;
    for (var b = [], c = 0; c < a.length; c++) b.push(a[c].name + "=" + a[c].nodeValue.replace(/[~'!<>@#$%^&*()-+_=:]/g, ""));
    return b.join("&")
}

function loadScript(a) {
    var b = document.createElement("script");
    b.type = "text/javascript";
    b.src = a;
    document.body.appendChild(b)
}
list = function(a) {
    /*a = a || 0;
    var b = layer.load();
    1 < a ? scTop(".mwz") : "R" == a && (a = parseInt($(".ohave").html()) || 0, a += "&Rf=1");
    $.ajax({
        type: "POST",
        url: "/apage/",
        async: !0,
        data: $("form:last *[value!='']").serialize() + "&page=" + a,
        dataType: "json",
        success: function(a) {
            if (-2 == a.state) return Rs(a), !1;
            $.each(a, function(a, b) {
                $("." + a).empty();
                $("." + a).html(b)
            });
            Cxchange();
            layer.close(b);
            0 < $(".on-photo").length && layer_photos()
        },
        error: function() {
           
            layer.close(b);
            return !1
        }
    })*/
};
$(".message_a").live("click", function() {
    $(this).removeClass("message_a");
    bulk("batch=message_read&id=" + $(this).attr("data_id"))
});

function message_operate(a, b, c, d) {
    var e = getFormJson();
    e.action = $(a).attr("action");
    e.batch = c || e.batch;
    e.scene = d || 0;
    if (0 != b) {
        if (void 0 === e.C1) return layer.alert("至少选择一条操作对象", {
            icon: 5
        }), !1
    } else e.all = 1;
    bulk(e)
}

function bulk(a) {
    $.ajax({
        type: "POST",
        url: "/execute/routine/",
        async: !1,
        data: a,
        dataType: "json",
        success: function(a) {
            Rs(a);
            return !1
        },
        error: function() {
            
            return !1
        }
    })
}
$(".cart_delete").live("click", function() {
    var a = $(this),
        b = a.attr("number"),
        c = "undefined" == typeof $(this).attr("mode") ? 0 : 1;
    Aform("cart_delete", "&number=" + b + "&mode=" + c, function(b) {
        if (1 == b.clear) {
            var c = a.closest("dl");
            (1 < c.children("ul").length ? a.closest("ul") : c).slideUp(500, function() {
                $(this).remove();
                carmoney()
            });
            $.each(b, function(a, b) {
                0 < $("." + a).length && $("." + a).empty().html(b)
            })
        }
    })
});
$(".cart_empty,.browse_empty,.message_empty").live("click", function() {
    var a = $(this),
        b = "undefined" == typeof a.attr("mode") ? 0 : 1,
        c = a.attr("class");
    layer.confirm("确定要<strong style='color:red'>" + $(this).attr("title") + "</strong>吗？", {
        icon: 3
    }, function(d) {
        Aform(c, "&mode=" + b, function(b) {
            1 == b.state && ($.each(b, function(a, b) {
                0 < $("." + a).length && $("." + a).empty().html(b)
            }), a.remove(), "cart_empty" == c && carmoney());
            layer.close(d)
        })
    })
});

function updateEndTime() {
    var a = (new Date).getTime();
    $(".ttime").each(function(b) {
        b = this.getAttribute("endTime");
        var c = (eval("new Date(" + b.replace(/\d+(?=-[^-]+$)/, function(a) {
            return parseInt(a, 10) - 1
        }).match(/\d+/g) + ")").getTime() - a) / 1E3;
        if (0 < c) {
            b = Math.floor(c % 60);
            var d = Math.floor(c / 60 % 60),
                e = Math.floor(c / 3600 % 24);
            c = Math.floor(c / 3600 / 24);
            $(this).html(c + "天" + e + "小时" + d + "分" + b + "秒")
        } else $(this).html("己结束")
    });
    setTimeout("updateEndTime()", 1E3)
}

function toDecimal2(a) {
    var b = parseFloat(a);
    if (isNaN(b)) return !1;
    b = Math.round(100 * a) / 100;
    a = b.toString();
    b = a.indexOf(".");
    0 > b && (b = a.length, a += ".");
    for (; a.length <= b + 2;) a += "0";
    return a
}

function ifstr(a, b) {
    return rs = -1 != a.indexOf(b) ? !0 : !1
}

function CheckHzurl(a) {
    var b = RegExp();
    b.compile("^(http|https)://[A-Za-z0-9]{1,8}.hmbwz.com?[A-Za-z0-9-_%&?/.=]+$");
    return b.test(a) ? !0 : !1
}

function getFormJson(a) {
    var b = {};
    a = $(a || "form *[value!='']").serializeArray();
    $.each(a, function() {
        void 0 !== b[this.name] ? (b[this.name].push || (b[this.name] = [b[this.name]]), b[this.name].push(this.value || "")) : b[this.name] = this.value || ""
    });
    return b
}

function usize(a) {
    a = a.toLowerCase(); - 1 == a.indexOf("b") && (a += "b");
    /[0-9]*[a-z]b/.test(a) || -1 == a.indexOf("b") || (a = a.substring(0, a.indexOf("b")), a = Math.ceil(a / 1024) + "kb"); - 1 != a.indexOf("kb") && 5 < a.length && (a = a.substring(0, a.indexOf("kb")), a = Math.ceil(a / 1024) + "mb"); - 1 != a.indexOf("mb") && 5 < a.length && (a = a.substring(0, a.indexOf("mb")), a = Math.ceil(a / 1024) + "gb"); - 1 != a.indexOf("gb") && 5 < a.length && (a = a.substring(0, a.indexOf("gb")), a = Math.ceil(a / 1024) + "tb");
    return a
}
progress = function(a) {
    layer.closeAll("loading");
    $("form").keypress(function(a) {
        if (13 == a.which) return !1
    });
    0 == $("#progress").length && $("body").append('<div id="progress"><span id="progress-bar" ><span id="progress-in" style="width:1%"></span></span><br><span id=\'progress-tisp\'>正在上传数据（<span id="progress-upload">1</span>/<span id="progress-uploaded">0</span>），请稍等…</span><ul><strong>回执信息：</strong></ul></div>');
    layer.open({
        type: 1,
        shade: [.02, "#000"],
        title: !1,
        closeBtn: 0,
        content: $("#progress")
    });
    if (a) return $("#progress-tisp").html("数据正在提交中，请稍等…"),
        $("#progress-in").width("100%"), !1
};

function SellContact(a, b) {
    scTop(a || "#layer_cont:first", 450);
    setTimeout(function() {
        prompt_people("#layer_cont", "商家的联系方式在这哦~", 2, 0)
    }, 800)
}

function scTop(a, b) {
    b || (b = 0);
    $("html, body").animate({
        scrollTop: $(a).offset().top - b
    }, 800)
}

function Cxchange() {
    0 < $(":checkbox[name=C1]:not(:disabled):not(:checked)").length || 0 >= $(":checkbox[name=C1]:not(:disabled)").length ? Cchange($(":checkbox[name=xuan]"), !1) : Cchange($(":checkbox[name=xuan]"), !0)
}

function Cchange(a, b) {
    a.attr("checked", b);
    "undefined" !== typeof form && form.render("checkbox")
}
jQuery.cookie = function(a, b, c) {
    if ("undefined" != typeof b) {
        c = c || {};
        null === b && (b = "", c = $.extend({}, c), c.expires = -1);
        var d = "";
        c.expires && ("number" == typeof c.expires || c.expires.toUTCString) && ("number" == typeof c.expires ? (d = new Date, d.setTime(d.getTime() + 864E5 * c.expires)) : d = c.expires, d = "; expires=" + d.toUTCString());
        var e = c.path ? "; path=" + c.path : "",
            f = c.domain ? "; domain=" + c.domain : "";
        c = c.secure ? "; secure" : "";
        document.cookie = [a, "=", encodeURIComponent(b), d, e, f, c].join("")
    } else {
        b = null;
        if (document.cookie && "" != document.cookie)
            for (c =
                document.cookie.split(";"), d = 0; d < c.length; d++)
                if (e = jQuery.trim(c[d]), e.substring(0, a.length + 1) == a + "=") {
                    b = decodeURIComponent(e.substring(a.length + 1));
                    break
                }
        return b
    }
};
(function(d) {
    var g, c, f;
    g = {
        speed: 700,
        pause: 4E3,
        showItems: 1,
        mousePause: !0,
        height: 0,
        animate: !0,
        margin: 0,
        padding: 0,
        startPaused: !1,
        autoAppend: !0
    };
    c = {
        moveUp: function(a, b) {
            return c.showNextItem(a, b, "up")
        },
        moveDown: function(a, b) {
            return c.showNextItem(a, b, "down")
        },
        nextItemState: function(a, b) {
            var e, c;
            c = a.element.children("ul");
            e = a.itemHeight;
            0 < a.options.height && (e = c.children("li:first").height());
            e += a.options.margin + 2 * a.options.padding;
            return {
                height: e,
                options: a.options,
                el: a.element,
                obj: c,
                selector: "up" === b ? "li:first" : "li:last",
                dir: b
            }
        },
        showNextItem: function(a, b, e) {
            var d;
            d = c.nextItemState(a, e);
            d.el.trigger("vticker.beforeTick");
            e = d.obj.children(d.selector).clone(!0);
            "down" === d.dir && d.obj.css("top", "-" + d.height + "px").prepend(e);
            b && b.animate ? a.animating || c.animateNextItem(d, a) : c.nonAnimatedNextItem(d);
            "up" === d.dir && a.options.autoAppend && e.appendTo(d.obj);
            return d.el.trigger("vticker.afterTick")
        },
        animateNextItem: function(a, b) {
            b.animating = !0;
            return a.obj.animate("up" === a.dir ? {
                top: "-=" + a.height + "px"
            } : {
                top: 0
            }, b.options.speed, function() {
                d(a.obj).children(a.selector).remove();
                d(a.obj).css("top", "0px");
                return b.animating = !1
            })
        },
        nonAnimatedNextItem: function(a) {
            a.obj.children(a.selector).remove();
            return a.obj.css("top", "0px")
        },
        nextUsePause: function() {
            var a, b;
            b = d(this).data("state");
            a = b.options;
            if (!b.isPaused && !c.hasSingleItem(b)) return f.next.call(this, {
                animate: a.animate
            })
        },
        startInterval: function() {
            var a, b;
            b = d(this).data("state");
            a = b.options;
            return b.intervalId = setInterval(function(a) {
                return function() {
                    return c.nextUsePause.call(a)
                }
            }(this), a.pause)
        },
        stopInterval: function() {
            var a;
            if (a = d(this).data("state")) return a.intervalId && clearInterval(a.intervalId),
                a.intervalId = void 0
        },
        restartInterval: function() {
            c.stopInterval.call(this);
            return c.startInterval.call(this)
        },
        getState: function(a, b) {
            var c;
            if (!(c = d(b).data("state"))) throw Error("vTicker: No state available from " + a);
            return c
        },
        isAnimatingOrSingleItem: function(a) {
            return a.animating || this.hasSingleItem(a)
        },
        hasMultipleItems: function(a) {
            return 1 < a.itemCount
        },
        hasSingleItem: function(a) {
            return !c.hasMultipleItems(a)
        },
        bindMousePausing: function(a) {
            return function(a, e) {
                return a.bind("mouseenter", function() {
                    if (!e.isPaused) return e.pausedByCode = !0,
                        c.stopInterval.call(this),
                        f.pause.call(this, !0)
                }).bind("mouseleave", function() {
                    if (!e.isPaused || e.pausedByCode) return e.pausedByCode = !1,
                        f.pause.call(this, !1),
                        c.startInterval.call(this)
                })
            }
        }(this),
        setItemLayout: function(a, b, c) {
            var f;
            a.css({
                overflow: "hidden",
                position: "relative"
            }).children("ul").css({
                position: "absolute",
                margin: 0,
                padding: 0
            }).children("li").css({
                margin: c.margin,
                padding: c.padding
            });
            return isNaN(c.height) || 0 === c.height ? (a.children("ul").children("li").each(function() {
                if (d(this).height() > b.itemHeight) return b.itemHeight = d(this).height()
            }), a.children("ul").children("li").each(function() {
                return d(this).height(b.itemHeight)
            }), f = c.margin + 2 * c.padding, a.height((b.itemHeight + f) * c.showItems + c.margin)) : a.height(c.height)
        },
        defaultStateAttribs: function(a, b) {
            return {
                itemCount: a.children("ul").children("li").length,
                itemHeight: 0,
                itemMargin: 0,
                element: a,
                animating: !1,
                options: b,
                isPaused: b.startPaused,
                pausedByCode: !1
            }
        }
    };
    f = {
        init: function(a) {
            var b, e;
            d(this).data("state") && f.stop.call(this);
            b = jQuery.extend({}, g);
            a = d.extend(b, a);
            b = d(this);
            e = c.defaultStateAttribs(b, a);
            d(this).data("state", e);
            c.setItemLayout(b, e, a);
            a.startPaused || c.startInterval.call(this);
            if (a.mousePause) return c.bindMousePausing(b, e)
        },
        pause: function(a) {
            var b;
            b = c.getState("pause", this);
            if (!c.hasMultipleItems(b)) return !1;
            b.isPaused = a;
            b = b.element;
            if (a) return d(this).addClass("paused"),
                b.trigger("vticker.pause");
            d(this).removeClass("paused");
            return b.trigger("vticker.resume")
        },
        next: function(a) {
            var b;
            b = c.getState("next", this);
            if (c.isAnimatingOrSingleItem(b)) return !1;
            c.restartInterval.call(this);
            return c.moveUp(b, a)
        },
        prev: function(a) {
            var b;
            b = c.getState("prev", this);
            if (c.isAnimatingOrSingleItem(b)) return !1;
            c.restartInterval.call(this);
            return c.moveDown(b, a)
        },
        stop: function() {
            c.getState("stop", this);
            return c.stopInterval.call(this)
        },
        remove: function() {
            var a;
            a = c.getState("remove", this);
            c.stopInterval.call(this);
            a = a.element;
            a.unbind();
            return a.remove()
        }
    };
    return d.fn.vTicker = function(a) {
        return f[a] ? f[a].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" !== typeof a && a ? d.error("Method " + a + " does not exist on jQuery.vTicker") : f.init.apply(this, arguments)
    };
})(jQuery);

//寮瑰嚭鐧诲綍绐楀彛A
function logins() {
    layer.open({
        type: 2,
        area: ['400px', '500px'],
        title: ["浜诧紒鍏堢櫥涓綍锛?", "border:none; background:#f2f2f2; color:#333;font-size:14px;"],
        skin: 'layui-layer-nobg', //鏃犺竟妗?
        content: ['../tem/openw.php', 'no']
    });
}


