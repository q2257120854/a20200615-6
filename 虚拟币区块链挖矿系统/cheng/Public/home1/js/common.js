

/*//订单信息
var loginid = 0;
$('#j_order').live('mouseenter',function(even){
    even.cancleBable;
    $(this).addClass('mod_dropmenu_on');
    $.ajax({
    	url:APP+'/Home/Index/loginStatus',
	    type:'post',
	    data:{loginid:loginid},
	    success:function(data){
	        if (data) {
		    	orderinfo(data);
		    }else{
		    	$('#j_iorder_pop').html('<div class="mod_iorder_unlogin"><a href="" >登录</a> 后查看最近的订单信息</div>');
		    }
	    }
    });
    $('#j_iorder_pop').removeClass('hide');
});

function orderinfo(uid){
	$.ajax({
    	url:APP+'/Home/Index/orderInfo',
	    type:'post',
	    data:{uid:uid},
	    success:function(data){
		    $('#j_iorder_pop').html('<div class="mod_iorder_unlogin">查看最近的订单信息</div>');
	    }
    });
}*/

$('#j_order').mouseleave(function(){
    $(this).removeClass('mod_dropmenu_on');
    $('#j_iorder_pop').addClass('hide');
});

//顶部广告
$('.mod_fbanner').slideDown(1000);
$('#j_fbanner_close').click(function(){
    $('.mod_fbanner').slideUp(1000);
});

//搜索
$('#q_show').focus(function(){
    if ($(this).val() != '') {
        $(this).val('');
    };
});
$('#q_show').blur(function(){
    if ($(this).val() == '') {
        $(this).val('请输入品牌或商品进行搜索');
   };
});
$('form[name=search]').submit(function(){
    if ($('#q_show').val() == '' || $('#q_show').val() == '请输入品牌或商品进行搜索') {
        return false;
    };
    $(this).attr('action',APP+'/Home/Search/index');
});

//购物车
$('.mod_minicart').mouseenter(function(even){
    even.cancleBable;
    $(this).addClass('mod_minicart_on');
    $.ajax({
        url:APP+'/Home/Showcart/viewInfo',
        type:'post',
        success:function(data){
            if(data == 0) {
                $('.mod_minicart_pop_inner').html('<div id="j_minicart_layer" class="mod_minicart_pop_inner"><div id="j_minicart_empty" class="mod_minicart_empty"><p>您的购物车是空的<br></p></div></div>');
            }else{
                $('.mod_minicart_pop_inner').html(data);
            }        	          
        }
    });
});
$('.mod_minicart').mouseleave(function(even){
    $(this).removeClass('mod_minicart_on');
});

viewCartNums();
//购物车展示数量
function viewCartNums(){
    $.ajax({
        url:APP+'/Home/Showcart/viewNums',
        type:'post',
        success:function(data){
            $('#j_minicart_num').html(data);
        }
    });
}


//分类列表
$.ajax({
	url:APP+'/Home/Index/viewCate',
    type:'post',
    data:{cid:0},
    success:function(data){
        if (data) {
            $('#frist_list').html(data);
        };
    }
});

$('#frist_list li').live('mouseenter',function(){
    $('#second_list').css('display','block');

    var first_li_num = $(this).attr('id').split('_')[1];
    var first_li_index = $(this).attr('index');
    //设置高度
    if (first_li_index>4) {
    	first_li_index = (first_li_index-4)*61;
    }else{
    	first_li_index = 0;
    }
    $('#second_list').css('top',(40+first_li_index)+'px');
    $('#second_list').children().attr('style','display: none;');

   	//显示具体分类列表
    if ($('#panel_'+first_li_num).length>0) {    	
    	$('#panel_'+first_li_num).attr('style','display: block;');
    }else{
    	$.ajax({
    		url:APP+'/Home/Index/catalogue',
    		type:'post',
    		data:{cid:first_li_num},
    		success:function(data){
    			$('#second_list').append(data);
    		}
    	});
    }
});

$('#category_container').mouseleave(function(){
	$('#second_list').css('display','none');
});

//返回头部
$(window).scroll(function(){
	if ($(window).scrollTop() > 400) {
		$('#j_backtop').css('display','block');
	}else{
		$('#j_backtop').css('display','none');
	}
});
$('#j_backtop').click(function(){
	$(window).scrollTop(0);
});

//登录页
//$('#login_form').attr('action','__APP__/home/login/enter');
$('#login_form :input[name=uname]').focus(function(){
	if ($(this).val() == '手机号/QQ号') {
		$(this).val('');
	};
});
$('#login_form :input[name=uname]').blur(function(){
	if ($(this).val() == '' || $(this).val() == '手机号/QQ号') {
		$(this).val('手机号/QQ号');
		$(this).addClass('login_error');
	}else{
		$(this).removeClass('login_error');
	}
});
$('#login_form :input[name=pwd]').focus(function(){
	if ($(this).val() == '密码') {
		$('.enter_inp2').eq(1).html('<input type="password" name="pwd" value="" class="enter_inp"><br />');
		$('#login_form :input[name=pwd]').focus();
	};
});

$('#login_form :input[name=pwd]').blur(function(){
	if ($(this).val() == '') {
		$(this).val('');
		$(this).addClass('login_error');
	}else{
		$(this).removeClass('login_error');
	}
});

$('#login_form').submit(function(){
	if ($('#login_form :input[class*=login_error]')){
		$('#login_form :input[class*=login_error]').eq(0).addClass('login_error');
	}
	if ($('#login_form :input[name=uname]').val() == '手机号/QQ号') {
		$('#login_form :input[name=uname]').addClass('login_error');
		return false;
	}
	if ($('#login_form :input[name=pwd]').val() == '密码' || $('#login_form :input[name=pwd]').val() == '') {
		$('#login_form :input[name=pwd]').addClass('login_error');
		return false;
	};

	if ($('#login_negotiate').attr('checked')) {
		return true;
	}else{
		return false;
	}
});
$('#delete-error').fadeOut(0);
$(".enter_sub").click(function(){
	var $uname = $(":input[name=uname]").val();
	var $pwd = $(":input[name=pwd]").val();
	$.ajax({
		url:APP+'/home/Login/enter',
		type:"post",
		data:{"uname":$uname,"pwd":$pwd},
		success:function(data){
			if(data==1){
				window.location="/index.php/home/index";
			}else{
				$(".enter_form").before('<div class="enter_error">您的用户名或密码错误,请重新输入</div>');
				$(".enter_error").fadeOut(1500);
			}
		}

	})
});

//导航
$.ajax({
    url:APP+"/home/Index/nav",
    dataType:'json',
    success:function(data){
         $("#j_hornav").html('');
            for(var i=0;i<data.length;i++){
               
                $("#j_hornav").append("<li class='mod_nav_li'><a  target='_blank' href='"+APP+data[i].nweb+"'>"+data[i].nname+"</a></li>");
            }
    }  
})  
