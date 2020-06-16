<?
include("../config/conn.php");
include("../config/function.php");
sesCheck();
$bh=$_GET[bh];
$userid=returnuserid($_SESSION[SHOPUSER]);
while0("*","yjcode_news where bh='".$bh."' and userid=".$userid);if(!$row=mysql_fetch_array($res)){php_toheader("newslist.php");}

if($_GET[control]=="add"){
 $sj=date("Y-m-d H:i:s");
 $tyid=preg_split("/xcf/",sqlzhuru($_POST[d1]));
 if(panduan("bh,type1","yjcode_tp where bh='".$bh."' and type1='资讯'")==1){$iftp=1;}else{$iftp=0;}

 if($iftp==0){ //提取图片
  preg_match_all("/<img.*\>/isU",$txt,$ereg);//正则表达式把图片的整个都获取出来了
  $img=$ereg[0][0];//图片
  $p="#src=('|\")(.*)('|\")#isU";//正则表达式
  preg_match_all ($p, $img, $img1);
  $tp =$img1[2][0];//获取第一张图片路径
  if(!empty($tp)){
  if(!check_in("://",$tp)){$tp=rtrim(weburl,"/").$tp;}
  createDir("../upload/news/".dateYMDN($row[sj])."/");
  $targetFolder="upload/news/".dateYMDN($row[sj])."/".$bh."/";
  createDir("../".$targetFolder);
  $mbh=returnbh();
  $wjv=$targetFolder.$mbh.".jpg";
  copy($tp,"../".$targetFolder.$mbh.".jpg");
  $cm=new CreatMiniature();
  $bw=600;$bg=500;$sw=200;$sh=160;
  $imgsrc="../".$targetFolder.$mbh.".jpg";
  list($width, $height) = getimagesize(weburl.$targetFolder.$mbh.".jpg");$bgv=intval($height/($width/$bw));
  $cm->SetVar($imgsrc,"file");if($width>$bw){$cm->Cut($imgsrc,$bw,$bgv);}
  if($width>$sw){$cm->Cut("../".$targetFolder.$mbh."-1.jpg",$sw,$sh);}else{copy($imgsrc,"../".$targetFolder.$mbh."-1.jpg");}
  intotable("yjcode_tp","bh,tp,type1,iffm,sj,userid,xh","'".$bh."','".$wjv."','资讯',1,'".$sj."',".intval($row[userid]).",1");
  }
 }

 $txt=sqlzhuru1($_POST[content]);
 $wdes=sqlzhuru($_POST[twdes]);if(empty($wdes)){$wdes=strgb2312(strip_tags($txt),0,220);}
 $tit=sqlzhuru($_POST[ttit]);
 $wkey=sqlzhuru($_POST[twkey]);if(empty($wkey)){$wkey=$tit;}
 updatetable("yjcode_news","
			 type1id=".$tyid[0].",
			 type2id=".$tyid[1].",
			 tit='".$tit."',
			 txt='".$txt."',
			 lastsj='".$sj."',
			 ifjc=0,
			 zze='".sqlzhuru($_POST[tzze])."',
			 ly='".sqlzhuru($_POST[tly])."',
			 lyurl='".sqlzhuru($_POST[tlyurl])."',
			 wkey='".$wkey."',
			 wdes='".$wdes."',
			 zt=1,
			 iftp=".$iftp." where bh='".$bh."' and userid=".$row[userid]);
 php_toheader("newslist.php");
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
<script type="text/javascript">
function tj(){
 if((document.f1.ttit.value).replace(/\s/,"")==""){alert("请输入标题");document.f1.ttit.focus();return false;}	
 layer.msg('正在提交', {icon: 16  ,time: 0,shade :0.25});
 tjwait();
 f1.action="news.php?control=add&bh=<?=$bh?>";
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
 
 <? include("rcap13.php");?>
 <script language="javascript">
 document.getElementById("rcap1").className="l1 l2";
 </script>

 <!--白B-->
 <div class="rkuang">
 
 <form name="f1" method="post" onsubmit="return tj()">
 <ul class="uk">
 <li class="l1"><span class="red">*</span> 分组：</li>
 <li class="l2">
 <select name="d1" class="inp fontyh">
 <? while1("*","yjcode_newstype where admin=1");while($row1=mysql_fetch_array($res1)){?>
 <option value="<?=$row1[id]?>xcf0"<? if($row1[id]==$row[type1id] && $row[type2id]==0){?> selected="selected"<? }?> style="background-color:#EFEFEF;color:#333;"><?=$row1[name1]?></option>
 <? while2("*","yjcode_newstype where admin=2 and name1='".$row1[name1]."'");while($row2=mysql_fetch_array($res2)){?>
 <option value="<?=$row1[id]?>xcf<?=$row2[id]?>"<? if($row1[id]==$row[type1id] && $row2[id]==$row[type2id]){?> selected="selected"<? }?>> - <?=$row2[name2]?></option>
 <? }?>
 <? }?>
 </select>
 </li>
 <li class="l1"><span class="red">*</span> 标题：</li>
 <li class="l2"><input type="text" size="50" value="<?=$row[tit]?>" class="inp" name="ttit" /></li>
 <li class="l1">作者：</li>
 <li class="l2"><input class="inp" name="tzze" value="<?=$row[zze]?>" size="10" type="text"/></li>
 <li class="l1">来源：</li>
 <li class="l2"><input class="inp" name="tly" value="<?=$row[ly]?>" size="10" type="text"/></li>
 <li class="l1">来源网址：</li>
 <li class="l2"><input class="inp" name="tlyurl" value="<?=$row[lyurl]?>" size="70" type="text"/></li>
 <li class="l7">详细内容：</li>
 <li class="l8"><script id="editor" name="content" type="text/plain" style="width:770px;height:400px;"><?=$row[txt]?></script></li>
 <li class="l1">SEO关键词：</li>
 <li class="l2"><input type="text" class="inp" value="<?=$row[wkey]?>" name="twkey" size="60" /></li>
 <li class="l9">SEO描述：</li>
 <li class="l10"><textarea name="twdes"><?=$row[wdes]?></textarea></li>
 <li class="l3"><? tjbtnr("下一步","newslist.php")?></li>
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