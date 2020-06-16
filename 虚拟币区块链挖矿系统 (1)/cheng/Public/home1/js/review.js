G.app.review = {
    version: "2013072511",
    DOMAIN:'pinglun.yixun.com',
    EXPER_DEF_VAL: "感谢您对小易的支持，您对小易这次提供的商品和服务还满意吗？发表感想，还有积分奖励哦！",
    ASKING_DEF_VAL: "字数长度请在5-1000个字之间。",
    DISCU_DEF_VAL: "字数长度请在5-1000个字之间。",
    initTextArea: function(a,defaultMsg) {

        if(window.location.host == "item.51buy.com"){
            G.app.review.DOMAIN = "item.51buy.com";
        }
        var b = $("textarea[name=content]", a);
        G.logic.validate.lenMon({
            target: b,
            minLen: 0,
            maxLen: 1000,
            sucClass: "",
            failClass: "strong",
            tipCtrl: $("span[t=word_calc]", a),
            charLenStyle: false
        });
        G.ui.tips.swapInput({
            target: b,
            defaultValue: defaultMsg,
            focusClass: "",
            blurClass: "nor"
        }).keydown(function(c) {
            if (c.ctrlKey && (c.which == 13 || c.which == 10)) {
                $("a[t=submit]", a).click()
            }
        }).focus(function() {
            G.ui.tips.none($(this))
        }).blur();
        $("input[t=accept_rule]").click(function() {
            if ($(this).attr("checked")) {
                G.ui.tips.none($("p[t=tipArea]", a))
            }
        });
        b.focus().blur();
        return b
    },
    initDiscussion: function() {
        var a = $("#review_discussion_box"),
        b = G.app.review.initTextArea(a,G.app.review.DISCU_DEF_VAL);
        G.app.review.codeChaneg();
        $("a[t=submit]", a).click(function() {
            if (G.logic.login.ifLogin(this, arguments) === false) {
                return
            }
            var e = G.logic.login.getLoginUid(),
            i = b.val();
            if ($("input[t=accept_rule]:checked").length <= 0) {
                G.ui.tips.warn("请仔细阅读易迅网的评论规则，接受后方可发表评论！", $("p[t=tipArea]", a));
                return
            }
            i = $.trim(i);
            if (i == G.app.review.DISCU_DEF_VAL) {
                i = ""
            }
            if (i.length <= 0) {
                G.ui.tips.warn("请填写讨论内容！", b);
                return
            }
            var f = $.trim($(".verify_input").val());
            if (f.length <= 0) {
                G.ui.tips.warn("请填写验证码。", b);
                return
            }
            if (i.length < 5 || i.length > 1000) {
                G.ui.tips.warn(G.app.review.DISCU_DEF_VAL, b);
                return
            }
            var d = itemInfo.pid,
            g = {
                pid: d,
                content: i,
                codeNum: f
            };
            var h = $("input[name=nick]", a);
            if (h.length > 0) {
                g.nick = h.val()
            }
            G.app.review.loading.open();
            G.util.post(G.util.token.addToken("http://"+G.app.review.DOMAIN+"/json.php?mod=review&act=adddiscussion&uid=" + e,'jq'), g,
            function(j) {
                G.app.review.loading.close();
                if (j && j.errno == 0) {
                    location.href = "http://item.yixun.com/item-" + d + ".html#review_box"
                } else {
                    if (j && j.errno == 14) {
                        G.ui.tips.warn("验证码错误。", b);
                        G.app.review.codeChaneg();
                        return
                    } else {
                        var c = {
                            12 : "内容过长，请删减部分内容后继续",
                            14 : "请填写昵称",
                            777 : "您所发表的内容可能包含敏感信息，我们会尽快审核，当管理员审核通过后，讨论将显示在页面中。",
                            600 : "您的发言频率过快，请稍候再发！",
                            602 : "您的经验值不足，无法发表讨论，如有任何疑问请您发表咨询",
                            776 : "您所发表的讨论中含有不恰当的信息，请您检查无误后再发表。"
                        };
                        if (j && (j.errno - 0) in c) {
                            return G.ui.popup.showMsg(c[j.errno])
                        }
                        G.ui.popup.showMsg("抱歉，发表讨论失败！")
                    }
                }
            })
        })
    },

    initExperience: function() {
        var a = $("#review_experience_box"),
            b = {};
            defultMsg = G.app.review.EXPER_DEF_VAL;

        $.ajax({
          url: 'http://'+G.app.review.DOMAIN+'/json.php?mod=review&act=guide&jsontype=str&pid=' + itemInfo.pid,
          success: function(o){
            if (o && o.errno == 0 && o.data != "" ) {
                G.app.review.EXPER_DEF_VAL = o.data;
                b = G.app.review.initTextArea(a,defultMsg);
            }else{
                 //do nothing
                 b = G.app.review.initTextArea(a,defultMsg);
            }
          },
          timeout:function(){
            b = G.app.review.initTextArea(a,defultMsg);
          },
          error:function(){
            b = G.app.review.initTextArea(a,defultMsg);
          },
          dataType: "jsonp",
          timeout: 1200
        });

        $("input[oname=满意]").attr("checked", true);
        a.data("star", 0);

        $("#review_grade_box .grade li").each(function(c) {
            $(this).mouseover(function() {
                $(this).addClass("strong");
                $("#review_grade_box .grade li .star").addClass("no_star").filter(":lt(" + (c + 1) + ")").removeClass("no_star")
            }).mouseout(function() {
                $(this).removeClass("strong");
                $("#review_grade_box .grade li .star").addClass("no_star").filter(":lt(" + a.data("star") + ")").removeClass("no_star")
            }).click(function() {
                a.data("star", c - 0 + 1);
                G.ui.tips.none($("#review_grade_box .grade"))
            })
        });

        $("a[t=submit]", a).click(function() {
            if (G.logic.login.ifLogin(this, arguments) === false) {
                return
            }
            var f = G.logic.login.getLoginUid(),
            j = b.val();
            if ($("input[t=accept_rule]:checked").length <= 0) {
                G.ui.tips.warn("请仔细阅读易迅网的讨论规则，接受后方可发表评论！", $("p[t=tipArea]", a));
                return
            }
            j = $.trim(j);
            if (j == G.app.review.EXPER_DEF_VAL) {
                j = ""
            }
            if (a.data("star") <= 0) {
                G.ui.tips.warn("请直接点击相应的星级进行评分！", $("#review_grade_box .grade"));
                return
            }
            if (j.length <= 0) {
                G.ui.tips.warn("请填写讨论内容！", b);
                return
            }
            if (j.length < 5 || j.length > 1000) {
                G.ui.tips.warn("字数长度请在5~1000个字之间。", b);
                return
            }
            var e = $("input[type=radio][oname]"),
            h = [];
            if (e.length > 0) {
                e.filter(":checked").each(function() {
                    h.push($(this).val())
                })
            }
            h = h.join(",");
            var d = itemInfo.pid,
            g = {
                pid: d,
                content: j,
                satisfaction: a.data("star"),
                votes: h
            };
            var i = $("input[name=nick]", a);
            if (i.length > 0) {
                g.nick = i.val()
            }
            G.app.review.loading.open();
            G.util.post(G.util.token.addToken("http://"+G.app.review.DOMAIN+"/json.php?mod=review&act=addexperience&uid=" + f,'jq'), g,
            function(k) {
                G.app.review.loading.close();
                if (k && ("errno" in k)) {
                    if (k.errno == 0) {
                        if (("data" in k) && ("user_is_no_score" in k.data)) {
                            G.ui.popup.showMsg("您属于企业用户，体验评论不再获得积分。有疑问请致电客服询问。", 1,
                            function() {
                                location.href = "http://item.yixun.com/item-" + d + ".html#review_box"
                            },
                            function() {
                                location.href = "http://item.yixun.com/item-" + d + ".html#review_box"
                            },
                            function() {},
                            "我知道了")
                        } else {
                            G.ui.popup.showMsg("发表成功<p><b>您的评论已成功提交，对应积分将即时发放到您的账户。部分特殊商品（如礼品卡）不发放积分，感谢支持。</b></p>", {
                                type: 3,
                                okText: "回首页逛逛",
                                okFn: function() {
                                    location.href = "http://www.yixun.com";
                                    return;
                                },
                                closeFn: function() {
                                    location.href = "http://item.yixun.com/item-" + d + ".html#review_box"
                                },
                                cancelText: "关闭当前页",
                                btns: 3,
                                cancelFn: function() {
                                    var browserName = navigator.appName;
                                    if (browserName=="Netscape") {
                                        window.open('', '_self', '');
                                        window.close();
                                    }else {
                                        if (browserName == "Microsoft Internet Explorer"){
                                            window.opener = "whocares";
                                            window.opener = null;
                                            window.open('', '_top');
                                            window.close();
                                        }
                                    }
                                    return;
                                }
                            });
                        }
                    } else {
                        var c = {
                            18 : "您没有购买过该商品，无法发表体验心得！",
                            21 : "您已经对该商品发表过体验心得了！",
                            22 : "请填写昵称",
                            23 : "您尚未购买该商品，无法发表体验评论，欢迎您发表商品讨论或购买后评价！",
                            24 : "订单出库48小时之后方可发表体验心得！",
                            27 : "您购买的商品已经超过了可评论的期限，您可以对一个月之内的订单发表体验评论并获取积分。感谢您对易迅网的一如既往的支持！",
                            28 : "您的订单尚未完成，暂时无法发表体验评论！",
                            600 : "您的发言频率过快，请稍候再发！",
                            776 : "您所发表的体验心得中含有不恰当的信息，请您检查无误后再发表。"
                        };
                        k.errno = parseInt(k.errno);
                        if (k.errno in c) {
                            G.ui.popup.showMsg(c[k.errno])
                        } else {
                            G.ui.popup.showMsg("抱歉，发表经验心得失败。")
                        }
                    }
                } else {
                    G.ui.popup.showMsg("抱歉，发表经验心得失败。")
                }
            })
        })
    },
    initAsking: function() {
        var a = $("#review_asking_box"),
			b = G.app.review.initTextArea(a,G.app.review.ASKING_DEF_VAL),
			hasBindPop = false;
        G.app.review.codeChaneg();
        $("a[t=submit]", a).click(function() {
            if (G.logic.login.ifLogin(this, arguments) === false) {
                return
            }
            var j = G.logic.login.getLoginUid(),
            k = b.val();
            if ($("input[t=accept_rule]:checked").length <= 0) {
                G.ui.tips.warn("请仔细阅读易迅网的评论规则，接受后方可发表评论！", $("p[t=tipArea]", a));
                return
            }
            k = $.trim(k);
            if (k == G.app.review.ASKING_DEF_VAL) {
                k = ""
            }
            if (k.length <= 0) {
                G.ui.tips.warn("请填写讨论内容！", b);
                return
            }
            var f = $.trim($(".verify_input").val());
            if (f.length <= 0) {
                G.ui.tips.warn("请填写验证码。", b);
                return
            }
            if (k.length < 5 || k.length > 1000) {
                G.ui.tips.warn("字数长度请在5~1000个字之间。", b);
                return
            }
            var l = 1,
            e = {
                1 : "asking",
                2 : "tranandpayasking",
                3 : "invoiceandmaintasking"
            },
            d = $("input[name=asking_type]:checked", a).val();
            if (e[d]) {
                l = d
            }
            var i = itemInfo.pid;
            var h = {
                pid: i,
                content: k,
                codeNum: f
            };
            var g = $("input[name=nick]", a);
            if (g.length > 0) {
                h.nick = g.val()
            }
            G.app.review.loading.open();
            G.util.post(G.util.token.addToken("http://"+G.app.review.DOMAIN+"/json1.php?mod=reviews&act=addasking&type=" + e[l] + "&uid=" + j,'jq'), h,
            function(m) {
                G.app.review.loading.close();
                if (m && m.errno == 0) {
					var content="<div id='J_PopSuccess'>感谢您的咨询，我们将尽快回复，您可至我的易迅-<a href='http://base.yixun.com/myconsult.html' ><b>商品咨询</b></a>查询。</div>";
					G.ui.popup.showMsg(content);
					if ( hasBindPop == false ) {
						$( '#J_PopSuccess' ).parents( '.layer_global' ).click( function( e ) {
							location.href = "http://item.yixun.com/item-" + i + ".html#asking_box";
						});
						hasBindPop = true;
					}
					//setTimeout( function() { location.href = "http://item.yixun.com/item-" + i + ".html#asking_box"; }, 1 );
                } else {
                    if (m && m.errno == 14) {
                        G.ui.tips.warn("验证码错误。", b);
                        G.app.review.codeChaneg();
                        return
                    } else {
                        var c = {
                            12 : "内容过长，请删减部分内容后继续",
                            14 : "请填写昵称",
                            777 : "您所发表的内容可能包含敏感信息，我们会尽快审核，当管理员审核通过后，咨询将显示在页面中。",
                            600 : "您的发言频率过快，请稍候再发！",
                            776 : "您所发表的咨询中含有不恰当的信息，请您检查无误后再发表。"
                        };
                        if (m && (m.errno - 0) in c) {
                            return G.ui.popup.showMsg(c[m.errno])
                        }
                        G.ui.popup.showMsg("抱歉，发表咨询失败！")
                    }
                }
            })
        })
    },
    codeChaneg: function() {
        $("#codeimg").attr("src", "http://"+G.app.review.DOMAIN+"/json.php?jsontype=str&mod=review&act=vcode&_=" + Math.random())
    },
    loading: (function() {
        var a = null;
        function b() {
            if (!a) {
                a = G.ui.popup.create({
                    title: "正在提交中...",
                    width: 500
                });
                a.paint(function(c) {
                    $(c.content).empty().html('<span class="loading_58_58">正在加载中</span>')
                })
            }
            return a
        }
        return {
            open: function() {
                b().show()
            },
            close: function() {
                b().close()
            }
        }
    })()
};/*  |xGv00|d27cc74a982cfaa274e4eb83ba2d3f3b */