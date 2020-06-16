$(document).ready(function(){
	var windowh = $(window).outerHeight();
	var windoww = $(window).outerWidth();
	$('.login_bg').css('height',windowh);
	$('.nav_side').css('height',windowh);
	$('.head').css('width',windoww-80);
	$('.alertbox').css('height',windowh);
})
$(window).resize(function(){
	var windowh = $(window).outerHeight();
	var windoww = $(window).outerWidth();
	$('.login_bg').css('height',windowh);
	$('.nav_side').css('height',windowh);
	$('.head').css('width',windoww-80);
	$('.alertbox').css('height',windowh);
})
