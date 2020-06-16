<?
header("Content-Type:text/html;charset=GB2312");
include("../../config/conn.php");
include("../../config/function.php");
include("../../config/xy.php");
$sj=date("Y-m-d H:i:s");
$getstr=$_GET[str];
$px="order by lastsj asc";

$ses=" where zt=0 and ifxj=0";

$ty1id=returnsx("j");if($ty1id!=-1){$ses=$ses." and ty1id=".$ty1id;}
$ty2id=returnsx("k");if($ty2id!=-1){$ses=$ses." and ty2id=".$ty2id;}
$ty3id=returnsx("m");if($ty3id!=-1){$ses=$ses." and ty3id=".$ty3id;}
if(returnsx("s")!=-1){$skey=safeEncoding(returnsx("s"));$ses=$ses." and tit like '%".$skey."%'";}

if($_GET[p]!=""){$page=$_GET[p];}else{$page=1;}
pagef($ses,20,"yjcode_pro",$px);
echo "ok_yjcode_".$count;
while($row=mysql_fetch_array($res)){
$tpv="../../".returntp("bh='".$row[bh]."' order by xh asc","-2");
if($row[fhxs]==2 || $row[fhxs]==3 || $row[fhxs]==4){$ifauto=1;}else{$ifauto=0;}
while1("id,uqq,shopname,xinyong","yjcode_user where id=".$row[userid]);$row1=mysql_fetch_array($res1);
$xy=returnjgdw($row1[xinyong],"",returnxy($row[userid],1));
// 0ok|1ID|2图片地址|3标题|4价格|5是否自动发货|6商家|7信用图标|8总页数
echo "ok|".$row[id]."|".returntppd($tpv,"../../img/none180x180.gif")."|".returntitdian($row[tit],40)."|".returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]))."|".$ifauto."|".$row1[shopname]."|".returnxytp($xy)."|".$page_count."_yjcode_";
}
?>
