$(document).ready(function(){
	var windowheight = $(document).height();
	$('.alertbox').css('height',windowheight)
	
})
$(document).resize(function(){
	var windowheight = $(document).height();
	$('.alertbox').css('height',windowheight)
})
