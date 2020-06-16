$(document).ready(function(){
/**
 * @author huanghaipeng
 * @desc 购买产品表单验证
 */
var bNum=parseInt($("#amountIncrease").val());//递增基数为1000
var times=parseInt($("#amountIncrease").val());//倍数，比如1000为输入值是1000的倍数
var min=$('#amountJoinMin').val();//最小金额
var max=$('#amountJoinMax').val();//最大金额
var rest=$('#amountJoinRest').val();//剩余金额
var amount=$('#investmentAmount').val();//输入框数据
var staticImg=$("#staticImg").val();
var planSign=$("#planSign").val();
resetStype();
$('#submit').on('click',function(){
	if(validateForm()){
		$.ajax({
			type: "post",
			url: "#",
			async: false,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			data:$("#investForm").serialize(),
			success: function(date){
				window.location.href="#";
			},
			error:function(date){
				alertMsg(".pop_s", "服务器链接异常");
			}
		});
	}
});
//金额输入框investmentAmount发生keyup时，替换文本框中的非数字内容，替换0开头的数字
$('#investmentAmount').on('keyup',function(){
	$('#investmentAmount').val($('#investmentAmount').val().replace(/\D/g,''));
	$('#investmentAmount').val($('#investmentAmount').val().replace(/^[0]*/g,''));
	//动态改变-号可用属性
	if($('#investmentAmount').val()-min<=0){
		$('#jian').attr("disabled",true);
	}else{
		$('#jian').removeAttr("disabled");
	}
	//动态改变+号可用属性
	if($('#investmentAmount').val()-max>=0||($('#investmentAmount').val()-rest>=0 && planSign!='H')){
		$('#plus').attr("disabled",true);
	}else{
		$('#plus').removeAttr("disabled");
	}
	resetStype();
});

//-号点击事件
$('#jian').on('click',function(){
	//alert('jian');
	amount=$('#investmentAmount').val();
	if(isNaN(amount)||amount==""){
		alertMsg(".pop_s","请输入数字");
		return;
	}
	amount=parseInt(amount);
	//console.log(amount);
	//如果输入金额-基础金额小于最小金额，进行if处理，否则进行else处理
	if(amount-min-bNum<0){
		amount=min;
	}else{
		if(amount%times==0){
			amount-=bNum;
		}else{
			amount=parseInt($('#investmentAmount').val()/times)*times;//输入框数据
		}
	}
	if(amount-max<0&&amount-rest<0&&$('#plus').attr("disabled")){
		$('#plus').removeAttr("disabled");
	}
	$('#investmentAmount').val(amount);
	resetStype();
});
//+号点击事件
$('#plus').on('click',function(){
	//alert('plus');
	amount=$('#investmentAmount').val();
	if(isNaN(amount)||amount==""){
		alertMsg(".pop_s","请输入数字");
		return;
	}
	amount=parseInt(amount);
	//console.log(amount);
	//如果输入金额+基础金额大于剩余金额或最大金额进行if处理，否则进行else处理
	if(amount+bNum-max>0){
		amount=max;
	}else if(amount+bNum-rest>0&&planSign!='H'){
		amount=rest;
	}else{
		if(amount%times==0){
			amount+=bNum;
		}else{
			amount=parseInt($('#investmentAmount').val()/times)*times+bNum;//输入框数据
		}
	}
	if(amount-min>0&&$('#jian').attr("disabled")){
		$('#jian').removeAttr("disabled");
	}
	$('#investmentAmount').val(amount);
	resetStype();
});
/**
 * 校验表单数据
 */
function validateForm(){
	var flag=false;
	if(valInvestForm()){
		flag=true;
	}
	return flag;
}
/**
 * 校验investmentAmount输入框数据
 */
function valInvestForm(){
	amount=$('#investmentAmount').val();
	if(isNaN(amount)||amount==""){
		alertMsg(".pop_s","请输入数字");
		return;
	}
	amount=parseInt(amount);
	amount=parseInt(amount/times)*times;//输入框数据
	if(min-0<=0){
		alertMsg(".pop_s","对不起，该产品已满额");
		return false;
	}
	if(amount-min<0){
		//alert("购买金额"+min+"元起，请重新输入");
		alertMsg(".pop_s","购买金额"+min+"元起，请重新输入");
		return false;
	}
	if((amount-rest>0&&planSign!='H')||amount-max>0){
		if(planSign!='H'){
			if(rest-max>0){
				amount=max;
			}else{
				amount=rest;
			}
		}else{
			amount=max;
		}
		
	}
	$('#investmentAmount').val(amount);
	return true;
}
function alertMsg(nodeId,msg){
	$(nodeId).html('<span>'+msg+'</span>');
	$(nodeId).fadeIn(0.3,function(){
		setTimeout(autoplay,3000);
		function autoplay(){
			 $(nodeId).fadeOut(0.3)
		}
	});
}

function resetStype(){
	amount=$('#investmentAmount').val();
	if(amount!=""){
		amount=parseInt(amount);
		min=parseInt(min);
		max=parseInt(max);
		if(amount-min<=0){
			$('#jian').css('backgroundImage', 'url(images/jian.png)');
			$('#plus').css('backgroundImage', 'url(images/add_hover.png)');
		}else if(amount-max>=0){
			$('#jian').css('backgroundImage', 'url(images/jian_hover.png)');
			$('#plus').css('backgroundImage', 'url(images/jia.png)');
		}else{
			$('#jian').css('backgroundImage', 'url(images/jian_hover.png)');
			$('#plus').css('backgroundImage', 'url(images/add_hover.png)');
		}
	}
}
});