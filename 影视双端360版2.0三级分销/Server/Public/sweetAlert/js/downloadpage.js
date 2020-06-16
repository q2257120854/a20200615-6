<script type="text/javascript">
if (document.getElementById("permissions").innerHTML == "不限") {
	document.getElementById("vip1").style.display = "none";
	document.getElementById("vip2").style.display = "none";
	document.getElementById("vip3").style.display = "none";
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else if (document.getElementById("permissions").innerHTML == "认证玩家及以上" && parseInt(document.getElementById("membersrGroupId").innerHTML) >= 20) {
	document.getElementById("vip1").style.display = "none";
	document.getElementById("vip2").style.display = "none";
	document.getElementById("vip3").style.display = "none";
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else if (document.getElementById("permissions").innerHTML == "小氪玩家及以上" && parseInt(document.getElementById("membersrGroupId").innerHTML) >= 21) {
	if (document.getElementById("unzipCode1").innerHTML == "") {
		document.getElementById("vip1").style.display = "none";
	}
	document.getElementById("vip2").style.display = "none";
	document.getElementById("vip3").style.display = "none";
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else if (document.getElementById("permissions").innerHTML == "土豪玩家及以上" && parseInt(document.getElementById("membersrGroupId").innerHTML) >= 24) {
	if (document.getElementById("unzipCode1").innerHTML == "") {
		document.getElementById("vip1").style.display = "none";
	}
	if (document.getElementById("unzipCode2").innerHTML == "") {
		document.getElementById("vip2").style.display = "none";
	}
	document.getElementById("vip3").style.display = "none";
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else if (document.getElementById("permissions").innerHTML == "稀有玩家及以上" && parseInt(document.getElementById("membersrGroupId").innerHTML) >= 25) {
	if (document.getElementById("unzipCode1").innerHTML == "") {
		document.getElementById("vip1").style.display = "none";
	}
	if (document.getElementById("unzipCode2").innerHTML == "") {
		document.getElementById("vip2").style.display = "none";
	}
	if(document.getElementById("unzipCode3").innerHTML == "") {
		document.getElementById("vip3").style.display = "none";
	}
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else if (document.getElementById("membersrGroupId").innerHTML == "1") {
	if (document.getElementById("unzipCode1").innerHTML == "") {
		document.getElementById("vip1").style.display = "none";
	}
	if (document.getElementById("unzipCode2").innerHTML == "") {
		document.getElementById("vip2").style.display = "none";
	}
	if(document.getElementById("unzipCode3").innerHTML == "") {
		document.getElementById("vip3").style.display = "none";
	}
	if (document.getElementById("extractPassword").innerHTML == "") {
	document.getElementById("extractPassword").innerHTML = "无提取码";
	}
}else{
	document.getElementById("vip1").style.display = "none";
	document.getElementById("vip2").style.display = "none";
	document.getElementById("vip3").style.display = "none";
	document.getElementById("extractPassword").innerHTML = "<a href=\"/plugin.php?id=keke_group\"><font color=\"#888\">查看权限：</font><font color=\"red\">" + document.getElementById("permissions").innerHTML + "&nbsp;</font><font color=\"#00f\">去升级</font></a>";
}
var membersrUid = document.getElementById("membersrUid").innerHTML;
var groupid = parseInt(document.getElementById("membersrGroupId").innerHTML);
var downloadurl = '{nex_sc_xiazai_value}';
function downloadclick(){
	if(groupid == 7){
		sweetAlert('哎呦……', '您还未登录，请登录后下载~' ,'error');
	}else if(groupid >= 8 || groupid == 1){
		swal({
			title: "确定下载吗？", 
			text: "每日下载次数将减少1次！", 
			type: "warning",
			showCancelButton: true, 
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "继续下载！", 
			cancelButtonText: "取消下载！",
			closeOnConfirm: false, 
			closeOnCancel: false	
		},
		function(isConfirm){
			if (isConfirm) {
				download()
			} else {
				swal('取消！', '您取消了下载~:)','error'); 
			} 
		});
	}else if(groupid > 2 || groupid <= 7 || $roupid == 9){
		sweetAlert('哎呦……', '由于您的账号存在违规记录，暂时无法进行下载！' ,'error');
	}
}
function download(){
	jQuery.post("/others/downloads/index.php", {membersrUid:membersrUid},
	function(data){
		var data = JSON.parse(data);
		if(data.code == 1){
			window.open(downloadurl);
			swal('提示！', data.tips + '，已为您打开下载页面~\n若弹窗被拦截请手动复制下载地址：' + downloadurl,'success');
		}else if(data.code == 0){
			sweetAlert('哎呦……', data.tips ,'error');
		}
	});
}
</script>
<script type="text/javascript" src="/others/downloads/js/sweetalert.js"></script>
<link rel="stylesheet" type="text/css" href="/others/downloads/css/sweetalert.css">