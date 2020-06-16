(function(a,b){$window=a(b),a.fn.lazyload=function(c){function f(){var b=0;d.each(function(){var c=a(this);if(e.skip_invisible&&!c.is(":visible"))return;if(!a.abovethetop(this,e)&&!a.leftofbegin(this,e))if(!a.belowthefold(this,e)&&!a.rightoffold(this,e))c.trigger("appear");else if(++b>e.failure_limit)return!1})}var d=this,e={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!0,appear:null,load:null};return c&&(undefined!==c.failurelimit&&(c.failure_limit=c.failurelimit,delete c.failurelimit),undefined!==c.effectspeed&&(c.effect_speed=c.effectspeed,delete c.effectspeed),a.extend(e,c)),$container=e.container===undefined||e.container===b?$window:a(e.container),0===e.event.indexOf("scroll")&&$container.bind(e.event,function(a){return f()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,c.one("appear",function(){if(!this.loaded){if(e.appear){var f=d.length;e.appear.call(b,f,e)}a("<img />").bind("load",function(){c.hide().attr("src",c.data(e.data_attribute))[e.effect](e.effect_speed),b.loaded=!0;var f=a.grep(d,function(a){return!a.loaded});d=a(f);if(e.load){var g=d.length;e.load.call(b,g,e)}}).attr("src",c.data(e.data_attribute))}}),0!==e.event.indexOf("scroll")&&c.bind(e.event,function(a){b.loaded||c.trigger("appear")})}),$window.bind("resize",function(a){f()}),f(),this},a.belowthefold=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.height()+$window.scrollTop():e=$container.offset().top+$container.height(),e<=a(c).offset().top-d.threshold},a.rightoffold=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.width()+$window.scrollLeft():e=$container.offset().left+$container.width(),e<=a(c).offset().left-d.threshold},a.abovethetop=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.scrollTop():e=$container.offset().top,e>=a(c).offset().top+d.threshold+a(c).height()},a.leftofbegin=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.scrollLeft():e=$container.offset().left,e>=a(c).offset().left+d.threshold+a(c).width()},a.inviewport=function(b,c){return!a.rightofscreen(b,c)&&!a.leftofscreen(b,c)&&!a.belowthefold(b,c)&&!a.abovethetop(b,c)},a.extend(a.expr[":"],{"below-the-fold":function(c){return a.belowthefold(c,{threshold:0,container:b})},"above-the-top":function(c){return!a.belowthefold(c,{threshold:0,container:b})},"right-of-screen":function(c){return a.rightoffold(c,{threshold:0,container:b})},"left-of-screen":function(c){return!a.rightoffold(c,{threshold:0,container:b})},"in-viewport":function(c){return!a.inviewport(c,{threshold:0,container:b})},"above-the-fold":function(c){return!a.belowthefold(c,{threshold:0,container:b})},"right-of-fold":function(c){return a.rightoffold(c,{threshold:0,container:b})},"left-of-fold":function(c){return!a.rightoffold(c,{threshold:0,container:b})}})})(jQuery,window);
function getBrowser() {
	var browser = {msie : false,firefox : false,opera : false,safari : false,chrome : false,netscape : false,appname : '未知',version : ''},
	userAgent = window.navigator.userAgent.toLowerCase();
	if (/(msie|firefox|opera|chrome|netscape)\D+(\d[\d.]*)/.test(userAgent)) {
		browser[RegExp.$1] = true;
		browser.appname = RegExp.$1;
		browser.version = RegExp.$2;
	} else if (/version\D+(\d[\d.]*).*safari/.test(userAgent)) {
		browser.safari = true;
		browser.appname = 'safari';
		browser.version = RegExp.$2;
	}
	return browser;
}
window.ppAjax = {
	alert : function (data) {
		window.ppData = data = toJson(data);
		if (window.ppExit)
			return;
	},
	submit : function (selector, callback) {
		$(selector).submit(function () {
			ppAjax.post($(this).attr("action"), $(this).serialize(), callback);
			return false;
		});
	},
	post : function (url, param, callback) {
		$.ajax({
			type : "POST",
			cache : false,
			url : url,
			data : param,
			success : callback,
			error : function (html) {
				layer.alert("提交数据失败，代码:" + html.status + "，请稍候再试", {icon : 0,shade : 0.6});
			}
		});
	}
};
function toJson(data) {
	var json = {};
	try {
		json = eval("(" + data + ")");
		if (json.kp_error) {
			ppAjax.debug(json);
			window.ppExit = true;
		} else {
			window.ppExit = false;
		}
	} catch (e) {
		alert(data);
	}
	return json;
}
//jQuery的cookie扩展
$.cookie = function (name, value, options) {
	if (typeof value != 'undefined') {
		options = options || {};
		if (value === null) {
			value = '';
			options.expires = -1;
		}
		var expires = '';
		if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
				date = new Date();
				date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
			} else {
				date = options.expires;
			}
			expires = '; expires=' + date.toUTCString();
		}
		var path = options.path ? '; path=' + options.path : '';
		var domain = options.domain ? '; domain=' + options.domain : '';
		var secure = options.secure ? '; secure' : '';
		document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	} else {
		var cookieValue = null;
		if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = jQuery.trim(cookies[i]);
				if (cookie.substring(0, name.length + 1) == (name + '=')) {
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}
};
function blink(selector){
	$(selector).fadeOut('slow', function(){
		$(this).fadeIn('fast', function(){
			blink(this);
		});
	});
}

