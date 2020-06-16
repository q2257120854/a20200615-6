var util = require('we7/resource/js/util.js');
App({

    onLaunch: function (res) {

	},
	
    onShow: function (res) {
		
    },
    onError: function (msg) {
        //console.log(msg)
    },
    //加载微擎工具类
    util: util,
    //导航菜单，微擎将会自己实现一个导航菜单，结构与小程序导航菜单相同
    //用户信息，sessionid是用户是否登录的凭证
    userInfo: {
        sessionid: null,
    },
    siteInfo: require('siteinfo.js')
});