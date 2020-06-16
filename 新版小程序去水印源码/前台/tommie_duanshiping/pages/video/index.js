var a = getApp(), t = 1;

Page({
  data: {
    videolist: [],
    list: [],
    isAudit: 1,
    tuijian: [],
    url: "",
    invite_award: "",
    shareTitle: "",
    imageUrl: "",
    show: !1
  },
  onLoad: function (a) {
    if (wx.getStorageSync("invita_openid").length < 5) {
      var i = a.openid || "";
      wx.setStorageSync("invita_openid", i);
    }
    this.pageRequest(t);
  },
  onShow: function (a) { },
  onPullDownRefresh: function () {
    this.setData({
      videolist: [],
      list: []
    }), t = 1, this.pageRequest(t);
  },
  pageRequest: function (i) {
    var e = this;
    a.util.request({
      url: "entry/wxapp/video",
      data: {
        pages: i
      },
      success: function (a) {
        console.log(a.data), wx.setNavigationBarTitle({
          title: "0" == a.data.data.isaudit.isaudit ? "最新热门视频" : "热门推荐"
        }), e.setData({
          isAudit: a.data.data.isaudit.isaudit,
          tuijian: a.data.data.tuijian,
          url: a.data.data.url,
          invite_award: a.data.data.isaudit.invite_award,
          shareTitle: a.data.data.isaudit.share_title,
          imageUrl: a.data.data.isaudit.share_img
        }), 0 == a.data.data.length ? e.setData({
          list: a.data.data.videolist,
          show: !0
        }) : (e.setData({
          list: a.data.data.videolist,
          videolist: e.data.videolist.concat(a.data.data.videolist)
        }), t++);
      }
    });
  },
  loadMore: function () {
    0 == this.data.list.length || this.pageRequest(t);
  },
  onShareAppMessage: function (a) {
    return a.from, {
      title: this.data.shareTitle,
      path: "/tommie_duanshiping/pages/index/index?openid=" + wx.getStorageSync("share_openid"),
      imageUrl: this.data.url + this.data.imageUrl
    };
  }
});
