<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

if(panduan("*","yjcode_tasktype where admin=1")==0){Audit_alert("任务类型未设置，联系管理员先设置【管理员后台-左侧-任务分组设置】！","./");}

if($_GET[control]=="add"){
 zwzr();
 if(empty($rowuser[uqq])){Audit_alert("请先补充您的联系QQ！","taskadd.php");}
 $sj=date("Y-m-d H:i:s");
 $userid=$rowuser[id];
 $jgxs=intval($_POST[R1]);
 $money1=0;
 $money2=0;
 $jsbao=abs($_POST[tjsbao]);
 if(0==$jgxs){$money1=$_POST[tmoneyu0];}
 elseif(1==$jgxs){$money1=$_POST[tmoneyu1_1];$money2=$_POST[tmoneyu1_2];}
 $money1=abs($money1);
 $money2=abs($money2);
 $rwxs=intval($_POST[R5]);
 if($jgxs!=0){$rwxs=0;}
 if($rwxs==0){ //单人任务
 $renshu=1;
 }else{ //多人任务
 $renshu=abs($_POST[trwxsu1]);
 if(empty($renshu)){Audit_alert("人数不得为空！","taskadd.php");}
 if($money1 % $renshu!=0){Audit_alert("预算跟人数不是整除，请修改！","taskadd.php");}
 }
 $zq=intval($_POST[R2]);
 if($zq==-1){$zq=sqlzhuru($_POST[zqtext]);} 
 if(!is_numeric($zq)){$zq=0;}
 if(empty($zq)){Audit_alert("任务周期不得为0！","taskadd.php");}
 $yxq=intval($_POST[R3]);
 if($yxq==-1){$yxq=sqlzhuru($_POST[yxqtext]);} 
 if(!is_numeric($yxq)){$yxq=0;}
 $endsj=date("Y-m-d H:i:s",strtotime("+".$yxq." day"));
 $bh=time()."task".$userid;
 if(empty($rowcontrol[taskok])){$zt=1;$zt1=105;}else{$zt=0;$zt1=100;}
 $ty=preg_split("/xcf/",sqlzhuru($_POST[d1]));
 $up1=$_FILES["inp1"]["name"];
 if(!empty($up1)){
 $mc=MakePassAll(2)."-".time()."-".$userid.".".returnhz($up1);
 $lj="../upload/".$userid."/".$bh."/";
 createDir($lj);
 move_uploaded_file($_FILES["inp1"]['tmp_name'],$lj.$mc);
 }
 if(empty($rwxs)){$t="tasklist.php";$ztv=$zt;}else{$t="taskmoney.php?bh=".$bh;$ztv=$zt1;}
 intotable("yjcode_task","bh,userid,sj,lastsj,zt,tit,txt,type1id,type2id,jgxs,money1,money2,money3,money4,money5,djl,useridhf,rwzq,yxq,yjtx,qqxs,motxs,yjfs,fj,taskty,tasknum,taskcy,jsbao","'".$bh."',".$userid.",'".$sj."','".$sj."',".$ztv.",'".sqlzhuru($_POST[t1])."','".sqlzhuru1($_POST[content])."',".$ty[0].",".$ty[1].",".$jgxs.",".$money1.",".$money2.",0,0,0,0,0,".$zq.",'".$endsj."',".$_GET[yjtz].",".intval($_POST[qqxsinp]).",".intval($_POST[motxsinp]).",".intval($_POST[R4]).",'".$mc."',".$rwxs.",".$renshu.",0,".$jsbao."");
 //PointIntoM($rowuser[id],"发布任务预付订金(任务编号".$bh.")",$money4*(-1));
 //PointUpdateM($rowuser[id],$money4*(-1));
 php_toheader("../user/".$t);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>发布任务 - <?=webname?></title>
<? include("../tem/cssjs.html");?>

<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="gbk" src="../config/ueditor/unit.js"></script>

<script type="text/javascript">
function tj(){
 if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.t1.focus();return false;}	
 if(moneyv!=0 && rwxsv==1){alert("多人任务只允许一口价方式");return false;}	
 c=document.getElementsByName("C1");if(c[0].checked){cv=1;}else{cv=0;}
 if(parseInt(document.getElementById("zqtext").value)==0){alert("任务周期不得为0");document.f1.zqtext.focus();return false;}
 tjwait();
 f1.action="taskadd.php?control=add&yjtz="+cv;
}

