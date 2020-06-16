<?
include("../config/conn.php");
include("../config/function.php");
$id=intval($_GET[id]);
if(empty($_SESSION["SHOPUSER"])){php_toheader("openw.php");}
while1("id,bh,userid","yjcode_pro where id=".$id." and zt=0");if(!$row1=mysql_fetch_array($res1)){Audit_alert("商品不存在或未上架",weburl,"parent.");}
$userid=returnuserid($_SESSION["SHOPUSER"]);
$probh=$row1[bh];

if($_GET[yjcode]=="wd"){
 zwzr();
 $txt=sqlzhuru1($_POST["s1"]);
 $mybh=returnbh();
 intotable("yjcode_wenda","bh,probh,userid,selluserid,sj,uip,txt,hftxt","'".$mybh."','".$probh."',".$userid.",".$row1[userid].",'".getsj()."','".getuip()."','".$txt."',''");
 php_toheader("wenda.php?id=".$id."&t=suc");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>问答咨询</title>
<? include("../tem/cssjs.html");?>
<style type="text/css">
.yjcode1{float:left;width:650px;}
.yjcode1 textarea{float:left;width:610px;height:300px;border:#ddd solid 1px;margin:20px;font-size:14px;}
.yjcode2{float:left;width:650px;}
.yjcode2 input{float:left;margin:0 20px;width:610px;color:#fff;border-radius:2px;height:40px;border:0;cursor:pointer;background-color:#1E9FFF;}
.suc{float:left;width:410px;font-size:14px;color:#6B6B6B;background:url(../img/suc.jpg) no-repeat;background-position:110px 120px;padding:130px 0 0 240px;height:50px;line-height:35px;text-align:center;height:250px;text-align:left;}
.suc strong{font-size:16px;color:#ff6600;}
</style>
<script language="javascript">
function tj(){
if(document.f1.s1.value==""){alert("请输入要咨询的问题");document.f1.s1.focus();return false;}
layer.msg('正在处理中，请稍等', {icon: 16  ,time: 0,shade :0.25});
f1.action="wenda.php?id=<?=$id?>&yjcode=wd";
}
function miaos(){
parent.location.reload();
}
</script>
</head>
<body>
<? if($_GET[t]=="suc"){?>
 <div class="suc">
 <strong>提交成功，等待商家审核并回复</strong><br>
 <span id="miao">5</span>秒后自动跳转(如未跳转,请刷新)
 </div>
 <script language="javascript">
 setTimeout("miaos()",4000);
 </script>
<? }else{?>
 <form name="f1" method="post" onsubmit="return tj()">
 <div class="yjcode1"><textarea name="s1" placeholder="请输入您要咨询的问题"></textarea></div>
 <div class="yjcode2"><input type="submit" value="提交问题" /></div>
 </form>
<? }?>
</body>
</html>