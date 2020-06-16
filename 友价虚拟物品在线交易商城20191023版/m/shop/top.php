<?
checkdjl("c1",$uid,"yjcode_user");
$sucnum=returnjgdw($rowuser[xinyong],"",returnxy($uid,1));
?>
<div class="topbg">

<div class="indextop box">
 <div class="d1" onClick="javascript:history.go(-1);"><img src="../img/leftjian.png" height="21" /></div>
 <div class="d2" onClick="gourl('../search/main.php');"><span class="s1"><img src="../img/ser.png" height="17" /></span><span class="s2">请输入搜索关键词！</span></div>
 <div class="d3"></div>
</div>

<div class="indextop1 box">
 <div class="d1"><a href="view<?=$uid?>.html"><img src="<?=returntppd("../../upload/".$rowuser[id]."/shop.jpg","../img/none70x70.gif")?>" width="40" height="40" /></a></div>
 <div class="d2"><?=$rowuser[shopname]?><br><img src="<?=weburl?>img/dj/<?=returnxytp($sucnum)?>" /></div>
 <div class="d3"><?=returncount("yjcode_pro where userid=".$rowuser[id]." and zt=0")?><br>宝贝数</div>
 <div class="d4"><?=$rowuser[djl]?><br>关注度</div>
</div>

</div>

<div class="topmenu box">
<div class="d1">
 <a href="view<?=$uid?>.html" id="topmenu1">首页</a>
 <a href="prolist_i<?=$uid?>v.html" id="topmenu2">全部宝贝</a>
 <a href="typeview<?=$uid?>.html" id="topmenu3">分类</a>
 <a href="aboutview<?=$uid?>.html" id="topmenu4">店铺简介</a>
</div>
</div>