//购物车部分
function add_cart(id,uid,sid,type){
	var load = layer.load();
	if(uid == _uid){
		layer.msg('不能购买自己的商品！');
		layer.close(load);
		return false;
	}
	ppAjax.post(webdir + "index.php?u=cart-add-ajax-1", {"id":id,"sid":sid,"num":1}, function(data){
		ppAjax.alert(data);
		if(window.ppData.err==0){
			if(type>0){
				window.location.href = webdir + "index.php?u=cart-index";
			}else{
				layer.alert(window.ppData.msg, {btn : ["立即去结算","稍候结算"]},function(){window.location.href= webdir + "index.php?u=cart-index";});
			}
		}else{
			layer.msg(window.ppData.msg);
		}
		layer.close(load);
	});
}
function del_cart(id,sid){
	var load = layer.load();
	ppAjax.post(webdir + "index.php?u=cart-del-ajax-1", {"id":id}, function(data){
		ppAjax.alert(data);
		if(window.ppData.err==0){
			layer.msg(window.ppData.msg);
			$('#li_' + id).remove();
			var len = $("#shop_" + sid + " .items").length;
			if(len == 0){
				$("#shop_" + sid).remove();
			}
			load_total();
		}else{
			layer.msg(window.ppData.msg);
		}
		layer.close(load);
	});
}
function show_jifen_form(id,dprice){
	var _totaljifen = 0 , user_jifen = $('#top_gold').text() - 0 - $("#_jifen_total").val(),num = $("#num_" + id).val();
	if(user_jifen >= dprice * jf_rate*num){
		_totaljifen = dprice*jf_rate*num ;
	}else{
		_totaljifen	= parseInt(user_jifen/jf_rate)*jf_rate ;
	}
	var _content = '\
		<div class="input-group">\
			<span class="input-group-addon">使用</span>\
			<input id="_jifen" value="'+_totaljifen+'" class="form-control" type="text" onchange="change_cart_jifen('+_totaljifen+');" autocomplete="off">\
			<span class="input-group-addon">'+jf_name+'可抵 <strong id="_jifen_notice" class="text-danger">'+(_totaljifen/jf_rate)+'</strong> 元</span>\
			<span class="input-group-btn"><a href="javascript:;" class="btn btn-info save_cid" onclick="save_cart_jifen('+id+');">保存</a></span>\
			<span class="input-group-btn"><a href="javascript:;" class="btn btn-link" onclick="layer.closeAll(\'tips\');"><i class="icon-cancel-circle"></i></a> </span>\
		</div>\
	';
	var tips = layer.tips(_content, '#jfbtn_' + id,{tips:[1, '#ddd'],time:0,area:'380px',shade: 0.35});
}
function change_cart_jifen(max){
	var _jifen = $('#_jifen').val();
	var _jifen_m = _jifen/jf_rate;
	if(parseInt(_jifen_m)!==_jifen_m){
		layer.msg('必须填写'+jf_rate+'的倍数！',function(){});
		$('#_jifen').val('0');
		return false;
	}
	if(_jifen > max){
		_jifen = max ;
		_jifen_m = max/jf_rate;
		$('#_jifen').val(_jifen);
	}
	$('#_jifen_notice').text(_jifen_m);
}
function save_cart_jifen(id){
	var _jifen = $('#_jifen').val(),_jifen_m = $('#_jifen_notice').text();
	$('#jifen_'+id).val(_jifen);
	if(_jifen > 0){
		$('#jfbtn_'+id).text('使用'+_jifen+jf_name+'抵价'+_jifen_m+'元');
	}else{
		$("#jfbtn_" + id).text(jfbtn_text);
	}
	load_total();
	layer.closeAll('tips');
}
function move_fav(id,pid){
	var load = layer.load();
	ppAjax.post(webdir + "index.php?u=fav-cart_to_fav-ajax-1", {"id":id,"pid":pid}, function(data){
		layer.close(load);
		ppAjax.alert(data);
		if(window.ppData.err==0){
			$("#li_" + id).remove();
			load_total();
		}else{
			layer.msg(window.ppData.msg);
		}
	});
}
function post_buy(id,pid,i){
	var err = 0 ;
	$.ajax({
		type	: "POST",
		cache	: false,
		url		: webdir + "member/index.php?book-cart_add",
		data	: {"id" : id,"pid" : pid, "num" : $("#num_" + id).val(), "use_jifen" : $("#jifen_" + id).val(),"first" : i},
		async	: false,
		success	: function(data){
			ppAjax.alert(data);
			if(window.ppData.err==0){
				$("#li_" + id).addClass('success');
				load_total();
			}else{
				$("#li_" + id).addClass('danger');
				err  = 1;
			}
		}
	});
	return err;
}
//购物车结束

