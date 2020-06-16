<?php
include("../config/conn.php");
include("../config/function.php");
include("../config/tpclass.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_user where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("userlist.php");}

//函数开始
if($_GET[control]=="update"){
 if(!strstr($adminqx,",0,") && !strstr($adminqx,",0701,")){Audit_alert("权限不够","default.php");}
 zwzr();
  $shopzt=sqlzhuru($_POST[R1]);
  //邮箱通知开店成功
if(2==$shopzt and !empty($row[email]) and $row[shopzt]!=2){
	require("../config/mailphp/sendmail.php");
	$au=returnmyweb($row[id],$row[myweb]);
	$txt="尊敬的".$row[nc]."您好：<br>您在".webname."(".weburl.")申请开通店铺审核通过！<br>店铺名称：".$row[shopname]."<br>站长QQ：".$row[uqq]."<br>店铺地址：".$au."<br><br><hr>开店审核通过！(如果不是您本人操作，请不用理会该邮件)，".weburl;;
	yjsendmail(sqlzhuru($_POST[tshopname])."--店铺审核通过！【商业源码】",$row[email],$txt);	
} 
if(3==$shopzt and !empty($row[email]) and $row[shopzt]!=3){
	require("../config/mailphp/sendmail.php");
	$au=returnmyweb($row[id],$row[myweb]);
	$txt="尊敬的".$row[nc]."您好：<br>您在".webname."(".weburl.")开店审核已被平台拒绝！(平台暂不对外开放，申请入驻，感谢您的支持与配合)，<br>".weburl;;
	yjsendmail(sqlzhuru($_POST[tshopname])."--店铺审核不通过！【商业源码】",$row[email],$txt);	
} 
 $shopzt=sqlzhuru($_POST[R1]);
 if(2==$shopzt){
  $ses="openshop=0,openshop1=0,";
  if(!empty($row[openshop1])){
   PointUpdateB($row[id],$row[openshop1],1);
   PointIntoB($row[id],"开店审核通过，保证金生效",$row[openshop1]);
  }
 }
 if(3==$shopzt){
  $ses="openshop=0,openshop1=0,";
  if(!empty($row[openshop])){
   PointUpdateM($row[id],$row[openshop]);
   PointIntoM($row[id],"开店申请被拒，费用退还",$row[openshop]);
  }
 }
 $dqsj=sqlzhuru($_POST[tdqsj]);
 if(!empty($dqsj)){$ses=$ses."dqsj='".$dqsj."',";}
 updatetable("yjcode_user",$ses."
			 shopname='".sqlzhuru($_POST[tshopname])."',
			 seokey='".sqlzhuru($_POST[tseokey])."',
			 seodes='".sqlzhuru($_POST[tseodes])."',
			 txt='".sqlzhuru1($_POST[content])."',
			 pm=".sqlzhuru($_POST[tpm]).",
			 djl=".sqlzhuru($_POST[tdjl]).",
			 shopzt=".$shopzt.",
			 shopztsm='".sqlzhuru($_POST[tshopztsm])."',
			 shoptype=".sqlzhuru($_POST[dshoptype]).",
			 sellbl=".sqlzhuru($_POST[tsellbl]).",
			 xinyong=".sqlzhuru($_POST[txinyong])." 
			 where id=".$id);
 uploadtpnodata(1,"upload/".$id."/","shop.jpg","allpic",300,300,0,0,"no");
 uploadtpnodata(2,"upload/".$id."/","bannar.jpg","allpic",1920,0,0,0,"no");
 
 $myweb=trim(sqlzhuru($_POST[tmyweb]));
 if(!empty($myweb)){
  if(panduan("id,myweb","yjcode_user where myweb='".$myweb."' and id<>".$id."")==1){Audit_alert("该自定义网址已经被使用，请更换！","shop.php?id=".$id);}
  if(!preg_match("/^[_a-zA-Z0-9]*$/",$myweb)){Audit_alert("自定义地址必须为数字或字母！","shop.php?id=".$id);}
  updatetable("yjcode_user","myweb='".$myweb."' where id=".$id);
 }
 
 if($shopzt!=2){updatetable("yjcode_pro","ifxj=1 where userid=".$id);}
 
 php_toheader("shop.php?t=suc&id=".$id);
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
<script language="javascript" src="js/adddate.js"></script>
<script language="javascript">
function tj(){
 if((document.f1.tshopname.value).replace("/\s/","")==""){alert("请输入店铺名称");document.f1.tshopname.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="shop.php?control=update&id=<?=$id?>";
}
function shopztonc(x){
 if(3==x){$("shopztv").style.display="";}else{$("shopztv").style.display="none";}
}
</script>

<script type="text/javascript" src="js/adddate.js" ></script> 

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=1;include("menu_user.php");?>

<div class="right">
 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","shop.php?id=".$id);}?>
 <? include("rightcap3.php");?>
 <script language="javascript">document.getElementById("rtit2").className="a1";</script>
 <!--B-->
 <div class="rkuang">
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <ul class="uk">
 <li class="l1">店铺审核状态：</li>
 <li class="l21"><strong><?=returnshopztv($row[shopzt])?></strong></li>
 <li class="l1"><span class="red">*</span> 店铺名称：</li>
 <li class="l2"><input type="text" size="30" value="<?=$row[shopname]?>" class="inp" name="tshopname" /></li>
 <li class="l1"><span class="red">*</span> 店铺类型：</li>
 <li class="l2">
 <select name="dshoptype" class="inp">
 <? for($i=0;$i<=2;$i++){?>
 <option value="<?=$i?>"<? if($i==$row[shoptype]){?> selected="selected"<? }?>><?=returnshoptype($i)?></option>
 <? }?>
 </select>
 </li>
 <li class="l1"><span class="red">*</span> 自定义地址：</li>
 <li class="l2"><span class="fd" style="margin-left:0;margin-right:10px;"><?=weburl?>vip</span><input type="text" size="20" value="<?=$row[myweb]?>" class="inp" name="tmyweb" /><span class="fd">(提示：数字、字母自由组合)</span></li>
 <li class="l1">店铺LOGO：</li>
 <li class="l2"><input type="file" name="inp1" id="inp1" class="inp1" size="15" accept=".jpg,.gif,.jpeg,.png"></li>
 <li class="l8"></li>
 <li class="l9"><img src="../upload/<?=$id?>/shop.jpg?t=<?=rnd_num(100)?>" width="54" height="54" /></li>
 <li class="l1">店铺通栏：</li>
 <li class="l2"><input type="file" name="inp2" class="inp1" id="inp2" size="15" accept=".jpg,.gif,.jpeg,.png"><span class="fd">最佳尺寸：1920*120</span></li>
 <li class="l8"></li>
 <li class="l9"><img src="../upload/<?=$id?>/bannar.jpg?t=<?=rnd_num(100)?>" width="54" height="54" /></li>
 <li class="l1">店铺关键词：</li>
 <li class="l2"><input  name="tseokey" value="<?=$row[seokey]?>" size="60" type="text" class="inp" /></li>
 <li class="l4">简要描述：</li>
 <li class="l5"><textarea name="tseodes"><?=$row[seodes]?></textarea></li>
 <li class="l10">详细描述：</li>
 <li class="l11"><script id="editor" name="content" type="text/plain" style="width:858px;height:330px;"><?=$row[txt]?></script></li>
 </ul>
 
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="uk">
 <li class="l1">交易收入比例：</li>
 <li class="l2">
 <input name="tsellbl" value="<?=$row[sellbl]?>" size="5" type="text" class="inp" />
 <span class="fd hui">交易成功后，卖家可获得的金额比例 <span class="red">1表示全归卖家，0.9表示90%归卖家，0.5表示50%归卖家</span>，依次类推</span>
 </li>
 <li class="l1">店铺到期：</li>
 <li class="l2"><input class="inp" readonly="readonly" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss')" name="tdqsj" value="<?=$row[dqsj]?>" size="20" type="text"/></li>
 <li class="l1">推荐排名：</li>
 <li class="l2"><input type="text" size="5" value="<?=$row[pm]?>" class="inp" name="tpm" /><span class="fd">0表示不推荐，反之从小到大排序</span></li>
 <li class="l1">店铺信用：</li>
 <li class="l2"><input type="text" size="5" value="<?=returnjgdw($row[xinyong],"",0)?>" class="inp" name="txinyong" /><span class="fd">0表示读取常规信用值，反之读取该值</span></li>
 <li class="l1">店铺点击率：</li>
 <li class="l2"><input type="text" size="5" value="<?=$row[djl]?>" class="inp" name="tdjl" /></li>
 <li class="l1">店铺审核：</li>
 <li class="l2">
 <label><input name="R1" type="radio" onclick="shopztonc(0)" value="0"<? if(0==$row[shopzt]){?> checked="checked"<? }?> />未提交申请</label>
 <label><input name="R1" type="radio" onclick="shopztonc(0)" value="1"<? if(1==$row[shopzt]){?> checked="checked"<? }?> />正在审核</label>
 <label><input name="R1" type="radio" onclick="shopztonc(0)" value="2"<? if(2==$row[shopzt]){?> checked="checked"<? }?> />正常开店</label>
 <label><input name="R1" type="radio" onclick="shopztonc(3)" value="3"<? if(3==$row[shopzt]){?> checked="checked"<? }?> />拒绝申请</label>
 <label><input name="R1" type="radio" onclick="shopztonc(4)" value="4"<? if(4==$row[shopzt]){?> checked="checked"<? }?> />店铺到期</label>
 </li>
 <li class="l1">店铺操作提示：</li>
 <li class="l21 red">变更为非正常开店的任何状态，该用户发布的所有商品均会下架</li>
 </ul>
 <ul class="uk uk0" id="shopztv" style="display:none;">
 <li class="l1">特别说明：</li>
 <li class="l21 red">如果拒绝申请，则会员缴纳的费用将退回至其会员帐号中。通过申请，不会自动扣费。因此请慎重该操作</li>
 <li class="l1">被拒原因：</li>
 <li class="l2"><input type="text" class="inp" name="tshopztsm" size="90" value="<?=$row[shopztsm]?>" /></li>
 </ul>
 <ul class="uk uk0">
 <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
 </ul>
 </form>
 <script language="javascript">
 shopztonc(<?=$row[shopzt]?>);
 </script>
 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
<script type="text/javascript">
//实例化编辑器
var ue = UE.getEditor('editor');
</script>
</body>
</html>