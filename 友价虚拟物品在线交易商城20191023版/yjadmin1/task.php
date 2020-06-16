<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
$sj=date("Y-m-d H:i:s");

$sqltask="select * from yjcode_task where id=".$id." and taskty=0";mysql_query("SET NAMES 'GBK'");$restask=mysql_query($sqltask);
if(!$rowtask=mysql_fetch_array($restask)){php_toheader("tasklist.php");}
$bh=$rowtask[bh];

if(!empty($rowtask[useridhf])){
$sqltaskhf="select * from yjcode_taskhf where bh='".$bh."' and taskty=0 and useridhf=".$rowtask[useridhf]."";mysql_query("SET NAMES 'GBK'");$restaskhf=mysql_query($sqltaskhf);
if(!$rowtaskhf=mysql_fetch_array($restaskhf)){php_toheader("tasklist.php");}
}


if($_GET[control]=="update" && $_POST[jvs]=="zt8"){
 
 if(8==$rowtask[zt]){ //纠纷
  $zt=intval($_POST[Rzt]);
  if(0==$zt){
   PointIntoM($rowtask[userid],"任务失败，平台介入，退回款项(任务编号".$bh.")",$rowtask[money3]);
   PointUpdateM($rowtask[userid],$rowtask[money3]);
   updatetable("yjcode_task","zt=9 where id=".$id);
   $txt="判定雇主胜利";
   intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$rowtask[useridhf].",3,'".$txt."','".$sj."',''");
   if(!empty($rowtask[jsbao])){
    PointIntoB($rowtask[userid],"平台介入判定雇主胜利，获赔保证金",$rowtask[jsbao],2);
    PointUpdateB($rowtask[userid],$rowtask[jsbao]); 
   }
  }elseif(1==$zt){
   PointIntoM($rowtask[useridhf],"任务纠纷胜诉，平台介入，获得佣金(任务编号".$bh.")",$rowtask[money2]);
   PointUpdateM($rowtask[useridhf],$rowtask[money2]);
   if(1==$rowtask[yjfs]){
   $m=$rowcontrol[taskyj]*$rowtask[money2]*(-1);
   PointIntoM($rowtask[useridhf],"任务完成，扣除平台中介费(任务编号".$bh.")",$m);
   PointUpdateM($rowtask[useridhf],$m);
   }elseif(2==$rowtask[yjfs]){
   $m=$rowcontrol[taskyj]*$rowtask[money2]*(-1)*0.5;
   PointIntoM($rowtask[useridhf],"任务完成，扣除平台中介费(任务编号".$bh.")",$m);
   PointUpdateM($rowtask[useridhf],$m);
   }
   updatetable("yjcode_task","zt=5 where id=".$id);
   $txt="判定接手方胜利";
   intotable("yjcode_tasklog","bh,userid,useridhf,admin,txt,sj,fj","'".$bh."',".$rowtask[userid].",".$rowtask[useridhf].",3,'".$txt."','".$sj."',''");
   if(!empty($rowtask[jsbao])){
    PointIntoB($rowtask[useridhf],"平台介入判定接手方胜利，退回任务保证金",$rowtask[jsbao],2);
    PointUpdateB($rowtask[useridhf],$rowtask[jsbao]); 
   }
  }
 
 }
 
 php_toheader("task.php?t=suc&id=".$id);

}elseif($_GET[control]=="update" && $_POST[jvs]=="zt1"){
 if(1==$rowtask[zt]){
  $zt=intval($_POST[Rzt]);
  if($zt==0){
  $endsj=date("Y-m-d H:i:s",strtotime("+".$rowtask[rwzq]." day"));
  updatetable("yjcode_task","zt=0,yxq='".$endsj."' where id=".$id);
  }
  elseif($zt==1){
   if($rowtask[money4]>0){
   PointIntoM($rowtask[userid],"任务审核不通过，订金退回(任务编号".$rowtask[bh].")",$rowtask[money4]);
   PointUpdateM($rowtask[userid],$rowtask[money4]);
   }
  updatetable("yjcode_task","zt=2 where id=".$id);
  }
 }
 
 php_toheader("task.php?t=suc&id=".$id);


}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?=webname?>管理系统</title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/ad.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/basic.js"></script>
<script language="javascript" src="js/layer.js"></script>

<script type="text/javascript" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>

</head>
<body>
<? include("top.php");?>
<script language="javascript">
document.getElementById("menu5").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0602,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
 <? $leftid=3;include("menu_ad.php");?>

