<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
if(empty($_SESSION[SAFEPWD])){Audit_alert("卡密信息操作需要先进行安全码验证!","safepwd.php");}
$bh=$_GET[bh];
$tcid=$_GET[tcid];
$userid=returnuserid($_SESSION[SHOPUSER]);
while0("*","yjcode_taocan where probh='".$bh."' and userid=".$userid." and id=".$tcid);if(!$row=mysql_fetch_array($res)){php_toheader("taocanlist.php?bh=".$bh);}

//函数开始
if($_GET[control]=="add"){
 zwzr();
 if($_POST[Rtjfs]=="txt"){
 $c=str_replace("\r","",($_POST[s1]));
 $d=preg_split("/\n/",$c);
 for($i=0;$i<=count($d);$i++){
  if(!empty($d[$i])){
   $e=preg_split("/\s/",$d[$i]);
     if(panduan("probh,tcid,userid,ka","yjcode_taocan_kc where probh='".$bh."' and tcid=".$tcid." and ka='".$e[0]."' and userid=".$userid)==0){
     $mi="";
	 if(count($e)>=2){for($ei=1;$ei<count($e);$ei++){$mi=$mi." ".$e[$ei];}}
	 intotable("yjcode_taocan_kc","probh,tcid,userid,ka,mi,ifok","'".$bh."',".$tcid.",".$userid.",'".$e[0]."','".$mi."',0");
	 }
  }
 }
 
 }elseif($_POST[Rtjfs]=="one"){
  if(panduan("probh,tcid,userid,ka","yjcode_taocan_kc where probh='".$bh."' and tcid=".$tcid." and ka='".sqlzhuru($_POST[tka])."' and userid=".$userid)==1){
  Audit_alert("卡号已存在，添加失败!","kc_tc.php?bh=".$bh."&tcid=".$tcid);
  }
  intotable("yjcode_taocan_kc","probh,tcid,userid,ka,mi,ifok","'".$bh."',".$tcid.",".$userid.",'".sqlzhuru($_POST[tka])."','".sqlzhuru($_POST[tmi])."',0");
 
 }else{
  $up1=$_FILES["inp1"]["name"];
  if(!empty($up1)){
  $hz=returnhz($up1);
  if($hz!="xls"){Audit_alert("失败.只能上传导入.xls后缀的文件，返回重试","kc.php?bh=".$bh);}
  $mu="../upload/".$userid."/";
  inp_tp_upload(1,$mu,$bh."-".$tcid,"xls");
  //导入开始
  require_once '../config/Excel/reader.php';
  $data = new Spreadsheet_Excel_Reader();
  $data->setOutputEncoding('CP936');
  $data->read($mu.$bh."-".$tcid.".xls");
  error_reporting(E_ALL ^ E_NOTICE);
  for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
  $ka= $data->sheets[0]['cells'][$i][1]."";
  $mi= $data->sheets[0]['cells'][$i][2]."";
   if(panduan("probh,tcid,userid,ka","yjcode_taocan_kc where probh='".$bh."' and tcid=".$tcid." and ka='".$ka."' and userid=".$userid)==0){
   intotable("yjcode_taocan_kc","probh,tcid,userid,ka,mi,ifok","'".$bh."',".$tcid.",".$userid.",'".$ka."','".$mi."',0");
   }
  }
  //导入结束
  delFile($mu.$bh."-".$tcid.".xls");
  }
 }
 kamikc_tc($bh,$tcid);
 php_toheader("kc_tc.php?t=suc&bh=".$bh."&tcid=".$tcid);
 
}elseif($_GET[control]=="update"){
 zwzr();
 $id=$_GET[id];
 if(panduan("id,probh,tcid,userid,ka","yjcode_taocan_kc where probh='".$bh."' and ka='".sqlzhuru($_POST[tka])."' and id<>".$id." and tcid=".$tcid." and userid=".$userid)==1){
 Audit_alert("卡号已存在，保存失败!","kc_tc.php?bh=".$bh."&action=update&id=".$id."&tcid=".$tcid);}
 updatetable("yjcode_taocan_kc","ka='".sqlzhuru($_POST[tka])."',mi='".sqlzhuru($_POST[tmi])."',ifok=".sqlzhuru($_POST[Rifok])." where userid=".$userid." and id=".$id);
 kamikc_tc($bh,$tcid);
 php_toheader("kc_tc.php?t=suc&bh=".$bh."&action=update&id=".$id."&tcid=".$tcid);

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<link href="css/sell.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function tjfsonc(x){
document.getElementById("tjfs1").style.display="none";
document.getElementById("tjfs2").style.display="none";
document.getElementById("tjfs3").style.display="none";
document.getElementById("tjfs"+x).style.display="";
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
 
 <? include("protop.php");?>
 <? include("rcap3.php");?>
 <script language="javascript">
 document.getElementById("rcap4").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","kc_tc.php?id=".$_GET[id]."&bh=".$bh."&action=".$_GET[action]."&tcid=".$tcid)?>
 <? if($_GET[action]==""){?>
 <script language="javascript">
 function tj(){
  layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
  tjwait();
  f1.action="kc_tc.php?control=add&bh=<?=$bh?>&tcid=<?=$tcid?>"; 
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="inf" name="jvs" />
 <ul class="uk">
 <li class="l1">添加方式：</li>
 <li class="l2">
 <label><input name="Rtjfs" type="radio" value="txt" onclick="tjfsonc(3)" checked="checked" /> 文本内容</label>
 <label><input name="Rtjfs" type="radio" value="one" onclick="tjfsonc(1)" /> 单一添加</label>
 <label><input name="Rtjfs" type="radio" value="more" onclick="tjfsonc(2)" /> 批量上传</label>
 </li>
 </ul>

 <ul class="uk uk0" id="tjfs3">
 <li class="l1">说明：</li>
 <li class="l21 red">导入格式为卡号+空格+密码(可跟上附加内容)，一行一组，如AAAAA BBBBB</li>
 <li class="l9">卡密内容：</li>
 <li class="l10"><textarea name="s1"></textarea></li>
 </ul>

 <ul class="uk uk0" id="tjfs1" style="display:none;">
 <li class="l1">卡号：</li>
 <li class="l2"><input type="text" class="inp" size="80" name="tka" /></li>
 <li class="l1">密码：</li>
 <li class="l2"><input type="text" class="inp" size="80" name="tmi" /></li>
 </ul>
 
 <ul class="uk uk0" id="tjfs2" style="display:none;">
 <li class="l1">选择文件：</li>
 <li class="l2"><input type="file" name="inp1" id="inp1" size="25"></li>
 <li class="l5"></li>
 <li class="l6">
 上传格式为xls文件，即excel，程序会自动识别，但必须保证符合规则，<strong class="red">第一列为卡号，第二列为密码</strong>，如下图<br>
 <img src="img/xls.gif" width="270" height="76" style="margin:10px 0 0 0;" />
 </li>
 </ul>
 
 <ul class="uk uk0">
 <li class="l3"><? tjbtnr("保存","kclist_tc.php?bh=".$bh."&tcid=".$tcid)?></li>
 </ul>
 </form>
 
 <?
 }else{
 while0("*","yjcode_taocan_kc where userid=".$luserid." and id=".$_GET[id]);if(!$row=mysql_fetch_array($res)){php_toheader("kclist_tc.php?bh=".$bh."&tcid=".$tcid);}
 ?>
 <script language="javascript">
 function tj(){
  layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
  tjwait();
  f1.action="kc_tc.php?control=update&bh=<?=$bh?>&id=<?=$_GET[id]?>&tcid=<?=$tcid?>"; 
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <input type="hidden" value="inf" name="jvs" />
 <ul class="uk">
 <li class="l1">卡号：</li>
 <li class="l2"><input type="text" class="inp" size="80" value="<?=$row[ka]?>" name="tka" /></li>
 <li class="l1">密码：</li>
 <li class="l2"><input type="text" class="inp" size="80" value="<?=$row[mi]?>" name="tmi" /></li>
 <li class="l1">使用情况：</li>
 <li class="l2">
 <label><input name="Rifok" type="radio" value="0"<? if(empty($row[ifok])){?> checked="checked"<? }?> /> 未使用</label>
 <label><input name="Rifok" type="radio" value="1"<? if(1==$row[ifok]){?> checked="checked"<? }?> /> 已使用</label>
 </li>
 <li class="l3"><? tjbtnr("保存","kclist_tc.php?bh=".$bh."&tcid=".$tcid)?></li>
 </ul>
 </form>
 <? }?>

 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>