<?
include("../config/conn.php");
include("../config/function.php");
include("../config/tpclass.php");
sesCheck();

$sqluser="select * from yjcode_user where uid='".$_SESSION[SHOPUSER]."'";mysql_query("SET NAMES 'GBK'");$resuser=mysql_query($sqluser);
if(!$rowuser=mysql_fetch_array($resuser)){php_toheader("../reg/");}

if(sqlzhuru($_POST[jvs])=="inf"){
 zwzr();
 $nc=sqlzhuru($_POST[tnc]);
 if(empty($nc)){Audit_alert("请输入昵称","inf.php");}
 updatetable("yjcode_user","uqq='".sqlzhuru($_POST[tuqq])."',weixin='".sqlzhuru($_POST[tweixin])."',mytxt='".sqlzhuru1($_POST[content])."' where uid='".$_SESSION[SHOPUSER]."'");
 if(panduan("uid,nc","yjcode_user where uid<>'".$_SESSION[SHOPUSER]."' and nc='".$nc."'")){Audit_alert("该昵称已被其他用户使用","inf.php");}
 updatetable("yjcode_user","nc='".$nc."' where uid='".$_SESSION[SHOPUSER]."'");
 uploadtpnodata(1,"upload/".$rowuser[id]."/","wx.jpg","allpic",150,150,0,0,"no");
 php_toheader("inf.php?t=suc"); 
}

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
 if((document.f1.tnc.value).replace("/\s/","")==""){layer.alert('请输入昵称', {icon:5});document.f1.tnc.focus();return false;}
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 tjwait();
 f1.action="inf.php";
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
 
 <? include("rcap1.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <? systs("恭喜您，操作成功!","inf.php")?>
 <form name="f1" method="post" onsubmit="return tj()" enctype="multipart/form-data">
 <input type="hidden" value="inf" name="jvs" />
 <ul class="uk">
 <li class="l1">用户帐号：</li>
 <li class="l21"><?=$_SESSION[SHOPUSER]?></li>
 <li class="l1"><span class="red" style="font-weight:normal;">*</span> 昵称：</li>
 <li class="l2"><input type="text" class="inp" name="tnc" value="<?=$rowuser[nc]?>" /></li>
 <li class="l1">邮箱地址：</li>
 <li class="l21"><?=$rowuser["email"]?> <a href="emailbd.php" class="blue">[邮箱认证]</a></li>
 <li class="l1">手机号码：</li>
 <li class="l21"><?=$rowuser[mot]?> <a href="mobbd.php" class="blue">[修改手机号码]</a></li>
 <li class="l1">QQ号码：</li>
 <li class="l2"><input type="text" class="inp" name="tuqq" value="<?=$rowuser[uqq]?>" /></li>
 <li class="l1">微信号码：</li>
 <li class="l2"><input type="text" class="inp" name="tweixin" value="<?=$rowuser[weixin]?>" /></li>
 <li class="l1">微信二维码：</li>
 <li class="l2"><input type="file" class="inp" name="inp1" id="inp1" size="25"><span class="fd">最佳尺寸：150*150</span></li>
 <? $tx="../upload/".$rowuser[id]."/wx.jpg";if(is_file($tx)){?>
 <li class="l5"></li>
 <li class="l6"><img src="<?=$tx?>?t=<?=rnd_num(100)?>" width="100" height="100" /></li>
 <? }?>
 <li class="l7">个人介绍：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"><?=$rowuser[mytxt]?></script></li>
 <li class="l3"><? tjbtnr("保存修改")?></li>
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