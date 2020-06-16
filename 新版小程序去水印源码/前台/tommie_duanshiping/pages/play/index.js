var t = getApp();

Page({
    data: {
        src: "",
        title: "",
        vid: "",
        play: !1,
        favouriteImg: "../../resource/image/shoucangb.png",
        favouriteState: 0,
        loginState: 0
    },
    onLoad: function(a) {
        var e = this;
        "" == t.myData.inviteOpenid && (t.myData.inviteOpenid = a.openid || ""), wx.setNavigationBarTitle({
            title: a.title
        }), wx.getStorage({
            key: "userInfo",
            success: function(t) {
                e.setData({
                    loginState: 1
                });
            },
            fail: function(t) {
                e.setData({
                    loginState: 0
                });
            }
        }), t.util.request({
            url: "entry/wxapp/play",
            data: {
                videoid: a.vid
            },
            success: function(t) {
                e.setData({
                    favouriteState: t.data.data.code,
                    favouriteImg: 0 == t.data.data.code ? "../../resource/image/shoucangb.png" : "../../resource/image/shoucanga.png"
                });
            }
        }), e.setData({
            title: a.title,
            vid: a.vid,
            src: "https://aweme.snssdk.com/aweme/v1/play/?video_id=" + a.vid + "&line=0&ratio=540p&media_type=4&vr_type=0",
            play: !0
        });
    },
    updateUserInfo: function(a) {
        var e = this;
        a.detail.userInfo ? t.util.getUserInfo(function(a) {
            t.util.request({
                url: "entry/wxapp/login",
                cachetime: "30",
                data: {},
                success: function(t) {
                    e.setData({
                        loginState: 1
                    });
                },
                fail: function(t) {
                    e.setData({
                        loginState: 0
                    });
                }
            });
        }, a.detail) : e.setData({
            loginState: 0
        });
    },
    favourite: function() {
        var a = this;
        0 == a.data.favouriteState ? t.util.request({
            url: "entry/wxapp/favourite",
            data: {
                videoid: a.data.vid
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    favouriteState: t.data.data.code,
                    favouriteImg: 0 == t.data.data.code ? "../../resource/image/shoucangb.png" : "../../resource/image/shoucanga.png"
                });
            }
        }) : t.util.request({
            url: "entry/wxapp/favourite",
            data: {
                code: a.data.favouriteState,
                videoid: a.data.vid
            },
            success: function(t) {
                a.setData({
                    favouriteState: t.data.data.code,
                    favouriteImg: 0 == t.data.data.code ? "../../resource/image/shoucangb.png" : "../../resource/image/shoucanga.png"
                });
            }
        });
    },
    back: function() {
        wx.switchTab({
            url: "../video/index"
        });
    },
    download: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/playdownload",
            data: {
                vid: a.data.vid
            },
            success: function(t) {
                if (t.data.data.apiurl.api_url) {
                    wx.showToast({
                        title: "下载中",
                        icon: "loading",
                        duration: 8e3
                    });
                    var e = wx.downloadFile({
                        url: t.data.data.apiurl.api_url + t.data.data.downurl,
                        success: function(t) {
                            200 === t.statusCode && (wx.hideToast({}), wx.saveVideoToPhotosAlbum({
                                filePath: t.tempFilePath,
                                success: function(t) {
                                    wx.showModal({
                                        title: "下载成功",
                                        content: "请在系统相册中查看！",
                                        confirmColor: "#ffa500",
                                        showCancel: !1,
                                        success: function(t) {}
                                    });
                                }
                            }));
                        },
                        fail: function(t) {
                            wx.showModal({
                                title: "下载失败",
                                content: "请稍后再试！",
                                confirmColor: "#ffa500",
                                showCancel: !1,
                                success: function(t) {
                                    a.setData({});
                                }
                            });
                        }
                    });
                    e.onProgressUpdate(function(t) {
                        wx.showToast({
                            title: String(t.progress) + "%",
                            icon: "loading",
                            duration: 8e4
                        }), t.totalBytesExpectedToWrite < 2e5 && e.abort();
                    });
                } else wx.setClipboardData({
                    data: t.data.data.downurl
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "下载失败",
                    content: "请稍后重试！",
                    confirmColor: "#ffa500",
                    showCancel: !1,
                    success: function(t) {}
                });
            }
        });
    },
    onShareAppMessage: function(a) {
        return a.from, {
            title: this.data.title + "【抖音无水印视频】",
            path: "/gzy_shortvideo/pages/play/index?vid=" + this.data.vid + "&title=" + this.data.title + "&openid=" + t.myData.openid
        };
    }
});