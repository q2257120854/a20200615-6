<?
include("../config/conn.php");
include("../config/function.php");
$admin=intval($_GET[admin]);
$id=intval($_GET[id]);
if(empty($admin) || empty($id)){Audit_alert("来源错误！",weburl,"parent.");}
if($admin==1){
 while0("*","yjcode_pro where id=".$id);if(!$row=mysql_fetch_array($res)){Audit_alert("来源错误！",weburl,"parent.");}
 $au="/product/view".$row[id].".html";
 $tit=$row[tit];
}
//举报E
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>安装服务详情</title>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />

<style type="text/css">
ul {
	list-style-type:none;
	margin:0;
	padding:0
}
li {
	list-style-type:none
}
a {
	color:#333;
	text-decoration:none;
	cursor:pointer
}

#windownbg{display:none;position:absolute;width:100%;height:100%;background:#000;top:0;left:0;}
#windown-box{width:650px;position:fixed;border:5px solid #4CB3E7;background:#FFF;text-align:left;}
#windown-title{position:relative;height:44px;border-bottom:1px solid #CCCCCC;overflow:hidden;background:#F5F5F5;}
#windown-title h2{background: url(/img/qq_kf.png) no-repeat scroll -66px 2px transparent;color: #666666;font-size: 20px;font-weight: bold;height: 40px;left: 10px;line-height: 40px;padding-left: 0px;position: absolute;top: 5px;}
#windown-title p{color: #666666;font-size: 15px;font-weight: bold;left: 198px;position: absolute;top: 17px;}
#windown-close{background: url(/img/qq_kf.png) no-repeat scroll -106px -42px transparent;cursor: pointer;height: 12px;overflow: hidden;position: absolute;right: 10px;text-indent: -10em;top: 17px;width: 12px;}

.ly_ins{float:left;width:600px;padding:15px;background:#fff}
.ly_ins table{border-collapse:collapse;width:100%}
.ly_ins .table1,.ly_ins td,.ly_ins th{border-bottom:1px solid #ddd;padding:0}
.ly_ins .table1{border:1px solid #ddd}
.ly_ins .table2{border:0}
.ly_ins .table2 td{border-bottom:1px solid #f1f1f1;padding:10px 8px;color:#666}
.ly_ins .table2 tr:last-child td:last-child{border-color:#fff}
.ly_ins td.nm1{text-align:right;border-bottom:1px solid #f8f8f8;background:#f8f8f8;width:15%;color:#333;border-right:1px solid #f1f1f1}
.ly_ins td.tyn{text-align:center;border-right:1px solid #ddd;font-weight:700;background:#f2f2f2;width:35px}
.ly_ins span{float:left;}
.ly_ins img{float:right;cursor:pointer}
.ins_notes{float:left;padding:5px 0;font-size:13px;width:98%;border-top:#e1e1e1 solid 1px}
.ins_notes li{float:left;line-height:25px}
.ins_notes span{text-decoration:underline}
.ins_notes b{padding-right:4px;color:#666;font-size:15px}
.ins_notes h3{float:left;font-size:14px;background:url(../img/deng.png) 0 center no-repeat;padding-left:20px;font-weight:700;}
.customer_div{float:left;width:300px;padding:15px;background:#f6f9ff}
.customer_div p{float:left;width:100%;margin:0 0 10px 0}
.customer_uqq{width:300px}
.customer_uqq span{float:left;line-height:27px}

.probq{float:left;border-left:#F5F4F4 solid 1px;border-top:#F5F4F4 solid 1px;font-size:12px;}
.probq li{float:left;border-bottom:#F5F4F4 solid 1px;padding:3px 0 0 10px;height:25px;border-right:#F5F4F4 solid 1px;}
.probq .l1{width:72px;background-color:#FDFDFD;}
.probq .l2{width:93px;}
</style>
</head>
<body>

<div class="layui-layer-content">
<div class="ly_ins">
<table class="table1">
<tbody><tr>
	<td class="tyn">商品<br>信息
	</td>
	<td>
		<table class="table2">
	<tbody><tr>
		<td class="nm1">商品名称</td>
		<td><span><a href="<?=$au?>" style="color:#247FBD" target="_blank"><?=$row[tit]?></a></span></td>
	</tr>

	</tbody>
	</table>
	</td>
</tr>
<tr>
		<td class="tyn">运行<br>环境
	</td>
	<td>
 <ul class="probq">
 <? 
 $a=preg_split("/xcf/",$row[tysx]);
 $sx1arr=array();
 $sxall="xcf";
 $m=0;
 for($i=0;$i<=count($a);$i++){
  $ai=$a[$i];
  if($ai!=""){
   if(!is_numeric($ai)){$z1=preg_split("/:/",$ai);$ai=$z1[0];}
   while1("*","yjcode_typesx where id=".$ai);if($row1=mysql_fetch_array($res1)){
    while2("*","yjcode_typesx where name1='".$row1[name1]."' and admin=1 and ifjd=1");if($row2=mysql_fetch_array($res2)){
     if(!in_array($row1[name1],$sx1arr)){$sx1arr[$m]=$row1[name1];$m++;}
     if(!is_numeric($a[$i])){$z1=preg_split("/:/",$a[$i]);$v=$z1[1];}else{$v=$row1[name2];}
     $sxall=$sxall.$row1[name1].":".$v."xcf";
    }
   }
  }
 }
 for($i=0;$i<count($sx1arr);$i++){
 ?>
 <li class="l1"><?=$sx1arr[$i]?>：</li><li class="l2"><? $b=preg_split("/xcf/",$sxall);for($j=0;$j<=count($b);$j++){if(check_in($sx1arr[$i],$b[$j])){echo str_replace($sx1arr[$i].":","",$b[$j])." ";}}?></li>
 <? }?>
 </ul>
</tbody>
</table>
<div class="ins_notes">
<h3>注意事项及说明：</h3>
<li><b>1.</b>【安装服务】需收费时，可在购物车结算中，自行选择是否需要购买该服务；</li>
<li><b>2.</b>【主机环境】非该商品仅支持的环境，而是卖家技术能力范围内可提供安装服务的环境；</li>
<li><b>3.</b> 对于未购买安装服务的交易，可在交易中追加购买安装服务；</li>
<li><b>4.</b> 免费或购买收费安装，而无法提供上述要求环境，即代表自愿放弃安装服务。</li>
	 </div>
  </div>
</div>
</form>

</body>
</html>