var moneyv=0;
function moneycaponc(x){
moneyv=x;
for(i=0;i<=2;i++){
document.getElementById("moneycap"+i).className="";
document.getElementById("moneyu"+i).style.display="none";
}
document.getElementById("moneycap"+x).className="l1";
document.getElementById("moneyu"+x).style.display="";
}

var rwxsv=0;
function rwxsonc(x){
rwxsv=x;
for(i=0;i<=1;i++){
document.getElementById("rwxs"+i).className="";
document.getElementById("rwxsu"+i).style.display="none";
}
document.getElementById("rwxs"+x).className="l1";
document.getElementById("rwxsu"+x).style.display="";
}

function zqonc(x){
if(x==-1){document.getElementById("zqtext").style.display="";zqcha();}
else{
 document.getElementById("zqtext").style.display="none";
 document.getElementById("zqtext").value=x;
 if(x!=0){document.getElementById("zqs1").innerHTML=x+"天";}
}
}
function zqcha(){
document.getElementById("zqs1").innerHTML=document.getElementById("zqtext").value+"天";
}

function yxqonc(x){
if(x==-1){document.getElementById("yxqtext").style.display="";yxqcha();}
else{
 document.getElementById("yxqtext").style.display="none";
 if(x!=0){document.getElementById("zqs2").innerHTML=x+"天";}else{document.getElementById("zqs2").innerHTML="自己报的";}
}
}
function yxqcha(){
document.getElementById("zqs2").innerHTML=document.getElementById("yxqtext").value+"天";
}

function qqxsover(){
 document.getElementById("qqxsm").style.display="";
}

function qqxsout(){
 document.getElementById("qqxsm").style.display="none";
}

function motxsover(){
 document.getElementById("motxsm").style.display="";
}

function motxsout(){
 document.getElementById("motxsm").style.display="none";
}

function qqxsonc(x,y){
document.f1.qqxsinp.value=x;
document.getElementById("qqxs").innerHTML=y;
qqxsout();
}

