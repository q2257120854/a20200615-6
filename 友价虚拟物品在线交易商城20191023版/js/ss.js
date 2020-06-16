if ($("#js_ads_banner_top_slide").length){  //判断当前广告是否展开，如果没有，则执行下面代码 
  var $slidebannertop = $("#js_ads_banner_top_slide"),$bannertop = $("#js_ads_banner_top"); 
  setTimeout(function(){$bannertop.slideUp(1000);$slidebannertop.slideDown(1000);},2500); //2500毫秒(2.5秒)后，小广告收回，大广告伸开，执行时间都是1秒(1000毫秒) 
  setTimeout(function(){$slidebannertop.slideUp(1000,function (){$bannertop.slideDown(1000);});},6500); //小广告展开。 
}