function add_fav(id,sid){
	ppAjax.post(webdir + "index.php?u=fav-add-ajax-1", {"id":id,"sid":sid}, function(data){
		ppAjax.alert(data);
		if(window.ppData.err==0){
			layer.msg(window.ppData.msg);
		}else{
			layer.msg(window.ppData.msg);
		}
	});
}
function del_fav(id,sid){
	ppAjax.post(webdir + "index.php?u=fav-del-ajax-1", {"id":id,"sid":sid}, function(data){
		ppAjax.alert(data);
		if(window.ppData.err==0){
			layer.msg(window.ppData.msg);
			$('#li_' + id).remove();
			$('#li_' + sid).remove();
		}else{
			layer.msg(window.ppData.msg);
		}
	});
}
function change_jifen(max,price){
	var _jifen = $('#_jifen').val();
	var _jifen_m = _jifen/jf_rate;
	if(parseInt(_jifen_m)!==_jifen_m){
		$('#_sorry').text('必须填写'+jf_rate+'的倍数！');
		$('#_jifen').val('0');
		return false;
	}else{
		$('#_sorry').text('');
	}
	if(_jifen > max){
		_jifen = max ;
		_jifen_m = max/jf_rate;
		$('#_jifen').val(_jifen);
	}
	var _money = $('#book_price').val() * 1 - _jifen_m;
	if(_money > price){
		$('#_sorry').text('现金不足！');
	}else{
		$('#_sorry').text('');
	}
	$('#_xianjin').val(_money);
	$('#_jifen_notice').text(_jifen_m);
}
function list_cron(){
	$.getScript(webdir+"index.php?u=cron-flag-id-2-ajax-1", function(){});
}
function home_cron(){
	$.getScript(webdir+"index.php?u=cron-flag-id-1-ajax-1", function(){});
	$.getScript(webdir+"index.php?u=cron-refresh_total-ajax-1", function(){});
}
function qiandao(){
	ppAjax.post(memurl + "/index.php?u=index-qiandao-ajax-1", {'rnum':Math.random()}, function(data){
		//ppAjax.alert(data);
		var res = toJson(data);
		if(res.err==0){
			layer.tips('签到成功！奖励<b>'+res.msg+'</b>'+jf_name+'<br/>连续签到奖励更多', '#qiandao', {tips: [1, '#00AA88']});
			var totalgold = parseInt($('#top_gold').text()) +  parseInt(res.msg);
			$('#top_gold').text(totalgold);
			$('#qd_str').text('已签到');
		}else{
			layer.tips(res.msg, '#qiandao', {tips: [1, '#00AA88']});
		}
	});
}
function load_comment(){
	var obj = $("#load_more");
	var next_url = obj.attr("next_url");
	var isnext = obj.attr("isnext");
	var no_more = function() {
		obj.html("没有了...").addClass('disabled');
		if(typeof load_more != "undefined") obj.off("click", load_more);
		if(typeof auto_load_more != "undefined") $(window).off("scroll", auto_load_more);
	}
	if(isnext < 1) { no_more(); return; }
	var ppJosnLock = false;
	var load_more = function() {
		if(!next_url || ppJosnLock) return;
		obj.html("加载中...");
		var com_load = layer.load();
		ppJosnLock = true;
		$.getJSON(next_url, function(res) {
			if(res.err == 0){
				try{
					//var json = eval("("+res+")");
					var json = res;
					next_url = json.next_url;
					var s = "";
					$.each(json.list_arr, function(i,item){
						s += '<li class="media">';
						s += '<a class="media-left" href="javascript:;"><img src="'+item.avatar+'" alt="'+item.author+'"></a>';
						s += '\
								<div class="media-body">\
									<p class="media-heading"><span class="text-info">'+item.author+'</span><small class="text-muted">['+item.ip+']</small> '+item.rates+' <small class="pull-right text-muted hidden-xs">'+item.date+'</small></p>\
									<p class="text-muted small">'+item.content+'</p>\
								</div>\
						';
						s += '</div>';
						//$("#more_div").before(s);
					});
					$("#comments_list").html(s);
					$('html, body').animate({
						scrollTop: $("#comments").offset().top
					}, 300);
					obj.html("下一页");
					layer.close(com_load);
					ppJosnLock = false;
					if(json.isnext < 1) no_more();
				}catch(e){
					layer.close(com_load);
				}
			}else{
				layer.msg(res.msg);
				layer.close(com_load);
			}
		});
	}
	obj.click(load_more);
}

