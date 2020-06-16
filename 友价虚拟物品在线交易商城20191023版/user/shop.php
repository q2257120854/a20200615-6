<?
include("../config/conn.php");
include("../config/function.php");
include("../config/tpclass.php");
sesCheck();

if(sqlzhuru($_POST[jvs])=="shop"){
 zwzr();
 $t1=sqlzhuru($_POST[t1]);
 $t2=sqlzhuru($_POST[t2]);
 $s1=sqlzhuru($_POST[s1]);
 if(empty($t1) || empty($t2) || empty($s1)){Audit_alert("信息不完整，返回重试！","shop.php");}
 $userid=returnuserid($_SESSION[SHOPUSER]);
 if(panduan("*","yjcode_user where shopname='".$t1."' and uid<>'".$_SESSION[SHOPUSER]."'")==1){Audit_alert("店铺名称已经被其他用户使用，返回重试！","shop.php");}
 updatetable("yjcode_user","shopname='".$t1."',seokey='".$t2."',seodes='".$s1."',txt='".sqlzhuru1($_POST[content])."' where uid='".$_SESSION[SHOPUSER]."'");
 uploadtpnodata(1,"upload/".$userid."/","shop.jpg","allpic",300,300,0,0,"no");
 uploadtpnodata(2,"upload/".$userid."/","bannar.jpg","allpic",1920,0,0,0,"no");

 $myweb=trim(sqlzhuru($_POST[tmyweb]));
 if(!empty($myweb)){
  if(panduan("id,myweb","yjcode_user where myweb='".$myweb."' and id<>".$userid."")==1){Audit_alert("该自定义网址已经被使用，请更换！","shop.php");}
  if(!preg_match("/^[_a-zA-Z0-9]*$/",$myweb)){Audit_alert("自定义地址必须为数字或字母！","shop.php");}
  updatetable("yjcode_user","myweb='".$myweb."' where id=".$userid);
 }else{
  updatetable("yjcode_user","myweb='' where id=".$userid);
 }

 php_toheader("shop.php?t=suc"); 
}

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."' and shopzt=2";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("openshop3.php");}
$usertx="../upload/".$rowuser[id]."/shop.jpg";
if(!is_file($usertx)){$usertx="img/nonetx.gif";}else{$usertx=$usertx."?id=".rnd_num(1000);}
$bannar="../upload/".$rowuser[id]."/bannar.jpg";
if(!is_file($bannar)){$bannar="img/nonetx.gif";}else{$bannar=$bannar."?id=".rnd_num(1000);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理面板 - <?=webname?></title>
<? include("cssjs.html");?>
<script type="text/javascript" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script language="javascript">
function tj(){
if((document.f1.t1.value).replace(/\s/,"")==""){alert("请输入店铺名称");document.f1.t1.focus();return false;}	
if((document.f1.t2.value).replace(/\s/,"")==""){alert("请输入主营产品");document.f1.t2.focus();return false;}	
if((document.f1.s1.value).replace(/\s/,"")==""){alert("请输入店铺简要描述");document.f1.s1.focus();return false;}	
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
tjwait();
f1.action="shop.php";
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
 
 <? include("rcap4.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","shop.php")?>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="shop" name="jvs" />
 <ul class="uk">
 <li class="l1">店铺到期：</li>
 <li class="l21"><?=$rowuser[dqsj]?> [<a href="openshop4.php">续费</a>]</li>
 <li class="l1">店铺名称：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$rowuser[shopname]?>" name="t1" /></li>
 <li class="l1">自定义地址：</li>
 <li class="l2"><span class="fd"><?=weburl?>vip</span><input type="text" size="20" value="<?=$rowuser[myweb]?>" class="inp" name="tmyweb" /><span class="fd">(提示：数字、字母自由组合)</span></li>
 <li class="l1">店铺LOGO：</li>
 <li class="l2"><input type="file" name="inp1" class="inp" id="inp1" size="25"><span class="fd">最佳尺寸：300*300</span></li>
 <li class="l5"></li>
 <li class="l6"><img src="<?=$usertx?>" width="100" height="100" /></li>
 <li class="l1">店招横幅：</li>
 <li class="l2"><input type="file" name="inp2" class="inp" id="inp2" size="25"><span class="fd">最佳尺寸：1920*120</span></li>
 <li class="l5"></li>
 <li class="l6"><img src="<?=$bannar?>" width="100" height="100" /></li>
 <li class="l1">主营产品：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$rowuser[seokey]?>" name="t2" size="60" /></li>
 <li class="l9">店铺简要描述：</li>
 <li class="l10"><textarea name="s1"><?=$rowuser[seodes]?></textarea></li>
 <li class="l7">详细描述：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"><?=$rowuser[txt]?></script></li>
 <li class="l3"><?=tjbtnr("保存修改")?></li>
 </ul>
 </form>
 
 </div>
 <!--白E-->

</div> 
<!--RE-->

</div>

<script language="javascript">
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
<div class="clear clear15"></div>
<? include("../tem/bottom.html");?>
</body>
</html>