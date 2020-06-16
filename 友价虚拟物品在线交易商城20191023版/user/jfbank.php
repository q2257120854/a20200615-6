<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

if(sqlzhuru($_POST[yjcode])=="jfbank"){
 zwzr();
 $fs=intval($_POST[fsv]);
 $tnum=intval($_POST[tnum]);
 if($tnum<=0){echo "兑换数值无效";exit;}
 if($fs==1){ //积分换人民币
  if($tnum>$rowuser[jf]){echo "兑换值超过您的可用积分";exit;}
  $m=sprintf("%.2f",$tnum/$rowcontrol[jfmoney]);
  PointIntoM($rowuser[id],"积分兑换金钱",$m);PointUpdateM($rowuser[id],$m);
  PointInto($rowuser[id],"积分兑换金钱",$tnum*(-1));PointUpdate($rowuser[id],$tnum*(-1));
 }elseif($fs==2){ //人民币换积分
  if($tnum>$rowuser[money1]){echo "兑换值超过您的可用余额";exit;}
  $jf=sprintf("%.2f",$tnum*$rowcontrol[jfmoney]);
  PointIntoM($rowuser[id],"积分兑换金钱",$tnum*(-1));PointUpdateM($rowuser[id],$tnum*(-1));
  PointInto($rowuser[id],"积分兑换金钱",$jf);PointUpdate($rowuser[id],$jf);
 }
 echo "ok";exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<script language="javascript">
var fs=1;
function tj(){
 if(fs==1){zhi=document.f1.t1.value;}
 else if(fs==2){zhi=document.f1.t2.value;}
 if(zhi=="" || isNaN(zhi)){layer.alert('请输入有效的兑换数量', {icon:5});return false;}

 var flag = false;  
 layer.confirm("确定要进行兑换吗？", {icon: 3, title:'提示'},  
  function(index){      //确认后执行的操作 
   layer.close(index); 
   layer.msg('数据处理中', {icon: 16  ,time: 0,shade :0.25});
   $.post("jfbank.php",{fsv:fs,tnum:zhi,yjcode:"jfbank"},function(result){
   if(result=="ok"){location.href="jfbank.php?t=suc";}else{layer.alert(result, {icon:5});return false;}
   });
  },  
  function(index){      //取消后执行的操作  
   flag = false;  
  });  
 return false;
}

function jfxs(x){
fs=x;
document.getElementById("uk1").style.display="none";
document.getElementById("uk2").style.display="none";
document.getElementById("uk"+x).style.display="";
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("top.php");?>
<div class="yjcode">

<? include("left.php");?>

<!--RB-->
<div class="userright">
 
 <? include("rcap8.php");?>
 <script language="javascript">
 document.getElementById("rcap3").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","jfbank.php")?>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1">兑换方式：</li>
 <li class="l2">
 <label><input name="R1" type="radio" value="1" onclick="jfxs(1)" checked="checked" /> 积分换人民币</label>
 <label><input name="R1" type="radio" value="2" onclick="jfxs(2)" /> 人民币换积分</label>
 </li>
 </ul>

 <ul class="uk uk0" id="uk1">
 <li class="l1">可用积分：</li>
 <li class="l21"><strong class="red"><?=$rowuser[jf]?></strong>分</li>
 <li class="l1">可用余额：</li>
 <li class="l21"><strong class="red"><?=sprintf("%.2f",$rowuser[money1])?></strong>元</li>
 <li class="l1">兑换比例：</li>
 <li class="l21"><?=$rowcontrol[jfmoney]?>分=1元人民币</li>
 <li class="l1">兑换积分：</li>
 <li class="l2"><input type="text" name="t1" class="inp" /></li>
 </ul>

 <ul class="uk uk0" id="uk2" style="display:none;">
 <li class="l1">可用余额：</li>
 <li class="l21"><strong class="red"><?=sprintf("%.2f",$rowuser[money1])?></strong>元</li>
 <li class="l1">可用积分：</li>
 <li class="l21"><strong class="red"><?=$rowuser[jf]?></strong>分</li>
 <li class="l1">兑换比例：</li>
 <li class="l21">1元人民币=<?=$rowcontrol[jfmoney]?>分</li>
 <li class="l1">兑换金额：</li>
 <li class="l2"><input type="text" name="t2" class="inp" /></li>
 </ul>
 
 <ul class="uk uk0">
 <li class="l3"><input type="submit" class="btn1" onmouseover="this.className='btn1 btn2';" onmouseout="this.className='btn1';" value="提交兑换" /></li>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>