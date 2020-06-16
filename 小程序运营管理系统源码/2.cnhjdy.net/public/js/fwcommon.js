$(function() {
	var code = $('.symbol-page').data('code')
	switch (code) {
		case 'index':
			$('.xiaochengxu-header .index-link').addClass("active").siblings('.nav-item').removeClass("active");
			$('.xiaochengxu-header .index-link .link').removeClass("linkActive").addClass("linkWhite").parent('.nav-item').find(".link").removeClass("linkWhite");
			break;
		case 'mendian':
			$('.xiaochengxu-header .mendian-link').addClass("active").siblings('.nav-item').removeClass("active");
			$('.xiaochengxu-header .mendian-link .link').removeClass("linkActive").addClass("linkWhite").parent('.nav-item').find(".link").removeClass("linkWhite");
			break;
		case 'shangcheng':
			$('.xiaochengxu-header .shangcheng-link').addClass("active").siblings('.nav-item').removeClass("active");
			$('.xiaochengxu-header .shangcheng-link .link').removeClass("linkActive").addClass("linkWhite").parent('.nav-item').find(".link").removeClass("linkWhite");
			break;
		default:
			$('.xiaochengxu-header .index-link').addClass("active").siblings('.nav-item').removeClass("active");
			$('.xiaochengxu-header .index-link .link').removeClass("linkActive").addClass("linkWhite").parent('.nav-item').find(".link").removeClass("linkWhite");
			break;
	}
	$('.xiaochengxu-header .nav-list .link').hover(
		function() {
			var parent = $(this).parent().attr("class");
			var arr=parent.split(" ");
			for (var i = arr.length - 1; i >= 0; i--) {
				if (arr[i] == "active") {
					break;
				}else {
					$(this).addClass('linkActive')
				}
			}
		},
		function() {
			$(this).removeClass('linkActive')
		}
	)
})