<div class="right">

 <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","task.php?id=".$id);}?>
 <div class="bqu1">
 <a href="javascript:void(0);" class="a1">单人任务</a>
 <a href="tasklist.php">返回列表</a>
 </div> 
 <!--B-->
 <div class="rkuang">
 <script language="javascript">
 function tj(){
 r=document.getElementsByName("Rzt");rr="";for(i=0;i<r.length;i++){if(r[i].checked==true){rr=r[i].value;}}if(rr==""){alert("请选择交易状态！");return false;}
 if(!confirm("确定提交操作吗？")){return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 f1.action="task.php?id=<?=$id?>&control=update";
 }
 </script>
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="rcap"><li class="l1"></li><li class="l2">任务主题</li><li class="l3"></li></ul>
 <? 
 while2("*","yjcode_user where id=".$rowtask[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="viewul">
 <li class="l1">任务主题：</li>
 <li class="l2"><a href="../task/view<?=$rowtask[id]?>.html" target="_blank"><strong><?=$rowtask[tit]?></strong></a></li>
 <li class="l1">雇主昵称：</li>
 <li class="l3"><?=$row2[nc]?></li>
 <li class="l1">联系QQ：</li>
 <li class="l3"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$row2[uqq]?>&site=<?=weburl?>&menu=yes" target="_blank"><?=$row2[uqq]?></a></li>
 <li class="l1">联系电话：</li>
 <li class="l3"><?=$row2[mot]?></li>
 <li class="l1">任务预算：</li>
 <li class="l3"><strong class="feng">￥<?=$rowtask[money1]?></strong></li>
 <li class="l1">任务状态：</li>
 <li class="l3"><?=returntask($rowtask[zt])?></li>
 <li class="l1">任务类型：</li>
 <li class="l3"><?=returntasktype(1,$rowtask[type1id])." ".returntasktype(2,$rowtask[type2id])?></li>
 <li class="l1">报价形式：</li>
 <li class="l3"><?=returntaskjgxs($rowtask[jgxs])?></li>
 <li class="l1">任务周期：</li>
 <li class="l3"><?=$rowtask[rwzq]?>天</li>
 <li class="l1">发布时间：</li>
 <li class="l3"><?=$rowtask[sj]?></li>
 <li class="l4">任务描述：</li>
 <li class="l5"><script id="editor" name="content" type="text/plain" style="width:853px;height:330px;"><?=$rowtask[txt]?></script></li>
 </ul>
 
 <? 
 if(!empty($rowtask[useridhf])){
 while2("*","yjcode_user where id=".$rowtaskhf[useridhf]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="rcap"><li class="l1"></li><li class="l2">接手方信息</li><li class="l3"></li></ul>
 <ul class="viewul">
 <li class="l1">中标用户：</li>
 <li class="l3"><?=$row2[nc]?></li>
 <li class="l1">联系QQ：</li>
 <li class="l3"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$row2[uqq]?>&site=<?=weburl?>&menu=yes" target="_blank"><?=$row2[uqq]?></a></li>
 <li class="l1">联系电话：</li>
 <li class="l3"><?=$row2[mot]?></li>
 <li class="l1">用户报价：</li>
 <li class="l3"><strong class="red">￥<?=$rowtaskhf[money1]?></strong></li>
 <li class="l1">中介费用：</li>
 <li class="l3">
 <? 
 if(empty($rowtask[yjfs])){echo "雇主承担，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]."</strong>";}
 elseif($rowtask[yjfs]==1){echo "接手方承担";}
 elseif($rowtask[yjfs]==2){echo "双方各承担一半，费用为<strong class='feng'>￥".$rowtaskhf[money1]*$rowcontrol[taskyj]*0.5."</strong>";}
 ?>
 </li>
 <li class="l1">用户IP：</li>
 <li class="l3"><a href="https://www.baidu.com/s?wd=<?=$rowtaskhf[uip]?>" target="_blank"><?=$rowtaskhf[uip]?></a></li>
 <li class="l1">报名时间：</li>
 <li class="l3"><?=$rowtaskhf[sj]?></li>
 <li class="l1">中标时间：</li>
 <li class="l3"><?=$rowtaskhf[zbsj]?></li>
 <li class="l1">任务截止：</li>
 <li class="l3 red"><?=$rowtaskhf[rwdq]?></li>
 <li class="l6">接手留言：</li>
 <li class="l7"><?=strip_tags(returnjgdw($rowtaskhf[txt],"","未填写任何说明"))?></li>
 </ul>
 <? }?>
 
 <ul class="rcap"><li class="l1"></li><li class="l2">管理员操作</li><li class="l3"></li></ul>
 <ul class="viewul">
 <? if(!empty($rowtask[useridhf])){?>
 <li class="l1">沟通记录：</li>
 <li class="l2"><a href="taskgt.php?bh=<?=$bh?>" class="red" target="_blank">【点击查看】</a></li>
 <? }?>
 <? if(8==$rowtask[zt]){?>
 <li class="l1">变更状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" /> <strong>判定雇主胜诉(可获赔接手方缴纳的任务保证金) </strong></label>
 <label><input name="Rzt" type="radio" value="1" /> <strong>判定接手方胜诉</strong></label> 
 </li>
 <li class="l8"><input type="submit" value="保存修改" class="btn1" /><input type="hidden" value="zt8" name="jvs" /></li>
 <? }?>
 
 <? if(1==$rowtask[zt]){?>
 <li class="l1">操作须知：</li>
 <li class="l2 red">审核状态变更后，不能再次审核，请认真核实任务内容是否合法合规</li>
 <li class="l1">变更状态：</li>
 <li class="l2">
 <label><input name="Rzt" type="radio" value="0" /> <strong>通过审核</strong></label>
 <label><input name="Rzt" type="radio" value="1" /> <strong>审核不通过</strong></label> 
 </li>
 <li class="l8"><input type="submit" value="保存修改" class="btn1" /><input type="hidden" value="zt1" name="jvs" /></li>
 <? }?>
 </ul>
 </form>
 </div>
 <!--E-->
 
</div>
</div>
<?php include("bottom.php");?>
<script type="text/javascript">
//实例化编辑器
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