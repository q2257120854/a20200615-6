function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e = require("../../../33C406676D08C8FF55A26E60F51510A7.js"), n = getApp();

Page({
    data: (a = {
        showTopTips: !1,
        color: "#ff9900",
        errorMessage: "错误提示",
        inputvalue: "",
        loginState: 0,
        appname: "",
        title: "",
        description: "",
        buttonjiexi: "recommend",
        qqgourp: "",
        shareTitle: "",
        api_url: "",
        helpUrl: "",
        adId: "",
        share_img: "",
        progress: 0,
        adImg: "",
        adText: "",
        copyText: null,
        isAudit: "0",
        downurl: "",
        isMember: ""
    }, t(a, "progress", ""), t(a, "playurl", ""), t(a, "adUnitIds", ""), t(a, "invite_award", ""), 
    t(a, "jiexibut", ""), a),
    onLoad: function(t) {
        if (wx.getStorageSync("invita_openid").length < 5) t.openid;
    },
    onShow: function(t) {
        var a = this;
        wx.getClipboardData({
            success: function(t) {
                var n = e.handleUrl(t.data);
                if (n && n !== a.data.inputvalue) {
                    var o = n.substring(0, 30);
                    wx.showModal({
                        title: "检测到视频链接，是否粘贴？",
                        content: o.length >= 30 ? o + "..." : n,
                        showCancel: !0,
                        cancelText: "取消",
                        cancelColor: "#ff9900",
                        confirmText: "粘贴",
                        confirmColor: "#ff9900",
                        success: function(t) {
                            t.cancel || a.setData({
                                inputvalue: n,
                                downurl: ""
                            });
                        },
                        fail: function(t) {},
                        complete: function(t) {}
                    });
                }
            },
            fail: function(t) {},
            complete: function(t) {}
        }), a.index(), wx.checkSession({
            success: function(t) {
                console.log("没过期"), a.setData({
                    loginState: 1
                });
            },
            fail: function() {
                console.log("过期了"), a.setData({
                    loginState: 0
                });
            }
        });
    },
    tipKeFuMsg: function(t) {
        wx.playBackgroundAudio({
            dataUrl: "http://tts.baidu.com/text2audio?idx=1&tex=" + encodeURIComponent(this.data.description) + "&cuid=baidu_speech_demo&cod=2&lan=zh&ctp=1&pdt=1&spd=5&per=0&vol=5&pit=5"
        });
    },
    start: function() {
        this.setData({
            color: "#ffb428"
        });
    },
    end: function() {
        this.setData({
            color: "#faa508"
        });
    },
    warn: function() {
        wx.showModal({
            title: "温馨提示",
            content: "请先登陆!",
            confirmColor: "#ff9900",
            showCancel: !1,
            success: function(t) {}
        });
    },
    updateUserInfo: function(t) {
        var a = this;
        t.detail.userInfo ? (a.setData({
            loginState: 1
        }), n.util.getUserInfo(function(t) {
            n.util.request({
                url: "entry/wxapp/login",
                cachetime: "30",
                data: {
                    inviterOpenid: wx.getStorageSync("invita_openid")
                },
                success: function(t) {
                    wx.setStorageSync("share_openid", t.data.data.openid), a.index(), a.query();
                },
                fail: function(t) {
                    a.setData({
                        loginState: 0
                    });
                }
            });
        }, t.detail)) : a.setData({
            loginState: 0
        });
    },
    changeLoginState: function() {
        this.setData({
            loginState: 0
        });
    },
    invalue: function(t) {
        this.setData({
            inputvalue: t.detail.value
        });
    },
    clear: function() {
        this.setData({
            inputvalue: ""
        });
    },
    index: function() {
        var t = this;
        n.util.request({
            url: "entry/wxapp/index",
            success: function(a) {
                console.log(a.data.data), t.setData({
                    title: a.data.data.index.title,
                    appname: a.data.data.index.app_name,
                    description: a.data.data.index.description,
                    qqgourp: a.data.data.index.qq_group,
                    shareTitle: a.data.data.index.share_title,
                    api_url: a.data.data.index.api_url,
                    share_img: a.data.data.index.share_img,
                    adId: a.data.data.index.ad_id,
                    invite_award: a.data.data.index.invite_award,
                    adUnitIds: a.data.data.index.adUnitIds,
                    adImg: a.data.data.url + a.data.data.index.adimg,
                    adText: a.data.data.index.adtext,
                    copyText: a.data.data.index.copytext,
                    isAudit: a.data.data.index.isaudit,
                    helpUrl: a.data.data.index.help_url,
                    progress: a.data.data.index.progress,
                    isMember: a.data.data.index.is_member,
                    jiexibut: a.data.data.index.api_url ? "下载视频" : "解析视频"
                }), wx.setNavigationBarTitle({
                    title: a.data.data.index.app_name
                });
            }
        });
    },
    paste: function() {
        var t = this;
        wx.getClipboardData({
            success: function(a) {
                var n = e.handleUrl(a.data);
                n ? t.setData({
                    inputvalue: n
                }) : wx.showModal({
                    title: "温馨提示",
                    content: "没有可用的链接",
                    confirmColor: "#ff9900",
                    showCancel: !1,
                    success: function(a) {
                        t.setData({
                            result: ""
                        });
                    }
                });
            }
        });
    },
    copy: function() {
        wx.setClipboardData({
            data: this.data.copyText
        });
    },
    query: function(t) {
        var a = this, e = a.isUrl(a.data.inputvalue);
        e && n.util.request({
            url: "entry/wxapp/query",
            data: {
                url: e
            },
            success: function(t) {
                a.setData({
                    downurl: t.data.data.downurl,
                    playurl: decodeURIComponent(t.data.data.downurl)
                });
            },
            fail: function(t) {
                var e = t.data.errno;
                wx.hideToast({}), wx.showModal({
                    title: "提示：",
                    content: t.data.message,
                    confirmColor: "#ff9900",
                    showCancel: !1,
                    success: function(t) {
                        3 === e && wx.removeStorage({
                            key: "userInfo",
                            success: function(t) {
                                a.setData({
                                    loginState: 0
                                }), wx.reLaunch({
                                    url: "../index/index"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    savevideo: function() {
        var t = this, a = wx.createRewardedVideoAd({
            adUnitId: t.data.adUnitIds
        });
        a.load().then(function() {
            return a.show();
        }).catch(function(t) {
            return console.log(t.errMsg);
        }), a.onError(function(a) {
            console.log(a), t.downloads();
        }), a.onClose(function(e) {
            a.offClose(), e && e.isEnded || void 0 === e ? t.downloads() : wx.showModal({
                title: "温馨提示：",
                content: "看完广告后自动保存到相册!",
                showCancel: !0,
                cancelText: "取消",
                cancelColor: "#ed3f14",
                confirmText: "确定",
                confirmColor: "#ed3f14",
                success: function(a) {
                    a.cancel || t.savevideo();
                }
            });
        });
    },
    downloads: function() {
        var t = this;
        t.data.api_url ? (wx.showToast({
            title: "开始下载！",
            icon: "loading",
            duration: 1e3
        }), wx.downloadFile({
            url: t.data.api_url + t.data.downurl,
            success: function(a) {
                200 === a.statusCode && (wx.hideToast({}), wx.saveVideoToPhotosAlbum({
                    filePath: a.tempFilePath,
                    success: function(a) {
                        t.setData({
                            playurl: ""
                        }), wx.showModal({
                            title: "下载成功",
                            content: "请在系统相册中查看！",
                            confirmColor: "#ff9900",
                            showCancel: !1,
                            success: function(t) {}
                        });
                    }
                }));
            },
            fail: function(a) {
                wx.hideToast({}), wx.showModal({
                    title: "下载失败",
                    content: a.data.message,
                    confirmColor: "#ff9900",
                    showCancel: !1,
                    success: function(a) {
                        t.setData({});
                    }
                });
            }
        }).onProgressUpdate(function(a) {
            "1" === t.data.progress ? wx.showToast({
                title: String(a.progress) + "%",
                icon: "loading",
                duration: 8e4
            }) : wx.showToast({
                title: "下载中...",
                icon: "loading",
                duration: 8e4
            });
        })) : t.copydownurl();
    },
    isUrl: function(t) {
        var a = this;
        return 0 == t.length ? (wx.showModal({
            title: "温馨提示",
            content: "网址不能为空",
            confirmColor: "#ff9900",
            showCancel: !1
        }), !1) : e.handleUrl(t) || (wx.showModal({
            title: "温馨提示",
            content: "请输入正确的网址",
            confirmColor: "#ff9900",
            showCancel: !1,
            success: function(t) {
                a.setData({
                    result: ""
                });
            }
        }), !1);
    },
    help: function() {
        this.data.helpUrl.length > 6 ? wx.navigateTo({
            url: "../../pages/web/index?url=" + this.data.helpUrl
        }) : wx.navigateTo({
            url: "../help/index"
        });
    },
    toduihuan: function() {
        wx.navigateTo({
            url: "../keypay/keypay"
        });
    },
    copyqq: function() {
        var t;
        t = this.data.qqgourp, wx.setClipboardData({
            data: t,
            success: function(t) {
                wx.showToast({
                    title: "复制成功",
                    icon: "success",
                    duration: 800
                }), setTimeout(function() {
                    wx.hideToast({});
                }, 800);
            }
        });
    },
    copydownurl: function() {
        var t = this, a = wx.createRewardedVideoAd({
            adUnitId: t.data.adUnitIds
        });
        a.load().then(function() {
            return a.show();
        }).catch(function(t) {
            return console.log(t.errMsg);
        }), a.onError(function(a) {
            console.log(a), t.copydownurls();
        }), a.onClose(function(e) {
            a.offClose(), e && e.isEnded || void 0 === e ? t.copydownurls() : wx.showModal({
                title: "温馨提示：",
                content: "看完广告后自动复制下载链接!",
                showCancel: !0,
                cancelText: "取消",
                cancelColor: "#ed3f14",
                confirmText: "确定",
                confirmColor: "#ed3f14",
                success: function(a) {
                    a.cancel || t.copydownurl();
                }
            });
        });
    },
    copydownurls: function() {
        wx.setClipboardData({
            data: this.data.playurl,
            success: function(t) {
                wx.showToast({
                    title: "复制成功",
                    icon: "success",
                    duration: 800
                }), setTimeout(function() {
                    wx.hideToast({});
                }, 800);
            }
        });
    },
    onShareAppMessage: function(t) {
        return t.from, {
            title: this.data.shareTitle,
            path: "/tommie_duanshiping/pages/index/index?openid=" + wx.getStorageSync("share_openid"),
            imageUrl: this.data.share_img
        };
    }
});