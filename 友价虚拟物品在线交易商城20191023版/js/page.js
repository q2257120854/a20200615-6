
$(document).ready(function() {

	$(window).scroll(function() {
		if (jQuery(this).scrollTop() > 1) {
			$(".header").addClass("header_scroll");
		} else {
			$(".header").removeClass("header_scroll");
		}
	});
	$(".aside ul li.consulting").click(function() {
		$(".aside ul li.consulting").addClass("active");
		$(".consulting_box").css("right", "40px");
	});
	$(".consulting_box .close").click(function() {
		$(".aside ul li.consulting").removeClass("active");
		$(".consulting_box").css("right", "-250px");
	});
	$(".header .mobileMenuBtn").click(function() {
		$(".header .mobileMenuBtn").toggleClass("active");
		$(".header .header_menu").toggleClass("active");
		$(".header .mobileMenuBtn_shad").toggleClass("active");
	});
	$(".header .mobileMenuBtn_shad").click(function() {
		$(".header .mobileMenuBtn").toggleClass("active");
		$(".header .header_menu").toggleClass("active");
		$(".header .mobileMenuBtn_shad").toggleClass("active");
	});
	var w_width = $(window).width();
	if (w_width < 767) {
		$(".technical_support_type .title").click(function() {
			$(".technical_support_type ul").slideToggle();
			$(".technical_support_type .title span").toggleClass("active");
		});
	} else {

	}

    /*·µ»Ø¶¥²¿*/
	$("body").append('<div id="toTop">Top</div>');
	$("body").append('<div id="close"></div>');
	$("body").append('<div id="show"></div>');

	var toTop = $('#toTop');

	toTop.on("click", function () {

	    $('body,html').animate({

	        scrollTop: 0

	    }, 500);

	});

	$(window).scroll(function () {

	    if (jQuery(this).scrollTop() < 100) {

	        toTop.css("bottom", "-100px");

	    } else {

	        toTop.css("z-index", 10000);

	        toTop.css("bottom", "60px");

	    }

	});

	var close = $("#close");
	close.on("click", function () {
	    $("#show").animate({
	        width: '40px'
	    }, 100);
	    $('.aside,#toTop,#close').animate({
	        width: 0
	    }, 100);
	})

	var show = $("#show");
	show.on("click", function () {
	    $("#show").animate({
	        width: '0px'
	    }, 100);
	    $('.aside,#toTop,#close').animate({
	        width: "40px"
	    }, 100);
	})
});


