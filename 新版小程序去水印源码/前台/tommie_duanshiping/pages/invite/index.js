var t = require("../../../33C406676D08C8FF55A26E60F51510A7.js"), a = getApp(), e = 1;

Page({
    data: {
        userlist: [],
        list: [],
        show: !1
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {
        console.log("开始"), this.pageRequest(), e = 0;
    },
    onHide: function() {},
    pageRequest: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/invite",
            data: {},
            success: function(a) {
                e.setData({
                    userlist: a.data.data,
                    list: t.page(a.data.data, 0)
                });
            }
        });
    },
    loadMore: function() {
        e++, this.setData({
            list: this.data.list.concat(t.page(this.data.userlist, e))
        });
    },
    onShareAppMessage: function() {}
});