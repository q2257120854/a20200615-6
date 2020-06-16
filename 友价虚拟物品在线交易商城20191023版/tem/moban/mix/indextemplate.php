<?
include("../../../config/conn.php");
include("../../../config/function.php");
include("../../../config/xy.php");
$sj=date("Y-m-d H:i:s");
?>
<html>
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$rowcontrol[webkey]?>">
<meta name="description" content="<?=$rowcontrol[webdes]?>">
<title><?=$rowcontrol[webtit]?> - <?=webname?></title>
<link rel="shortcut icon" href="img/favicon.ico" />
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="homeimg/jquery.flexslider.css" rel="stylesheet" type="text/css" >
<script language="javascript" src="js/basic.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script language="javascript" src="js/index.js"></script>
<script src="http://www.ecmoban.com/content/themes/ecmoban2014/js/jquery.min.js"></script>
<script type="text/javascript" src="homeimg/jquery.flexslider-min.js"></script>
<? if(empty($rowcontrol[ifwap])){?>
<script language="javascript">
if(is_mobile()) {document.location.href= '<?=weburl?>m/';}
</script>
<? }?>
</head>
<body>
<? 
autoAD("ADI00");
while1("*","yjcode_ad where adbh='ADI00' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){
$tp="gg/".$row1[bh].".".$row1[jpggif];
$image_size= getimagesize("../../../".$tp);
?>
<div class="topbanner_hj" style="background:url(<?=$tp?>) no-repeat center 0;height:<?=$image_size[1]?>px;"><a href="<?=$row1[aurl]?>" target="_blank"></a></div>
<? }?>

<? include("../../../tem/top.html");?>
<? include("../../../tem/top1.html");?>
<span id="leftnone" style="display:none;"></span>
<script language="javascript">
leftmenuover();
yhifdis(0);
document.getElementById("zhuTop").className="bfb bfbtop1 bfbtop1N"
document.getElementById("topmenu1").className="a1";
</script>

 <!--切换B-->
 <div class="banner" id="banner" >
 <? autoAD("mix_02");$i=0;while1("*","yjcode_ad where adbh='mix_02' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <a href="<?=$row1[aurl]?>" class="d1" target="_blank" style="background:url(gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>) center no-repeat;"></a>
 <? $i++;}?>
 <div class="d2" id="banner_id">
 <ul style="margin-left:-<?=86*$i/2?>px;">
 <? for($j=0;$j<$i;$j++){?><li></li><? }?>
 </ul>
 </div>
 </div>
 <script type="text/javascript">banner();</script>
 <!--切换E-->

<div class="bfb"></div>

<div class="yjcode">
 
<script type="text/javascript" src="http://www.ecmoban.com/content/themes/ecmoban2014/js/transport.js"></script>
<div class="cover-page-plug-in j-cover-page-plug-in clearfix">

<div class="fl w484 mr1" style="height: 260px;">
<? adread("mix_03",454,260);?>
<p class="btn" style="display: none;">
<a class="click-more" href="<?=$row1[aurl]?>" target="_blank">点击了解详情</a>
<i></i>
</p>
</div>

<? autoAD("mix_04");$i=0;while1("*","yjcode_ad where adbh='mix_04' and zt=0 order by xh asc limit 3");while($row1=mysql_fetch_array($res1)){?>
<div class="fl w241 mr1" style="height: 260px;">
<a href="<?=$row1[aurl]?>" target="_blank"><img src="gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>" alt="ecjia开源" style="position: absolute; left: 0px; top: 0px;" width="241" height="260"></a>
<p class="btn" style="display: none;">
<a class="click-more" href="<?=$row1[aurl]?>" target="_blank">点击了解详情</a>
<i></i>
</p>
</div>
<? $i++;}?>
</div> 

 <!--推荐产品B-->
 <div class="tjspcap fontyh">推荐商品</div>
 <div class="tjpro fontyh">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 4");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <span id="dqsj<?=$i?>" style="display:none;"><?=$dqsj?></span>
 <ul class="u1 u1<?=$i?>">
 <li class="l1"><a href="<?=$au?>" target="_blank"><img class="tp" border="0" src="<?=returntp("bh='".$row1[bh]."'","-1")?>" width="270" height="294" /></a><span class="djs" id="djs<?=$i?>">正在加载</span></li>
 <li class="l2"><a href="<?=$au?>" title="<?=$row1[tit]?>" target="_blank"><?=strgb2312($row1[tit],0,50)?></a></li>
