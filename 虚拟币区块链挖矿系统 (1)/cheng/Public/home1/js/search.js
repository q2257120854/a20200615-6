//左侧分类导航
$('#category_container').hover(function(){
	$(this).addClass('mod_cate_on');
},function(){
	$(this).removeClass('mod_cate_on');
});

$('div[name=left_cate]').on('click',function(){
	if ($(this).attr('mtag') == 'active') {
		$(this).toggleClass('cate_item_on');
	}else{
		$(this).toggleClass('cate_item_open');
	}	
});
$("a[name='active']").parent().parent().addClass('cate_item_on');
$("a[name='active']").parent().parent().attr('mtag','active');

//更多按钮
$('.filter_act span').click(function(){
	if ($(this).parent().attr('class') == 'filter_showmore') {
		$(this).html('收起');
		$(this).parent().attr('class','filter_showless');
		if ($(this).parent().parent().parent().attr('name') == 'goodsbrand') {
			$(this).parent().parent().parent().removeClass('filter_item_brand');
			$(this).parent().parent().parent().addClass('filter_item_atoz');
			$('.filter_atoz').removeClass('hide');
		}else{
			$(this).parent().parent().parent().removeClass('filter_item_single');
			$(this).parent().parent().parent().addClass('filter_item_multiple');
		}
	}else{
		$(this).html('更多');
		$(this).parent().attr('class','filter_showmore');
		if ($(this).parent().parent().parent().attr('name') == 'goodsbrand') {
			$(this).parent().parent().parent().removeClass('filter_item_atoz');
			$(this).parent().parent().parent().addClass('filter_item_brand');
			$('.filter_atoz').addClass('hide');
		}else{
			$(this).parent().parent().parent().removeClass('filter_item_multiple');
			$(this).parent().parent().parent().addClass('filter_item_single');			
		}
	}
});

//品牌A-Z
var hoverTimer;
$('.filter_atoz_item').hover(function(){
	clearTimeout(hoverTimer);
	var current = $(this);
	hoverTimer = setTimeout(function(){
		current.siblings().removeClass('filter_atoz_current');
		current.addClass('filter_atoz_current');
		var chars = current.html();
		if (chars == '<b>全部</b>') {
			$('#brand_dl .filter_dt').removeClass('hide');
			$('#brand_dl .filter_dd').removeClass('hide');
		}else{
			$('#brand_dl .filter_dt').addClass('hide');
			$('#brand_dl .filter_dd').addClass('hide');
			$('#brand_dl .filter_dd').each(function(){
				if ($(this).attr('bindex') == chars) {
					$(this).removeClass('hide');
				};
			});
		}
	}, 500);
},function(){
	clearTimeout(hoverTimer);
});

//选中属性
var bid = $('[name=bid]:input').val();
$('.filter_dd').each(function(){
		if ($(this).attr('brandvalue') == bid) {
			$(this).siblings().eq(0).removeClass('filter_dt_on');
			$(this).addClass('filter_dd_on');
		};
});

//滑动下拉选项卡
$('.filter_attr').hover(function(){
	$(this).addClass('filter_attr_on');
},function(){
	$(this).removeClass('filter_attr_on');
});

//默认属性
var attr = new Array();
for (var i=0; i< $('[id^=attr_]').length; i++) {
		attr[i] = 0;
	}
if ($('[name=attr]:input').val()) {
	attr = $('[name=attr]:input').val().split('-');
	for (var i = 0; i<attr.length; i++) {
		$('#attr_'+i+' .filter_dd').each(function(){
			if ($(this).attr('attrvalue') == attr[i]) {
				$(this).siblings().eq(0).removeClass('filter_dt_on');
				$(this).addClass('filter_dd_on');
			};
		});
		$('#attr_'+i+'>div>div>a').each(function(){
			if ($(this).attr('attrvalue') == attr[i]) {
				$(this).siblings().eq(0).removeClass('filter_attr_item_on');
				$(this).addClass('filter_attr_item_on');
			};
		});
	}
}

