var t = getApp();

Page({
    data: {
        color: "#ffa500",
        key: "",
        weixin: ""
    },
    onLoad: function(a) {
        var n = this;
        t.util.request({
            url: "entry/wxapp/vippay",
            success: function(t) {
                console.log(t.data), n.setData({
                    weixin: t.data.data.weixin
                });
            }
        });
    },
    onShow: function() {},
    invalue: function(t) {
        console.log(t.detail.value), this.setData({
            key: t.detail.value
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
    duihuan: function() {
        var a = this, n = a.data.key;
        n.length < 5 ? wx.showModal({
            title: "温馨提示",
            content: "请输入正确的激活码",
            confirmColor: "#ffa500",
            showCancel: !1,
            success: function(t) {
                a.setData({
                    result: ""
                });
            }
        }) : wx.showModal({
            title: "温馨提示",
            content: "是否确认兑换？",
            confirmColor: "#ffa500",
            showCancel: !0,
            success: function(a) {
                a.cancel || t.util.request({
                    url: "entry/wxapp/keypay",
                    data: {
                        key: n
                    },
                    success: function(t) {
                        wx.showModal({
                            title: "温馨提示：",
                            content: "恭喜！兑换成功！",
                            confirmColor: "#ffa500",
                            showCancel: !1,
                            success: function(t) {
                                t.cancel;
                            }
                        });
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {}
});