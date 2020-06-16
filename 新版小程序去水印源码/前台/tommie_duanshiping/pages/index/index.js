function t(t, a, o) {
  return a in t ? Object.defineProperty(t, a, {
    value: o,
    enumerable: !0,
    configurable: !0,
    writable: !0
  }) : t[a] = o, t;
}
var a, o = require("../../../33C406676D08C8FF55A26E60F51510A7.js"), e = getApp();
var util = require('../../resource/js/lanch.js');
var app = getApp();
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
  }, t(a, "progress", ""), t(a, "playurl", ""), t(a, "adUnitIds", ""), t(a, "scrollTop", 0),
  t(a, "showAddMeBtn", !0), t(a, "isTop", 0), t(a, "jiexibut", ""), a),
  onLoad: function(t) {
    if (wx.getStorageSync("invita_openid").length < 5) {
      var a = t.openid || "";
      wx.setStorageSync("invita_openid", a);
    }
  },
  onShow: function (res) {
    let that = this;
    wx.getClipboardData({
      success: function (res) {
        let result = util.handleUrl(res.data);
        if (result && result !== that.data.inputvalue) {
          let txturl = result.substring(0, 30)
          wx.showModal({
            title: '检测到视频链接，是否粘贴？',
            content: txturl.length >= 30 ? txturl + '...' : result,
            showCancel: true,//是否显示取消按钮
            cancelText: "取消",//默认是“取消”
            cancelColor: '#ff9900',//取消文字的颜色
            confirmText: "粘贴",//默认是“确定”
            confirmColor: '#ff9900',//确定文字的颜色
            success: function (res) {
              if (res.cancel) {

              } else {

                that.setData({
                  inputvalue: result,
                  downurl: ""
                })
              }
            },
            fail: function (res) { },
            complete: function (res) { },
          })

        }
      },
      fail: function (res) { },
      complete: function (res) { },
    })

    that.index()

    wx.checkSession({
      success: function (e) {
        console.log("没过期");
        that.setData({
          loginState: 1
        })
      },
      fail: function () {
        console.log("过期了");
        that.setData({
          loginState: 0
        })
      }
    });

  },

  tipKeFuMsg: function (t) {
    let that = this;
    wx.playBackgroundAudio({
      dataUrl: "http://tts.baidu.com/text2audio?idx=1&tex=" + encodeURIComponent(that.data.description) + "&cuid=baidu_speech_demo&cod=2&lan=zh&ctp=1&pdt=1&spd=5&per=0&vol=5&pit=5"
    });
  },
  start: function () {
    let that = this;
    that.setData({
      color: '#ffb428'
    })
  },
  end: function () {
    let that = this;
    that.setData({
      color: '#faa508'
    })
  },
  warn: function () {
    wx.showModal({
      title: '温馨提示',
      content: "请先登陆!",
      confirmColor: "#ff9900",
      showCancel: false,
      success: function (res) {

      }
    })
  },
  updateUserInfo: function (result) {
    var that = this;
    if (result.detail.userInfo) {
      that.setData({
        loginState: 1
      })
      app.util.getUserInfo(function (userInfo) {
        app.util.request({
          'url': 'entry/wxapp/login',
          'cachetime': '30',
          data: {
            inviterOpenid: wx.getStorageSync("invita_openid")
          },
          success(res) {
            wx.setStorageSync("share_openid", res.data.data.openid);
            that.index(),
              that.query()
          },
          fail(res) {
            that.setData({
              loginState: 0
            })
          }
        })
      }, result.detail)
    } else {
      that.setData({
        loginState: 0
      })
    }

  },
  changeLoginState: function () {
    this.setData({
      loginState: 0
    })
  },
  invalue: function (e) {
    this.setData({
      inputvalue: e.detail.value
    })
  },
  clear: function () {
    this.setData({
      inputvalue: ''
    })
  },
  index: function () {
    let that = this;
    let adIdList = [];
    app.util.request({
      'url': 'entry/wxapp/index',
      success(res) {
        res.data.data.index.ad_id.includes('、') ? adIdList = res.data.data.index.ad_id.split('、') : adIdList[0] = res.data.data.index.ad_id;
        console.log(res.data.data)
        that.setData({
          title: res.data.data.index.title,
          appname: res.data.data.index.app_name,
          description: res.data.data.index.description,
          qqgourp: res.data.data.index.qq_group,
          shareTitle: res.data.data.index.share_title,
          api_url: res.data.data.index.api_url,
          share_img: res.data.data.index.share_img,
          adId: adIdList[0],
          adUnitIds: adIdList[1],
          adImg: res.data.data.url + res.data.data.index.adimg,
          adText: res.data.data.index.adtext,
          copyText: res.data.data.index.copytext,
          isAudit: res.data.data.index.isaudit,
          helpUrl: res.data.data.index.help_url,
          progress: res.data.data.index.progress,
          isMember: res.data.data.index.is_member,
          jiexibut: res.data.data.index.api_url ? '下载视频' : '解析视频'
        }),
          wx.setNavigationBarTitle({
            title: res.data.data.index.app_name
          })

      }
    })
  },
  paste: function () {
    let that = this;
    wx.getClipboardData({
      success: function (res) {
        let result = util.handleUrl(res.data);
        if (result) {
          that.setData({
            inputvalue: result
          })
        } else (
          wx.showModal({
            title: '温馨提示',
            content: "没有可用的链接",
            confirmColor: "#ff9900",
            showCancel: false,
            success: function (res) {
              that.setData({
                result: ''
              })
            }
          })
        )

      }
    })

  },
  copy: function () {
    let that = this;
    wx.setClipboardData({
      data: that.data.copyText
    })
  },
  query: function (e) {
    let that = this;
    let gurl = that.isUrl(that.data.inputvalue);
    if (gurl) {
      app.util.request({
        'url': 'entry/wxapp/query',
        'data': {
          url: gurl
        },
        success(res) {
          that.setData({ downurl: res.data.data.downurl, playurl: decodeURIComponent(res.data.data.downurl) })
        },
        fail(res) {
          let err = res.data.errno
          wx.hideToast({})
          wx.showModal({
            title: '提示：',
            content: res.data.message,
            confirmColor: "#ff9900",
            showCancel: false,
            success: function (res) {
              if (err === 3) {
                wx.removeStorage({
                  key: 'userInfo',
                  success(res) {
                    that.setData({
                      loginState: "0"
                    })
                    wx.reLaunch({
                      url: '../index/index'
                    })
                  }
                })
              }
            }
          })

        }
      })


    }
  },
  savevideo: function () {
    let that = this;
    let videoAd = wx.createRewardedVideoAd({
      adUnitId: that.data.adUnitIds
    })
    videoAd.offLoad()
    videoAd.offClose()
    videoAd.offError()
    videoAd.load()
      .then(() => videoAd.show())
      .catch(err => console.log(err.errMsg))
    videoAd.onError(err => {
      console.log(err),
        that.downloads()
    })
    videoAd.onClose(res => {
      if (res && res.isEnded || res === undefined) {
        that.downloads()
      } else {
        wx.showModal({
          title: '温馨提示：',
          content: '看完广告后自动保存到相册!',
          showCancel: true,
          cancelText: "取消",
          cancelColor: '#ed3f14',
          confirmText: "确定",
          confirmColor: '#ed3f14',
          success: function (res) {
            if (res.cancel) {
            } else {
              that.savevideo()
            }

          }
        })
      }
    }
    )
  },

  downloads: function () {
    let that = this;
    if (that.data.api_url) {
      wx.showToast({
        title: '开始下载！',
        icon: 'loading',
        duration: 1000
      })
      const downloadTask = wx.downloadFile({
        url: that.data.api_url + that.data.downurl,
        success(res) {

          if (res.statusCode === 200) {
            wx.hideToast({})
            wx.saveVideoToPhotosAlbum({
              filePath: res.tempFilePath,
              success(res) {
                that.setData({ playurl: "" })
                wx.showModal({
                  title: '下载成功',
                  content: "请在系统相册中查看！",
                  confirmColor: "#ff9900",
                  showCancel: false,
                  success: function (res) {
                  }
                })
              }
            })


          }
        },
        fail(res) {
          //console.log(res)
          wx.hideToast({})
          wx.showModal({
            title: '下载失败',
            content: res.data.message,
            confirmColor: "#ff9900",
            showCancel: false,
            success: function (res) {
              that.setData({

              })
            }
          })
        }
      })

      downloadTask.onProgressUpdate((res) => {

        if (that.data.progress === "1") {
          wx.showToast({
            title: String(res.progress) + "%",
            icon: 'loading',
            duration: 80000
          })
        } else {
          wx.showToast({
            title: "下载中...",
            icon: 'loading',
            duration: 80000
          })
        }

      })
    } else {
      that.copydownurl()
    }
  },
  isUrl: function (url) {
    var that = this;
    if (url.length == 0) {
      wx.showModal({
        title: '温馨提示',
        content: "网址不能为空",
        confirmColor: "#ff9900",
        showCancel: false,
      })
      return false;
    } else {
      let result = util.handleUrl(url);
      if (result) {
        return result;
      } else {
        wx.showModal({
          title: '温馨提示',
          content: "请输入正确的网址",
          confirmColor: "#ff9900",
          showCancel: false,
          success: function (res) {
            that.setData({
              result: ''
            })
          }
        })
        return false;
      }
    }
  },
  help: function () {
    let that = this;
    if (that.data.helpUrl.length > 6) {
      wx.navigateTo({
        url: '../../pages/web/index?url=' + that.data.helpUrl
      })
    } else {
      wx.navigateTo({
        url: '../help/index'
      })
    }

  },
  toduihuan: function () {
    wx.navigateTo({
      url: '../keypay/keypay'
    })
  },
  copyqq: function () {
    var that = this;
    var dataT = "";
    dataT = that.data.qqgourp
    wx.setClipboardData({
      data: dataT,
      success: function (res) {
        wx.showToast({
          title: '复制成功',
          icon: 'success',
          duration: 800
        })
        setTimeout(
          function () {
            wx.hideToast({})
          }, 800);
      }
    })
  },
  copydownurl: function () {
    let that = this;
    let videoAd = wx.createRewardedVideoAd({
      adUnitId: that.data.adUnitIds
    })
    videoAd.offLoad()
    videoAd.offClose()
    videoAd.offError()
    videoAd.load()
      .then(() => videoAd.show())
      .catch(err => console.log(err.errMsg))
    videoAd.onError(err => {
      console.log(err),
        that.copydownurls()
    })
    videoAd.onClose(res => {
      if (res && res.isEnded || res === undefined) {
        that.copydownurls()
      } else {
        wx.showModal({
          title: '温馨提示：',
          content: '看完广告后自动复制下载链接!',
          showCancel: true,
          cancelText: "取消",
          cancelColor: '#ed3f14',
          confirmText: "确定",
          confirmColor: '#ed3f14',
          success: function (res) {
            if (res.cancel) {
            } else {
              that.copydownurl()
            }

          }
        })
      }
    }
    )
  },
  copydownurls: function () {
    let that = this;
    wx.setClipboardData({
      data: that.data.playurl,
      success: function (res) {
        wx.showToast({
          title: '复制成功',
          icon: 'success',
          duration: 800
        })
        setTimeout(
          function () {
            wx.hideToast({})
          }, 800);
      }
    })
  },
  onPageScroll: function (t) {
    var a = this;
    t.scrollTop <= 0 ? t.scrollTop = 0 : t.scrollTop > wx.getSystemInfoSync().windowHeight && (t.scrollTop = wx.getSystemInfoSync().windowHeight),
      t.scrollTop > this.data.scrollTop || t.scrollTop >= this.data.scrollHeight ? console.log("向下滚动") : console.log("向上滚动"),
      setTimeout(function () {
        a.setData({
          scrollTop: t.scrollTop
        });
      }, 0);
  },
  onClose1: function (t) {
    this.setData({
      scrollTop: 0
    });
  },
  _eventbackToTop: function () {
    wx.pageScrollTo({
      scrollTop: 0,
      duration: 300
    });
  },
  gomd5: function () {
    wx.switchTab({
      url: "/tommie_duanshiping/pages/md5/index"
    });
  },
  onShareAppMessage: function (t) {
    return t.from, {
      title: this.data.shareTitle,
      path: "/tommie_duanshiping/pages/index/index?openid=" + wx.getStorageSync("share_openid"),
      imageUrl: this.data.share_img
    };
  }
});