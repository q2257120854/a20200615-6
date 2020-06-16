$(document).ready(function(){
	$('.bannerbox').slide({
		titCell: '.banner_hd li',
		mainCell: '.banner_bd',
		effect: 'left',
		autoPlay: true,
		titOnClassName: 'active',
	});

	$('.market_box').slide({
		titCell: '.market_hd li',
		mainCell: '.market_bd',
		effect: 'fade',
		autoPlay: false,
		titOnClassName: 'active',
	});
	$(".profitbox").slide({titCell:".profithd ul",mainCell:".profitbd",autoPage:true,effect:"left",autoPlay:false,vis:3});
	// $('.teambox').slide({titCell:'.teamhd ul',mainCell:'.teambd',effect:'left',autoPlay:true,autoPage:'<li></li>'});
	$('.environmentbox').slide({titCell:'.environmenthd ul',mainCell:'.environmentbd',effect:'left',autoPlay:true,autoPage:'<li></li>'});
	$('.fun_leftbox').slide({titCell:'.fun_left_hd ul',mainCell:'.fun_leftbd',effect:'left',autoPlay:true,autoPage:'<li></li>'});
	$('.solute_leftbox').slide({titCell:'.solute_left_hd ul',mainCell:'.solute_leftbd',effect:'left',autoPlay:true,autoPage:'<li></li>'});
	$('.swiper-container1').slide({
		titCell: '.swiper-containerhd1 li',
		mainCell: '.swiper-wrapper1',
		effect: 'left',
		autoPlay: false,
		titOnClassName: 'active',
		prevCell:'.prev1',
		nextCell:'.next1',
		autoPage:'<li></li>',
		 startFun:function(i,c){
		$('#textarea1').html(i+1)
		$('#total1').html(c)
    },
    endFun:function(i,c){
        $('#textarea1').html(i+1)
        $('#total1').html(c)
    }
	});
	$('.swiper-container2').slide({
		titCell: '.swiper-containerhd2 li',
		mainCell: '.swiper-wrapper2',
		effect: 'left',
		autoPlay: false,
		titOnClassName: 'active',
		prevCell:'.prev2',
		nextCell:'.next2',
		autoPage:'<li></li>',
		 startFun:function(i,c){
		$('#textarea2').html(i+1)
		$('#total2').html(c)
    },
    endFun:function(i,c){
        $('#textarea2').html(i+1)
        $('#total2').html(c)
    }
	});
	$('.swiper-container3').slide({
		titCell: '.swiper-containerhd3 li',
		mainCell: '.swiper-wrapper3',
		effect: 'left',
		autoPlay: false,
		titOnClassName: 'active',
		prevCell:'.prev3',
		nextCell:'.next3',
		autoPage:'<li></li>',
		 startFun:function(i,c){
		$('#textarea3').html(i+1)
		$('#total3').html(c)
    },
    endFun:function(i,c){
        $('#textarea3').html(i+1)
        $('#total3').html(c)
    }
	});
	$('.swiper-container4').slide({
		titCell: '.swiper-containerhd4 li',
		mainCell: '.swiper-wrapper4',
		effect: 'left',
		autoPlay: false,
		titOnClassName: 'active',
		prevCell:'.prev4',
		nextCell:'.next4',
		autoPage:'<li></li>',
		 startFun:function(i,c){
		$('#textarea4').html(i+1)
		$('#total4').html(c)
    },
    endFun:function(i,c){
        $('#textarea4').html(i+1)
        $('#total4').html(c)
    }
	});
	$('.newsbox').slide({
		titCell: '.news_left li',
		mainCell: '.news_right_box',
		effect: 'fade',
		autoPlay: false,
		titOnClassName: 'active',
		prevCell:'prev1',
		nextCell:'next1',
	});
	/* 使用js分组，每6个li放到一个ul里面 */
$(".teambox .teambd li").each(function(i){ $(".teambox .teambd li").slice(i*10,i*10+10).wrapAll("<ul></ul>");});
 
/* 调用SuperSlide，每次滚动一个ul，相当于每次滚动6个li */
$(".teambox").slide({titCell:".teamhd ul",mainCell:".teambd .team",autoPage:true,effect:"leftLoop",autoPlay:true});
})

function showewm(){
	$('.ewm').show();
}
function hideewm(){
	$('.ewm').hide()
}