function motxsonc(x,y){
document.f1.motxsinp.value=x;
document.getElementById("motxs").innerHTML=y;
motxsout();
}
</script>
</head>
<body>
<? include("../tem/top.html");?>
<? include("../tem/top1.html");?>
<div class="yjcode">
 <div class="dqwz">
 <ul class="u1">
 <li class="l1">当前位置：<a href="<?=weburl?>">首页</a> > <a href="./">任务大厅</a> > 发布新任务</li></ul>
 </div>
 
 <div class="tleft fontyh">
  <? if(empty($rowuser[uqq])){?>
  <div class="errts">请先补充您的QQ号码，才能发起任务。【<a href="../user/inf.php" target="_blank">点击补充</a>】</div>
  <? }?>
  <form name="f1" method="post" onSubmit="return tj()" enctype="multipart/form-data">
  <ul class="u1">
  <li class="l1">01、一句话描述您的需求</li>
  <li class="l2"><input type="text" class="inp fontyh" autocomplete="off" disableautocomplete style="width:740px;" name="t1" /></li>
  <li class="l1">02、将需求说的详细些</li>
  <li class="l3"><script id="editor" name="content" type="text/plain" style="width:764px;height:380px;"></script></li>
  <li class="lf">上传附件：</li>
  <li class="lf1"><input type="file" name="inp1" id="inp1" size="25"></li>
  <li class="l1">03、类型</li>
  <li class="l2">
  <select name="d1" class="fontyh">
  <? while1("*","yjcode_tasktype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <option value="<?=$row1[id]?>xcf0"><?=$row1[name1]?></option>
  <? while2("*","yjcode_tasktype where admin=2 and name1='".$row1[name1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){?>
  <option value="<?=$row1[id]?>xcf<?=$row2[id]?>">-----<?=$row2[name2]?></option>
  <? }?>
  <? }?>
  </select>
  </li>
  <li class="l1">04、任务金额</li>
  </ul>
  <div class="moneycap">
  <label class="l1" id="moneycap0" onClick="moneycaponc(0)"><input name="R1" type="radio" value="0" checked> <span>一口价</span></label>
  <label id="moneycap1" onClick="moneycaponc(1)"><input name="R1" type="radio" value="1"> <span>范围报价</span></label>
  <label id="moneycap2" onClick="moneycaponc(2)"><input name="R1" type="radio" value="2"> <span>开放报价</span></label>
  </div>
  <ul class="moneyu" id="moneyu0">
  <li class="l1">
  <strong>一口价说明：</strong><br>
  1.当服务商觉得能完成任务且能接受您的任务酬金时，则可以报名参加接单；<br>
  2.之后您可在报名列表中选择雇佣您看中的服务商来完成您的任务。  
  </li>
  <li class="l2">
  <span class="s1">您愿支付的一口价金额：</span>
  <input type="text" name="tmoneyu0" />
  <span class="s2">元</span>
  </li>
  </ul>
  <ul class="moneyu" id="moneyu1" style="display:none;">
  <li class="l1">
  <strong>范围报价说明：</strong><br>
  1.您可以选择一个预算范围，服务商可以在此范围内进行报价；<br>
  2.之后您可在报价列表中选择雇佣您觉得合适的服务商来完成您的任务。
  </li>
  <li class="l2">
  <span class="s1">您的预算金额范围：</span>
  <input type="text" name="tmoneyu1_1" />
  <span class="s2">~</span>
  <input type="text" name="tmoneyu1_2" />
  <span class="s2">元</span>
  </li>
  </ul>
  <ul class="moneyu" id="moneyu2" style="display:none;">
  <li class="l1">
  <strong>开放报价说明：</strong><br>
  <b class="blue">1.不设置预算价格和范围，由服务商自由报价。</b><br>
  2.之后您可在报价列表中选择雇佣您觉得合适的服务商来完成您的任务。
  </li>
  </ul>
  <ul class="jsu" style="display:none;">
  <li class="l1">接手保证金：</li>
  <li class="l2"><input type="text" name="tjsbao" value="0" /><span class="fd">元 （对方接手任务需要冻结的保证金，对方没完成，你可以获赔这笔保证金）</span></li>
  </ul>
  
  <ul class="u1">
  <li class="l1">05、任务形式</li>
  </ul>
  <div class="rwxs">
  <label class="l1" id="rwxs0" onClick="rwxsonc(0)"><input name="R5" type="radio" value="0" checked> <span>单人任务</span></label>
  <label id="rwxs1" onClick="rwxsonc(1)"><input name="R5" type="radio" value="1"> <span>多人任务</span></label>
  </div>
  <ul class="rwxsu" id="rwxsu0">
  <li class="l1">
  <strong>单人任务说明：</strong><br>
  1.任务只允许一个用户接手；<br>
  </li>
  </ul>
  <ul class="rwxsu" id="rwxsu1" style="display:none;">
  <li class="l1">
  <strong>多人任务说明：</strong><br>
  1.金额与人数必须为整除关系，如100元10人为正确示例；而100元9人是无效示例；<br>
  <span class="red">2.多人任务只允许一口价任务条件下选择。  </span>
  </li>
  <li class="l2">
  <span class="s1">输入任务人数：</span>
  <input type="text" name="trwxsu1" />
  <span class="s2">人</span>
  </li>
  </ul>

  
  <ul class="u1">
  <li class="l1">06、平台中介费用</li>
  </ul>
  <div class="zhouqi">
  <ul class="zqu">
  <li class="l1">方<br>式</li>
  <li class="l2">
  <span class="s1">
  <label><input name="R4" type="radio" value="0" checked> 雇主承担</label>
  <label><input name="R4" type="radio" value="1"> 接手方承担</label>
  <label><input name="R4" type="radio" value="2"> 双方各承担一半</label>
  </span>
  <span class="s2">交易完成后，平台将收取成交金额<strong class="red"><?=$rowcontrol[taskyj]*100?>%</strong>的佣金</span>
  </li>
  </ul>
  </div>
  
  <ul class="u1">
  <li class="l1">07、任务周期、有效期</li>
  </ul>
  <div class="zhouqi">
  <ul class="zqu">
  <li class="l1">周<br>期</li>
  <li class="l2">
  <span class="s1">
  <label><input name="R2" type="radio" value="1" onClick="zqonc(1)"> 1天</label>
  <label><input name="R2" type="radio" value="3" onClick="zqonc(3)" checked> 3天</label>
  <label><input name="R2" type="radio" value="7" onClick="zqonc(7)"> 7天</label>
  <label><input name="R2" type="radio" value="10" onClick="zqonc(10)"> 10天</label>
  <label><input name="R2" type="radio" value="-1" onClick="zqonc(-1)"> 自定义</label>
  <input type="text" name="zqtext" id="zqtext" onKeyUp="zqcha()" value="15" class="zqt" style="display:none;" />
  </span>
  <span class="s2">您需服务商在<strong id="zqs1">1天</strong>时间内来完成此任务。</span>
  </li>
  </ul>
  <ul class="zqu zqu1">
  <li class="l1">有<br>效<br>期</li>
  <li class="l2">
  <span class="s1">
  <label><input name="R3" type="radio" value="3" onClick="yxqonc(3)" checked> 3天</label>
  <label><input name="R3" type="radio" value="7" onClick="yxqonc(7)"> 7天</label>
  <label><input name="R3" type="radio" value="15" onClick="yxqonc(15)"> 15天</label>
  <label><input name="R3" type="radio" value="30" onClick="yxqonc(30)"> 30天</label>
  <label><input name="R3" type="radio" value="90" onClick="yxqonc(90)"> 90天</label>
  <label><input name="R3" type="radio" value="-1" onClick="yxqonc(-1)"> 自定义</label>
  <input type="text" name="yxqtext" id="yxqtext" onKeyUp="yxqcha()" class="zqt" style="display:none;" />
  </span>
  <span class="s2">即该任务<strong id="zqs2">3天</strong>内允许报名、报价，此期间您可以随时雇佣合适的服务商来完成任务；<br>但最迟需在<strong id="zqs3">3</strong>天任务截止报名、报价后的3天内选择雇佣服务商，否则系统自动关闭任务。</span>
  </li>
  </ul>
  </div>
  
  <ul class="u1">
  <li class="l1">08、联系方式</li>
  </ul>
  <ul class="lxfs">
  <li class="l1">提醒：若您需要修改联系信息可在<a href="../user/inf.php" target="_blank">个人资料</a>和<a href="../user/mobbd.php" target="_blank">手机绑定</a>中修改。（也可以发布任务后再修改）</li>
  <li class="l2">QQ：</li>
  <li class="l3" onMouseOver="qqxsover()" onMouseOut="qqxsout()">
   <span id="qqxs" class="xs">投标服务商可见</span>
   <span id="qqxsm" class="xsm" style="display:none;">
   <a href="javascript:void(0);" onClick="qqxsonc(1,'投标服务商可见')">投标服务商可见</a>
   <a href="javascript:void(0);" onClick="qqxsonc(0,'登录(非游客)可见')">登录(非游客)可见</a>
   <a href="javascript:void(0);" onClick="qqxsonc(2,'中标服务商可见')">中标服务商可见</a>
   </span>
   <input type="hidden" value="1" id="qqxsinp" name="qqxsinp" />
  </li>
  <li class="l2 l21">电话：</li>
  <li class="l3" onMouseOver="motxsover()" onMouseOut="motxsout()">
   <span id="motxs" class="xs">投标服务商可见</span>
   <span id="motxsm" class="xsm" style="display:none;">
   <a href="javascript:void(0);" onClick="motxsonc(1,'投标服务商可见')">投标服务商可见</a>
   <a href="javascript:void(0);" onClick="motxsonc(0,'登录(非游客)可见')">登录(非游客)可见</a>
   <a href="javascript:void(0);" onClick="motxsonc(2,'中标服务商可见')">中标服务商可见</a>
   </span>
   <input type="hidden" value="1" id="motxsinp" name="motxsinp" />
  </li>
  </ul>

  <ul class="u1">
  <li class="l1">09、辅助选项</li>
  </ul>
  <div class="fuzhu">
  <label><input name="C1" type="checkbox" value=""><span>有人报名、报价请邮件提醒我</span></label>
  </div>

  <ul class="u1">
  <li class="l6"><? tjbtnr("提交任务")?></li>
  </ul>
  </form>
 </div>
 
  <div class="xqright">
   <h2><?=webname?>为您承诺</h2>
   <ul class="u1">
   <li class="l1">商家100%严格审核认证</li>
   <li class="l2">商品有问题，全额退款</li>
   <li class="l3">平台担保，交易无忧</li>
   <li class="l4">提供专业售后服务，放心购买</li>
   </ul>
   <h3>不会发需求？</h3>
   <div class="tel">全国统一服务热线<br><strong><?=$rowcontrol[webtelv]?></strong></div>
  </div>

</div>
<? include("../tem/bottom.html");?>
<script type="text/javascript">

var ue= UE.getEditor('editor'

, {

            toolbars:[

            ['fullscreen', 'source', '|', 'undo', 'redo', '|',

                'removeformat', 'formatmatch' ,'|', 'forecolor',

                 'fontsize', '|',

                'link', 'unlink',

                'insertimage', 'emotion', 'attachment']

        ]

        });
</script>
</body>
</html>