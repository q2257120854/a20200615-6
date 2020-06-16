var t = {
    handleUrl: function(t) {
        return !!(t = t.match(/(https?|http|ftp|file):\/\/[-A-Za-z0-9+&@#\/%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/%=~_|]/g)) && t[0];
    },
    fmtDate: function(t) {
        var e = new Date(parseInt(1e3 * t)), n = 1900 + e.getYear(), r = "0" + (e.getMonth() + 1), a = "0" + e.getDate();
        return n + "-" + r.substring(r.length - 2, r.length) + "-" + a.substring(a.length - 2, a.length);
    },
    page: function(e, n) {
        var r = [], a = 0 == n ? 0 : 15 * n;
        if (a > e.length) wx.showToast({
            title: "已经到底了！",
            icon: "none"
        }); else for (var g = 0; g < 15 && a + g < e.length; g++) r.push(e[a + g]), -1 == r[g].regtime.indexOf("-") && (r[g].regtime = t.fmtDate(r[g].regtime));
        return r;
    }
};

module.exports = t;