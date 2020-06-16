//幻灯片函数
function slider_all(imgs,dotes,ons,prev,next){
	var img = $(imgs);
	var dote = $(dotes);
	var slider_num = 0;
	var cut_sliders;
	function slider_run(){
		cut_sliders = setInterval(function(){						
			cut_show(slider_num,1);

			slider_num++;
			if (slider_num == img.siblings().length) {
				slider_num = 0;
			};

			cut_show(slider_num,0);
		},2000);
	}
	slider_run();
	img.parent().parent().mouseenter(function(e){
		e.cancleBable;
		clearInterval(cut_sliders);
		if (prev != '') {
			prev.removeClass('hide');
			next.removeClass('hide');
		}
	});
	img.parent().parent().mouseleave(function(e){
		e.cancleBable;
		slider_run();
		if (prev != '') {
			prev.addClass('hide');
			next.addClass('hide');
		}
	});

	if (prev != '') {
		var prev = $(prev);
		prev.click(function(){
			cut_show(slider_num,1);
			slider_num--;
			if (slider_num < 0) {
				slider_num = img.siblings().length-1;
			};
			cut_show(slider_num,0);
		});
	}

	if (next != '') {
		var next = $(next);
		next.click(function(){
			cut_show(slider_num,1);
			slider_num++;
			if (slider_num == img.siblings().length) {
				slider_num = 0;
			};
			cut_show(slider_num,0);
		});
	}

	dote.mouseenter(function(){
		cut_show(slider_num,1);
		slider_num = $(this).attr('index')-1;
		cut_show(slider_num,0);
	});

	function cut_show(num,type){
		if (type == 1) {
			img.eq(num).css('display','none');
			dote.eq(num).removeClass(ons);
		}else{
			img.eq(num).css('display','list-item');
			dote.eq(num).addClass(ons);
		}	
	}
}
slider_all('.slider_img li','#j_strigger li','on','#j_sprev','#j_snext');

$('div[ftag=floorsnum]').each(function(){
	var floor = $(this).attr('id');
	slider_all('#'+floor+' .sx_mod_glide_img li','#'+floor+' .sx_mod_glide_trigger>i','glide_on','','');
});

//幻灯片结束

//抢购时间
setInterval(function(){
	var date = new Date();
	var hour = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();
	var $hour = (minutes == 0 && seconds == 0)?24-hour:23-hour;
	var $minutes = seconds==0?60 - minutes:59 - minutes;
	var $seconds = 60 - seconds;
	function date_format(date){
		if (date<10) {
			return '0'+date;
		}else{
			return date;
		}
	}
	$('#j_daily_h').html(date_format($hour));
	$('#j_daily_m').html(date_format($minutes));
	$('#j_daily_s').html(date_format($seconds));
},1000);


//初始化首页选择卡
$('div[name=hotsale]').each(function(){
	var floor = $(this).attr('id').split('_')[1];
	var cid = $(this).children().eq(0).children().children().attr('id').split('_')[1];
	ajaxTab(cid,floor);
});

//首页选项卡
$('ul[name=hottabs] li').live('mouseenter',function(){
	$(this).siblings().removeClass('on');
	$(this).addClass('on');
	var cid = $(this).attr('id').split('_')[1];
	var floor = $(this).parent().parent().parent().attr('id').split('_')[1];
	$("#fhots_"+floor).children().attr('style','');
	if ($("#fhots_"+floor+" ul[id=viewtab_"+cid+"]").length > 0) {
		$("#fhots_"+floor+" ul[id=viewtab_"+cid+"]").attr('style',"opacity: 1; display: block;");
	}else{
		ajaxTab(cid,floor);
	}
});

//选项卡ajax函数
function ajaxTab(cid,floor){
	$.ajax({
		url:APP+"/Home/Index/floorTab",
		type:'post',
		data:{cid:cid},
		success:function(data){
			$("#fhots_"+floor).append(data);
		}
	});
}