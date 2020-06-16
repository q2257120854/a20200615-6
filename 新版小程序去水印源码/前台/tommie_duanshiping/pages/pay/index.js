var a = getApp();

Page({
    data: {
        array: [],
        id: 0,
        price: 0,
        name: ""
    },
    onLoad: function(a) {},
    onShow: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/payconfig",
            data: {},
            cachetime: "0",
            success: function(a) {
                e.setData({
                    price: a.data.data.data.money_a,
                    name: a.data.data.data.num_a + "次",
                    array: [ {
                        name: a.data.data.data.num_a,
                        price: a.data.data.data.money_a
                    }, {
                        name: a.data.data.data.num_b,
                        price: a.data.data.data.money_b
                    }, {
                        name: a.data.data.data.num_c,
                        price: a.data.data.data.money_c
                    } ]
                });
            },
            fail: function(a) {}
        });
    },
    weixinpay: function() {
        var t = this, e = Math.floor(900 * Math.random()) + 100, n = t.generateTimeReqestNumber() + e;
        console.log(n), a.util.request({
            url: "entry/wxapp/pay",
            data: {
                orderid: n,
                money: t.data.price,
                num: t.data.name
            },
            cachetime: "0",
            success: function(e) {
                e.data && e.data.data && !e.data.errno && wx.requestPayment({
                    timeStamp: e.data.data.timeStamp,
                    nonceStr: e.data.data.nonceStr,
                    package: e.data.data.package,
                    signType: "MD5",
                    paySign: e.data.data.paySign,
                    success: function(e) {
                        console.log(e), a.util.request({
                            url: "entry/wxapp/payse",
                            data: {
                                orderid: n
                            },
                            cachetime: "0",
                            success: function(a) {
                                wx.showModal({
                                    title: "系统提示",
                                    content: "你已经成功充值" + t.data.name,
                                    confirmColor: "#ffa500",
                                    showCancel: !1,
                                    success: function(a) {}
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        console.log("失败", a);
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    onfirmColor: "#ffa500",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && console.log(a);
                    }
                });
            }
        });
    },
    choseTxtColor: function(a) {
        var t = a.currentTarget.dataset.id;
        console.log(a), this.setData({
            id: t,
            price: a.currentTarget.dataset.price,
            name: a._relatedInfo.anchorRelatedText
        });
    },
    pad2: function(a) {
        return a < 10 ? "0" + a : a;
    },
    generateTimeReqestNumber: function() {
        var a = new Date();
        return a.getFullYear().toString() + this.pad2(a.getMonth() + 1) + this.pad2(a.getDate()) + this.pad2(a.getHours()) + this.pad2(a.getMinutes());
    }
});