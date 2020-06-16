<?
include("../config/conn.php");
include("../config/function.php");
require("../config/tpclass.php");
sesCheck();
$bh=returndeldian($_GET[bh]);
$mybh=returndeldian($_GET[mybh]);
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
$rowuser=mysql_fetch_array($resuser);
$userid=$rowuser[id];
while0("*","yjcode_provideo where bh='".$mybh."' and probh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("provideolist.php?bh=".$bh);}

//函数开始
if($_GET[control]=="update"){
 zwzr();
 if(1==intval($_POST[d1])){$u=$_POST[t2];}
 else{$u=inp_tp_upload(1,"../upload/".$row[userid]."/".$bh."/",$mybh);if(!empty($u)){$u="../upload/".$row[userid]."/".$bh."/".$u;}}
 if(!empty($u)){$ses=",url='".$u."'";}
 if($rowcontrol[ifproduct]=="on"){$nzt=0;}else{$nzt=1;}
 $iftj=intval($_POST[tiftj]);
 if(1==$iftj){updatetable("yjcode_provideo","iftj=0 where probh='".$bh."'");}
 updatetable("yjcode_provideo","tit='".sqlzhuru($_POST[ttit])."'".$ses.",iftj=".$iftj.",admin=".$_POST[d1].",zt=".$nzt.",gs='".sqlzhuru($_POST[d2])."' where id=".$row[id]);
 uploadtpnodata(2,"upload/".$row[userid]."/".$bh."/",$mybh.".jpg","allpic",140,84,0,0,"no");
 php_toheader("provideo.php?t=suc&mybh=".$mybh."&bh=".$bh);

}
//函数结果
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<style type="text/css">
.uk{float:left;margin:0 0 0 0;width:900px;font-size:14px;text-align:left;}
.uk li{float:left;}
.uk .l1{width:160px;text-align:right;padding:19px 10px 0 0;height:30px;color:#666666;}
.uk .l21{width:730px;height:30px;padding:19px 0 0 0;}
.uk .l2{width:730px;height:38px;padding:11px 0 0 0;}
.uk .l2 .fd{float:left;margin:6px 7px 0 0;}
.uk .l2 .inp{float:left;border:#CCCCCC solid 1px;height:34px;padding:0 0 0 5px;margin-right:7px;}
.uk .l2 .finp{float:left;}
@media screen and (-webkit-min-device-pixel-ratio:0) {
.uk .l2 .finp{padding:5px 0 0 0;}
}
.uk .l3{width:730px;padding:10px 0 0 170px;}
.uk .l3 .btn1{cursor:pointer;float:left;border:0;color:#fff;width:173px;height:44px;margin-right:10px;background-color:#E83A17;font-size:16px;}
.uk .l3 .btn2{background-color:#D43211;}
.uk .l3 .btn3{cursor:pointer;float:left;color:#C9C9C9;width:172px;height:44px;margin-right:10px;background-color:#FBFBFB;font-size:16px;border:#E6E6E6 solid 1px;}
.uk .l3 .btn4{background-color:#F3F3F3;}
.uk .l5{width:160px;text-align:right;padding:13px 10px 0 0;height:90px;}
.uk .l6{width:730px;height:90px;padding:13px 0 0 0;}
.uk0{margin-top:0;}
.systs{float:left;width:878px;margin:10px 10px 0 10px;background-color:#EBF8A4;border:#A2D246 solid 1px;color:#FF6600;padding:9px 0 0 0;height:24px;text-align:center;}
</style>
<script language="javascript">
function tj(){
if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.ttit.focus();return false;}
if(document.f1.d2.value==""){alert("请选择视频格式");return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="provideo.php?bh=<?=$bh?>&control=update&mybh=<?=$row[bh]?>";
}
function infcha(){
d=parseInt(document.f1.d1.value);
document.getElementById("infout").style.display="none";
document.getElementById("infmy").style.display="none";
if(d==1){document.getElementById("infout").style.display="";}
else if(d==2){document.getElementById("infmy").style.display="";}
}
</script>
</head>
<body>
 <!--白B-->
 
 <? systs("恭喜您，操作成功!","provideo.php?bh=".$bh."&mybh=".$_GET[mybh])?>
 
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="video" name="jvs" />
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 标题：</li>
 <li class="l2"><input type="text" size="50" value="<?=$row[tit]?>" class="inp" name="ttit" /> </li>
 <li class="l1">视频截图：</li>
 <li class="l2"><span class="finp"><input type="file" name="inp2" id="inp2" size="25"> 最佳尺寸：140*84</span></li>
 <? $tp="../upload/".$userid."/".$bh."/".$mybh.".jpg";if(is_file($tp)){?>
 <li class="l5"></li>
 <li class="l6"><img src="<?=$tp?>" width="130" height="74" /></li>
 <? }?>
 <li class="l1">来路：</li>
 <li class="l2">
 <select name="d1" onchange="infcha()" class="inp">
 <option value="1">外部视频地址</option>
 <option value="2"<? if(2==$row[admin]){?> selected="selected"<? }?>>自己上传</option>
 </select>
 <select name="d2" class="inp">
 <option value=""></option>
 <? $arr=array("flv","swf","mp4");for($i=0;$i<count($arr);$i++){?>
 <option value="<?=$arr[$i]?>"<? if($arr[$i]==$row[gs]){?> selected="selected"<? }?>><?=$arr[$i]?></option>
 <? }?>
 </select>
 <span class="fd red">注：手机端只支持MP4格式</span>
 </li>
 </ul>
 
 <ul class="uk uk0" id="infout" style="display:none;">
 <li class="l1">视频路径：</li>
 <li class="l2"><input value="<?=$row[url]?>" name="t2" class="inp" style="width:500px;" type="text"/></li>
 </ul>
 
 <ul class="uk uk0" id="infmy" style="display:none;">
 <li class="l1">自己上传：</li>
 <li class="l2"><input type="file" name="inp1" id="inp1" size="15" accept=".flv,.swf,.mp4"> </li>
 <li class="l1">视频路径：</li>
 <li class="l2"><input value="<?=$row[url]?>" readonly="readonly" class="inp redony" size="40" type="text"/> <span class="fd">[<a href="<?=$row[url]?>" target="_blank">下载</a>]</span></li>
 </ul>
 <ul class="uk uk0">
 <li class="l1">推荐序号：</li>
 <li class="l2">
 <select name="tiftj" class="inp">
 <option value="1">推荐，即在该商品主页能看到</option>
 <option value="0"<? if(0==$row[iftj]){?> selected="selected"<? }?>>不推荐</option>
 </select>
 </li>
 <li class="l3"><? tjbtnr("下一步","provideolist.php?bh=".$bh)?></li>
 </ul>
 </form>
 
 <!--白E-->


<script language="javascript">
infcha();
</script>

</body>
</html>