<li class="l3">￥<strong><?=$money1?></strong> <s class="hui">￥<?=$row1[money1]?></s></li>
<li class="l4"><?=strgb2312(($money1/$row1[money1]*10),0,3)?>折</li>

 </ul>
 <? $i++;}?>
 </div>
 <script language="javascript">
 userChecksj();
 </script>
 <!--推荐产品E-->

</div>

<div class="bfb bfbh fontyh">
<div class="yjcode">
 <!--列表B-->
 <div class="listcap">
  <div class="d1">新品上架</div>
  <div class="d2">
  <? $i=1;while1("*","yjcode_type where admin=1 and iftj=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
  <a href="javascript:void(0);" id="lista<?=$i?>" onMouseOver="listcapover(<?=$i?>)"<? if($i==1){?> class="a1"<? }?>><?=$row1[type1]?></a>
  <? $i++;}?>
  </div>
 </div>
 <span id="listcapA" style="display:none;"><?=$i?></span>
 <? $i=1;while1("*","yjcode_type where admin=1 and iftj=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
 <div class="container" id="list<?=$i?>"<? if($i!=1){?> style="display:none;"<? }?>>
 <!-- Effect-1 -->
 <?
 $j=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 and ty1id=".$row1[id]." order by lastsj asc limit 8");while($row=mysql_fetch_array($res)){
 $au="product/view".$row[id].".html";
 $money1=returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]);
 ?>
 <div class="list<? if($j==1 || $j==5){?> list0<? }?>">
 <ul class="u1">
 <li>
 <div class="port-1 effect-2">
  <div class="image-box"><img src="<?=returntp("bh='".$row[bh]."'","")?>" width="257" height="257" alt="<?=$row[tit]?>"></div>
  <div class="text-desc"><h3><?=returntype(2,$row[ty2id])?></h3><p><?=strgb2312($row[wdes],0,300)?></p><a href="<?=$au?>" target="_blank" class="btn">立即购买</a>
  </div>
 </div>
 </li>
 </ul>
 <ul class="u2">
 <li class="l1"><a href="<?=$au?>" target="_blank" title="<?=$row[tit]?>"><?=strgb2312($row[tit],0,60)?></a></li>
 <li class="l2"><strong>￥<?=sprintf("%.2f",$money1)?></strong></li>
 <li class="l3"><?=sprintf("%.1f",10*$money1/$row[money1])?>折</li>
 </ul>
 </div>
 <? $j++;}?>
 <!-- Effect-1 End -->
 </div>
 <? $i++;}?>
 
 <!--列表E-->
 
 <!--商家B-->
 <div class="listcap listcap1">
  <div class="d1">优质商家</div>
 </div>
 <div class="shoplist">
 <? 
 $i=1;
 while1("*","yjcode_user where pm>0 and shopzt=2 and zt=1 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
 $xy=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
 ?>
 <div class="shop shop<?=$i?>">
  <div class="d1"><img src="<?="upload/".$row1[id]."/shop.jpg"?>" onerror="this.src='img/none300x300.gif'" width="261" height="261"></div>
  <div class="d2"><?=returntitdian($row1[seodes],100)?></div>
  <div class="d3">我已经赚了<?=sprintf("%.2f",$row1[sellmall])?>元</div>
  <div class="d4">
  <span class="s1"><a href="shop/view<?=$row1[id]?>.html" target="_blank"><?=$row1[shopname]?></a></span>
  <span class="s2"><img src="img/dj/<?=returnxytp($xy)?>" title="<?=$xy?>分" /></span>
  </div>
 </div>
 <? $i++;}?>
 </div>
 <!--商家E-->
  <!--商家B-->
<div class="classical-case fl wfs mt50">
<div class="header fl wfs">
<h3 class="fl">经典案例</h3>
</div>
<div class="body">
<ul class="list-case j-list-case">
<? autoAD("ADI13");$i=0;while1("*","yjcode_ad where adbh='ADI13' and zt=0 order by xh asc");while($row1=mysql_fetch_array($res1)){?>
<li class="items">
<img src="gg/<?=$row1[bh]?>.<?=$row1[jpggif]?>" alt="">
<a class="txt" href="<?=$row1[aurl]?>" target="_blank">
<span>
<?=$row1[tit]?>
</span>
</a>
</li>
<? $i++;}?>
</ul>
</div>
</div>
 <!--商家E-->
<!--资讯 start-->
<div class="bfb bfbnews">
<div class="yjcode">
 
