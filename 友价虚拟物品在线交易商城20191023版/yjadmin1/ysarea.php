<?
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$bh=$_GET[bh];
while0("*","yjcode_pro where bh='".$bh."'");if(!$row=mysql_fetch_array($res)){exit;}

if($_GET[control]=="add"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("权限不够","default.php");}
 $area="|".sqlzhuru($_POST[area1]).",".sqlzhuru($_POST[add2]).",".sqlzhuru($_POST[add3])."|";
 if(strstr($row[ysarea],$area)==""){$areav=$row[ysarea].$area;updatetable("yjcode_pro","ysarea='".$areav."' where id=".$row[id]);}
 php_toheader("ysarea.php?bh=".$bh);

}elseif($_GET[control]=="del"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0101,")){Audit_alert("权限不够","default.php");}
 $a=preg_split("/xcf/",$_GET[aid]);
 $str=$row[ysarea];
 for($i=0;$i<=count($a);$i++){
  if($a[$i]!=""){
   $ss="|".$a[$i]."|";
   $str=str_replace($ss,"",$str);
  }	 
 }
 updatetable("yjcode_pro","ysarea='".$str."' where id=".$row[id]);
 php_toheader("ysarea.php?bh=".$bh);


}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>销售区域设置</title>
<style type="text/css">
body{margin:0;font-size:12px;text-align:center;color:#333;word-wrap:break-word;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
*{margin:0 auto;padding:0;}
ul{list-style-type:none;margin:0;padding:0;}
.uk{float:left;margin:10px 0 0 0;width:600px;font-size:14px;border-bottom:#e1e1e2 solid 1px;}
.uk li{float:left;}
.uk .l1{width:530px;height:45px;padding:0 0 0 10px;}
.uk .l1 .fd{float:left;margin:2px 3px 0 0;}
.uk .l1 .inp{float:left;border:#CCCCCC solid 1px;height:31px;margin-right:2px;font-family:"Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;}
.uk .l2{width:60px;height:45px;}
.uk .l2 input{float:left;color:#fff;font-size:14px;width:50px;height:31px;border:0;background-color:#ff6600;cursor:pointer;}
.u1{float:left;width:290px;height:30px;text-align:left;border-bottom:#e1e1e2 solid 1px;border-right:#e1e1e2 solid 1px;font-size:14px;}
.u1 li{float:left;}
.u1 .l1{width:20px;padding:6px 0 0 10px;}
.u1 .l2{width:260px;padding:5px 0 0 0;height:22px;overflow:hidden;}
.control{float:left;width:600px;height:35px;border-bottom:#e1e1e2 solid 1px;background-color:#F5F6FA;}
.control a{float:left;margin:5px 0 0 10px;padding:4px 10px 0 10px;height:21px;background-color:#1E9FFF;color:#fff;text-decoration:none;}
.list{float:left;width:600px;height:364px;overflow-y:scroll;}
</style>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function area1cha(){
 farea2.location="../tem/area2.php?area1id="+document.getElementById("area1").value;	
}
function tj(){
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="ysarea.php?control=add&bh=<?=$bh?>";
}
function areadel(){
 var c=document.getElementsByName("C1");
 str="";
 for(i=0;i<c.length;i++){
  if(c[i].checked){
	if(str==""){str=c[i].value;}else{str=str+"xcf"+c[i].value;}
  }
 }
 if(str==""){alert("请至少选择一条数据");return false;}
 location.href="ysarea.php?control=del&bh=<?=$bh?>&aid="+str;
}
var selon=0;
function selonc(){
 c=document.getElementsByName("C1");
 if(selon==0){
 for(i=0;i<c.length;i++){c[i].checked="checked";}
 selon=1;
 }else{
 for(i=0;i<c.length;i++){c[i].checked=false;}
 selon=0;
 }
}
</script>
</head>
<body>
<form name="f1" method="post" onsubmit="return tj()">
<input type="hidden" value="area" name="yjcode" />
<ul class="uk">
<li class="l1"><? include("../tem/area.php");?></li>
<li class="l2"><input type="submit" value="添加" /></li>
</ul>
</form>
<div class="control">
<a href="javascript:void(0);" onclick="selonc()" class="a1">全选/反选</a>
<a href="javascript:void(0);" onclick="areadel()" class="a2">删除</a>
</div>
<div class="list">
<?
$a=preg_split("/\|/",$row[ysarea]);
for($i=1;$i<=count($a);$i++){
if($a[$i]!=""){
$areav="";
if(strstr($a[$i],"0,0,0")!=""){$areav="全国";}
$b=preg_split("/,/",$a[$i]);
for($j=0;$j<3;$j++){
$areav=$areav." ".returnarea($b[$j]);
}
?>
<label>
<ul class="u1">
<li class="l1"><input name="C1" type="checkbox" value="<?=$a[$i]?>" /></li>
<li class="l2"><?=$areav?></li>
</ul>
</label>
<? }}?>
</div>
</body>
</html>