//属性选中
$('.filter_dl a').click(function(){
	if ($(this).attr('nametag') == 'attr') {
		var currattr = $(this).parent().parent().parent().attr('id').split('_')[1];
		var attrvalue = $(this).parent().attr('attrvalue');
		if (attrvalue>0) {
			attr[currattr] = attrvalue;
		}else{
			attr[currattr] = 0;
		}
		$('[name=attr]:input').val(attr.join('-'));
	}else if ($(this).attr('nametag') == 'attrsel') {
		var currattr = $(this).parent().parent().parent().attr('id').split('_')[1];
		var attrvalue = $(this).attr('attrvalue');
		if (attrvalue > 0) {
			attr[currattr] = attrvalue;
		}else{
			attr[currattr] = 0;
		}
		$('[name=attr]:input').val(attr.join('-'));
	}else if($(this).attr('nametag') == 'brand'){
		var brandvalue = $(this).parent().attr('brandvalue');
		if (brandvalue > 0) {
			var bid = brandvalue;
		}else{
			var bid = 0;
		}
		$('[name=bid]:input').val(bid);
	}else if($(this).attr('nametag') == 'viewattr'){
		return;
	}
	$('form[name=searchattr]').submit();
});

//筛选排序
var sort = $('[name=sort]:input').val();
$('a[nametag=sort]').removeClass('sort_cate_on');
if (sort == 4) {
	$('a[sortbtntype=3_4]').addClass("sort_cate_on");
	$('a[sortbtntype=3_4]').children().eq(1).addClass("sort_arrow_desc");
}else if(sort == 3){
	$('a[sortbtntype=3_4]').addClass("sort_cate_on");
	$('a[sortbtntype=3_4]').children().eq(1).addClass("sort_arrow_asc");
}else if(sort == 2){
	$('a[sortbtntype=2]').addClass("sort_cate_on");
}else if(sort == 1){
	$('a[sortbtntype=1]').addClass("sort_cate_on");
}else{
	$('a[sortbtntype=0]').addClass("sort_cate_on");
}

$('.sort_cate a').live('click',function(){
	var sortvalue = $(this).attr('sortbtntype');
	if (sortvalue == '3_4') {
		if ($('b[class*="sort_arrow_asc"]').length>0) {
			var sort = 4;
		}else{
			var sort = 3;
		}
	}else{
		var sort = sortvalue;
	}
	$('[name=sort]:input').val(sort);
	$('form[name=searchattr]').submit();
});

//价格筛选
if ($('[name=price]:input').val().length>0) {
	var price = $('[name=price]:input').val().split('-');
	var beginPrice = price[0].length>0?price[0]:'最低价';
	var endPrice = price[1].length>0?price[1]:'最高价';
	$('#sBeginPrice').val(beginPrice);
	$('#sEndPrice').val(endPrice);
};

$('.sort_price').hover(function(){
	$(this).addClass('sort_price_2');
},function(){
	$(this).removeClass('sort_price_2');
	$('#sPriceHover').children().attr('style','');
});

$('.sort_price_input').focus(function(){
	if ($(this).val() == '最低价' || $(this).val() == '最高价') {
		$(this).val('');
	};
});

//价格选择
$('#sConfirmPrice').click(function(){
	beginPrice = $('#sBeginPrice').val();
	endPrice = $('#sEndPrice').val();
	if (beginPrice == '最低价' || beginPrice == '' || isNaN(beginPrice)) {
		$('#sBeginPrice').css('border','1px solid red');
		return;
	};
	if (endPrice == '最高价' || endPrice == '' || isNaN(endPrice)) {
		$('#sEndPrice').css('border','1px solid red');
		return;
	};
	if (parseInt(endPrice) < parseInt(beginPrice)) {
		$('#sEndPrice').css('border','1px solid red');
		return;
	};
	$('[name=price]:input').val(beginPrice+'-'+endPrice);
	$('form[name=searchattr]').submit();
});

$('#sPriceRange a').click(function(){
	var price = $(this).text();
	if (price == '4000以上') {
		price = '4000-+';
	}
	$('[name=price]:input').val(price);
	$('form[name=searchattr]').submit();
});