<div class="cap">
 <div class="d1">友价源码的<span>最新动态</span></div>
 <div class="d2">为您提供最新网站公告、补丁更新、技术支持等信息，每篇内容均经过核实</div>
</div>
<div class="church fl wfs mt50">
<dl class="knowledge fl">
<dt class="title">
<div class="d1 d0">
<ul class="u1">
<li class="l1">升级补丁</li>
<li class="l2"><a href="/news/newslist_j21v.html" target="_blank">MORE+</a></li>
</dt>
<dd class="fl wfs">
<? while1("*","yjcode_newstype where admin=1 and xh=1 order by xh asc limit 1");while($row1=mysql_fetch_array($res1)){?>
<? while2("*","yjcode_news where type1id=".$row1[id]." and zt=0 order by lastsj desc limit 5");while($row2=mysql_fetch_array($res2)){?>
<a target="_blank" href="news/txtlist_i<?=$row2[id]?>v.html" title="<?=$row1[name1]?>"><?=returntitcss(strgb2312($row2[tit],0,53),$row2[ifjc],$row2[titys])?></a>
<? }?>
<? }?>
</dd>
</dl>
<dl class="reputation fl">
<dt class="title">
<div class="d1">
<ul class="u1">
<li class="l1">技术文档</li>
<li class="l2"><a href="/news/newslist_j22v.html" target="_blank">MORE+</a></li>
</dt>
<dd class="fl wfs">
<? while1("*","yjcode_newstype where admin=1 and xh=2 order by xh asc limit 1");while($row1=mysql_fetch_array($res1)){?>
<? while2("*","yjcode_news where type1id=".$row1[id]." and zt=0 order by lastsj desc limit 5");while($row2=mysql_fetch_array($res2)){?>
<a target="_blank" href="news/txtlist_i<?=$row2[id]?>v.html" title="<?=$row1[name1]?>"><?=returntitcss(strgb2312($row2[tit],0,53),$row2[ifjc],$row2[titys])?></a>
<? }?>
<? }?>
</dd>
</dl>
<dl class="letters fl">
<dt class="title">
<div class="d1">
<ul class="u1">
<li class="l1">官方公告</li>
<li class="l2"><a href="/news/newslist_j23v.html" target="_blank">MORE+</a></li>
</dt>
<dd class="fl wfs">
<? while1("*","yjcode_newstype where admin=1 and xh=3 order by xh asc limit 1");while($row1=mysql_fetch_array($res1)){?>
<? while2("*","yjcode_news where type1id=".$row1[id]." and zt=0 order by lastsj desc limit 5");while($row2=mysql_fetch_array($res2)){?>
<a target="_blank" href="news/txtlist_i<?=$row2[id]?>v.html" title="<?=$row1[name1]?>"><?=returntitcss(strgb2312($row2[tit],0,53),$row2[ifjc],$row2[titys])?></a>
<? }?>
<? }?>
</dd>
</dl>
</div>
<!--资讯E-->
</div>
</div>
</div>
</div>

<script src="http://www.ecmoban.com/content/themes/ecmoban2014/js/jquery.easing.1.3.js"></script>
<? include("../../../tem/bottom.html");?>
<script src="http://www.ecmoban.com/content/themes/ecmoban2014/js/Animation.js"></script>
<script>
        //插件点击隐藏或者展示按钮
        $(".j-cover-page-plug-in div").bind("mouseenter mouseleave",function(e){
            if(e.type == "mouseenter"){
                $(this).find(".btn").show();
            }else{
                $(this).find(".btn").hide();
            }

        });
    // 商品动画
      var move=function(wrap,cname){
           
            $("."+wrap).each(function(){
                var obj=$(this).find("."+cname);
                var p=obj.find("p");
                $(this).hover(function(){
                    p.stop().animate({height:20},200);
                    $(this).addClass("active");
                },function(){
                    p.stop().animate({height:0},200);
                    $(this).removeClass("active");
                });
            });
        }
        move("j-items-li","wrap_div");
        // 插件动画
        var run = function() {
            var obj = $(".j-cover-page-plug-in");
            obj.addClass("clearfix");
            obj.find(".fl").css("height", 260);
            obj.find("img").css({
                position: "absolute",
                left: 0,
                top: 0
            });
            obj.find("img").hover(function() {
                $(this).stop().animate({
                    left: '-10px'
                },200);
            }, function() {
                $(this).stop().animate({
                    left: 0
                },200);
            });
        }
        run();
    </script>


</body>

</html>