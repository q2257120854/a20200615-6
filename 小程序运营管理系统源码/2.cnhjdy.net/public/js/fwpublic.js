
$(document).ready(function(){
    itemchange();
    $("#32").find(".a_top a").attr("href","javascript:void(0);");
    $("#35").find(".a_top a").attr("href","javascript:void(0);");
    //$(".main_adv_img ul li").find("img")
    $(".anli").find(".bich:first").css('border','none');
/*var txt1="<div class='blank85'></div>";  
$("body").prepend(txt1);*/
    $("#pubCallButton a").mouseover(function(){
    	$(".float-box").addClass("call");
    });

    $(".contact-box .close-btn").bind('click',function(){
    	$(".float-box").removeClass("call");
    });
    $(".gotot a").bind('click',function(){
    	$("html,body").animate({scrollTop:0},"300");
    	$(".gotot").css("display", "none");
    });
    $(".btn-1 a").hover(function () {
        $(".pop-consult-box") .removeClass("hideanimation").addClass("showanimation");
    });
    // setTimeout(function(){$(".pop-consult-box").addClass("showanimation");},"15000");
     $(".pop-consult-box .close-btn").bind('click',function(){
        $(".pop-consult-box").addClass("hideanimation");
         setTimeout("showcall()","100");
    });
    setTimeout("aqln_hover()","800");
  aqln_leave();
     setTimeout("bannerhover()","800");
  bannerleave();



});


function bannerhover(){
    $("#slideBox2").mouseover(function(){
      $("#slideBox2").oneTime(50,function(){  
          $(".prev").animate({'left':'0px'},"300");
          $(".next").animate({'right':'0px'},"300");
          //.animate({'height':'203px'},"300");.fadeIn(300);
      });
      
  });
}
function bannerleave(){
    $("#slideBox2").mouseleave(function(){
      $("#slideBox2").stopTime(); 
      $(".prev").stopTime();
      $(".next").stopTime();
        $(".prev").animate({'left':'-52px'},"300");
        $(".next").animate({'right':'-52px'},"300");
      //.animate({'width':'0px','height':'0px'},"300");
  });
}



function itemchange(){
$("#add_items li").bind("click",function(){
    $("#add_items li").removeClass("active");
   $(this).addClass("active");
   var idx = $(this).attr("rel");
   $(".tab-change").css("display", "none");
   $(".tab-change[rel='"+idx+"']").css("display", "block");
});

}

/*榧犳爣涓婄Щ鏄剧ず*/

function aqln_hover(){
    $(".btn-3 a").mouseover(function(){
      $(".btn-3 a").oneTime(50,function(){  
          $(".btn-3 img").stop().animate({'width':'100px','height':'100px'},"300");
      });
      
  });
}
function aqln_leave(){
    $(".btn-3 a").mouseleave(function(){
      $(".btn-3 a").stopTime(); 
      $(".btn-3 img").stopTime();
      $(".btn-3 img").stop().animate({'width':'0px','height':'0px'},"300");
  });
}
function showcall(){
	$(".float-box").addClass("call");
	$(".float-box.call .float-box-c").fadeIn(500);
	
	/*setTimeout(function(){
    	$(".float-box").removeClass("call");
	},"5000");*/
}


function gotoTop(min_height){

//鑾峰彇椤甸潰鐨勬渶灏忛珮搴︼紝鏃犱紶鍏ュ€煎垯榛樿涓�600鍍忕礌
    min_height ? min_height = min_height : min_height = 50;
    //涓虹獥鍙ｇ殑scroll浜嬩欢缁戝畾澶勭悊鍑芥暟
    $(window).scroll(function(){
        //鑾峰彇绐楀彛鐨勬粴鍔ㄦ潯鐨勫瀭鐩翠綅缃�
        var s = $(window).scrollTop();
        //褰撶獥鍙ｇ殑婊氬姩鏉＄殑鍨傜洿浣嶇疆澶т簬椤甸潰鐨勬渶灏忛珮搴︽椂锛岃杩斿洖椤堕儴鍏冪礌娓愮幇锛屽惁鍒欐笎闅�
        if( s > min_height){
            $(".gotot").fadeIn(100).css("display", "block");
            $("#hdw").css("border-bottom", "1px solid #ccc");

        }else{
            $(".gotot").fadeOut(200);

            $("#hdw").css("border-bottom", "none");
        };
    });

};
gotoTop();
/*鍒ゆ柇绐椾綋鐨勫ぇ灏忓疄鐜颁笉鍚岀殑灞曠ず鏁堟灉*/
function change(){
	var s =document.body.clientWidth;
 	if (s<=980) {
	    TouchSlide({ 
	        slideCell:"#slideBox",
	        titCell:".hd ul", //寮€鍚嚜鍔ㄥ垎椤� autoPage:true 锛屾鏃惰缃� titCell 涓哄鑸厓绱犲寘瑁瑰眰
	        mainCell:".bd ul", 
	        effect:"leftLoop", 
	        delayTime:300,
	        autoPage:true,//鑷姩鍒嗛〉
	        autoPlay:false //鑷姩鎾斁
	    });
 	};
}
/*婊氬姩鏉″湪IE涓嬮殣钘�*/
function iesidebar(){
   if ($.browser.msie && ($.browser.version == "7.0")) {
            $(".topcontent").css("display", "none");
            //$(".topscroll").css("display", "none");
            $(".circlel").each(function(){
              $(this).removeClass();
            });
            $(".circler").each(function(){
              $(this).removeClass();
            });
        }
     else   if ($.browser.msie && ($.browser.version == "6.0")) {
            $(".topcontent").css("display", "none");
            $(".topscroll").css("display", "none");
            $("body").html("<b>鎮ㄧ殑娴忚鍣ㄥお鏃ф媺!鏇存柊鐜颁唬娴忚鍣ㄤ綋楠屼細鏇村ソ鍝︼紒</b>");
            $("b").css({"text-align":"center","padding-top":"60px","display":"block"});
        }
else   if ($.browser.msie && ($.browser.version == "8.0")) {
            $(".topcontent").css("display", "none");
             $(".circlel").each(function(){
              $(this).removeClass();
            });
            $(".circler").each(function(){
              $(this).removeClass();
            });
        }
}

/*鑾峰彇婊氬姩鐨勯珮搴�*/
 function getScroll(){  
     var bodyTop = 0;    
     if (typeof window.pageYOffset != 'undefined') {    
         bodyTop = window.pageYOffset;    
     } else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {    
         bodyTop = document.documentElement.scrollTop;    
     }    
     else if (typeof document.body != 'undefined') {    
         bodyTop = document.body.scrollTop;    
     }    
     return bodyTop  
}  


