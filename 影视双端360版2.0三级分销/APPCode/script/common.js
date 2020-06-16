 
 function openWin(name,params){
	  if (typeof(params) == 'boolean') {
        isTabBar = isLogin;
        isLogin = params;
        params = {};
    }
		if (localStorage.getItem('user_id')<1) {
			  api.toast({
				msg: '(ｷ｀ﾟДﾟ´)!!    你还没登陆！',
				duration: 2000
			});
				api.openWin({
				   name: 'login',
				   url: '../html/login.html',
				   delay: 2000
			   });
			   return;
			 }
		api.openWin({
			  name: ''+name+'',
			  url: '../html/'+name+'.html',
			   pageParam: params,
			 
		  });
	}
 
  function openWin1(name,params){
	  if (typeof(params) == 'boolean') {
        isTabBar = isLogin;
        isLogin = params;
        params = {};
    }
		if (localStorage.getItem('user_id')<1) {
			  api.toast({
				msg: '(ｷ｀ﾟДﾟ´)!!    你还没登陆！',
				duration: 2000
			});
				api.openWin({
				   name: 'login',
				   url: './html/login.html',
				   delay: 2000
			   });
			   return;
			 }
		api.openWin({
			  name: ''+name+'',
			  url: './html/'+name+'.html',
			   pageParam: params,
			 
		  });
	}
 function openPlayer(url,title,img){
	 var videoPlayer = api.require('videoPlayer');
videoPlayer.close();
	 	var time = localStorage.getItem('viptime');
		var user_id = localStorage.getItem('user_id');
		var username = localStorage.getItem('user_name');
		var timestamp = Date.parse(new Date())/1000;
	 if (localStorage.getItem('user_id')<1) {
			  api.toast({
				msg: '(ｷ｀ﾟДﾟ´)!!    你还没登陆！',
				duration: 2000
			});
				api.openWin({
				   name: 'login',
				   url: '../html/login.html',
				   delay: 2000
			   });
			   return;
			 }
			 
		 if (time>timestamp) {
		
		api.openWin({
           name: 'x5_win',
           url: '../html/x5_win.html',
           delay: 300,
           pageParam: {
					url: url,
					title:title,
					srcUrl:url,
					img:img,
					needRecordHistory: true
				},
           //pageParam:{url:dataurl2},
           bgColor: '#000000'
       });
		 }else if (time<timestamp){
                  VipExpiredHint();   //会员过期弹窗提示
			}
	   
	 
 }
  function openPlayer1(url,title,img){
	 var videoPlayer = api.require('videoPlayer');
videoPlayer.close();
	 	var time = localStorage.getItem('viptime');
		var user_id = localStorage.getItem('user_id');
		var username = localStorage.getItem('user_name');
		var timestamp = Date.parse(new Date())/1000;
	 if (localStorage.getItem('user_id')<1) {
			  api.toast({
				msg: '(ｷ｀ﾟДﾟ´)!!    你还没登陆！',
				duration: 2000
			});
				api.openWin({
				   name: 'login',
				   url: '../html/login.html',
				   delay: 2000
			   });
			   return;
			 }
			 
		 if (time>timestamp) {
		
		api.openWin({
           name: 'x6_win',
           url: '../html/x6_win.html',
           delay: 300,
           pageParam: {
					url: url,
					title:title,
					srcUrl:url,
					img:img,
					needRecordHistory: true
				},
           //pageParam:{url:dataurl2},
           bgColor: '#000000'
       });
		 }else if (time<timestamp){
                  VipExpiredHint();   //会员过期弹窗提示
			}
	   
	 
 }
 function formatDateTime(timeStamp) {
        var date = new Date();
        date.setTime(timeStamp * 1000);
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        m = m < 10 ? ('0' + m) : m;
        var d = date.getDate();
        d = d < 10 ? ('0' + d) : d;
        var h = date.getHours();
        h = h < 10 ? ('0' + h) : h;
        var minute = date.getMinutes();
        var second = date.getSeconds();
        minute = minute < 10 ? ('0' + minute) : minute;
        second = second < 10 ? ('0' + second) : second;
        return y + '-' + m + '-' + d;
    };
	
