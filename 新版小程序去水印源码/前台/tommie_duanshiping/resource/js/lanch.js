var lanch = {};
lanch.handleUrl = function (str) {
  var reg = /(https?|http|ftp|file):\/\/[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]/g;
  str = str.match(reg);
  if (str) {
    return (str[0])
  } else {
    return (false)
  }
},
  lanch.fmtDate = function (obj) {
    var date = new Date(parseInt(obj * 1000));
    var y = 1900 + date.getYear();
    var m = "0" + (date.getMonth() + 1);
    var d = "0" + date.getDate();
    return y + "-" + m.substring(m.length - 2, m.length) + "-" + d.substring(d.length - 2, d.length);
  },
  lanch.page = function (list, id) {
    var arr = [];

    var index = (id == 0) ? 0 : id * 15;
    if (index > list.length) {
      wx.showToast({
        title: '已经到底了！',
        icon: 'none'
      })
    } else {
      wx.showToast({
        title: '加载中',
        icon: 'loading',
        duration: 500
      });
      for (var i = 0; i < 15; i++) {
        if ((index + i) < list.length) {
          arr.push(list[index + i]);
          if (arr[i].regtime.indexOf("-") == -1) {
            arr[i].regtime = lanch.fmtDate(arr[i].regtime);
          }

        } else {
          break;
        }

      }
    }
    return arr;
  }
module.exports = lanch;