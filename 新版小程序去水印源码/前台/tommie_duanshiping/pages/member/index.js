var a = getApp();

Page({
    data: {
        loginState: 0,
        headimg: "",
        helpUrl: "",
        nickname: "",
        contact: "",
        qq: "",
        is_pay: "0",
        isAudit: 1,
        isMember: "",
        num: "10",
        inviteuum: 0,
        inviteaward: 0,
        onpayenter: "0",
        qq_group: "",
        date: ""
    },
    onLoad: function(a) {
        if (wx.getStorageSync("invita_openid").length < 5) {
            var t = a.openid || "";
            wx.setStorageSync("invita_openid", t);
        }
    },
    onShow: function(t) {
        var e = this;
        wx.checkSession({
            success: function(t) {
                console.log("没过期"), e.setData({
                    loginState: 1
                }), a.util.request({
                    url: "entry/wxapp/member",
                    success: function(a) {
                        console.log(a.data.data), e.setData({
                            headimg: a.data.data.user.headimg,
                            nickname: a.data.data.user.nickname,
                            contact: a.data.data.contact.contact,
                            qq: a.data.data.contact.qq_num,
                            is_pay: a.data.data.contact.is_pay,
                            num: a.data.data.user.maximum,
                            isAudit: a.data.data.contact.isaudit,
                            date: a.data.data.endtime,
                            isMember: a.data.data.contact.is_member,
                            onpayenter: a.data.data.contact.onpayenter,
                            inviteaward: a.data.data.contact.invite_award,
                            helpUrl: a.data.data.contact.help_url,
                            qq_group: a.data.data.contact.qq_group,
                            inviteuum: a.data.data.inviteuum
                        });
                    }
                });
            },
            fail: function() {
                console.log("过期了"), e.setData({
                    loginState: 0
                });
            }
        });
    },
    updateUserInfo: function(t) {
        var e = this;
        t.detail.userInfo ? a.util.getUserInfo(function(t) {
            a.util.request({
                url: "entry/wxapp/login",
                cachetime: "30",
                data: {
                    inviterOpenid: wx.getStorageSync("invita_openid")
                },
                success: function(t) {
                    wx.setStorageSync("share_openid", t.data.data.openid), a.util.request({
                        url: "entry/wxapp/member",
                        cachetime: "300",
                        success: function(a) {
                            console.log(a.data.data), e.setData({
                                headimg: a.data.data.user.headimg,
                                nickname: a.data.data.user.nickname,
                                contact: a.data.data.contact.contact,
                                qq: a.data.data.contact.qq_num,
                                is_pay: a.data.data.contact.is_pay,
                                date: a.data.data.endtime,
                                num: a.data.data.user.maximum,
                                isAudit: a.data.data.contact.isaudit,
                                isMember: a.data.data.contact.is_member,
                                onpayenter: a.data.data.contact.onpayenter,
                                inviteaward: a.data.data.contact.invite_award,
                                helpUrl: a.data.data.contact.help_url,
                                inviteuum: a.data.data.inviteuum
                            });
                        }
                    }), e.setData({
                        loginState: 1
                    });
                },
                fail: function(a) {
                    e.setData({
                        loginState: 0
                    });
                }
            });
        }, t.detail) : e.setData({
            loginState: 0
        });
    },
    warn: function() {
        wx.showModal({
            title: "温馨提示",
            content: "请先登陆!",
            confirmColor: "#ffa500",
            showCancel: !1,
            success: function(a) {}
        });
    },
    copyqq_group: function() {
        wx.setClipboardData({
            data: this.data.qq_group,
            success: function(a) {},
            fail: function(a) {},
            complete: function(a) {}
        });
    },
    business: function() {
        var a = this;
        wx.showModal({
            title: "温馨提示",
            content: "您将复制微信号:" + a.data.qq,
            confirmColor: "#ffa500",
            showCancel: !1,
            success: function(t) {
                wx.setClipboardData({
                    data: a.data.qq
                });
            }
        });
    },
    previewImage: function(a) {
        wx.previewImage({
            urls: [ this.data.contact ]
        });
    },
    onShareAppMessage: function(a) {
        return {
            title: this.data.nickname + "的会员中心",
            path: "/tommie_duanshiping/pages/member/index?openid=" + wx.getStorageSync("share_openid")
        };
    }
});