function VipExpiredHint() {

                  /*会员过期弹窗提示*/
                  var dialogBox = api.require('dialogBox');
                  dialogBox.alert({
                      tapClose: true,  //描述：（可选项）是否点击遮罩层关闭该对话框  默认值：false
                      texts: {
                          content: '您的VIP会员已过期',
                          leftBtnTitle: '在想想',
                          rightBtnTitle: '去续费'
                      },
                      styles:{
                bg: '#fff',            //（可选项）字符串类型；对话框整体背景配置，支持#、rgb、rgba、img；默认：#fff
                corner: 10,             //（可选项）数字类型；对话框背景圆角大小；默认：2
                w: 300,                //（可选项）数字类型；对话框的宽；默认：300
                title:{                //（可选项）JSON对象；弹窗标题栏样式配置，不传则不显示标题区域
                    marginT: 20,       //（可选项）数字类型；标题栏与对话框顶端间距；默认：20
                    icon: 'widget://image/dialogBoxTisi.jpg',          //（可选项）字符串类型；标题前面的图标路径，要求本地路径（widget://、fs://）；图片为正方形的，如：50*50、100*100，建议开发者传大小合适的图片以适配高分辨率手机屏幕，不传则不显示
                    iconSize: 80,      //（可选项）数字类型；icon 图标边长大小,若 icon 不存在则此参数无效；默认：24
                    titleSize: 14,     //（可选项）数字类型；标题字体大小；默认：14
                    titleColor: '#000' //（可选项）字符串类型；标题字体颜色，支持#、rgb、rgba；默认：#fff
                },
                content:{              //（可选项）JSON 对象；文本内容配置，若不传则不显示该区域
                    marginT: 20,       //（可选项）数字类型；内容文本顶端与标题栏底端的距离，如果标题栏不存在，则是到窗口顶端的距离；默认：20
                    marginB: 40,       //（可选项）数字类型；内容文本底端与 left/right 顶端的距离，如果 left/right 都不存在，则是到对话框底端的距离；默认：20
                    color: '#3d3d3d',     //（可选项）字符串类型；内容文本字体颜色，支持 rgb、rgba、#；默认：#eee
                    size: 12           //（可选项）数字类型：内容文本字体大小；默认：12
                },
                left:{                 //（可选项）JSON 对象；左边按钮样式配置，不传则不显示左边按钮
                    marginB: 30,        //（可选项）数字类型；左边按钮的下边距；默认：7
                    marginL: 30,       //（可选项）数字类型；左边按钮的左边距；默认：20
                    w: 100,            //（可选项）数字类型；左边按钮的宽；默认：130
                    h: 40,             //（可选项）数字类型；左边按钮的高；默认：35
                    corner: 10,         //（可选项）数字类型；左边按钮圆角半径；默认：0.0
                    bg: '#3d3d3d',        //（可选项）字符串类型；左边按钮的背景，支持rgb、rgba、#、img；默认：'#e0e'
                    color: '#fff',  //（可选项）字符串类型；左边按钮标题字体颜色，支持rgb，rgba、#；默认：'#007FFF'
                    size: 12           //（可选项）数字类型；左边按钮标题字体大小；默认：12
                },
                right: {               //（可选项）JSON 对象；右边按钮样式配置，不传则不显示右边按钮
                    marginB: 30,        //（可选项）数字类型；右边按钮的下边距；默认：7
                    marginL: 40,      //（可选项）数字类型；右边按钮左边距；默认：10
                    w: 100,            //（可选项）数字类型；右边按钮的宽；默认：130
                    h: 40,             //（可选项）数字类型；右边按钮的高；默认：35
                    corner: 10,         //（可选项）数字类型；右边按钮圆角半径；默认：0.0
                    bg: '#3d3d3d',        //（可选项）字符串类型；右边按钮的背景，支持rgb、rgba、#、img；默认：'#e0e'
                    color: '#fff',  //（可选项）字符串类型；右边按钮标题字体颜色，支持rgb、rgba、#；默认：'#007FFF'
                    size: 12           //（可选项）数字类型；右边按钮标题字体大小；默认：12
                }
            }
                  }, function(ret) {
                      if (ret.eventType == 'left') {
                          var dialogBox = api.require('dialogBox');
                          dialogBox.close({
                              dialogName: 'alert'
                          });
                      }else if (ret.eventType == 'right') {
                        api.openWin({
                            name: 'open_vip_win',
                            url: '../html/open_vip_win.html',
                            delay: 300
                        });
                        var dialogBox = api.require('dialogBox');
                        dialogBox.close({
                            dialogName: 'alert'
                        });
                      }
                  });
                  /*    会员过期弹窗提示结束    */

}
	