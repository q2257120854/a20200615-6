<?
include("../config/conn.php");
include("../config/function.php");
$admin=intval($_GET[admin]);
$id=intval($_GET[id]);
if(empty($admin) || empty($id)){Audit_alert("来源错误！",weburl,"parent.");}
if($admin==1){
 while0("*","yjcode_pro where id=".$id);if(!$row=mysql_fetch_array($res)){Audit_alert("来源错误！",weburl,"parent.");}
 $tit=$row[tit];
}

//举报B
if($_GET[control]=="jb"){
 zwzr();
 if(strtolower($_SESSION["authnum_session"])!=strtolower(sqlzhuru($_POST["t1"]))){Audit_alert("验证码不正确，返回修改验证码！","jubao.php?admin=".$admin."&id=".$id);}
 $sj=date("Y-m-d H:i:s");
 intotable("yjcode_jubao","bh,sj,jbqq,jbid,admin,tyid,txt,zt,uip","'".returnbh()."','".$sj."','".sqlzhuru($_POST[t2])."',".$id.",".$admin.",".intval($_POST[d1]).",'".sqlzhuru1($_POST[content])."',1,'".getuip()."'");
 php_toheader("jubao.php?t=suc&admin=".$admin."&id=".$id);
}
//举报E
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>举报弹窗</title>
<link href="../css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../config/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="../config/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" src="../config/ueditor/lang/zh-cn/zh-cn.js"></script>
<script language="javascript" src="../js/jquery.min.js"></script>
<script language="javascript" src="../js/layer.js"></script>
<script language="javascript">
function tj(){
if(document.f1.t1.value==""){alert("请输入验证码");document.f1.t1.focus();return false;}
layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
f1.action="jubao.php?control=jb&admin=<?=$admin?>&id=<?=$id?>";
}
function miaos(){
parent.location.reload();
}
</script>
<style type="text/css">
.jubao{float:left;width:650px;text-align:left;height:450px;}
.jubao .d1{float:left;width:620px;height:27px;padding:11px 0 0 30px;background:url(../img/deng.png) no-repeat;background-position:10px 10px;background-color:#F6F9FF;}
.jubao .uk{float:left;width:650px;font-size:14px;margin:20px 0 0 0;}
.jubao .uk li{float:left;}
.jubao .uk li .inp{float:left;font-size:14px;height:30px;border:#E6E6E6 solid 1px;}
.jubao .uk .l1{width:95px;text-align:right;padding:6px 15px 0 0;height:44px;font-weight:700;}
.jubao .uk .l21{width:540px;height:44px;font-weight:700;padding:6px 0 0 0;}
.jubao .uk .l2{width:540px;height:50px;}
.jubao .uk .l3{width:95px;text-align:right;padding:6px 15px 0 0;height:184px;font-weight:700;}
.jubao .uk .l4{width:503px;padding-right:37px;height:190px;font-weight:700;}
.jubao .uk .l6{width:215px;height:50px;}
.jubao .uk .l6 .img1{float:left;margin:0 0 0 10px;height:31px;}
.jubao .uk .l5{width:540px;height:50px;padding:0 0 0 110px;}
.jubao .uk .l5 input{float:left;cursor:pointer;color:#fff;font-size:14px;width:92px;height:32px;background-color:#1AA094;border:0;}
.suc{float:left;width:410px;font-size:14px;color:#6B6B6B;background:url(../img/suc.jpg) no-repeat;background-position:110px 140px;padding:150px 0 0 240px;height:50px;line-height:35px;text-align:center;height:250px;text-align:left;}
.suc strong{font-size:16px;color:#ff6600;}
</style>
</head>
<body>
<? if(empty($_GET[t])){?>
<form name="f1" method="post" onsubmit="return tj()">
<div class="jubao fontyh">
 <div class="d1">提供有效的凭证会加快举报进程，同时我们对您的信息绝对保密!</div>
 <ul class="uk">
 <li class="l1">举报对象</li>
 <li class="l21" style="color:#0101FF;font-weight:700;"><?=$tit?></li>
 <li class="l1">举报类型</li>
 <li class="l2">
 <select name="d1" class="inp fontyh">
 <? while1("*","yjcode_jubaotype where admin=".$admin." and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>"><?=$row1[tit]?></option>
 <? }?>
 <option value="0">其他一些举报原因，请在下方填写具体的内容</option>
 </select>
 </li>
 <li class="l3">举报原因</li>
 <li class="l4"><script id="editor" name="content" type="text/plain" style="width:503px;height:115px;"><?=$row[bz]?></script></li>
 <li class="l1">验证码</li>
 <li class="l6"><input type="text" class="inp" style="width:90px;" name="t1" /><img src="../config/getYZM.php" onClick="this.src='../config/getYZM.php?'+Math.random();" class="img1" /></li>
 <li class="l1" style="letter-spacing:1px;color:#999;">联系QQ</li>
 <li class="l6"><input type="text" class="inp" style="width:178px;" name="t2" /></li>
 <li class="l5"><input type="submit" class="fontyh" value="提交举报" /></li>
 </ul>
</div>
</form>
<script language="javascript">
//实例化编辑器
var ue= UE.getEditor('editor'
, {
            toolbars:[
            [
                'link',
                'insertimage', 'attachment']
        ]
        });
</script>
<? }elseif($_GET[t]=="suc"){?>
 <div class="suc fontyh">
 <strong>举报信息已经提交成功，感谢您的支持</strong><br>
 <span id="miao">5</span>秒后自动跳转(如未跳转,请刷新)
 </div>
 <script language="javascript">
 setTimeout("miaos()",4000);
 </script>
<? }?>
</body>
</html>