$(".lable_nav > li").hover(function () {
    $(".lable_nav > li").removeClass('active');
    $(this).addClass('active');
    var index = $(this).index();
    $(".J_lable_nav_con").css("display", 'none');
    $(".J_lable_nav_con").eq(index).css("display", 'block');
})
$(".lable_conter_3_left_nav > li").hover(function () {
    $(".lable_conter_3_left_nav > li").removeClass('active');
    $(this).addClass('active');
    var index = $(this).index();
    $(".lable_conter_3_left_con  ").css("display", 'none');
    $(".lable_conter_3_left_con  ").eq(index).css("display", 'block');
})
$(".J-select-tab > li").hover(function () {
    $(".J-select-tab > li").removeClass('active');
    $(this).addClass('active');
})
new Swiper('.swiper-container-top', {
    autoplay: true,//可选选项，自动滑动
    direction : 'vertical',
})
new Swiper('.vipHall_scroll', {
    autoplay: true,//可选选项，自动滑动
    slidesPerView : 8,
})


$(".exponent > span:not(:nth-child(1))").click(function () {
    var val = $(this).html();
    $("#topt").val(val);
})
$(".fb-btn").click(function () {
    window.location.href="/user/productlx.php"
})

/*切换分类*/
var type_index= 0;
$("body").delegate(".loadinfo","click",function () {
    $(".inner").css("display","none");
    if(type_index < 2){
         type_index++;
    }else{
        type_index=0;
    }
    $(".inner").eq(type_index).css("display","block");
})

$(".startop_tit > span ").hover(function(){
    $(".startop_tit > span").removeClass("select");
    $(this).addClass("select");
    var index = $(this).index();
    $(".startop_box > ul").css("display","none");
    $(".startop_box > ul").eq(index).css("display","block");
})

/*图片切换*/
$(".tablecorll > a ").hover(function () {
    var h_idx = $(this).index();
    $(this).parents(".talenthpbox").find(".taletptop").children(".tablelicx").css("display","none");
    $(this).parents(".talenthpbox").find(".taletptop").children(".tablelicx").eq(h_idx).css("display","block");

    $(this).parents(".talenthpbox").find(".taletptop").children(".tlarrow").css("left",35 + h_idx * 71 + "px");

})
