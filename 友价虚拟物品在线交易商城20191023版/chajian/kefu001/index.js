$(function() {
    $(".contact .goTop").click(function(event) {
      if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){  
        return window.location.href='#top'; 
         }  
        $('html,body').animate({ scrollTop: 0 })
    });
    $(".close_contact").click(function() { //¹Ø±ÕÊ×Ò³²à±ßÀ¸
        $(".contact").hide(300);
        $("span.tel").fadeIn(300);
    })

    $("span.tel").click(function() {
        $(".contact").show(300);
        $("span.tel").hide(300);
        return false;
    });
})
