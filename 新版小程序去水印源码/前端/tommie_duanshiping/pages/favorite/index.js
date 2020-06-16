var a = getApp(), t = 1;

Page({
    data: {
        videolist: [],
        list: [],
        show: !1,
        nickname: ""
    },
    onLoad: function(a) {
        if (wx.getStorageSync("invita_openid").length < 5) {
            var e = a.openid || "";
            wx.setStorageSync("invita_openid", e);
        }
        t = 1, this.pageRequest(t);
    },
    pageRequest: function(e) {
        var i = this;
        a.util.request({
            url: "entry/wxapp/myfavourite",
            data: {
                pages: e
            },
            success: function(a) {
                0 == a.data.data.length ? i.setData({
                    list: a.data.data.data,
                    show: !0
                }) : (i.setData({
                    list: a.data.data.data,
                    videolist: i.data.videolist.concat(a.data.data.data),
                    nickname: a.data.data.nickname
                }), t++);
            }
        });
    },
    loadMore: function() {
        0 == this.data.list.length ? this.setData({
            show: !0
        }) : this.pageRequest(t);
    },
    onShareAppMessage: function(a) {
        return {
            title: this.data.nickname + "的抖音无水印视频收藏",
            path: "/tommie_duanshiping/pages/favorite/index?openid=" + wx.getStorageSync("share_openid")
        };
    }
});