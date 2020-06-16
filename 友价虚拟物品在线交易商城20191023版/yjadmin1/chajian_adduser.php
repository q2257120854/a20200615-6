<?php
set_time_limit(0);
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$uip=getuip();
//函数开始
if($_GET[control]=="add"){

 zwzr();
 $r1=intval($_POST[R1]);
 if($r1==1){ //自动生成
  for($pii=1;$pii<=intval($_POST[t1]);$pii++){
  $uid=MakePassAll(12);
   if(panduan("uid","yjcode_user where uid='".$uid."'")==0){
   $pwd=returnbh();
   $nc=$uid;
   $sj=date("Y-m-d H:i:s");
   include("../reg/reg_tem.php");
   }
  }
 }elseif($r1==2){ //XLS导入
  $up1=$_FILES["inp1"]["name"];
  if(!empty($up1)){
  $hz=returnhz($up1);
  if($hz!="xls"){Audit_alert("失败.只能上传导入.xls后缀的文件，返回重试","chajian_adduser.php");}
  inp_tp_upload(1,"./","chajian_adduser","xls");
  //导入开始
  require_once '../config/Excel/reader.php';
  $data = new Spreadsheet_Excel_Reader();
  $data->setOutputEncoding('CP936');
  $data->read("chajian_adduser.xls");
  error_reporting(E_ALL ^ E_NOTICE);
  for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
  $uid= $data->sheets[0]['cells'][$i][1]."";
  $pwd= $data->sheets[0]['cells'][$i][2]."";
   if(panduan("uid","yjcode_user where uid='".$uid."'")==0){
   $nc=$uid;
   $sj=date("Y-m-d H:i:s");
   include("../reg/reg_tem.php");
   }
  }
  //导入结束
  delFile("chajian_adduser.xls");
  }
 
 }
 
 php_toheader("chajian_adduser.php?t=suc");
}
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
<script language="javascript">
function r1onc(x){
document.getElementById("r1main1").style.display="none";
document.getElementById("r1main2").style.display="none";
document.getElementById("r1main"+x).style.display="";
}
</script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu7").className="a1";
</script>

<div class="yjcode">
 <? $leftid=1;include("menu_chajian.php");?>

<div class="right">
 <!--B-->
 <? systs("恭喜您，操作成功!","chajian_adduser.php")?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">批量添加会员</a>
 </div> 
 <div class="rkuang">
 <script language="javascript">
 function tj(){
  layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
  f1.action="chajian_adduser.php?control=add"; 
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l1">会员总量：</li>
 <li class="l21"><?=returncount("yjcode_user")?>位</li>
 <li class="l1">添加方式：</li>
 <li class="l2">
 <label><input name="R1" type="radio" value="1" onclick="r1onc(1)" checked="checked" /> 自动生成</label>
 <label><input name="R1" type="radio" value="2" onclick="r1onc(2)" /> 批量上传</label>
 </li>
 </ul>
 
 <ul class="uk uk0" id="r1main1">
 <li class="l1">生成数量：</li>
 <li class="l2"><input type="text" class="inp" value="0" size="10" name="t1" /><span class="fd">组</span></li>
 </ul>
 
 <ul class="uk uk0" id="r1main2" style="display:none;">
 <li class="l1">选择文件：</li>
 <li class="l2"><input type="file" name="inp1" class="inp1" id="inp1" size="25"></li>
 <li class="l1"></li>
 <li class="l21">上传格式为xls文件，即excel，程序会自动识别，但必须保证符合规则，<strong class="red">第一列为账号，第二列为密码</strong></li>
 </ul>
 
 <ul class="uk uk0">
 <li class="l3"><input type="submit" value="开始生成" class="btn1" /></li>
 </ul>
 </form>

 </div>
 <!--E-->
 
</div>

</div>

<?php include("bottom.php");?>
</body>
</html>