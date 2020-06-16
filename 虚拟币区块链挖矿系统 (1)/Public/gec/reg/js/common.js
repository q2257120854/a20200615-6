function showLoading(msg,time){
$("#msg").html(msg);
$(".loading-wrapper").show();
if(time>0){
	setTimeout("hideLoading()",time);
}
}
 
function hideLoading(){
$(".loading-wrapper").hide();
}
function jump(url){
window.location.href =url;
}