//仅显示有货
if ($('[name=stockfilter]:input').val() == '1') {
	$('#stockFilterChk').addClass('sort_type_radio_on');
};
$('#stockFilterChk').click(function(){
	if ($('[name=stockfilter]:input').val() == '1') {
		var stock = 0;
	}else{
		var stock = 1;
	}
	$('[name=stockfilter]:input').val(stock);
	$('form[name=searchattr]').submit();
});

//仅显示有货
if ($('[name=style]:input').val() == '1') {
	$('.sort_style a').eq(0).removeClass('sort_style_lk_on');
	$('.sort_style a').eq(1).addClass('sort_style_lk_on');
	$('.goods').addClass('goods2');
}

$('.sort_style a').click(function(){
	var style = $(this).attr('showbtntype');
	$('[name=style]:input').val(style);
	$('form[name=searchattr]').submit();
});

//商品列表
$('#itemList li').hover(function(){
	$(this).addClass('goods_li_hover');
},function(){
	$(this).removeClass('goods_li_hover');
});

//删除属性
$('.crumb_selected').click(function(){
	if($(this).attr('keyname') == 'brand'){
		$('[name=bid]:input').val('');
	}else if($(this).attr('keyname') == 'attr'){
		var attrkey = $(this).attr('attrkey');
		var elements = '[attrvalue='+attrkey+']';
		if ($(elements).parent().parent().attr('id')) {
			var id = $(elements).parent().parent().attr('id').split('_')[1];
		}else{
			var id = $(elements).parent().parent().parent().attr('id').split('_')[1];
		}
		attr[id] = 0;
		$('[name=attr]:input').val(attr.join('-'));
	}
	$('form[name=searchattr]').submit();
});


//当前条件下搜索
var search = $('#crumbKey').val();
$('.crumb_search').hover(function(){
	$(this).addClass('crumb_search_1');
},function(){
	$(this).removeClass('crumb_search_1');
	$('#crumbKey').val(search);
});
$('#crumbKey').focus(function(){
	if ($(this).val() == '在当前条件下搜索') {
		$(this).val('');
	};
});
$('#crumbKey').blur(function(){
	if ($(this).val() == ''){
		$(this).val('在当前条件下搜索');
	}
});

$('#crumbSearchKey').click(function(){
	var searchval = $('#crumbKey').val();
	if (searchval == '在当前条件下搜索' || searchval == '') {
		return;
	}
	$('[name=searchval]:input').val(searchval);
	$('form[name=searchattr]').submit();
});

//分页
$('.mod_page_lk').click(function(){
	var page = $(this).attr('pages');
	$('[name=page]:input').val(page);
	$('form[name=searchattr]').submit();
});
$('.mod_page_go').click(function(){
	var page = $('#pageinput').val();
	$('[name=page]:input').val(page);
	$('form[name=searchattr]').submit();
});

//显示更多
var brandlen = 0;
$('#brand_dl dd a').each(function(){
	brandlen += $(this).text().length;
});

if (brandlen > 100) {
	$('#brand_dl').parent().next().removeClass('hide');
};

$('div[id^=attr_]').each(function(){
	var attrlen = 0;
	var child = $(this).children().children();
	var attrs = child.length;
	for (var i = 1; i<attrs; i++) {
		attrlen += parseInt(child.eq(i).children().text().length);
	}
	if (attrlen > 50) {
		$(this).next().removeClass('hide');
	};
});

// 添加购物车
$('.goods_buy').on('click',function(e){
	var price = $(this).attr('ptag');
	var gid = $(this).attr('idtag');
	ajaxhandle(price,gid);
	var x = e.pageX;
	var y = e.pageY;
	$('.mod_carttip').removeClass('hide');
	$('.mod_carttip').css('left',x-60);
	$('.mod_carttip').css('top',y-120);
});
function ajaxhandle(price,gid){
	var nums = 1;
	$.ajax({
		url:APP+"/Home/Goods/showCart",
		type:"post",
		data:{gid:gid,nums:nums,price:price},
		// 执行成功执行以下函数，返回值为data
		success:function(data){
			if (data == 1) {
				viewCartNums();
			}
		}
	});
}

//加入购物车提示信息
$('.mod_carttip_close').on('click',function(){
	$('.mod_carttip').addClass('hide');
})