<?php
include("../config/conn.php");
include("../config/function.php");
require("../config/tpclass.php");
AdminSes_audit();
$bh=$_GET[bh];
$mybh=$_GET[mybh];
while0("*","yjcode_provideo where bh='".$_GET[mybh]."' and probh='".$bh."'");if(!$row=mysql_fetch_array($res)){php_toheader("provideolist.php?bh=".$bh);}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("权限不够","default.php");}
 zwzr();
 if(1==intval($_POST[d1])){$u=$_POST[t2];}else{$u=inp_tp_upload(1,"../upload/".$row[userid]."/".$bh."/",$mybh);if(!empty($u)){$u="../upload/".$row[userid]."/".$bh."/".$u;}}
 if(!empty($u)){$ses=",url='".$u."'";}
 $iftj=intval($_POST[tiftj]);
 if(1==$iftj){updatetable("yjcode_provideo","iftj=0 where probh='".$bh."'");}
 updatetable("yjcode_provideo","tit='".sqlzhuru($_POST[ttit])."'".$ses.",iftj=".$iftj.",admin=".$_POST[d1].",zt=".$_POST[Rzt].",gs='".sqlzhuru($_POST[d2])."' where id=".$row[id]);
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
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>
<style type="text/css">
.uk{float:left;width:100%;margin-top:10px;text-align:left;}
.uk li{float:left;}
.uk .l1{width:125px;height:38px;text-align:right;font-size:14px;padding:10px 5px 0 0;}
.uk .l2{width:-moz-calc(100% - 130px);width:-webkit-calc(100% - 130px);width:calc(100% - 130px);height:48px;}
.uk .l2 .inp{float:left;height:27px;border:#B6B7C9 solid 1px;border-radius:2px;font-size:14px;padding:9px 0 0 5px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;background:url(../img/inpbg.gif) left top repeat-x;}
.uk .l2 .redony{background-image:none;background-color:#EAEAEA;}
.uk .l2 .inp1{float:left;font-size:14px;margin:10px 0 0 0;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
.uk .l2 .fd{float:left;margin:11px 0 0 10px;}
.uk .l2 label{float:left;cursor:pointer;margin:0 10px 0 0;padding:9px 10px 0 10px;height:25px;background-color:#FCFCFD;border:#B6B7C9 solid 1px;border-radius:5px;font-size:14px;}
.uk .l3{width:888px;padding:0 0 0 130px;height:48px;}
.uk .l3 .btn1{float:left;color:#fff;font-size:14px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;width:92px;height:38px;cursor:pointer;border:0;background-color:#009688;border-radius:2px;}
.uk .l3 .btn1:hover{background-color:#33AB9F;}
.uk .l3 .btn2{float:left;color:#333;font-size:14px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;width:90px;height:38px;cursor:pointer;border:#C9C9C9 solid 1px;background-color:#fff;border-radius:2px;margin-left:10px;}
.uk .l3 .btn2:hover{background-color:#F7F7F7;}
.uk .l8{width:130px;text-align:right;height:76px;}
.uk .l9{width:-moz-calc(100% - 130px);width:-webkit-calc(100% - 130px);width:calc(100% - 130px);height:76px;}
@media screen and (-webkit-min-device-pixel-ratio:0) {
.uk .l2 .inp{padding:0 0 0 5px;height:36px;}
}
.uk0{margin-top:0;}
</style>
</head>
<body>


 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！[<a href='provideolx.php?bh=".$bh."'>继续添加新视频</a>]","provideo.php?bh=".$bh."&mybh=".$mybh);}?>

 <!--B-->
 <script language="javascript">
 function tj(){
 if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.ttit.focus();return false;}
 r=document.getElementsByName("Rzt");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择审核状态！");return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
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
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="video" name="jvs" />
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 标题：</li>
 <li class="l2"><input type="text" size="50" value="<?=$row[tit]?>" class="inp" name="ttit" /> </li>
 <li class="l1">视频截图：</li>
 <li class="l2"><input type="file" name="inp2" class="inp1" id="inp2" size="25"><span class="fd">最佳尺寸：140*84</span></li>
 <li class="l8"></li>
 <li class="l9"><img src="<?="../upload/".$row[userid]."/".$bh."/".$mybh.".jpg"?>" width="108" height="65" /></li>
 <li class="l1">视频来路：</li>
 <li class="l2">
 <select name="d1" onchange="infcha()" class="inp">
 <option value="1">外部视频地址</option>
 <option value="2"<? if(2==$row[admin]){?> selected="selected"<? }?>>自己上传</option>
 </select>
 <select name="d2" class="inp" style="margin-left:10px;">
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
 <li class="l2"><input value="<?=$row[url]?>" readonly="readonly" class="inp redony" size="40" type="text"/><span class="fd">[<a href="<?=$row[url]?>" target="_blank">下载</a>]</span></li>
 </ul>

 
 <ul class="uk uk0">
 <li class="l1">推荐序号：</li>
 <li class="l2">
 <select name="tiftj" class="inp">
 <option value="1">推荐，即在该商品主页能看到</option>
 <option value="0"<? if(0==$row[iftj]){?> selected="selected"<? }?>>不推荐</option>
 </select>
 </li>
 <li class="l1">审核状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" <? if(0==$row[zt]){?>checked="checked"<? }?> /> <strong>正常展示</strong></label> 
 <label><input name="Rzt" type="radio" value="1" <? if(1==$row[zt]){?>checked="checked"<? }?> /> <strong>正在审核</strong></label> 
 <label><input name="Rzt" type="radio" value="2" <? if(2==$row[zt]){?>checked="checked"<? }?> /> <strong>审核不通过</strong></label> 
 </li>
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /><input type="button" onclick="gourl('provideolist.php?bh=<?=$bh?>')" value="返回列表" class="btn2" /></li>
 </ul>
 
 </form>
 <!--E-->
 
<script language="javascript">
infcha();
</script>
</body>
</html>