function send_buy(){
	var user_price = $('#user_price').val(),totalprice = $('#book_price').val() * 1 , dprice = $('#book_dprice').val() * 1, user_jifen = $('#user_jifen').val() * 1;

	var _totaljifen = 0 ;
	if(user_jifen >= dprice*jf_rate){
		_totalprice = totalprice - dprice ;
		_totaljifen = dprice*jf_rate ;
	}else{
		_totaljifen	= parseInt(user_jifen/jf_rate)*jf_rate ;
		_totalprice = totalprice - parseInt(user_jifen/jf_rate);
	}
	var lay_content = "<p class='alert text-danger'>余额不足！<br/>您的现金余额："+user_price+"元<br/>";
	if(_totaljifen > 0){
		lay_content += "您的"+jf_name+"余额："+user_jifen+"，最多可抵 "+_totaljifen/jf_rate+" 元<br/>";
	}
	if((_totalprice*1 > user_price*1)){
		layer.open({
			type: 1,
			title: ['友情提醒', 'font-weight:bold;color:green'],
			btn: ['去充值', '取消'],
			yes: function(index, layero){
				window.location.href	= memurl + '/index.php?u=record-order-price-' + (_totalprice-user_price);
			},cancel: function(index){
			},
			shadeClose: true,
			content: lay_content + "您至少需充值："+(_totalprice-user_price)+"元</p>"
		});
		return false;
	}else{
		if(dprice > 0){
			var _content = '\
				<div class="input-group mt10">\
					<span class="input-group-addon">支付现金</span>\
					<input id="_xianjin" value="'+_totalprice+'" class="form-control" type="text" readonly>\
					<span class="input-group-addon">元</span>\
				</div>\
				<div class="input-group mt10">\
					<span class="input-group-addon">使用'+jf_name+'</span>\
					<input id="_jifen" value="'+_totaljifen+'" class="form-control" type="text" onchange="change_jifen('+_totaljifen+','+user_price+');">\
					<span class="input-group-addon">可抵价<strong id="_jifen_notice" class="text-info">'+(_totaljifen/jf_rate)+'</strong>元</span>\
				</div>\
				<p class="mt10">当前'+item_name+'最多可使用<span class="text-red">'+dprice*jf_rate+jf_name+'抵价'+dprice+'元</span><br/>您当前现金为：'+user_price+'元，'+jf_name+'为：'+user_jifen+'</p>\
			';
		}else{
			var _content = '确认后将扣除' + totalprice + '元';
		}
		_content += '\
			<div class="input-group mt10">\
				<span class="input-group-addon text-red">支付密码</span>\
				<input id="_pinpass" value="" class="form-control" type="password">\
			</div>\
		';
		if(!_pin){
			_content += '<p class="alert alert-waring"><a class="text-red" href="'+memurl+'/index.php?u=index-profile#pinpass_d" target="_blank">尚未设置支付密码，立即去设置</a></p>';
		}
		_content += '<br/><span id="_sorry" class="text-red"></span>&nbsp;';
		layer.open({
			title: ['购买确认', 'font-weight:bold;color:green'],
			btn:['确认','取消'],
			yes:function(index,layero){
				var btn = layero.find('.layui-layer-btn'); //按钮组
				var body = layero.find('.layui-layer-content'); //内容区
				btn.hide();
				body.append("<br/>请稍候...若无响应请到<a class='text-info' href='"+memurl+"/index.php?u=book-index' target='_blank'>会员中心</a>查看！");
				$.ajax({
					type	: "POST",
					cache	: false,
					url		: $('#order_book').attr("action"),
					data	: {'pid':$('#book_pid').val(),'cid':$('#book_cid').val(),'use_jifen':$('#_jifen').val(),'pinpass':$('#_pinpass').val()},
					success	: function(data){
						ppAjax.alert(data);
						if(window.ppData.err==0){
							layer.msg('购买成功，请稍后，即将进入会员中心！', {icon: 1,time: 2000,shade: 0.6}, function(){window.location = memurl+'/index.php?u=book-index';});
						}else{
							layer.alert(window.ppData.msg, {icon: 5,shade: 0.6}) ;
						}
					},error : function(html){
						layer.alert("提交数据失败，代码:"+ html.status +"，请稍候再试", {icon: 0,shade: 0.6}) ;
					}
				});
			},cancel:function(index){
				layer.close(index);
			},
			shadeClose: false,
			content: _content
		});
	}
}
function lxfEndtime(){
	$(".time_remark_txt").each(function(){
		var endtime = $(this).attr("endTime");
		var nowtime = new Date().getTime(); 
		var youtime = endtime - nowtime;
		var seconds = youtime/1000;
		var minutes = Math.floor(seconds/60);
		var hours = Math.floor(minutes/60);
		var days = Math.floor(hours/24);
		var CDay= days ;
		var CHour= hours % 24;
		var CMinute= minutes % 60;
		var CSecond= Math.floor(seconds%60);
		if(endtime>nowtime){
			$(this).html("<i class='icon-clock'></i> "+CDay+"天"+CHour+"小时"+CMinute+"分"+CSecond+"秒"); 
		}
	});
	setTimeout("lxfEndtime()",1000);
}
var History = {
	'Json': '',
	'Display': true,
	'Clear': function() {
		$.cookie('NEWZHAN_history', null,{path:'/'});
		$('#errshow').html('<tr><td colspan="3" class="text-center text-red">浏览记录已被清空</td></tr>');
	},
	'List': function(){
		var jsondata = [];
		if (this.Json) {
			jsondata = this.Json;
		} else {
			var jsonstr = $.cookie('NEWZHAN_history');
			if (jsonstr != undefined) {
				jsondata = eval(jsonstr);
			}
		};
		html = '<table class="table table-hover small" id="data-table">';
		html += '<tr><th>标题</th><th>价格</th><th>'+jf_name+'抵价</th></tr>';
		html += '<tbody id="errshow">';
		if (jsondata.length > 0){
			for ($i = 0; $i < jsondata.length; $i++) {
				var d_price = jsondata[$i].d_price > 0 ? jsondata[$i].d_price : '-';
				html += '<tr><td><a href="' + jsondata[$i].url + '">' + jsondata[$i].title + '</a></td><td>' + jsondata[$i].price + '</td><td>' + d_price + '</td></tr>';
			}
		} else {
			html += '<tr><td colspan="3" class="text-center text-red">暂无浏览记录</td></tr>';
		};
		html += '</tbody>';
		html += '<tfoot>';
		html += '<tr><td colspan="3" class="text-right"><a onclick="History.Clear();" class="btn btn-danger btn-xs" href="javascript:void(0)"><i class=" icon-bin"></i> 清空所有记录</a></td></tr>';
		html += '</tfoot>';
		html += '</table>';
		layer.open({
			type: 1,
			title: ['浏览记录', 'font-weight:bold;color:green'],
			area:'600px',
			shadeClose: true,
			content: html,
			success: function(layero, index){
				//分页
			}
		});
	},
	//History.Insert(title, price, d_price, limit, days);
	'Insert': function(title, price, d_price, limit, days){
		var jsondata = $.cookie('NEWZHAN_history');
		var url 	= document.URL;
		//var url 	= window.location.href;
		if (jsondata != undefined) {
			this.Json = eval(jsondata);
			jsonstr = '{item:[{"title":"' + title + '","url":"' + url + '","price":"' + price + '","d_price":"' + d_price + '"},';
			for ($i = 0; $i <= limit; $i++){
				if (this.Json[$i]) {
					if (this.Json[$i].url != url) {
						jsonstr += '{"title":"' + this.Json[$i].title + '","url":"' + this.Json[$i].url + '","price":"' + this.Json[$i].price + '","d_price":"' + this.Json[$i].d_price + '"},';
					}
				} else {
					break;
				}
			};
			jsonstr = jsonstr.substring(0, jsonstr.lastIndexOf(','));
			jsonstr += "]}";
		} else {
			jsonstr = '{item:[{"title":"' + title + '","url":"' + url + '","price":"' + price + '","d_price":"' + d_price + '"}]}';
		};
		this.Json = eval(jsonstr);
		$.cookie('NEWZHAN_history', jsonstr,{path:'/',expires:days});
	}
}
function clear_cookie(){
	$("#list_checkbox :checkbox").each(function(){
		var _id = $(this).attr('id');
		$.cookie(_id, null,{path:'/'});
	});
	$("a.extlink").each(function(){
		var _id = $(this).attr('_cook') ;
		$.cookie(_id, null,{path:'/'});
	});
	$.cookie('order', null,{path:'/'});
}
function search(type){
	clear_cookie();
	var keyword = $("#search_keyword").val() , mid = $("#search_mid").val(), sid = $("#search_sid").val();
	if (!keyword) {
		layer.tips('搜索词不能为空！', '#search_keyword',{tips: 3});
		return false;
	}
	if(type == 0 && sid){
		$.cookie('search_sid', sid,{path:'/'});
	}else{
		$.cookie('search_sid', null,{path:'/'});
	}
	//$("#search_form").submit();
	_surl = search_url.replace(/\{mid\}/,mid);
	_surl = _surl.replace(/%7Bkeyword%7D/,keyword);
	window.location.href = _surl;
	return false;
}
$(document).ready(function () {
	$('#search_all').click(function(){
		search(1);
	});
	$('#search_shop').click(function(){
		search(0);
	});
	$("a.btn-diy").hover(function(){
		var str = $(this).attr("_title");
		var color = $(this).attr("color");
		var that = this;
		layer.tips(str, that, {tips: [1, color]});
	},function(){
		layer.closeAll('tips');
	});
	$(".item_list .panel").hover(function(){
		$(this).addClass('panel_hover');
		var _text = $(this).find('.good_remark_txt').text().trim();
		if(_text.length > 0){
			$(this).find('.good_remark').slideDown('fast');
		}
	},function(){
		$(this).removeClass('panel_hover');
		$(this).find('.good_remark').slideUp('fast');
	});
	$('#artbody img').addClass('img-responsive center-block');
	$('#navbar a').click(function(){
		clear_cookie();
	});
	$('#orderby a').click(function(){
		$.cookie('order', $(this).attr('data'),{path:'/'});
		window.location.reload();
	});
	$('#comments_order input').click(function(){
		layer.load();
		$.cookie('comment_order', $(this).val());
		window.location.reload();
	});
	$('#list_check').click(function(){
		$("#list_checkbox :checkbox").each(function(){
			var _id = $(this).attr('id');
			var _checked = $('#' + _id)[0].checked;
			$.cookie(_id, _checked ? 1 : 0,{path:'/'});
		});
		window.location.reload();
	});
	$('#list_check_del').click(function(){
		$("#list_checkbox :checkbox").each(function(){
			var _id = $(this).attr('id');
			$.cookie(_id, null,{path:'/'});
		});
		window.location.reload();
	});
	$('#sorderby a').click(function(){
		$.cookie('sorder', $(this).attr('data'),{path:'/'});
		window.location.reload();
	});
	$('#qiandao').click(function(){
		qiandao();
	});
	$('a.extlink').click(function(){
		var name = $(this).attr('_cook') ;
		$.cookie(name, $(this).attr('_data'),{path:'/'});
		window.location.reload();
	});
	$('a.extlink2').click(function(){
		var name 	= $(this).attr('_cook') ;
		var url 	= $('#exts').attr('_url') ;
		$.cookie(name, $(this).attr('_data'),{path:'/'});
		window.location.href = url;
	});
    $("img[data-original]").lazyload({effect:"fadeIn"});
	$('li.dropdown').mouseover(function() {   
		 $(this).addClass('open');
	}).mouseout(function() {
		$(this).removeClass('open');
	});
	$(".dropdown-toggle").click(function(){
		if($(this).attr('href')) window.location = $(this).attr('href');
	});
	// 页面浮动面板
	$("#totop").click(function(){
		$("html,body").animate({scrollTop :0},500);
		return false;
	});
	//pm_count
	if(_uid && _uid> 0){
		$.getScript(webdir + "index.php?u=pm-index", function(){
			if(pm_count){
				$("#top_newpm").html('<a href="'+memurl+'/index.php?u=pm-index" onMouseOver="layer.tips(\'有'+pm_count+'条新消息\',this);" class="blink"><i class="icon-commenting"></i></a>');blink('.blink');
			}
		});
	}
	blink('.blink');
	$("#top_qrcode").click(function(){
		layer.open({type: 4,content: ['<div style="padding:30px;text-align:center;"><img src=\''+weburl+'static/img/qrcode.png\'><br/><span class="text-danger mb0"><span class="f24">扫一扫</span><br>或在手机浏览器直接输入本站网址</span></div>', '#top_qrcode'],tips: [1, '#fff'],closeBtn: 0,shadeClose:true});
	})
});